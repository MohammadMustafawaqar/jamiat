<?php

namespace App\Http\Controllers\Jamiat\Forms;

use App\Helpers\JamiaHelper;
use App\Http\Controllers\Controller;
use App\Models\Jamiat\Form;
use App\Models\Jamiat\Grade;
use App\Models\Jamiat\StudentForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RajabController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $years = JamiaHelper::getQamariAndShamsiYears();

        $form = Form::find(3);
        $highestSerial = (int) DB::table('student_forms')
            ->selectRaw('MAX(CAST(serial_number AS UNSIGNED)) as max_serial')
            ->value('max_serial') + 1;

        $perPage = $request->perPage ?? 10;
        $studentForms = $form->studentForms()->where('status', 'unused')->paginate($request->perPage ?? 10)
        ->withQueryString();
        return view('backend.jamiat.forms.rajab.index', [
            'form' => $form,
            'studentForms' => $studentForms,
            'highestSerial' => $highestSerial,
            'qamariYears' => $years['qamari'],  
            'shamsiYears' => $years['shamsi'],
            'perPage' => $perPage

        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.jamiat.forms.rajab.create', [
            'array' => [1, 2, 3, 4, 5, 6, 7]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'start_range' => 'required|integer',
            'end_range' => 'required|integer|gte:start_range',
            'grade_id' => 'required|integer',
            'shamsi_year' => 'required',
            'qamari_year' => 'required'
        ]);

        $start = $request->start_range;
        $end = $request->end_range;

        $existingSerials = DB::table('student_forms')->pluck('serial_number')->toArray();


        $dataToInsert = [];
        for ($serial = $start; $serial <= $end; $serial++) {
            if (in_array($serial, $existingSerials)) {
                continue;
            }

            $dataToInsert[] = [
                'serial_number' => $serial,
                'form_id' => 3,
                'grade_id' => $request->grade_id,
                'student_id' => null,
                'status' => 'unused',
                'created_at' => now(),
                'updated_at' => now(),
                'qamari_year' => $request->qamari_year,
                'shamsi_year' => $request->shamsi_year
            ];
        }

        if (!empty($dataToInsert)) {
            StudentForm::insert($dataToInsert);

            $grade = Grade::find($request->grade_id);
            $studentForms = StudentForm::whereIn('serial_number', array_column($dataToInsert, 'serial_number'))->where('form_id', 3)->get();

            return view('backend.jamiat.forms.rajab.create', [
                'form' => $studentForms,
                'grade_name' => $grade?->name,
                'grade_classes' => $grade->grade_classes,
            ]);
        }

        return redirect()->back()->with('error', __('messages.already_exist'));
    }

    /**
     * Display the specified resource.
     */
    public function show($locale, string $id)
    {
        $studentForm = StudentForm::where('id', $id)->get();
        return view('backend.jamiat.forms.rajab.create', [
            'form' => $studentForm,
            'grade_name' => $studentForm->first()?->grade?->name,
            'grade_classes' => $studentForm->first()->grade->grade_classes
        ]);
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
    public function destroy($locale, $id)
    {
        $form = StudentForm::find($id);

        if($form->status == 'unused'){
            $form->delete();
        }else{
            return redirect()->back()->with('error', __('messages.cant_delete'));
        }

        return redirect()->back()->with('success', __('messages.deleted'));
    }

    public function printManyForms(Request $request)
    {
        $selectedIds = explode(',', $request->stud_form_ids);
        $studentForm = StudentForm::whereIn('id', $selectedIds)->get();
        return view('backend.jamiat.forms.rajab.create', [
            'form' => $studentForm,
            'grade_name' => $studentForm->first()?->grade?->name,
            'grade_classes' => $studentForm->first()->grade->grade_classes
        ]);
    }
}
