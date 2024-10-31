<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Committee extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'student_id', 'committee_member_id', 'date_time', 'details'];
    protected static function booted()
    {
        static::creating(function ($model) {
            $model->user_id = Auth::id();
        });
    }

    public function committeeMember()
    {
        return $this->belongsTo(CommitteeMember::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
