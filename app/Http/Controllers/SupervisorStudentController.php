<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Supervisor;
use App\Models\SupervisorStudent;
use Illuminate\Http\Request;

class SupervisorStudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $supervisorStudents = SupervisorStudent::get();
        $students = Student::orderBy('id', 'desc')->get();
        $supervisors = Supervisor::orderBy('id', 'desc')->get();
        return view('supervisorStudent.index', compact('supervisorStudents', 'supervisors', 'students'));
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
        $request->validate([
            'supervisor_id' => 'required|integer',
            'student_id' => 'required|integer|unique:supervisor_students',
        ]);
        SupervisorStudent::create([
            'supervisor_id' => $request->supervisor_id,
            'student_id' => $request->student_id
        ]);
        // foreach ($request->student_id as  $value) {
        //     SupervisorStudent::create([
        //         'supervisor_id' => $request->supervisor_id,
        //         'student_id' => $value
        //     ]);
        // }
        return redirect()->back()->with("msg", __('messages.record_submitted'));
    }
    /**
     * Display the specified resource.
     */
    public function show(SupervisorStudent $supervisorStudent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($locale, SupervisorStudent $supervisorStudent)
    {
        $students = Student::orderBy('id', 'desc')->get();
        $supervisors = Supervisor::orderBy('id', 'desc')->get();
        return view('supervisorStudent.edit', compact('supervisorStudent', 'students', 'supervisors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($locale, Request $request, SupervisorStudent $supervisorStudent)
    {
        $request->validate([
            'supervisor_id' => 'required|integer',
            'supervisor_id' => 'required',
        ]);
        $supervisorStudent->update($request->all());
        return redirect()->route('supervisor-student.index')->with("msg", __('messages.record_updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($locale, SupervisorStudent $supervisorStudent)
    {
        $supervisorStudent->delete();
        return redirect()->back()->with("msg", __('messages.record_deleted'));
    }
}
