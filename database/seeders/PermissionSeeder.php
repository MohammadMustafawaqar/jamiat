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
        $permissions = [
            ['name' => 'schools.*', 'guard_name' => 'web'],
            ['name' => 'schools.create', 'guard_name' => 'web'],
            ['name' => 'schools.edit', 'guard_name' => 'web'],
            ['name' => 'schools.read', 'guard_name' => 'web'],
            ['name' => 'schools.delete', 'guard_name' => 'web'],
            ['name' => 'schools.import', 'guard_name' => 'web'],
            ['name' => 'schools.address.interior', 'guard_name' => 'web'],
            ['name' => 'schools.address.exterior', 'guard_name' => 'web'],


            ['name' => 'students.*', 'guard_name' => 'web'],
            ['name' => 'students.create', 'guard_name' => 'web'],
            ['name' => 'students.edit', 'guard_name' => 'web'],
            ['name' => 'students.read', 'guard_name' => 'web'],
            ['name' => 'students.show', 'guard_name' => 'web'],
            ['name' => 'students.delete', 'guard_name' => 'web'],
            ['name' => 'students.import', 'guard_name' => 'web'],
            ['name' => 'students.read.rajab', 'guard_name' => 'web'],
            ['name' => 'students.read.commission', 'guard_name' => 'web'],
            ['name' => 'students.read.evaluation', 'guard_name' => 'web'],
            ['name' => 'students.create.rajab', 'guard_name' => 'web'],
            ['name' => 'students.create.commission', 'guard_name' => 'web'],
            ['name' => 'students.create.evaluation', 'guard_name' => 'web'],

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

            // Committee Members
            ['name' => 'committee_member.*', 'guard_name' => 'web'],
            ['name' => 'committee_member.create', 'guard_name' => 'web'],
            ['name' => 'committee_member.edit', 'guard_name' => 'web'],
            ['name' => 'committee_member.read', 'guard_name' => 'web'],
            ['name' => 'committee_member.delete', 'guard_name' => 'web'],


             // Committee Members
            ['name' => 'topics.*', 'guard_name' => 'web'],
            ['name' => 'topics.create', 'guard_name' => 'web'],
            ['name' => 'topics.edit', 'guard_name' => 'web'],
            ['name' => 'topics.read', 'guard_name' => 'web'],
            ['name' => 'topics.delete', 'guard_name' => 'web'],

            ['name' => 'centers.*', 'guard_name' => 'web'],
            ['name' => 'centers.create', 'guard_name' => 'web'],
            ['name' => 'centers.edit', 'guard_name' => 'web'],
            ['name' => 'centers.read', 'guard_name' => 'web'],
            ['name' => 'centers.show', 'guard_name' => 'web'],

        ];


        $role = Role::find(1);
        // $permissions = Permission::get();
        foreach ($permissions as $permission) {
            $prmsn = Permission::create($permission);
            $role->givePermissionTo($prmsn->name);
        }
        $user = User::first();
        $user->assignRole($role->name);
    }
}
