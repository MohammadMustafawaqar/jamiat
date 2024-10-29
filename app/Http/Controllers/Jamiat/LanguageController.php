<?php

namespace App\Http\Controllers\Jamiat;

use App\Http\Controllers\Controller;
use App\Models\Jamiat\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LanguageController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:language.read')->only('index');
        $this->middleware('permission:language.create')->only(['index', 'store']);
        $this->middleware('permission:language.edit')->only(['index', 'edit','update']);
        $this->middleware('permission:language.delete')->only(['index', 'destroy']);
        $this->middleware('permission:language.*')->only(['index', 'store', 'create', 'edit', 'update', 'destroy']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $languages = Language::paginate(10);
        return view('backend.jamiat.language.index', [
            'languages' => $languages
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

        
        $language = Language::create($validator->validated());

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
        $language = Language::findOr($id);

        $language->delete();

        return redirect()->back()->with('msg', __('messages.record_deleted'));
    }
}
