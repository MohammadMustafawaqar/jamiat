<?php

namespace App\Models;

use App\Models\Jamiat\Exam;
use App\Models\Jamiat\ExamSubject;
use App\Models\Jamiat\Form;
use App\Models\Jamiat\StudentExam;
use App\Models\Jamiat\StudentExamSubject;
use App\Models\Jamiat\StudentForm;
use App\Models\Jamiat\Tazkira;
use App\Traits\CreatedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory, CreatedBy;
    protected $guarded = [];


    public function addressType()
    {
        return $this->belongsTo(AddressType::class);
    }

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
            get: fn() => "{$this->currentDistrict->province->name}, {$this->currentDistrict->name}, {$this->current_village}",
        );
    }
    protected function permanentAddress(): Attribute
    {
        return Attribute::make(
            get: fn() => "{$this->permanentDistrict->province->name}, {$this->permanentDistrict->name}, {$this->permanent_village}",
        );
    }


    protected function getPermanentFullAddressAttribute()
    {
        return "{$this->permanentDistrict->province->name}, {$this->permanentDistrict->name}, {$this->permanent_village}";
    }

    public function exams()
    {
        return $this->belongsToMany(Exam::class, 'student_exams', 'student_id', 'exam_id')
            ->withPivot('student_id', 'exam_id', 'class_id', 'sub_class_id');
    }

    public function forms()
    {
        return $this->belongsToMany(Form::class, 'student_forms',  'student_id', 'form_id')
            ->withPivot('id');
    }

    public function getFormTypeAttribute()
    {
        return $this->forms()->first()?->id ? __('jamiat.'.$this->forms()->first()?->form_type) : '';
    }

    public function getFullNameAttribute()
    {
        return $this->name . ' '. $this->last_name;
    }

    public function tazkira()
    {
        return $this->belongsTo(Tazkira::class);
    }

    public function studentExams()
    {
        return $this->hasMany(StudentExam::class);
    }

    public function getPhoneNumberAttribute()
    {
        return $this->phone && $this->phone[0] === '0' && $this->phone[0] != '+' ? $this->phone : '0' . $this->phone;
    }
    public function getWhatsappAttribute($value)
    {
        return $value && $value[0] === '0' && $value[0] != '+' ? $value : '0' . $value;
    }

  

 


}
