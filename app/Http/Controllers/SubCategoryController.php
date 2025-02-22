<?php

namespace App\Http\Controllers;

use App\Models\SubCategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
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
            'name' => 'required|string|max:255|unique:sub_categories'
        ]);
        SubCategory::create($request->all());
        return redirect()->back()->with("msg", __('messages.record_submitted'));
    }

    /**
     * Display the specified resource.
     */
    public function show(SubCategory $subCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($locale, SubCategory $subCategory)
    {
        return view('category.edit_sub_category', compact('subCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($locale, Request $request, SubCategory $subCategory)
    {
        $subCategory->update($request->all());
        return redirect()->route('category.show', $subCategory->category_id)->with("msg", __('messages.record_updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($locale, SubCategory $subCategory)
    {
        $subCategory->delete();
        return redirect()->back()->with("msg", __('messages.record_deleted'));
    }
}
