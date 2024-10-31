<?php

namespace App\Models\Jamiat;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentExam extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $with = ['subClass'];

    public function class()
    {
        return $this->belongsTo(CClass::class, 'class_id');
    }
    public function subClass()
    {
        return $this->belongsTo(SubClass::class, 'sub_class_id');
    }

    public function student()
    {
        return $this->belongsToMany(Student::class);
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }
}
