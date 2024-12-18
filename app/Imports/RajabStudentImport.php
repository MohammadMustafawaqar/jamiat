<?php

namespace App\Imports;

use App\Exports\InvalidStudentExport;
use App\Exports\InvalidStudentsExport;
use App\Models\AddressType;
use App\Models\Appreciation;
use App\Models\Country;
use App\Models\District;
use App\Models\Gender;
use App\Models\Jamiat\Language;
use App\Models\Jamiat\StudentExam;
use App\Models\Jamiat\StudentForm;
use App\Models\Jamiat\Tazkira;
use App\Models\Province;
use App\Models\School;
use App\Models\Student;
use Exception;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Facades\Excel;

class RajabStudentImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use SkipsFailures;

    protected $requestData;
    protected $invalidRows = [];

    public function __construct($requestData)
    {
        $this->requestData = $requestData;
    }

    function findOrCreateSimilarWithCondition($model, $column, $name, $conditions = [])
    {
        if ($name === null || $name === '') return null;
        $query = $model::query();
        foreach ($conditions as $field => $value) {
            $query->where($field, $value);
        }

        $records = $query->get();
        $mostSimilar = null;
        $highestSimilarity = 0;

        foreach ($records as $record) {
            $similarity = similar_text($record->$column, $name) / max(strlen($record->$column), strlen($name));
            if ($similarity > $highestSimilarity) {
                $highestSimilarity = $similarity;
                $mostSimilar = $record;
            }
        }

        if ($highestSimilarity >= 0.7) {
            return $mostSimilar;
        }

        return $model::create(array_merge($conditions, [$column => $name]));
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
        return str_replace(['-', ' ', '/'], '', $tazkira);
    }

    public function headingRow(): int
    {
        return 6;
    }

    public function model(array $row)
    {
        // dd($row);

        $errors = [];


        $currentProvince = null;
        if ($row['faaly_astony'] != '' || $row['faaly_astony'] != null) {
            $currentProvince = Province::where('name', $row['faaly_astony'])->first();
            if (!$currentProvince) {
                $currentProvince = Province::create(['country_id' => 1, 'name' => $row['faaly_astony']]);
            }
        } else {
            $errors[] = "Current Province is required";
        }

        $permanentProvince = null;
        if ($row['asly_astonny'] != '' || $row['asly_astonny'] != null) {
            $permanentProvince = Province::where('name', $row['asly_astonny'])->first();
            if (!$permanentProvince) {
                $permanentProvince = Province::create(['country_id' => 1, 'name' => $row['asly_astonny']]);
            }
        } else {
            $errors[] = "Permanent Province is required";
        }

        $schoolProvince = null;
        if ($row['ar'] != '' || $row['ar'] != null) {
            $schoolProvince = Province::where('name', $row['ar'])->first();
            if (!$schoolProvince) {
                $schoolProvince = Province::create(['country_id' => 1, 'name' => $row['ar']]);
            }
        } else {
            $errors[] = "School Province is required";
        }

        $schoolCountry = null;
        if ($row['zdh_ky_hyoad'] != '' || $row['zdh_ky_hyoad'] != null) {
            $schoolCountry = Country::where('name', $row['zdh_ky_hyoad'])->first();
            if (!$schoolCountry) {
                $schoolCountry = Country::create(['name' => $row['zdh_ky_hyoad']]);
            }
        } else {
            $errors[] = "School Country is required";
        }


        // Find or create districts with resolved province IDs
        if ($currentProvince) {
            $currentDistrict = $this->findOrCreateSimilarWithCondition(
                District::class,
                'name',
                $row['faaly_astony'],
                ['province_id' => $currentProvince->id]
            );
        }

        if ($permanentProvince) {
            $permanentDistrict = $this->findOrCreateSimilarWithCondition(
                District::class,
                'name',
                $row['olsoaly'],
                ['province_id' => $permanentProvince->id]
            );
        }

        // $schoolDistrict = $this->findOrCreateSimilarWithCondition(
        //     District::class,
        //     'name',
        //     $row[],
        //     ['province_id' => $schoolProvince->id]
        // );

        // Find or create gender records
        $gender = Gender::where('name_ps', $row['gnst'])->first();

        // For the school, match name, country, province, and district
        $school = School::all()->filter(function ($school) use ($row, $schoolCountry, $schoolProvince) {
            $nameSimilarity = similar_text($school->name, $row['gamaah_nom']) / max(strlen($school->name), strlen($row['gamaah_nom']));
            $countryMatch = $school->country_id === $schoolCountry?->id ?? 1;
            $provinceMatch = $school->province_id === $schoolProvince?->id ?? 25;
            // $districtMatch = $school->district_id === $schoolDistrict->id;

            return $nameSimilarity >= 0.7 && $countryMatch && $provinceMatch;
        })->first();

        if($row['gamaah_nom'] != null && $row['gamaah_nom'] != ''){
            if (!$school) {
                $school = School::create([
                    'name' => $row['gamaah_nom'],
                    'country_id' => $schoolCountry?->id ?? 1,
                    'province_id' => $schoolProvince?->id ?? 25,
                    // 'district_id' => $schoolDistrict->id,
                    'address_type_id' => 1
                ]);
            }
        }else{
            $errors[] = 'School Name required';
        }

        $language = Language::firstOrCreate([
            'pa_name' => $row['morny_zhbh'] ?? 'پښتو'
        ]);

        $address_type = AddressType::where('name', $row['form_noaah'])->first();

        // if (!$address_type) $errors[] = "AddressType Not Found";

        if (!empty($errors)) {
            $row['errors'] = implode(', ', $errors);
            $this->invalidRows[] = $row;
            return null;
        }

        // Proceed with Tazkira creation
        $tazkira = Tazkira::create([
            'type' => $this->determineTazkiraType($row['tthkr_nmbr']),
            'tazkira_no' => $this->formatTazkira($row['tthkr_nmbr']),
        ]);

        $appreciation = Appreciation::where('name', $row['tkdyr'])->first();

        // Create Student record with resolved IDs
        $student = Student::create([
            'form_id' => $row['shmarh'],
            'name' => $row['nom'],
            'last_name' => $row['tkhls'],
            'father_name' => $row['dplarnom'],
            'grand_father_name' => $row['nykh_nom'],
            'current_district_id' => $currentDistrict?->id ?? null,
            'permanent_district_id' => $permanentDistrict->id ?? null,
            'current_village' => $row['faaly_olsoaly'],
            'permanent_village' => $row['olsoaly'],
            'school_id' => $school->id,
            'gender_id' => $gender?->id ?? 1,
            'dob_qamari' => $row['zydo_nyh'],
            'phone' => $row['ylfon_shmyrh'],
            'tazkira_id' => $tazkira->id,
            'appreciation_id' => $appreciation?->id ?? null,
            'address_type_id' => $address_type->id ?? 1,
            'language_id' => $language?->id,
            'graduation_year' => $row['fraght_kal'],
        ]);

        // Create related StudentExam and StudentForm records
        StudentExam::create([
            'student_id' => $student->id,
            'exam_id' => $this->requestData['exam_id'],
        ]);

        StudentForm::create([
            'student_id' => $student->id,
            'form_id' => 3,
            'serial_number' => $row['shmarh']
        ]);

        return $student;
    }

    public function rules(): array
    {
        return [
            // 'form_id' => 'required',
            // 'name' => 'required|string|max:255',
            // 'last_name' => 'required|string|max:255',
            // 'father_name' => 'required|string|max:255',
            // 'grand_father_name' => 'required|string|max:255',
            // '14' => 'required',
            // 'اصلی استونګنځی' => 'required',
            // 'current_village' => 'required|string|max:255',
            // 'permanent_village' => 'required|string|max:255',
            // 'zdh_ky_hyoad' => 'required',
            // 'ar' => 'required',
            //  => 'required',
            // 'school' => 'required',
            // 'gender' => 'required',
            // 'tazkira_type' => 'nullable',
            // 'tazkira_no' => 'required|integer|unique:tazkiras,tazkira_no',
            // 'dob' => ['required', 'string', 'regex:/^\d{4}-\d{2}-\d{2}$/'],
            // 'dob_shamsi' => ['required', 'string', 'regex:/^\d{4}-\d{2}-\d{2}$/'],
            // 'dob_qamari' => ['required', 'string', 'regex:/^\d{4}-\d{2}-\d{2}$/'],
            // 'phone' => ['required', 'string', 'regex:/^(07\d{8}|00937\d{8})$/'],
        ];
    }

    public function getInvalidRows()
    {
        return $this->invalidRows;
    }

    public function saveInvalidRecordsToFile()
    {
        $fileName = 'invalid_students_import_' . time() . '.xlsx';
        Excel::store(new InvalidStudentExport($this->invalidRows), 'public/excel_error/' . $fileName);

        return $fileName;
    }
}
