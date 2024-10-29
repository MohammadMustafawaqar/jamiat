<?php

namespace App\Http\Controllers\Jamiat;

use App\Http\Controllers\Controller;
use App\Models\Jamiat\CClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClassController extends Controller
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
    public function store($locale, Request $request, $campus_id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3|max:255',
            'capacity' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => 'validation-error',
            ], 422);
        }

        $class = CClass::create($validator->validated() + [
            'campus_id' => $campus_id
        ]);

        return response()->json([
            'status' => 'success',
            'message' => __('messages.record_submitted')
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($locale, $campus_id, string $id)
    {
        $class = CClass::find($id);


        return response()->json([
            'status' => 'success',
            'data' => $class
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($locale, $campus_id, string $id)
    {
        $class = CClass::find($id);


        return response()->json([
            'status' => 'success',
            'data' => $class
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($locale, $campus_id, Request $request, string $id)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3|max:255',
            'capacity' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => 'validation-error',
            ], 422);
        }

        $class = CClass::find($id);

        $class->update($validator->validated());

        session()->flash('msg',__('messages.record_updated'));
        return response()->json([
            'status' => 'success',
            'message' => __('messages.record_updated')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
