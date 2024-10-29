<?php

namespace App\Models\Jamiat;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubClass extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function class()
    {
        return $this->belongsTo(CClass::class);
    }
}
