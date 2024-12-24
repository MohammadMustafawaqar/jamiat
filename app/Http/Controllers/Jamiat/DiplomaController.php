<?php

namespace App\Http\Controllers\Jamiat;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;

class DiplomaController extends Controller
{
    public function create()
    {
        return view('backend.jamiat.student.diploma.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'exam_id' => 'required',
            'student_ids' => 'required',
        ]);

        $students = Student::whereIn('id', $request->student_ids)
            ->whereHas('studentExams', function($query) use($request){
                $query->where('exam_id', $request->exam_id)
                    ->where('appreciation_id', '<>', null);
            })->get();


        if($students->isEmpty()){
            return redirect()->back()->with('error', __('messages.no_succeed_students'));
        }
        
        return view('backend.jamiat.student.diploma.create', [
            'students' => $students,
        ]);
    }
}
