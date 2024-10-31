<?php

namespace App\Http\Controllers;

use App\Models\CommitteeMember;
use Illuminate\Http\Request;

class CommitteeMemberController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:committee_member.read')->only('index');
        $this->middleware('permission:committee_member.create')->only(['index', 'store']);
        $this->middleware('permission:committee_member.edit')->only(['index', 'edit','update']);
        $this->middleware('permission:committee_member.delete')->only(['index', 'destroy']);
        $this->middleware('permission:committee_member.*')->only(['index', 'store', 'create', 'edit', 'update', 'destroy']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $committeeMembers=CommitteeMember::orderByDesc('id')->get();
        return view('committeeMember.index',compact('committeeMembers'));
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
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'job' => 'required|string|max:50',
        ]);
        CommitteeMember::create($request->all());
        return redirect()->back()->with("msg", __('messages.record_submitted'));
    }

    /**
     * Display the specified resource.
     */
    public function show(CommitteeMember $committeeMember)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($locale, CommitteeMember $committeeMember)
    {
        return view('committeeMember.edit', compact('committeeMember'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($locale, Request $request, CommitteeMember $committeeMember)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'job' => 'required|string|max:50',
        ]);
        $committeeMember->update($request->all());
        return redirect()->route('committee-member.index')->with("msg", __('messages.record_updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($locale, CommitteeMember $committeeMember)
    {
        $committeeMember->delete();
        return redirect()->back()->with("msg", __('messages.record_deleted'));
    }
}
