<?php

namespace App\Imports;

use App\Exports\InvalidSchoolExport;
use App\Models\AddressType;
use App\Models\District;
use App\Models\Province;
use App\Models\School;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Facades\Excel;

class SchoolImport implements  ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{

    use SkipsFailures;

    // Store invalid rows and errors
    protected $invalidRows = [];

    public function model(array $row)
    {
        $errors = [];
       

        // Validate related models and capture errors
        $address_type = AddressType::where('name', $row['address_type'])->first();
        if (!$address_type) {
            $errors[] = 'Invalid Address Type';
        }

        $province = Province::where('name', $row['province'])->first();
        if (!$province) {
            $errors[] = 'Invalid Province';
        }

        $district = District::where('name', $row['district'])->first();
        if (!$district) {
            $errors[] = 'Invalid District';
        }

        // If there are any errors, capture the invalid row with errors
        if (!empty($errors)) {
            $row['errors'] = implode(', ', $errors); // Add errors to the row
            $this->invalidRows[] = $row; // Store the invalid row
            return null; // Skip this row
        }


        // If no errors, return the new model
        return new School([
            'address_type_id' => $address_type->id,
            'province_id' => $province->id,
            'district_id' => $district->id,
            'village' => $row['village'],
            'name' => $row['name'],
            'details' => $row['details'],
        ]);
    }

    public function rules(): array
    {
        return [
            'address_type' => 'required|string',
            'province' => 'required|string',
            'district' => 'required|string',
            'village' => 'required|string',
            'name' => 'required|string',
            'details' => 'nullable|string',
        ];
    }

    public function getInvalidRows()
    {

        return $this->invalidRows;
    }

    // After import event to handle export of invalid records
    public function saveInvalidRecordsToFile()
    {
        $fileName = 'invalid_schools_' . time() . '.xlsx';
        Excel::store(new InvalidSchoolExport($this->invalidRows), 'public/excel_error/' . $fileName);

        return $fileName;
    }
  
    
   
}
