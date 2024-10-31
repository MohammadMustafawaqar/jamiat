<?php

namespace App\Http\Controllers;

use App\Exports\InvalidSchoolExport;
use App\Imports\SchoolImport;
use App\Models\Country;
use App\Models\District;
use App\Models\Province;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Permission;

class SchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $schools = School::paginate(10);
        return view('school.index', compact('schools'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->grades);
        $request->validate([
            'address_type_id' => 'required',
            'grades' => 'required',
            'district_id' => 'required',
            'name' => 'required|string|max:255|unique:schools',
        ]);


        $country_id = $request->address_type_id == 2
            ? $request->country_id
            : Country::where('name', 'افغانستان')->first()->id;

        $school = School::create($request->except('country_id') + [
            'country_id' => $country_id
        ]);
        foreach ($request->grades as $grade) {
            $school->grades()->attach($grade);
        }
        return redirect()->back()->with("msg", __('messages.record_submitted'));
    }


    /**
     * Display the specified resource.
     */
    public function show(School $school)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($locale, School $school)
    {
        if (!Auth::user()->can('schools.edit')) {
            abort(403, 'Unauthorized action.');
        }
        $countries = Country::get();
        $provinces = Province::where('country_id', $school->district->province->country_id)->get();
        $districts = District::where('province_id', $school->district->province_id)->get();
        return view('school.edit', compact('school'), compact('countries', 'provinces', 'districts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($locale, Request $request, School $school)
    {
        $request->validate([
            'address_type_id' => 'required',
            'district_id' => 'required',
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('schools')->ignore($school->id),
            ],
        ]);
        $school->update($request->all());
        return redirect()->route('schools.index')->with("msg", __('messages.record_updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($locale, School $school)
    {
        $school->delete();
        return redirect()->back()->with("msg", __('messages.record_deleted'));
    }

    public function storeFromSelect(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'country_id' => 'required',
            'province_id' => 'required',
            'district_id' => 'required',
            'name' => 'required',
        ]);




        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => 'validation-error',
            ], 422);
        }

        $school = School::create([
            'address_type_id' => $request->country_id == 1 ? 1 : 2,
            'province_id' => $request->province_id,
            'district_id' => $request->district_id,
            'name' => $request->name,
            'village' => '',
            'status' => 'through_select'
        ]);

        return response()->json([
            'request' => $request->all(),
            'name' => $school->name,
            'id' => $school->id,
        ]);
    }


    public function importFromExcel(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|required|mimes:xlsx,csv,xls|max:10240'
        ]);
        $file = request()->file('excel_file');

        $import = new SchoolImport;

        // Import the file
        Excel::import($import, $request->file('excel_file'));

        $invalidRows = $import->getInvalidRows();
        // dd($invalidRows);
        // If there are invalid rows, save them to a file
        if (!empty($invalidRows)) {
            $fileName = $import->saveInvalidRecordsToFile();

            // Show error message with download link
            return redirect()->back()->with([
                'error' => __('messages.error_uploading_excel'),
                'download_link' => $fileName,
            ]);
        }

        return redirect()->back()->with('msg', 'imported successfully');
    }

    public function downloadInvalidFile($locale, $fileName)
    {

        $filePath = storage_path('app/public/excel_error/' . $fileName);

        return response()->download($filePath)->deleteFileAfterSend(true);
    }
}
