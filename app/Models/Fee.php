<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fee extends Model
{
    use HasFactory;

   
    protected $fillable = ['topic_id', 'amount', 'details'];

    public function topic() {
        return $this->belongsTo(Topic::class);
    }
   
    public function fee()
    {
        return $this->hasOne(Fee::class);
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
