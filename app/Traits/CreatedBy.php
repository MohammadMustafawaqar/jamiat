<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

trait CreatedBy
{
    protected static function bootCreatedBy()
    {
        static::creating(function ($model) {
            if (auth()->check()) {
                $model->created_by = Auth::id();
            }
        });
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
