<?php

namespace App\Models\Jamiat;

use App\Models\District;
use App\Models\Province;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }
}

