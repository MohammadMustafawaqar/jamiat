<?php

namespace App\Imports;

use App\Global\Settings;
use App\Models\District;
use App\Models\Jamiat\Exam;
use App\Models\Jamiat\Grade;
use App\Models\Province;
use App\Models\User;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // dd($row['grade']);
        $grade = Grade::where('name', $row['grade'])->first();
        $province = Province::where('name', $row['province'])->first();
        $district = District::where('name', $row['district'])->first();
        $start_date = Settings::change_from_hijri($row['start_date']);
        $end_date = Settings::change_from_hijri($row['end_date']);
        return new Exam([
            'title' => $row['title'],
            'grade_id' => $grade->id,
            'province_id' => $province->id,
            'district_id' => $district->id,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'address' => $row['address'],
        ]); 
    }
}
