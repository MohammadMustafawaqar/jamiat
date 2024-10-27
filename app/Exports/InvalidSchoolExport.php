<?php

namespace App\Exports;

use App\Models\School;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InvalidSchoolExport implements FromArray, WithHeadings
{
    protected $invalidRows;

    public function __construct(array $invalidRows)
    {
        $this->invalidRows = $invalidRows;
    }

    public function array(): array
    {
        return $this->invalidRows;
    }

    public function headings(): array
    {
        return [
            'name',
            'address_type',
            'province',
            'district',
            'village',
            'details',
            'Errors', // Include errors in the heading
        ];
    }
}
