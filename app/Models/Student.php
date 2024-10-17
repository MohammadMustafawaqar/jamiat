<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'current_district_id',
        'permanent_district_id',
        'sub_category_id',
        'school_id',
        'gender_id',
        'appreciation_id',
        'form_id',
        'name',
        'name_en',
        'last_name',
        'last_name_en',
        'father_name',
        'father_name_en',
        'grand_father_name',
        'grand_father_name_en',
        'current_village',
        'permanent_village',
        'dob',
        'dob_qamari',
        'graduation_year',
        'phone',
        'whatsapp',
    ];

    public function currentDistrict()
    {
        return $this->belongsTo(District::class, 'current_district_id');
    }

    public function permanentDistrict()
    {
        return $this->belongsTo(District::class, 'permanent_district_id');
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function gender()
    {
        return $this->belongsTo(Gender::class);
    }

    public function appreciation()
    {
        return $this->belongsTo(Appreciation::class);
    }

    public function supervisors()
    {
        return $this->belongsToMany(Supervisor::class, 'supervisor_students');
    }
    public function committees()
    {
        return $this->hasMany(Committee::class);
    }

    protected function imagePath(): Attribute
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
        $public_path =  explode('storage', $this->image_path);
        $public_path =  public_path() . '/storage' . $public_path[1];
        if (file_exists($public_path)) {
            unlink($public_path);
        }
    }

    // public function topic()
    // {
    //     return $this->hasOne(Topic::class, 'user_id');
    // }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function thesesOfLastTopic()
    {
        return $this->hasManyThrough(Thesis::class, Topic::class, 'user_id', 'topic_id');
    }

    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn() => "{$this->name} {$this->last_name}",
        );
    }
    protected function currentAddress(): Attribute
    {
        return Attribute::make(
            get: fn() => "{$this->currentDistrict->province->country->name} - {$this->currentDistrict->province->name} - {$this->currentDistrict->name} - {$this->current_village}",
        );
    }
    protected function permanentAddress(): Attribute
    {
        return Attribute::make(
            get: fn() => "{$this->permanentDistrict->province->country->name} - {$this->permanentDistrict->province->name} - {$this->permanentDistrict->name} - {$this->permanent_village}",
        );
    }


}
