<?php

namespace App\Imports;

use App\Exports\InvalidStudentExport;
use App\Global\Settings;
use App\Models\AddressType;
use App\Models\Country;
use App\Models\District;
use App\Models\Gender;
use App\Models\Jamiat\StudentExam;
use App\Models\Jamiat\StudentForm;
use App\Models\Jamiat\Tazkira;
use App\Models\Province;
use App\Models\School;
use App\Models\Student;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Facades\Excel;

class RajabStudentImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{

    use SkipsFailures;

    protected $requestData;
    // Store invalid rows and errors
    protected $invalidRows = [];

    public function __construct($requestData)
    {
        // Store additional request data
        $this->requestData = $requestData;
    }

    public function model(array $row)
    {
        $errors = [];


        // Retrieve IDs based on `name` from models, and capture errors if not found
        $currentDistrict = District::where('name', $row['current_district'])->first();
        if (!$currentDistrict) $errors[] = "Invalid Current District";

        $permanentDistrict = District::where('name', $row['permanent_district'])->first();
        if (!$permanentDistrict) $errors[] = "Invalid Permanent District";

        $schoolCountry = Country::where('name', $row['school_country'])->first();
        if (!$schoolCountry) $errors[] = "Invalid School Country";

        $schoolProvince = Province::where('name', $row['school_province'])->first();
        if (!$schoolProvince) $errors[] = "Invalid School Province";

        $schoolDistrict = District::where('name', $row['school_district'])->first();
        if (!$schoolDistrict) $errors[] = "Invalid School District";

        $school = School::where('name', $row['school'])
            ->where(function ($query) use ($schoolProvince, $schoolDistrict) {
                $query->where('province_id', $schoolProvince?->id)
                    ->orWhere('district_id', $schoolDistrict?->id);
            })
            ->first();

        if (!$school) $errors[] = "Invalid School";

        $gender = Gender::where('name_ps', $row['gender'])->first();
        if (!$gender) $errors[] = "Invalid Gender";

        // If there are errors, store them and skip the row
        if (!empty($errors)) {
            $row['errors'] = implode(', ', $errors);
            $this->invalidRows[] = $row;
            return null; // Skip invalid row
        }


        // Create Tazkira record if tazkira_type and tazkira_no are provided
        $tazkira = Tazkira::create([
            'type' => $row['tazkira_type'],
            'tazkira_no' => $row['tazkira_no'],
        ]);

        // Create Student record with resolved IDs
        $student = Student::create([
            'form_id' => $row['form_id'],
            'name' => $row['name'],
            'last_name' => $row['last_name'],
            'father_name' => $row['father_name'],
            'grand_father_name' => $row['grand_father_name'],
            'current_district_id' => $currentDistrict->id,
            'permanent_district_id' => $permanentDistrict->id,
            'current_village' => $row['current_village'],
            'permanent_village' => $row['permanent_village'],
            'school_id' => $school->id,
            'gender_id' => $gender->id,
            'dob_qamari' => $row['dob_qamari'],
            'phone' => $row['phone'],
            'tazkira_id' => $tazkira->id,
        ]);

        // Create StudentExam record
        StudentExam::create([
            'student_id' => $student->id,
            'exam_id' => $this->requestData['exam_id'],
        ]);

        // Create StudentForm record
        StudentForm::create([
            'student_id' => $student->id,
            'form_id' => 3,
        ]);

        return $student;
    }

    public function rules(): array
    {
        return [
            'form_id' => 'required',

            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'grand_father_name' => 'required|string|max:255',

            'current_district' => 'required',
            'permanent_district' => 'required',
            'current_village' => 'required|string|max:255',
            'permanent_village' => 'required|string|max:255',

            'school_country' => 'required',
            'school_province' => 'required',
            'school_district' => 'required',
            'school' => 'required',
            'gender' => 'required',

            'tazkira_type' => 'nullable',
            'tazkira_no' => 'required|integer|unique:tazkiras,tazkira_no',

            'dob' => ['required', 'string', 'regex:/^\d{4}-\d{2}-\d{2}$/'],
            'dob_shamsi' => ['required', 'string', 'regex:/^\d{4}-\d{2}-\d{2}$/'],
            'dob_qamari' => ['required', 'string', 'regex:/^\d{4}-\d{2}-\d{2}$/'],

            'phone' => ['required', 'string', 'regex:/^(07\d{8}|00937\d{8})$/'],
        ];
    }

    public function getInvalidRows()
    {

        return $this->invalidRows;
    }

    // After import event to handle export of invalid records
    public function saveInvalidRecordsToFile()
    {
        $fileName = 'invalid_students_import_' . time() . '.xlsx';
        Excel::store(new InvalidStudentExport($this->invalidRows), 'public/excel_error/' . $fileName);

        return $fileName;
    }
}
