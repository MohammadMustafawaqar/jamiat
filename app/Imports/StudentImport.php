<?php

namespace App\Imports;

use App\Exports\InvalidStudentExport;
use App\Exports\InvalidStudentsExport;
use App\Global\Settings;
use App\Models\AddressType;
use App\Models\Appreciation;
use App\Models\Country;
use App\Models\District;
use App\Models\Gender;
use App\Models\Jamiat\EducationLevel;
use App\Models\Jamiat\Form;
use App\Models\Jamiat\Language;
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

class StudentImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
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

        $currentProvince = Province::where('name', $row['current_province'])->first();
        if (!$currentProvince) $errors[] = "Invalid Current Province";

        // Retrieve IDs based on `name` from models, and capture errors if not found
        $currentDistrict = District::where('name', $row['current_district'])
            ->where('province_id', $currentProvince->id)->first();
        if (!$currentDistrict) $errors[] = "Invalid Current District";

        $permanentProvince = Province::where('name', $row['permanent_province'])->first();
        if (!$permanentProvince) $errors[] = "Invalid Permanent Province";

        $permanentDistrict = District::where('name', $row['permanent_district'])
            ->where('province_id', $permanentProvince->id)->first();
        if (!$permanentDistrict) $errors[] = "Invalid Permanent District";

        $schoolCountry = Country::where('name', $row['school_country'])->first();
        if (!$schoolCountry) $errors[] = "Invalid School Country";

        $schoolProvince = Province::where('name', $row['school_province'])->first();
        if (!$schoolProvince) $errors[] = "Invalid School Province";

        $schoolDistrict = District::where('name', $row['school_district'])->first();
        if (!$schoolDistrict) $errors[] = "Invalid School District";

        $school = School::where('name', $row['school'])
            ->where(function ($query) use ($schoolProvince, $schoolDistrict) {
                $query->where('province_id', $schoolProvince->id)
                    ->orWhere('district_id', $schoolDistrict->id);
            })
            ->first();

        if (!$school) $errors[] = "School Not Found";

        $gender = Gender::where('name_ps', $row['gender'])->first();
        if (!$gender) $errors[] = "Gender Not Found";

        $language = Language::where('pa_name', $row['mother_tongue'])
            ->orWhere('en_name', $row['mother_tongue'])
            ->orWhere('ar_name', $row['mother_tongue'])
            ->orWhere('da_name', $row['mother_tongue'])
            ->first();
        if (!$language) $errors[] = "Mother Tongue Not Found";

        $edu_level = EducationLevel::where('pa_name', $row['education_level'])
            ->orWhere('da_name', $row['education_level'])
            ->orWhere('en_name', $row['education_level'])
            ->orWhere('ar_name', $row['education_level'])
            ->first();
        if (!$edu_level) $errors[] = "Education Level Not Found";

        $appreciation = Appreciation::where('name', $row['appreciation'])->first();
        if (!$appreciation) $errors[] = "Appreciation Not Found";

        if (!empty($errors)) {
            $row['errors'] = implode(', ', $errors);
            $this->invalidRows[] = $row;
            return null;
        }


        // Create Tazkira record if tazkira_type and tazkira_no are provided
        $tazkira = Tazkira::create([
            'type' => $row['tazkira_type'],
            'tazkira_no' => $row['tazkira_no'],
        ]);

        // Create Student record with resolved IDs
        $student = Student::create([
            'address_type_id' => $this->requestData['address_type_id'],
            'form_id' => $row['form_id'],
            'name' => $row['name'],
            'last_name' => $row['last_name'],
            'father_name' => $row['father_name'],
            'grand_father_name' => $row['grand_father_name'],
            'current_district_id' => $currentDistrict->id,
            'permanent_district_id' => $permanentDistrict->id,
            'current_village' => $row['current_village'],
            'permanent_village' => $row['permanent_village'],
            'education_level_id' => $edu_level->id,
            'language_id' => $language->id,
            'appreciation_id' => $appreciation->id,
            'graduation_year' => $row['graduation_year'],
            'school_id' => $school->id,
            'gender_id' => $gender->id,
            'dob_qamari' => $row['dob_qamari'],
            'phone' => $row['phone'],
            'whatsapp' => $row['whatsapp'],
            'tazkira_id' => $tazkira->id,
            'relative_contact' => $row['relative_contact'],
        ]);

        // Create StudentExam record
        StudentExam::create([
            'student_id' => $student->id,
            'exam_id' => $this->requestData['exam_id'],
        ]);


        $form = Form::where('form_type', $this->requestData['form_type'])->first();
        // Create StudentForm record
        StudentForm::create([
            'student_id' => $student->id,
            'form_id' => $form->id,
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
            'current_province' => 'required|string|max:255',
            'permanent_province' => 'required|string|max:255',
            'current_district' => 'required',
            'permanent_district' => 'required',
            'current_village' => 'required|string|max:255',
            'permanent_village' => 'required|string|max:255',

            'school_country' => 'required',
            'school_province' => 'required',
            'school_district' => 'required',
            'school' => 'required',
            'gender' => 'required',

            'mother_tongue' => 'required|string|max:255',
            'education_level' => 'required|string|max:255',

            'tazkira_type' => 'nullable',
            'tazkira_no' => 'required|integer|unique:tazkiras,tazkira_no',

            'dob_qamari' => ['required', 'string', 'regex:/^\d{4}-\d{2}-\d{2}$/'],

            'appreciation' => 'required',
            'graduation_year' => 'required|integer',


            'phone' => ['required', 'string', 'regex:/^(07\d{8}|00937\d{8})$/'],
            'whatsapp' => ['required', 'string', 'regex:/^(07\d{8}|00937\d{8})$/'],
            'relative_contact' => ['required', 'string', 'regex:/^(07\d{8}|00937\d{8})$/'],

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
        Excel::store(new InvalidStudentsExport($this->invalidRows), 'public/excel_error/' . $fileName);

        return $fileName;
    }
}
