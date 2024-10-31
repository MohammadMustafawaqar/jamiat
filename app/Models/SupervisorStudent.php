<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupervisorStudent extends Model
{
    use HasFactory;
    protected $fillable = ['supervisor_id', 'student_id', 'details'];

    public function supervisor()
    {
        return $this->belongsTo(Supervisor::class);
    }
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
