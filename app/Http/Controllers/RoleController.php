<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'role_name' => 'required|string|max:255|unique:roles,name'
        ]);
        $role=new Role();
        $role->name=$request->role_name;
        $role->guard_name='web';
        $role->save();
        return redirect()->back()->with("msg", __('messages.record_submitted'));
    }

    public function edit($locale, $id)
    {
        $role=Role::find($id);
        return view('user.edit_role', compact('role'));
    }

    public function update($locale, Request $request, $id)
    {
        $role=Role::find($id);
        $role->name=$request->role_name;
        $role->guard_name='web';
        $role->save();
        return redirect()->route('user.index')->with("msg", __('messages.record_updated'));
    }

    function getPermissions(Request $request)
    {
        $role_id = $request->role_id;
        $role = Role::find($role_id);
        $permissions = Permission::all();
        return view("user.permissions", compact("role", "permissions"));
    }

    function givePermissions(Request $request)
    {
        $role_id = $request->role_id;
        $role = Role::findById($role_id);
        DB::table("role_has_permissions")
            ->where(["role_id" => $role_id])->delete();
        if ($request->permissions) {
            foreach ($request->permissions as $permission) {
                $role->givePermissionTo($permission);
            }
        }
        return back()->with('msg', "Permissions are assigned to the role!");
    }
    function giveRole(Request $request)
    {
        $user = User::find($request->user_id);
        $role = Role::findById($request->role_id);
        if ($user->hasAnyRole(Role::all())) {
            DB::table('model_has_roles')->where('model_id', $user->id)->delete();
        }
        $user->assignRole($role->name);
        return back()->with('msg', "Role assigned to the User!");
    }
}
