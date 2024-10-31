<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supervisor extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','name', 'last_name', 'father_name', 'phone', 'whatsapp'];

    public function students()
    {
        return $this->belongsToMany(Student::class, 'supervisor_students')->withPivot(["id", "student_id"]);
    }
}
