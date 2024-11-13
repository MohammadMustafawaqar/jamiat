<?php

namespace App\Http\Controllers;

use App\Helpers\JamiaHelper;
use App\Imports\RajabStudentImport;
use App\Imports\StudentImport;
use App\Imports\UsersImport;
use App\Models\Appreciation;
use App\Models\Category;
use App\Models\Country;
use App\Models\Gender;
use App\Models\Jamiat\Campus;
use App\Models\Jamiat\Exam;
use App\Models\Jamiat\Form;
use App\Models\Jamiat\StudentForm;
use App\Models\Jamiat\Tazkira;
use App\Models\School;
use App\Models\Student;
use App\Models\Jamiat\StudentExam;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return redirect()->route('admin.student.form.commission');
        $students = Student::with('forms', 'exams')->paginate(10);
        return view('student.index', compact("students"));
    }

    public function commissionForm(Request $request)
    {

        $perPage = $request->input('perPage', 10);
        $query = $students = Form::find(1)->students()->getQuery();

        $students = JamiaHelper::applyStudentFilters($query, $request)
            ->paginate($perPage)
            ->withQueryString();

        $exams = Exam::all();

        return view('backend.jamiat.student.index', [
            'students' => $students,
            'exams' => $exams,
            'perPage' => $perPage

        ]);
    }

    public function evaluationForm(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $query = $students = Form::find(2)->students()->addSelect('students.*')->getQuery();

        $students = JamiaHelper::applyStudentFilters($query, $request)
            ->orderBy('name')
            ->paginate($perPage)
            ->withQueryString();


        $exams = Exam::all();

        return view('backend.jamiat.student.index', [
            'students' => $students,
            'exams' => $exams,
            'perPage' => $perPage
        ]);
    }

    public function rajabIndex(Request $request)
    {
        $exams = Exam::all();

        $perPage = $request->input('perPage', 10);
        $query = Form::find(3)->students()->getQuery();

        $students = JamiaHelper::applyStudentFilters($query, $request)
            ->paginate($perPage)
            ->withQueryString();

        // dd($students);

        return view('backend.jamiat.student.rajab.index', [
            'students' => $students,
            'exams' => $exams
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $exams = Exam::all();
        $forms = Form::all();
        return view('student.create', compact('exams', 'forms'));
    }

    public function secondForm(Request $request)
    {
        $validated = $request->validate([
            'form_type' => 'required',
            'address_type_id' => 'required',
            'exam_grade' => 'required',
            // 'exam_id' => 'required',
        ]);

        session([
            'pre_form_data' => $validated
        ]);

        $countries = Country::get();
        $schools = School::where('address_type_id', $validated['address_type_id'])->get();
        $categories = Category::get();
        $appreciations = Appreciation::get();
        $genders = Gender::get();
        $exams = Exam::all();
        $nic_types = [
            (object)[
                'value' => 'paper',
                'text' => __('jamiat.paper_nic')
            ],
            (object)[
                'value' => 'electric',
                'text' => __('jamiat.electric_nic')
            ],
        ];

        return view('student.second-form', [
            'countries' => $countries,
            'schools' => $schools,
            'categories' => $categories,
            'appreciations' => $appreciations,
            'genders' => $genders,
            'exams' => $exams,
            'selections' => $validated,
            'nic_types' => $nic_types
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $session = session('pre_form_data', []);
        $form_type = $session['form_type'];
        $address_type = $session['address_type_id'];
        // $exam_id = $session['exam_id'];

        $request->validate([
            'current_district_id' => 'required|integer|exists:districts,id',
            'permanent_district_id' => 'required|integer|exists:districts,id',
            'sub_category_id' => $form_type == '3' ? 'nullable' : 'nullable|integer|exists:sub_categories,id',
            'relative_contact' => $form_type == '3' ? 'nullable' : 'nullable|string',
            'language_id' => $form_type == '3' ? 'nullable' : 'exists:languages,id',
            'education_level_id' => $form_type == '3' ? 'nullable' : 'nullable|exists:education_levels,id',
            'school_country_id' => 'required',
            'school_province_id' => 'required',
            'school_district_id' => 'required',
            'school_id' => 'required|integer|exists:schools,id',
            'gender_id' => 'required|integer|exists:genders,id',
            'appreciation_id' => $form_type == '3' ? 'nullable' : 'required|integer|exists:appreciations,id',
            'form_id' => 'required|string',
            'tazkira_type' => 'nullable',
            'tazkira_no' => 'required|integer',
            'name' => 'required|string|max:255',
            // 'name_en' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            // 'last_name_en' => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            // 'father_name_en' => 'required|string|max:255',
            'grand_father_name' => 'required|string|max:255',
            // 'grand_father_name_en' => 'required|string|max:255',
            'current_village' => 'required|string|max:255',
            'permanent_village' => 'required|string|max:255',
            'dob' => $form_type == '3' ? 'required|date' : 'nullable',
            'dob_qamari' => 'required|string|max:255',
            'dob_shamsi' => $form_type == '3' ? 'required' : 'nullable',
            'graduation_year' => $form_type == '3' ? 'nullable' : 'required|integer',
            'phone' => 'required|string',
            'whatsapp' => $form_type == '3' ? 'nullable' : 'required|string',
            'image_path' => 'nullable|mimes:jpeg,jpg,png|max:2048'
        ]);
        // $user = User::create([
        //     'name' => $request->name,
        //     'email' => $request->phone,
        //     'password' => Hash::make('12345678'),
        // ]);
        $request->merge(input: ['address_type_id' => $address_type]);
        $tazkira = Tazkira::create([
            'type' => $request->tazkira_type,
            'tazkira_no' => $request->tazkira_no
        ]);

        $student = Student::create(
            $request->except([
                'tazkira_type',
                'tazkira_no',
                'school_country_id',
                'school_province_id',
                'school_district_id',
                'current_country_id',
                'permanent_country_id',
                'current_province_id',
                'permanent_province_id',
                'action',
                'new_school'

            ]) + [
                'tazkira_id' => $tazkira->id
            ]
        );
        // $student_exam = StudentExam::create([
        //     'student_id' => $student->id,
        //     'exam_id' => $exam_id
        // ]);

        $student_form = StudentForm::create([
            'form_id' => $form_type,
            'student_id' => $student->id
        ]);
        if ($request->hasFile('image_path')) {
            $student->image_path = $request->file('image_path')->store('public/students');
            $student->save();
        }

        if ($request->action == 'save_continue') {
            return redirect()->back()->with("msg", __('messages.record_submitted'));
        } else {
            session()->forget('pre_form_data');
            return redirect()->route('students.index')->with("msg", __('messages.record_submitted'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($locale, Student $student)
    {
        return view('student.show', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($locale, Student $student)
    {
        $countries = Country::get();
        $schools = School::get();
        $categories = Category::get();
        $appreciations = Appreciation::get();
        $genders = Gender::get();
        $nic_types = [
            (object)[
                'value' => 'paper',
                'text' => __('jamiat.paper_nic')
            ],
            (object)[
                'value' => 'electric',
                'text' => __('jamiat.electric_nic')
            ],
        ];
        return view('student.edit', compact("student", "countries","nic_types", "schools", 'categories', 'appreciations', 'genders'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($locale, Request $request, Student $student)
    {

        $request->validate([
            'current_district_id' => 'required|integer|exists:districts,id',
            'permanent_district_id' => 'required|integer|exists:districts,id',
            'sub_category_id' => 'required|integer|exists:sub_categories,id',
            'school_id' => 'required|integer|exists:schools,id',
            'gender_id' => 'required|integer|exists:genders,id',
            'appreciation_id' => 'required|integer|exists:appreciations,id',
            'form_id' => 'required|string',
            'name' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'last_name_en' => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'father_name_en' => 'required|string|max:255',
            'grand_father_name' => 'required|string|max:255',
            'grand_father_name_en' => 'required|string|max:255',
            'current_village' => 'required|string|max:255',
            'permanent_village' => 'required|string|max:255',
            'dob' => 'required|date',
            'dob_qamari' => 'required|string|max:255',
            'graduation_year' => 'required|integer',
            'phone' => 'required|string',
            'whatsapp' => 'required|string',
        ]);
        $user = User::find($student->user_id);
        $user->name = $request->name;
        $user->email = $request->phone;
        $user->save();
        $student->update($request->all());
        if ($request->hasFile('image_path')) {
            if (isset($student->image_path)) {
                $student->dropFile('image_path');
            }
            $student->image_path = $request->file('image_path')->store('public/students');
            $student->save();
        }
        return redirect()->route('students.index')->with("msg", __('messages.record_submitted'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($locale, Student $student)
    {
        $student->delete();

        return redirect()->back()->with('msg', __('messages.record_deleted'));
    }

    public function updateProfile(Request $request)
    {
        $student = Student::where('user_id', Auth::id())->first();
        $request->validate([
            'current_district_id' => 'required|integer|exists:districts,id',
            'permanent_district_id' => 'required|integer|exists:districts,id',
            'sub_category_id' => 'required|integer|exists:sub_categories,id',
            'gender_id' => 'required|integer|exists:genders,id',
            'appreciation_id' => 'required|integer|exists:appreciations,id',
            'name' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'last_name_en' => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'father_name_en' => 'required|string|max:255',
            'grand_father_name' => 'required|string|max:255',
            'grand_father_name_en' => 'required|string|max:255',
            'current_village' => 'required|string|max:255',
            'permanent_village' => 'required|string|max:255',
            'dob' => 'required|date',
            'dob_qamari' => 'required|string|max:255',
            'graduation_year' => 'required|integer',
            'phone' => 'required|string',
            'whatsapp' => 'required|string',
        ]);
        $user = User::find($student->user_id);
        $user->name = $request->name;
        $user->email = $request->phone;
        $user->save();
        $student->update($request->all());
        if ($request->hasFile('image_path')) {
            if (isset($student->image_path)) {
                $student->dropFile('image_path');
            }
            $student->image_path = $request->file('image_path')->store('public/students');
            $student->save();
        }
        return redirect()->back()->with("msg", __('messages.record_updated'));
    }

    public function importRajabFromExcel(Request $request)
    {
        $validated = $request->validate([
            'exam_id' => 'required',
            'address_type_id' => 'required',
        ]);
        $file = request()->file('excel_file');

        $extension = $file->getClientOriginalExtension();

        if ($extension !== 'xlsx' && $extension !== 'csv') {
            return back()->with('error', 'Invalid file type. Please upload an Excel or CSV file.');
        }

        $import = new RajabStudentImport($validated);
        Excel::import($import, $file->getRealPath());

        if ($import->failures()->isNotEmpty()) {
            // Retrieve validation failures
            $errors = [];
            foreach ($import->failures() as $failure) {
                $rowErrors = "Row {$failure->row()}: " . implode(', ', $failure->errors());
                $errors[] = $rowErrors;
            }

            // Redirect back with errors
            return redirect()->back()->withErrors($errors);
        }

        $invalidRows = $import->getInvalidRows();
        // dd($invalidRows);
        // If there are invalid rows, save them to a file
        if (!empty($invalidRows)) {
            $fileName = $import->saveInvalidRecordsToFile();

            // Show error message with download link
            return redirect()->back()->with([
                'error' => __('messages.error_uploading_excel'),
                'download_link' => $fileName,
            ]);
        }

        return redirect()->back()->with('msg', 'imported successfully');
    }

    public function importFromExcel(Request $request)
    {
        $validated = $request->validate([
            'exam_id' => 'required',
            'address_type_id' => 'required',
            'form_type' => 'required',
        ]);



        $file = request()->file('excel_file');

        $extension = $file->getClientOriginalExtension();

        if ($extension !== 'xlsx' && $extension !== 'csv') {
            return back()->with('error', 'Invalid file type. Please upload an Excel or CSV file.');
        }

        $import = new StudentImport($validated);
        Excel::import($import, $file, null, \Maatwebsite\Excel\Excel::XLSX);


        if ($import->failures()->isNotEmpty()) {
            // Retrieve validation failures
            $errors = [];
            foreach ($import->failures() as $failure) {
                $rowErrors = "Row {$failure->row()}: " . implode(', ', $failure->errors());
                $errors[] = $rowErrors;
            }

            // Redirect back with errors
            return redirect()->back()->withErrors($errors);
        }

        $invalidRows = $import->getInvalidRows();


        if (!empty($invalidRows)) {
            $fileName = $import->saveInvalidRecordsToFile();

            // Show error message with download link
            return redirect()->back()->with([
                'error' => __('messages.error_uploading_excel'),
                'download_link' => $fileName,
            ]);
        }

        return redirect()->back()->with('msg', 'imported successfully');
    }


    public function generateIdCard(Request $request)
    {
        $request->validate([
            'exam_id' => 'required'
        ]);

        $students = Student::orderBy('name')->whereIn('id', $request->student_ids)->get();
        $exam = Exam::with('students')->find($request->exam_id);

        foreach ($students as $student) {

            $currentExam = StudentExam::firstOrCreate(
                [
                    'exam_id' => $request->exam_id,
                    'student_id' => $student->id
                ],
                ['status' => 'created']
            );

            if ($currentExam->wasRecentlyCreated) {
                $currentExam->status = 'created';
            }
            $currentExam->save();
            // find campus of exam
            // if ($currentExam->status != 'class selected' || $currentExam->sub_class_id == null) {
                $campus = Campus::with('classes')->find($exam?->campus_id);
                $classes = $campus->classes;
                foreach ($classes as $class) {
                    $sub_classes = $class->subClasses;
                    if ($sub_classes) {
                        foreach ($sub_classes as $sub_class) {
                            $assigned_student_count = $sub_class->studentExams->count();
                            if ($sub_class->capacity > $assigned_student_count) {
                                $currentExam->update([
                                    'sub_class_id' => $sub_class->id,
                                    'status' => 'class selected',
                                ]);
                            }
                        }
                    }
                }
            // }
            // dd($assigned_student_count);
            // dd($exam);
            // if()
            // if exa exists then update exam_id else create new.

        }

        return view('backend.jamiat.student.card.generate', [
            'students' => $students
        ]);
    }
}
