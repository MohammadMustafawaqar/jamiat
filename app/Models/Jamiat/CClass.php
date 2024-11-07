<?php

namespace App\Models\Jamiat;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CClass extends Model
{
    use HasFactory;

    protected $table = 'classes';
    protected $with = ['studentExams', 'subClasses'];

    protected $guarded = [];

    public function campus()
    {
        return $this->belongsTo(Campus::class);
    }

    public function studentExams()
    {
        return $this->hasMany(StudentExam::class, 'class_id', 'id');
    }

    public function getAddressAttribute()
    {
        
        return $this->campus->name . '، ' . $this->name;
    }

    public function subClasses()
    {
        return $this->hasMany(SubClass::class, 'class_id', 'id');
    }

  
}
