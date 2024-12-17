<?php

namespace App\Models\Jamiat;

use App\Models\AddressType;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentForm extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table_name = 'Student_forms';
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function getFormattedSerialNumberAttribute()
    {
        $letter = '';
        $grade_id = $this->grade->id;
        switch ($grade_id) {
            case 1: 
                $letter = 'ل';
                break;
            case 2: 
                $letter = 'م';
                break;
            case 3: 
                $letter = 'د';
                break;
        }
        $englishDigits = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $arabicDigits = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];

        // $arabic =  str_replace($englishDigits, $arabicDigits, $this->serial_number);
        return $letter .'-'. str_pad($this->serial_number, 8, '0', STR_PAD_LEFT);
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }

    public function addressType()
    {
        return $this->belongsTo(AddressType::class);
    }

 


}
