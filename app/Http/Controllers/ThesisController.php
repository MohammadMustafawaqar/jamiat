<?php

namespace App\Http\Controllers;

use App\Models\Thesis;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ThesisController extends Controller
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
            'file_path' => 'required|file'
        ]);
        $topic = Topic::where('user_id', Auth::id())->orderBy('id', 'desc')->first();
        $thesis = Thesis::create([
            'topic_id' => $topic->id,
            'details' => $request->details,
        ]);
        if ($request->hasFile('file_path')) {
            $thesis->file_path = $request->file('file_path')->store('public/theses');
            $thesis->save();
        }
        return redirect()->back()->with("msg", __('messages.record_submitted'));
    }

    /**
     * Display the specified resource.
     */
    public function show($locale, $id)
    {
        $thesis = Thesis::find($id);
        return view('studentPages.thesis.show', compact('thesis'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($locale, $id)
    {
        $thesis = Thesis::find($id);
        return view('studentPages.thesis.edit', compact('thesis'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($locale, Request $request, $id)
    {
        $thesis = Thesis::find($id);
        $thesis->details = $request->details;
        $thesis->save();
        if ($request->hasFile('file_path')) {
            if (isset($student->file_path)) {
                $student->dropFile('file_path');
            }
            $thesis->file_path = $request->file('file_path')->store('public/theses');
            $thesis->save();
        }
        return redirect()->route('home')->with("msg", __('messages.record_updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($locale, $id)
    {
        $thesis = Thesis::find($id);
        $thesis->delete();
        if ($thesis) {
            if (isset($thesis->file_path)) {
                $thesis->dropFile('file_path');
            }
        }
        return redirect()->back()->with("msg", __('messages.record_deleted'));
    }

    public function showSupervisorThesis($locale,$thesis_id)
    {
        $thesis = Thesis::find($thesis_id);
        return view('supervisorPages.student.comment', compact('thesis'));
    }
    public function updataStatus($locale, Request $request, $id)
    {
        $thesis = Thesis::find($id);
        $thesis->update($request->all());
        // dd($request->all());
        return redirect()->back()->with("msg", __('messages.record_updated'));
    }
}
