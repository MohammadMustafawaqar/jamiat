<?php

namespace App\Models\Jamiat;

use App\Models\School;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function schools()
    {
        return $this->belongsToMany(School::class);
    }

    public function getGradeClassesAttribute()
    {
        if ($this->id == 1) {
            return "( الدرجة السادسة، الدرجة السابعة، الدرجة الثامنة، الدرجة التاسعة)";
        } elseif ($this->id == 2) {
            return "(الدرجة العاشرة، الدرجة الحادي عشرة)";
        }

        return null; // Default value if no match
    }
}
