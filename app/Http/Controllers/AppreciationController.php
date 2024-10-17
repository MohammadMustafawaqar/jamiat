<?php

namespace App\Http\Controllers;

use App\Models\Appreciation;
use Illuminate\Http\Request;

class AppreciationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $appreciations = Appreciation::get();
        return view('appreciation.index', compact('appreciations'));
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
            'name' => 'required|string|max:255|unique:appreciations'
        ]);
        Appreciation::create($request->all());
        return redirect()->back()->with("msg", __('messages.record_submitted'));
    }


    /**
     * Display the specified resource.
     */
    public function show($locale, Appreciation $appreciation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($locale, Appreciation $appreciation)
    {
        return view('appreciation.edit', compact('appreciation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($locale, Request $request, Appreciation $appreciation)
    {
        $appreciation->update($request->all());
        return redirect()->route('appreciation.index')->with("msg", __('messages.record_updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($locale, Appreciation $appreciation)
    {
        $appreciation->delete();
        return redirect()->back()->with("msg", __('messages.record_deleted'));
    }
}
