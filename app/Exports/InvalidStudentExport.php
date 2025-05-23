<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InvalidStudentExport implements WithHeadings
{
    protected $invalidRows;

    public function __construct(array $invalidRows)
    {
        $this->invalidRows = $invalidRows;
    }


    public function headings(): array
    {
        return [
            'form_id',
            'name',
            'last_name',
            'father_name',
            'grand_father_name',
            'current_province',
            'current_district',
            'current_village',
            'permanent_province',
            'permanent_district',
            'permanent_village',
            'school_country',
            'school_province',
            'school_district',
            'school_name',
            'gender',
            'tazkira_type',
            'tazkira_no',
            'dob',
            'dob_qamari',
            'dob_shamsi',
            'phone',
            'errors', // Include errors column
        ];
    }
}
