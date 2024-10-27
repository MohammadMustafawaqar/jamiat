<?php

namespace App\Models\Jamiat;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentForm extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table_name = 'Student_forms';
    public function student()
    {
        return $this->belongsTo(Student::class);
    }


}
