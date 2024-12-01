<?php

namespace App\Models\Jamiat;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentExamSubject extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $tableName = 'student_exam_subjects';
    public function examSubject()
    {
        return $this->belongsTo(ExamSubject::class, 'exam_subject_id');
    }

    public function subject()
    {
        return $this->hasOneThrough(
            Subject::class,
            ExamSubject::class,
            'id',               // Foreign key on ExamSubject table
            'id',               // Foreign key on Subject table
            'exam_subject_id',  // Local key on StudentExamSubject table
            'subject_id'        // Local key on ExamSubject table
        );
    }

    public function studentExam()
    {
        return $this->belongsTo(StudentExam::class);
    }

    public function student()
    {
        return $this->hasOneThrough(Student::class, StudentExam::class, 'id', 'id', 'student_exam_id', 'student_id');
    }
}
