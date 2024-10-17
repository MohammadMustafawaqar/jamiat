<?php

namespace App\Models;

use App\Enums\ThesisStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thesis extends Model
{
    use HasFactory;
    protected $casts = [
        'status' => ThesisStatus::class,
    ];
    protected $fillable = ['topic_id', 'details','status','marks'];

    public function topic() {
        return $this->belongsTo(Topic::class);
    }
    public function comments() {
        return $this->hasMany(Comment::class);
    }

    
    protected function filePath(): Attribute
    {
        return Attribute::make(function ($value) {
            if ($value) {
                $value = explode('public/', $value);
                $value = 'storage/' . $value[1];
                return url($value);
            }
        });
    }
    public function dropFile()
    {
        $public_path =  explode('storage', $this->file_path);
        $public_path =  public_path() . '/storage' . $public_path[1];
        if (file_exists($public_path)) {
            unlink($public_path);
        }
    }
}
