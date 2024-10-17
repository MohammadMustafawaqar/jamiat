<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TopicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $topics = Topic::orderBy('status')->get();
        return view('topic.index', compact('topics'));
    }
    public function searchTopic(Request $request)
    {
        if ($request->title == "") {
            return "";
        }
        $topics = Topic::where('title', 'like', $request->title . '%')->get();
        $response = "";
        foreach ($topics as $topic) {
            $response = "<li class='list-group-item'>" . $topic->title . "</li>";
        }
        return $response;
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
            'title' => 'required|string|unique:topics'
        ]);
        Topic::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
        ]);
        return redirect()->back()->with("msg", __('messages.topic_selected'));
    }

    /**
     * Display the specified resource.
     */
    public function show($locale, Topic $topic)
    {
        $response = "";
        if ($topic->fee) {
            return view('topic.printSlip',compact('topic'));
            $response .= "<h3>موضوع: " . $topic->title . "</h3>";
            $response .= "<h5>فیس: " . $topic->fee->amount . " افغانۍ</h5>";
            $response .= "<a class='btn btn-sm btn-primary' href='" . $topic->fee->file_path . "' target='_blank'>د فیس رسید</a>";
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($locale, Topic $topic)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($locale, Request $request, Topic $topic)
    {
        $topic->update($request->all());
        return redirect()->back()->with("msg", __('messages.record_updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($locale, Topic $topic)
    {
        //
    }
}
