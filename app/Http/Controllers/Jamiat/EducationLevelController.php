<?php

namespace App\Http\Controllers\Jamiat;

use App\Http\Controllers\Controller;
use App\Models\Jamiat\EducationLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EducationLevelController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:education_level.read')->only('index');
        $this->middleware('permission:education_level.create')->only(['index', 'store']);
        $this->middleware('permission:education_level.edit')->only(['index', 'edit','update']);
        $this->middleware('permission:education_level.delete')->only(['index', 'destroy']);
        $this->middleware('permission:education_level.*')->only(['index', 'store', 'create', 'edit', 'update', 'destroy']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $levels = EducationLevel::paginate(10);
        return view('backend.jamiat.education-level.index', compact(
            'levels'
        ));
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
            'ar_name' => 'required|string|max:64',
            'en_name' => 'required|string|max:64',
            'pa_name' => 'required|string|max:64',
            'da_name' => 'required|string|max:64',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => 'validation-error',
            ], 422);
        }

        
        $level = EducationLevel::create($validator->validated());

        return response()->json([
            'message' => __('messages.record_submitted'),
            'status' => 'success'
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
        $edu_level = EducationLevel::findOrFail($id);
        $edu_level->delete();

        return redirect()->back()->with('msg', __('messages.record_deleted'));
    }
}
