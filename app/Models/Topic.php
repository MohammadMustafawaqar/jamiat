<?php

namespace App\Models;

use App\Enums\TopicStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;
    protected $casts = [
        'status' => TopicStatus::class,
    ];
    protected $fillable = ['user_id', 'title', 'status','remarks'];

    public function user() {
        return $this->belongsTo(User::class);
    }
    public function theses() {
        return $this->hasMany(Thesis::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'user_id');
    }
    public function fee()
    {
        return $this->hasOne(Fee::class);
    }
}
