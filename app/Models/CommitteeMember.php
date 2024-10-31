<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CommitteeMember extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'name', 'last_name', 'father_name', 'phone', 'job', 'details'];
    protected static function booted()
    {
        static::creating(function ($model) {
            $model->user_id = Auth::id();
        });
    }

    public function committees()
    {
        return $this->hasMany(Committee::class);
    }
}
