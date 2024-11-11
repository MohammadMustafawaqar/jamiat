<?php

namespace App\Http\Controllers\Jamiat;

use App\Http\Controllers\Controller;
use App\Models\Jamiat\CClass;
use App\Models\Jamiat\SubClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubClassController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:sub_class.read')->only('index');
        $this->middleware('permission:sub_class.create')->only(['index', 'store']);
        $this->middleware('permission:sub_class.edit')->only(['index', 'edit','update']);
        $this->middleware('permission:sub_class.delete')->only(['index', 'destroy']);
        $this->middleware('permission:sub_class.*')->only(['index', 'store', 'create', 'edit', 'update', 'destroy']);
      }
    
    /**
     * Display a listing of the resource.
     */
    public function index($locale, $class_id)
    {
        $sub_classes = SubClass::where('class_id', $class_id)->paginate(10);
        $class = CClass::find($class_id);

        return view('backend.jamiat.campus.classes.sub_classes.index', [
            'sub_classes' => $sub_classes,
            'campus_id' => $class->campus_id,
            'class_id' => $class_id
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
    public function store(Request $request, $locale, $class_id)
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

        $class = SubClass::create($validator->validated() + [
            'class_id' => $class_id
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
    public function edit($locale, $class_id, string $id)
    {
        $class = SubClass::find($id);


        return response()->json([
            'status' => 'success',
            'data' => $class
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$locale, $class_id, string $id)
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

        $class = SubClass::find($id);

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
    public function destroy($locale, $class_id, string $id)
    {
        $class = SubClass::findOrFail($id);

        $class->delete();

        return redirect()->back()->with('msg', __('messages.record_deleted'));
    }
}
