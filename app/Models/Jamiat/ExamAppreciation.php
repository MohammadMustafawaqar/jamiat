<?php

namespace App\Models\Jamiat;

use App\Models\Appreciation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamAppreciation extends Model
{
    use HasFactory;

    protected $tableName = 'exam_appreciations';

    protected $guarded = [];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function appreciation()
    {
        return $this->belongsTo(Appreciation::class);
    }
}
