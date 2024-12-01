<?php

namespace App\Models\Jamiat;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamSubject extends Model
{
    use HasFactory;
    
    protected $tableName = 'exam_subjects';
    protected $guarded = [];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

}
