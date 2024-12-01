<?php

namespace App\Models;

use App\Models\Jamiat\Exam;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appreciation extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function exams()
    {
        return $this->belongsToMany(Exam::class);
    }
}
