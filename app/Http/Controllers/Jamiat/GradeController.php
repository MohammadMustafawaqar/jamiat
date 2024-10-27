<?php

namespace App\Http\Controllers\Jamiat;

use App\Http\Controllers\Controller;
use App\Models\Jamiat\Grade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $grades = Grade::paginate(10);
        return view('backend.jamiat.grade.index', [
            'grades' => $grades
        ]);
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
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255|min:4',
            'equivalent' => 'nullable|string|max:255|min:3',
            'description' => 'nullable|string|max:255|min:3',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }


        Grade::create([
            'name' => $request->name,
            'description' => $request->description,
            'equivalent' => $request->equivalent,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => __('messages.record_submitted')
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($locale, string $id)
    {
        $grade = Grade::find($id);

        $grade->delete();

        return redirect()->back()->with('success', __('messages.record_deleted'));
    }
}
