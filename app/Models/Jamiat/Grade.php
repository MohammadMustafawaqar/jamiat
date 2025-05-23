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

    public function getLocalizedNameAttribute()
    {

        $replace = [
            'الیعلة' => 'علیې',
            'العالمیة' => 'عالمیې',
            'العالمیة العلیا' => 'عالیمةالعلیا'
        ];

        return str_replace(array_keys($replace), array_values($replace), $this->name);
    }

    public function getArabicEquivalentAttribute()
    {

        $replace = [
            'لیسانس' => 'البكالوريوس',
            'ماستري' => 'الماجستیر',
            'دوکتورا' => 'الدکتوراه'
        ];

        return str_replace(array_keys($replace), array_values($replace), $this->equivalent);
    }

    public function getEnglishEquivalentAttribute()
    {
        $replace = [
            'لیسانس' => "Bachelor's Degree",
            'ماستري' => "Master's Degree ",
            'دوکتورا' => "PhD's Degree"
        ];

        return str_replace(array_keys($replace), array_values($replace), $this->equivalent);
    }
}
