<?php

namespace App\Models\Jamiat;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tazkira extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function tazkiraNo(): Attribute
{
    return Attribute::make(
        get: fn () => str_replace(['-', ' ', ''], '', $this->attributes['tazkira_no']),
    );
}
}
