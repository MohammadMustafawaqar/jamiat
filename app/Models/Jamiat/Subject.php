<?php

namespace App\Models\Jamiat;

use App\Global\Settings;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getNameAttribute()
    {
        return Settings::trans($this->en_name, $this->pa_name, $this->da_name, $this->ar_name);
    }

    public function studentExamSubject()
    {
        return $this->hasOneThrough(StudentExamSubject::class, ExamSubject::class);
    }
}
