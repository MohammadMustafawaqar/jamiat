<?php

namespace App\Http\Controllers;

use App\Models\Province;
use Illuminate\Http\Request;

class ProvinceController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:countries.read')->only(['index', 'show']);
        $this->middleware('permission:countries.create')->only(['index', 'store']);
        $this->middleware('permission:countries.edit')->only(['index', 'edit','update']);
        $this->middleware('permission:countries.delete')->only(['index', 'destroy']);
        $this->middleware('permission:countries.*')->only(['index', 'store', 'create', 'edit', 'update', 'destroy']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
            'name' => 'required|string|max:255|unique:provinces'
        ]);
        Province::create($request->all());
        return redirect()->back()->with("msg", __('messages.record_submitted'));
    }

    /**
     * Display the specified resource.
     */
    public function show($locale, Province $province)
    {
        return view('province.show',compact('province'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($locale, Province $province)
    {
        // dd($province->name);
        return view('province.edit',compact('province'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($locale, Request $request, Province $province)
    {
        $province->update($request->all());
        return redirect()->route('country.show',$province->country_id)->with("msg", __('messages.record_updated'));
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($locale, Province $province)
    {  
        $province->delete();
        return redirect()->back()->with("msg", __('messages.record_deleted'));
    }
}
