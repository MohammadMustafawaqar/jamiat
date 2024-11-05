<?php

namespace App\Http\Controllers\Jamiat;

use App\Http\Controllers\Controller;
use App\Models\Jamiat\Campus;
use App\Models\Jamiat\CClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CampusController extends Controller
{

    public function __construct()
    {
        // $this->middleware('permission:exam_centers.read')->only('index');
        // $this->middleware('permission:exam_centers.create')->only(['index', 'store']);
        // $this->middleware('permission:exam_centers.edit')->only(['index', 'edit','update']);
        // $this->middleware('permission:exam_centers.delete')->only(['index', 'destroy']);
        // $this->middleware('permission:exam_centers.*')->only(['index', 'store', 'create', 'edit', 'update', 'destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $campuses = Campus::paginate(10);
        return view('backend.jamiat.campus.index', [
            'campuses' => $campuses
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3|max:255',
            'province_id' => 'required|exists:provinces,id'
        ]);

        if($validator->fails()){
            return response()->json([
                'errors' => $validator->errors(),
                'status' => 'validation-error',
            ], 422);
        }

        $campus = Campus::create($validator->validated());

        return response()->json([
            'status' => 'success',
            'message' => __('messages.record_submitted')
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($locale, string $id)
    {
        $campus = Campus::find($id);
        $classes = CClass::where('campus_id', $id)->paginate(10);
        return view('backend.jamiat.campus.classes.index', [
            'classes' => $classes,
            'campus' => $campus,
        ]);
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
    public function destroy(string $id)
    {
        //
    }
}
