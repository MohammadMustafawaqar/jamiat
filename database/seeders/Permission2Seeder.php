<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Permission2Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            ['name' => 'schools.import', 'guard_name' => 'web'],
            ['name' => 'schools.address.interior', 'guard_name' => 'web'],
            ['name' => 'schools.address.exterior', 'guard_name' => 'web'],

            ['name' => 'students.import', 'guard_name' => 'web'],
            ['name' => 'students.create.rajab', 'guard_name' => 'web'],
            ['name' => 'students.create.commission', 'guard_name' => 'web'],
            ['name' => 'students.create.evaluation', 'guard_name' => 'web'],

            // language
            ['name' => 'language.*', 'guard_name' => 'web'],
            ['name' => 'language.create', 'guard_name' => 'web'],
            ['name' => 'language.edit', 'guard_name' => 'web'],
            ['name' => 'language.read', 'guard_name' => 'web'],
            ['name' => 'language.delete', 'guard_name' => 'web'],

            // exam
            ['name' => 'exam.*', 'guard_name' => 'web'],
            ['name' => 'exam.create', 'guard_name' => 'web'],
            ['name' => 'exam.edit', 'guard_name' => 'web'],
            ['name' => 'exam.read', 'guard_name' => 'web'],
            ['name' => 'exam.delete', 'guard_name' => 'web'],

            // education_level
            ['name' => 'education_level.*', 'guard_name' => 'web'],
            ['name' => 'education_level.create', 'guard_name' => 'web'],
            ['name' => 'education_level.edit', 'guard_name' => 'web'],
            ['name' => 'education_level.read', 'guard_name' => 'web'],
            ['name' => 'education_level.delete', 'guard_name' => 'web'],

            // school_grade
            ['name' => 'school_grade.*', 'guard_name' => 'web'],
            ['name' => 'school_grade.create', 'guard_name' => 'web'],
            ['name' => 'school_grade.edit', 'guard_name' => 'web'],
            ['name' => 'school_grade.read', 'guard_name' => 'web'],
            ['name' => 'school_grade.delete', 'guard_name' => 'web'],
        ];

        $role = Role::find(1);
        $role = Role::find(1);
        $permissions = Permission::get();
        foreach ($permissions as $permission) {
            $role->givePermissionTo($permission->name);
        }
    }
}
