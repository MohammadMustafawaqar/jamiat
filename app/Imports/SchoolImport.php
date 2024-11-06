<?php

namespace App\Imports;

use App\Exports\InvalidSchoolExport;
use App\Models\AddressType;
use App\Models\District;
use App\Models\Jamiat\SchoolGrade;
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

class SchoolImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
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

        if (!$row['province']) {
            $errors[] = 'Invalid Province';
        } 

        $province = Province::firstOrCreate([
            'name' => $row['province'],
        ], [
            'country_id' => $address_type->id
        ]);

    

        $district = null;

        if($row['district'] != null){
            $district = District::firstOrCreate([
                'province_id' => $province->id,
                'name' => $row['district'],
            ]);
        }else{
            $district = District::firstOrCreate([
                'province_id' => $province->id,
                'name' => 'نامعلوم',
            ]);
        }
        if (!$district) {
            $errors[] = 'Invalid District';
        }
       

        $existingSchool = School::where('name', $row['name'])
            ->whereHas('province', function ($query) use ($province) {
                $query->where('id', $province->id);
            })
            ->exists();

        if ($existingSchool) {
            $errors[] = 'School already exists';
        }

         if (!empty($errors)) {
            $row['errors'] = implode(', ', $errors); // Add errors to the row
            $this->invalidRows[] = $row; // Store the invalid row
            return null; // Skip this row
        }

        $school = School::create([
            'address_type_id' => $address_type->id,
            'province_id' => $province->id,
            'district_id' => $district->id,
            'village' => $row['village'] ?? 'نامعلوم',
            'name' => $row['name'],
            'details' => '',
            'status' => 'imported_from_excel'
        ]);

        SchoolGrade::create([
            'school_id' => $school->id,
            'grade_id' => 2
        ]);

        return $school;




       

        // If there are any errors, capture the invalid row with errors

    }

    public function rules(): array
    {
        return [
            'address_type' => 'required|string',
            'province' => 'required|string',
            'village' => 'nullable|string',
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
