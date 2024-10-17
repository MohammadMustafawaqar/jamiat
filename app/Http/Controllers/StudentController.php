<?php

namespace App\Http\Controllers;

use App\Models\Appreciation;
use App\Models\Category;
use App\Models\Country;
use App\Models\Gender;
use App\Models\School;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::get();
        return view('student.index', compact("students"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $countries = Country::get();
        $schools = School::get();
        $categories = Category::get();
        $appreciations = Appreciation::get();
        $genders = Gender::get();
        return view('student.create', compact("countries", "schools", 'categories', 'appreciations', 'genders'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
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
        $user = User::create([
            'name' => $request->name,
            'email' => $request->phone,
            'password' => Hash::make('12345678'),
        ]);
        $request->merge(['user_id' => $user->id]);
        $student = Student::create($request->all());
        if ($request->hasFile('image_path')) {
            $student->image_path = $request->file('image_path')->store('public/students');
            $student->save();
        }
        return redirect()->back()->with("msg", __('messages.record_submitted'));
    }

    /**
     * Display the specified resource.
     */
    public function show($locale, Student $student)
    {
        return view('student.show',compact('student'));
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
        return view('student.edit', compact("student", "countries", "schools", 'categories', 'appreciations', 'genders'));
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
        //
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
}
