<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InvalidStudentsExport implements FromArray, WithHeadings
{
    protected $invalidRows;

    public function __construct(array $invalidRows)
    {
        $this->invalidRows = $invalidRows;
    }

    public function array(): array
    {
        return array_map(function ($row) {
            return [
                'form_id'             => (string) ($row['form_id'] ?? ''),
                'name'                => (string) ($row['name'] ?? ''),
                'last_name'           => (string) ($row['last_name'] ?? ''),
                'father_name'         => (string) ($row['father_name'] ?? ''),
                'grand_father_name'   => (string) ($row['grand_father_name'] ?? ''),
                'current_province'    => (string) ($row['current_province'] ?? ''),
                'current_district'    => (string) ($row['current_district'] ?? ''),
                'current_village'     => (string) ($row['current_village'] ?? ''),
                'permanent_province'  => (string) ($row['permanent_province'] ?? ''),
                'permanent_district'  => (string) ($row['permanent_district'] ?? ''),
                'permanent_village'   => (string) ($row['permanent_village'] ?? ''),
                'school_country'      => (string) ($row['school_country'] ?? ''),
                'school_province'     => (string) ($row['school_province'] ?? ''),
                'school_district'     => (string) ($row['school_district'] ?? ''),
                'school'              => (string) ($row['school'] ?? ''),
                'gender'              => (string) ($row['gender'] ?? ''),
                'graduation_year'     => (string) ($row['graduation_year'] ?? ''),
                'appreciation'        => (string) ($row['appreciation'] ?? ''),
                'education_level'     => (string) ($row['education_level'] ?? ''),
                'mother_tongue'       => (string) ($row['mother_tongue'] ?? ''),
                'dob_qamari'          => (string) ($row['dob_qamari'] ?? ''),
                'phone'               => (string) ($row['phone'] ?? ''),
                'whatsapp'            => (string) ($row['whatsapp'] ?? ''),
                'tazkira_no'             => (string) ($row['tazkira_no'] ?? ''),
                'relative_contact'    => (string) ($row['relative_contact'] ?? ''),
                'errors'              => (string) ($row['errors'] ?? ''), // Include errors column if present
            ];
        }, $this->invalidRows);
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
            'school',
            'gender',
            'graduation_year',
            'appreciation',
            'education_level',
            'mother_tongue',
            'dob_qamari',
            'phone',
            'whatsapp',
            'tazkira',
            'relative_contact',
            'errors', // Include errors column
        ];
    }
}
