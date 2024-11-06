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

    function normalizeName($name)
    {
        if ($name === null || $name === '') return null; // Check if the name is null or empty
        $name = str_replace(' ', '', $name); // Remove spaces
        $name = str_replace('ګ', 'گ', $name); // Replace ګ with گ
        $name = str_replace('ی', 'ي', $name); // Replace ګ with گ
        $name = str_replace('ې', 'ي', $name); // Replace ګ with گ
        $name = str_replace('ئ', 'ي', $name); // Replace ګ with گ
        $name = str_replace('ۍ', 'ي', $name); // Replace ګ with گ
        return $name;
    }



    function dateFormat($date)
    {
        $date = str_replace(' ', '', $date);
        return str_replace('/', '-', $date);
    }

    function determineTazkiraType($tazkira)
    {
        $cleanedTazkira = str_replace(['-', ' '], '', $tazkira);

        if (strlen($cleanedTazkira) === 13 && ctype_digit($cleanedTazkira)) {
            return 'electric';
        } else {
            return 'paper';
        }
    }

    function formatTazkira($tazkira)
    {
        return str_replace(['-', ' '], '', $tazkira);
    }


    public function model(array $row)
    {
        $errors = [];

        // $currentProvince = Province::where('name', $row['current_province'])->first();
        $currentProvince = Province::whereRaw('REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(TRIM(name), " ", ""), "ی", "ي"), "ګ", "گ"), "ئ", "ي"), "ې", "ي") = ?', [$this->normalizeName($row['current_province'])])->first();
        if (!$currentProvince) $errors[] = "Invalid Current Province";


        $currentDistrict = null;

        if ($row['current_district'] != ''  && $currentProvince) {

            $currentDistrict = District::firstOrCreate([
                'province_id' => $currentProvince->id,
                'name' => $row['current_district'],
            ]);
        } else {
            if ($currentProvince != null) {
                $currentDistrict = District::firstOrCreate([
                    'province_id' => $currentProvince->id,
                    'name' => 'نامعلوم',
                ]);
            }
        }
        if (!$currentDistrict) {
            $errors[] = 'Invalid Current District';
        }


        $permanentProvince = Province::whereRaw('REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(TRIM(name), " ", ""), "ی", "ي"), "ګ", "گ"), "ئ", "ي"), "ې", "ي") = ?', [$this->normalizeName($row['permanent_province'])])->first();
        if (!$permanentProvince) $errors[] = "Invalid Permanent Province";


        $permanentDistrict = null;

        if ($row['permanent_district'] != '' && $permanentProvince) {

            $permanentDistrict = District::firstOrCreate([
                'province_id' => $permanentProvince->id,
                'name' => $row['permanent_district'],
            ]);
        } else {
            if ($permanentProvince != null) {
                $permanentDistrict = District::firstOrCreate([
                    'province_id' => $permanentProvince->id,
                    'name' => 'نامعلوم',
                ]);
            }
        }
        if (!$permanentDistrict) {
            $errors[] = 'Invalid District';
        }


        // $schoolCountry = Country::where('name', $row['school_country'])->first();
        // dd($schoolCountry, $row['school_country']);


        // $schoolProvince = Province::where('name', $row['school_province'])->first();
        // if (!$schoolProvince) $errors[] = "Invalid School Province";

        if (!$row['school_province']) {
            $errors[] = 'Invalid School Province';
        }

        // $schoolProvince = Province::firstOrCreate([
        //     'name' => $row['school_province'],
        //     'country_id' => $row['school_country'] == 'افغانستان' ? 1 : 2
        // ]);



        $schoolCountry = null;
        if ($row['school_country'] != '') {
            $schoolCountry = Country::firstOrCreate([
                'name' => $row['school_country'],
            ]);
        }

        if (!$schoolCountry) {
            $errors[] = 'Invalid schoolCountry';
        }

        if ($row['school_province'] != '') {
            $schoolProvince = Province::firstOrCreate([
                'name' => $row['school_province'],
                'country_id' => $schoolCountry->id
            ]);
        } else {
            $schoolProvince = Province::firstOrCreate([
                'name' => 'نامعلوم',
                'country_id' => $schoolCountry->id
            ]);
        }
        if (!$schoolProvince) {
            $errors[] = 'Invalid SChool province';
        }

        // $schoolDistrict = District::where('name', $row['school_district'])->first();
        // if (!$schoolDistrict) $errors[] = "Invalid School District";

        $schoolDistrict = null;

        if ($row['school_district'] != '') {
            $schoolDistrict = District::firstOrCreate([
                'province_id' => $schoolProvince->id,
                'name' => $row['school_district'],
            ]);
        } else {
            $schoolDistrict = District::firstOrCreate([
                'province_id' => $schoolProvince->id,
                'name' => 'نامعلوم',
            ]);
        }
        if (!$schoolDistrict) {
            $errors[] = 'Invalid School District';
        }

        // $school = School::whereRaw('REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(TRIM(name), " ", ""), "ی", "ي"), "ګ", "گ"), "ئ", "ي"), "ې", "ي") = ?', [$this->normalizeName($row['school'])])
        //     ->where('province_id', $schoolProvince->id)
        //     ->first();

        $school = School::firstOrCreate([
            'name' => $row['school'] ?? 'نامعلوم',
            'province_id' => $schoolProvince->id
        ], [
            'address_type_id' => $schoolCountry->id == 1 ? 1 : 2,
            'district_id' => $schoolDistrict->id,
            'village' => $row['school_village'] ?? 'نامعلوم',
            'details' => '',
            'status' => 'imported_from_excel'
        ]);

        if (!$school) $errors[] = "School Not Found";

        $gender = Gender::where('name_ps', $row['gender'])->first();
        if (!$gender && $row['gender']) $errors[] = "Gender Not Found";

        $language = Language::where('pa_name', $row['mother_tongue'])
            ->orWhere('en_name', $row['mother_tongue'])
            ->orWhere('ar_name', $row['mother_tongue'])
            ->orWhere('da_name', $row['mother_tongue'])
            ->first();
        if (!$language && $row['mother_tongue']) $errors[] = "Mother Tongue Not Found";

        $edu_level = EducationLevel::where('pa_name', $row['education_level'])
            ->orWhere('da_name', $row['education_level'])
            ->orWhere('en_name', $row['education_level'])
            ->orWhere('ar_name', $row['education_level'])
            ->first();
        if (!$edu_level && $row['education_level']) $errors[] = "Education Level Not Found";

        $appreciation = Appreciation::where('name', $row['appreciation'])->first();
        if (!$appreciation && $row['appreciation'] && $row['appreciation'] != 'Null') $errors[] = "Appreciation Not Found";

        if (!empty($errors)) {
            $row['errors'] = implode(', ', $errors);
            $this->invalidRows[] = $row;
            return null;
        }


        // Create Tazkira record if tazkira_type and tazkira_no are provided
        $tazkira = Tazkira::create([
            'type' => $this->determineTazkiraType($row['tazkira_no']),
            'tazkira_no' => $this->formatTazkira($row['tazkira_no']),
        ]);

        // Create Student record with resolved IDs
        $student = Student::create([
            'address_type_id' => $row['school_country'] == 'افغانستان' ? 1 : 2,
            'form_id' => $row['form_id'],
            'name' => $row['name'],
            'last_name' => $row['last_name'],
            'father_name' => $row['father_name'],
            'grand_father_name' => $row['grand_father_name'],
            'current_district_id' => $currentDistrict->id,
            'permanent_district_id' => $permanentDistrict->id,
            'current_village' => $row['current_village'],
            'permanent_village' => $row['permanent_village'],
            'education_level_id' => $edu_level?->id,
            'language_id' => $language?->id,
            'appreciation_id' => $appreciation?->id,
            'graduation_year' => $row['graduation_year'],
            'school_id' => $school->id,
            'gender_id' => 1,
            'dob_qamari' => $this->dateFormat($row['dob_qamari']),
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
            'form_id' => 2,
        ]);

        return $student;
    }

    public function rules(): array
    {
        return [
            'form_id' => 'required',
            'name' => 'required|string|max:255',
            // 'last_name' => 'required|string|max:255',
            // 'father_name' => 'required|string|max:255',
            // 'grand_father_name' => 'required|string|max:255',
            // 'current_province' => 'required|string|max:255',
            // 'permanent_province' => 'required|string|max:255',
            // 'current_district' => 'required',
            // 'permanent_district' => 'required',
            // 'current_village' => 'required|string|max:255',
            // 'permanent_village' => 'required|string|max:255',

            // 'school_country' => 'required',
            // 'school_province' => 'required',
            // 'school_district' => 'required',
            // 'school' => 'required',
            // 'gender' => 'required',

            // 'mother_tongue' => 'required|string|max:255',
            // 'education_level' => 'required|string|max:255',

            // 'tazkira_type' => 'nullable',
            // 'tazkira_no' => 'required|integer|unique:tazkiras,tazkira_no',

            // 'dob_qamari' => ['required', 'string', 'regex:/^\d{4}-\d{2}-\d{2}$/'],

            // 'appreciation' => 'required',
            // 'graduation_year' => 'required|integer',


            // 'phone' => ['required', 'string', 'regex:/^(07\d{8}|00937\d{8})$/'],
            // 'whatsapp' => ['required', 'string', 'regex:/^(07\d{8}|00937\d{8})$/'],
            // 'relative_contact' => ['required', 'string', 'regex:/^(07\d{8}|00937\d{8})$/'],

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
