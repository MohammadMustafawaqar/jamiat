<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\District;
use App\Models\Province;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class SchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $schools = School::get();
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
        $request->validate([
            'address_type_id' => 'required',
            'district_id' => 'required',
            'name' => 'required|string|max:255|unique:schools',
        ]);
        School::create($request->all());
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
}
