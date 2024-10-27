<?php

namespace App\Models\Jamiat;

use App\Models\School;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function schools()
    {
        return $this->belongsToMany(School::class);
    }
}
