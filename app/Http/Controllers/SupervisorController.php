<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Supervisor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SupervisorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $supervisors = Supervisor::get();
        return view('supervisor.index', compact('supervisors'));
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
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'phone' => 'required|string|max:15|unique:users,email',
            'whatsapp' => 'required|string|max:15',
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->phone,
            'user_type' => 'Supervisor',
            'password' => Hash::make('12345678'),
        ]);
        $request->merge(['user_id' => $user->id]);
        Supervisor::create($request->all());
        return redirect()->back()->with("msg", __('messages.record_submitted'));
    }


    /**
     * Display the specified resource.
     */
    public function show($locale, Supervisor $supervisor)
    {
        return view('supervisor.show', compact('supervisor'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($locale, Supervisor $supervisor)
    {
        return view('supervisor.edit', compact('supervisor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($locale, Request $request, Supervisor $supervisor)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'whatsapp' => 'required|string|max:15',
        ]);
        $supervisor->update($request->all());
        return redirect()->route('supervisors.index')->with("msg", __('messages.record_updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($locale, Supervisor $supervisor)
    {
        $supervisor->delete();
        return redirect()->back()->with("msg", __('messages.record_deleted'));
    }


    public function allStudent()
    {
        $students = Supervisor::where('user_id', Auth::id())->first()->students;
        return view('supervisorPages.student.index', compact('students'));
    }


    public function showSupervisorStudent($locale, $student_id)
    {
        $student = Student::with('user', 'user.topic', 'user.topic.theses')->find($student_id);

        // dd($student);

        return view('supervisorPages.student.show', compact('student'));
    }
}
