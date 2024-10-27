<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Province;
use App\Models\School;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function loadProvinces(Request $request)
    {
        $response = "<option></option>";
        $provinces = Province::where('country_id', $request->country_id)->get();
        foreach ($provinces as $province) {
            $response .= "<option value='{$province->id}'>{$province->name}</option>";
        }
        return $response;
    }
    public function loadDistricts(Request $request)
    {
        $response = "<option></option>";
        $districts = District::where('province_id', $request->province_id)->get();
        foreach ($districts as $district) {
            $response .= "<option value='{$district->id}'>{$district->name}</option>";
        }
        return $response;
    }
    public function loadDistrictsAndSchools(Request $request)
    {
        $response = "<option></option>";
        $res_schools = "<option></option>";
        $districts = District::where('province_id', $request->province_id)->get();
        $schools = School::where('province_id', $request->province_id)->get();
        foreach ($districts as $district) {
            $response .= "<option value='{$district->id}'>{$district->name}</option>";
        }
        foreach($schools as $school) {
            $res_schools .=  "<option value='{$school->id}'>{$school->name}</option>";
        }
        return [
            'schools' => $res_schools,
            'districts' => $response
        ];
    }

    public function loadSchools(Request $request)
    {
        $response = "<option></option>";
        $schools = School::where('district_id', $request->district_id)->get();
        foreach ($schools as $school) {
            $response .= "<option value='{$school->id}'>{$school->name}</option>";
        }
        return $response;
    }
    public function loadSubCategories(Request $request)
    {
        $response = "<option></option>";
        $subCategories = SubCategory::where('category_id', $request->category_id)->get();
        foreach ($subCategories as $subCategory) {
            $response .= "<option value='{$subCategory->id}'>{$subCategory->name}</option>";
        }
        return $response;
    }
}
