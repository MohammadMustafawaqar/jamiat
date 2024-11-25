<?php

namespace App\Models\Jamiat;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_forms', 'form_id');
    }

    public function studentForms()
    {
        return $this->hasMany(StudentForm::class);
    }
}
