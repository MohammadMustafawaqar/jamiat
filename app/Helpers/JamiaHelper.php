<?php 
namespace App\Helpers;

use App\Models\Country;
use App\Models\Jamiat\Campus;
use App\Models\Jamiat\EducationLevel;
use App\Models\Jamiat\Exam;
use App\Models\Jamiat\Grade;
use App\Models\Jamiat\Language;

class JamiaHelper{

    public static function grades()
    {
        return Grade::where("status", "active")->get();
    }

    public static function educationLevels()
    {
        return EducationLevel::all();
    }

    public static function languages()
    {
        return Language::all();
    }

    public static function exams()
    {
        return Exam::all();
    }

    public static function campuses()
    {
        return Campus::all();
    }

    public static function countries()
    {
        return Country::all();
    } 
}