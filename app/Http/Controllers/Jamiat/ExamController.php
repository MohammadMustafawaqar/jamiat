<?php

namespace App\Http\Controllers\Jamiat;

use App\Global\Settings;
use App\Http\Controllers\Controller;
use App\Models\Jamiat\Exam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ExamController extends Controller
{
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
        ], attributes: [
            'title' => __('lang.title'),
            'start_date' => __('jamiat.start_date'),
            'end_date' => __('jamiat.end_date'),
            'grade_id' => __('jamiat.exam_grade'),
            'description' => __('jamiat.description'),
        ]);

        if($validator->fails()){
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
    public function update(Request $request, string $id)
    {
        //
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
}
