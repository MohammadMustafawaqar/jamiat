<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class RajabStudentExport implements FromCollection,WithHeadings, WithMapping
{

    private $request_data; 

    public function __construct($request)
    {
        $this->request_data = $request;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Student::where('form_id', 3)->when($this->request_data['school_id'], function($query) {
            $query->where('school_id', $this->request_data['school_id']);
        })->with(['tazkira', 'school'])->get();
    }

    public function headings(): array
    {
        return [
            'شمېره',
            'فورم ایډی',
            'نوم',
            'پلار نوم',
            'تذکرې شمېره',
            'اوسنې پته',
            'دایمي پته',
            'اړیکې شمېره',
            'واټسپ',
            'جامعې نوم',
            'جامعې ادرس',
            'د فراغت کال',
            'تقدیر',
        ];
    }

    public function map($student): array
    {
        return [
            $student->id,
            $student->form_id,
            $student->full_name,
            $student->father_name,
            $student->tazkira?->tazkira_no,
            $student->currentAddress,
            $student->permanentAddress,
            $student->phone,
            $student->whatsapp != $student->phone ? $student->whatsapp : '',
            $student->school?->name,
            $student->school?->address,
            $student->graduation_year,
            $student->appreciation?->name ?? 'نامعلوم',
        ];
    }
}
