<?php

namespace App\Models\Jamiat;

use App\Models\Province;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campus extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function classes()
    {
        return $this->hasMany(CClass::class);
    }



    
}
