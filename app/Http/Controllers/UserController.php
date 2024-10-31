<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // if (!Auth::user()->can('users.read')) {
        //     abort(403, 'Unauthorized action.');
        // }
        $users = User::all();
        $roles=Role::get();
        return view('user.index', compact('users','roles'));
    }

    public function getLogs(Request $request)
    {
        $logs = Log::where('user_id', $request->user_id)->orderBy('id', 'desc');
        return DataTables::eloquent($logs)
            ->toJson();
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
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'user_type' => 'Admin',
            'password' => Hash::make($request->password),
        ]);

        return redirect()->back()->with("msg", "User created successfully");
    }

    /**
     * Display the specified resource.
     */
    public function show($locale, User $user)
    {
        // if (!Auth::user()->can('users.read')) {
        //     abort(403, 'Unauthorized action.');
        // }
        return view('user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($locale, User $user)
    {
        // if (!Auth::user()->can('users.edit')) {
        //     abort(403, 'Unauthorized action.');
        // }
        return view("user.edit", compact("user"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($locale, Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->save();
        return redirect()->route('user.index')->with("msg", "User updated successfully!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($locale, User $user)
    {
        //
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            "current_password" => "required|string|min:8",
            "password" => "required|string|min:8|confirmed",
        ]);
        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->save();
        return redirect()->back()->with('msg', 'Password changed successfully.');
    }


    function updateUserStatus(Request $request)
    {
        // if (!Auth::user()->can('users.edit')) {
        //     abort(403, 'Unauthorized action.');
        // }
        // dd($request->all());
        $user = User::find($request->user_id);
        $user->isActive = $request->status;
        $user->save();
        return "User status changed";
    }

    
}
