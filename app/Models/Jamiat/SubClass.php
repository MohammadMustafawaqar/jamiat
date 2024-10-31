<?php

namespace App\Models\Jamiat;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubClass extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function class()
    {
        return $this->belongsTo(CClass::class);
    }

    
    public function studentExams()
    {
        return $this->hasMany(StudentExam::class, 'sub_class_id', 'id');
    }

    public function getAddressAttribute()
    {
        
        return $this->class->campus->name . '، ' . $this->class->name . '، ' . $this->name;
    }
}
