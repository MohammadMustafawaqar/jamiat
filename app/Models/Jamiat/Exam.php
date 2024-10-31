<?php

namespace App\Models\Jamiat;

use App\Models\District;
use App\Models\Province;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }

    public function campus()
    {
        return $this->belongsTo(Campus::class);
    }

    public function classes()
    {
        return $this->hasManyThrough(CClass::class, Campus::class, 'id', 'campus_id', 'campus_id', 'id');
    }
    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_exams');
    }

    public function getFullAddressAttribute()
    {
        return $this->address . ', ' . $this->district?->name . ', ' . $this->province?->name;
    }
}

