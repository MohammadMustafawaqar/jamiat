<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('permissions')->insert([
            ['name' => 'schools.*', 'guard_name' => 'web'],
            ['name' => 'schools.create', 'guard_name' => 'web'],
            ['name' => 'schools.edit', 'guard_name' => 'web'],
            ['name' => 'schools.read', 'guard_name' => 'web'],
            ['name' => 'schools.delete', 'guard_name' => 'web'],

            ['name' => 'students.*', 'guard_name' => 'web'],
            ['name' => 'students.create', 'guard_name' => 'web'],
            ['name' => 'students.edit', 'guard_name' => 'web'],
            ['name' => 'students.read', 'guard_name' => 'web'],
            ['name' => 'students.show', 'guard_name' => 'web'],
            ['name' => 'students.delete', 'guard_name' => 'web'],

            ['name' => 'supervisors.*', 'guard_name' => 'web'],
            ['name' => 'supervisors.create', 'guard_name' => 'web'],
            ['name' => 'supervisors.edit', 'guard_name' => 'web'],
            ['name' => 'supervisors.read', 'guard_name' => 'web'],
            ['name' => 'supervisors.show', 'guard_name' => 'web'],
            ['name' => 'supervisors.delete', 'guard_name' => 'web'],

            ['name' => 'countries.*', 'guard_name' => 'web'],
            ['name' => 'countries.create', 'guard_name' => 'web'],
            ['name' => 'countries.edit', 'guard_name' => 'web'],
            ['name' => 'countries.read', 'guard_name' => 'web'],
            ['name' => 'countries.show', 'guard_name' => 'web'],
            ['name' => 'countries.delete', 'guard_name' => 'web'],

            ['name' => 'categories.*', 'guard_name' => 'web'],
            ['name' => 'categories.create', 'guard_name' => 'web'],
            ['name' => 'categories.edit', 'guard_name' => 'web'],
            ['name' => 'categories.read', 'guard_name' => 'web'],
            ['name' => 'categories.show', 'guard_name' => 'web'],
            ['name' => 'categories.delete', 'guard_name' => 'web'],

            ['name' => 'appreciations.*', 'guard_name' => 'web'],
            ['name' => 'appreciations.create', 'guard_name' => 'web'],
            ['name' => 'appreciations.edit', 'guard_name' => 'web'],
            ['name' => 'appreciations.read', 'guard_name' => 'web'],
            ['name' => 'appreciations.delete', 'guard_name' => 'web'],

            ['name' => 'users.*', 'guard_name' => 'web'],
            ['name' => 'users.create', 'guard_name' => 'web'],
            ['name' => 'users.edit', 'guard_name' => 'web'],
            ['name' => 'users.read', 'guard_name' => 'web'],
            ['name' => 'users.db_backup', 'guard_name' => 'web'],
            ['name' => 'users.file_backup', 'guard_name' => 'web'],
        ]);
        $role = Role::create(['name' => 'Super Admin', 'guard_name' => 'web']);
        $permissions = Permission::get();
        foreach ($permissions as $permission) {
            $role->givePermissionTo($permission->name);
        }
        $user = User::first();
        $user->assignRole($role->name);
    }
}
