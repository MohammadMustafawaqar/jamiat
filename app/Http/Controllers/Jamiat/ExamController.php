<?php

namespace App\Http\Controllers\Jamiat;

use App\Global\Settings;
use App\Helpers\HijriDate;
use App\Http\Controllers\Controller;
use App\Models\Jamiat\Exam;
use App\Models\Jamiat\ExamAppreciation;
use App\Models\Jamiat\ExamSubject;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ExamController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:exam.read')->only('index');
        $this->middleware('permission:exam.create')->only(['index', 'store']);
        $this->middleware('permission:exam.edit')->only(['index', 'edit', 'update']);
        $this->middleware('permission:exam.delete')->only(['index', 'destroy']);
        $this->middleware('permission:exam.*')->only(['index', 'store', 'create', 'edit', 'update', 'destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $exams = Exam::orderBy('created_at', 'desc')->paginate(10);

        return view('backend.jamiat.exam.index', [
            'exams' => $exams
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:64',
            'start_date' => 'required',
            'end_date' => 'nullable',
            'grade_id' => 'required',
            'description' => 'nullable|string|max:255|min:3',
            'province_id' => 'required',
            'district_id' => 'nullable',
            'address' => 'nullable|string|max:255|min:3',
            'campus_id' => 'required'
        ], attributes: [
            'title' => __('lang.title'),
            'start_date' => __('jamiat.start_date'),
            'end_date' => __('jamiat.end_date'),
            'grade_id' => __('jamiat.exam_grade'),
            'description' => __('jamiat.description'),
            'campus_id' => __('jamiat.campus'),
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => 'validation-error',
            ], 422);
        }

        $exam = Exam::create($request->except('start_date', 'end_date') + [
            'start_date' => Settings::change_from_hijri($request->start_date),
            'end_date' => Settings::change_from_hijri($request->end_date),
        ]);

        return response()->json([
            'request' => $request->all(),
            'message' => __('messages.record_submitted')
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $locale,  string $id)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:64',
            'start_date' => 'required',
            'end_date' => 'nullable',
            'grade_id' => 'required',
            'description' => 'nullable|string|max:255|min:3',
            'province_id' => 'required',
            'district_id' => 'nullable',
            'campus_id' => 'required'
        ], attributes: [
            'title' => __('lang.title'),
            'start_date' => __('jamiat.start_date'),
            'end_date' => __('jamiat.end_date'),
            'grade_id' => __('jamiat.exam_grade'),
            'description' => __('jamiat.description'),
            'campus_id' => __('jamiat.campus'),
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => 'validation-error',
            ], 422);
        }

        $st_date = Carbon::parse($request->start_date)->format('Y-m-d');
        $en_date = $request->end_date ? Carbon::parse($request->end_date)->format('Y-m-d') : null;

        $start_date = Settings::change_from_hijri($st_date);
        $end_date = $request->end_date ? Settings::change_from_hijri($en_date) : null;

        $exam = Exam::find($id);


        $exam = $exam->update($request->except('start_date', 'end_date') + [
            'start_date' => $start_date,
            'end_date' => $end_date,
        ]);

        return response()->json([
            'request' => $request->all(),
            'message' => __('messages.record_updated')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($locale, string $id)
    {
        $exam = Exam::findOrFail($id);

        $exam->delete();

        return redirect()->back()->with('msg', __('messages.record_deleted'));
    }

    public function assignSubjects(Request $request, $locale, $exam_id)
    {

        $validator = Validator::make($request->all(), [
            'subject_ids' => 'required|array',
            'min_app.*' => ['required', 'integer', 'max:1000'],
        ], attributes: [
            'subject_ids' => __('sidebar.subjects'),
            'min_app.*' => '',
        ]);

        try {
            DB::beginTransaction();
            $exam = Exam::find($exam_id);
            $exam->subjects()->sync($request->subject_ids);

            foreach ($request->min_app as $key => $value) {
                ExamAppreciation::updateOrCreate([
                    'exam_id' => $exam_id,
                    'appreciation_id' => $key,
                ], [
                    'min_score' => $value
                ]);
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => __('messages.record_submitted')
            ]);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'status' => 'server error',
                'message' => $e->getMessage()
            ], 500);
        }

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => 'validation-error',
            ], 422);
        }
    }

    public function getExamSubjects($locale, $exam_id)
    {
        $subjects = ExamSubject::where('exam_id', $exam_id)->pluck('subject_id');
        $appreciations = ExamAppreciation::where('exam_id', $exam_id)->get();

        return response()->json([
            'exists' => $subjects->isNotEmpty() || $appreciations->isNotEmpty(),
            'subjects' => $subjects,
            'appreciations' => $appreciations,
        ]);
    }
}
