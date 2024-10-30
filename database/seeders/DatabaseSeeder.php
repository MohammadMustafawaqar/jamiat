<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\AddressType;
use App\Models\Appreciation;
use App\Models\Category;
use App\Models\Country;
use App\Models\District;
use App\Models\Gender;
use App\Models\NicType;
use App\Models\Province;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::withoutEvents(function () {
            User::create([
                'name' => "Admin",
                'email' => "admin@gmail.com",
                'password' => Hash::make("admin123"),
            ]);
        });

        // DB::table('permissions')->insert([
        //     ['name' => 'schools.*', 'guard_name' => 'web'],
        //     ['name' => 'schools.create', 'guard_name' => 'web'],
        //     ['name' => 'schools.edit', 'guard_name' => 'web'],
        //     ['name' => 'schools.read', 'guard_name' => 'web'],
        //     ['name' => 'schools.delete', 'guard_name' => 'web'],

        //     ['name' => 'students.*', 'guard_name' => 'web'],
        //     ['name' => 'students.create', 'guard_name' => 'web'],
        //     ['name' => 'students.edit', 'guard_name' => 'web'],
        //     ['name' => 'students.read', 'guard_name' => 'web'],
        //     ['name' => 'students.show', 'guard_name' => 'web'],
        //     ['name' => 'students.delete', 'guard_name' => 'web'],

        //     ['name' => 'supervisors.*', 'guard_name' => 'web'],
        //     ['name' => 'supervisors.create', 'guard_name' => 'web'],
        //     ['name' => 'supervisors.edit', 'guard_name' => 'web'],
        //     ['name' => 'supervisors.read', 'guard_name' => 'web'],
        //     ['name' => 'supervisors.show', 'guard_name' => 'web'],
        //     ['name' => 'supervisors.delete', 'guard_name' => 'web'],

        //     ['name' => 'countries.*', 'guard_name' => 'web'],
        //     ['name' => 'countries.create', 'guard_name' => 'web'],
        //     ['name' => 'countries.edit', 'guard_name' => 'web'],
        //     ['name' => 'countries.read', 'guard_name' => 'web'],
        //     ['name' => 'countries.show', 'guard_name' => 'web'],
        //     ['name' => 'countries.delete', 'guard_name' => 'web'],

        //     ['name' => 'categories.*', 'guard_name' => 'web'],
        //     ['name' => 'categories.create', 'guard_name' => 'web'],
        //     ['name' => 'categories.edit', 'guard_name' => 'web'],
        //     ['name' => 'categories.read', 'guard_name' => 'web'],
        //     ['name' => 'categories.show', 'guard_name' => 'web'],
        //     ['name' => 'categories.delete', 'guard_name' => 'web'],

        //     ['name' => 'appreciations.*', 'guard_name' => 'web'],
        //     ['name' => 'appreciations.create', 'guard_name' => 'web'],
        //     ['name' => 'appreciations.edit', 'guard_name' => 'web'],
        //     ['name' => 'appreciations.read', 'guard_name' => 'web'],
        //     ['name' => 'appreciations.delete', 'guard_name' => 'web'],

        //     ['name' => 'users.*', 'guard_name' => 'web'],
        //     ['name' => 'users.create', 'guard_name' => 'web'],
        //     ['name' => 'users.edit', 'guard_name' => 'web'],
        //     ['name' => 'users.read', 'guard_name' => 'web'],
        //     ['name' => 'users.db_backup', 'guard_name' => 'web'],
        //     ['name' => 'users.file_backup', 'guard_name' => 'web'],
        // ]);
        // $role = Role::create(['name' => 'Super Admin', 'guard_name' => 'web']);
        // $permissions = Permission::get();
        // foreach ($permissions as $permission) {
        //     $role->givePermissionTo($permission->name);
        // }
        // $user = User::first();
        // $user->assignRole($role->name);


        Country::insert([
            ['name' => 'افغانستان'],
            ['name' => 'پاکستان'],
            ['name' => 'سعودی عربستان'],
            ['name' => 'هند'],
            ['name' => 'ترکیه'],
        ]);
        Province::insert([
            ['country_id' => '1', 'name' => 'کابل'],
            ['country_id' => '1', 'name' => 'ننگرهار'],
            ['country_id' => '1', 'name' => 'بلخ'],
            ['country_id' => '1', 'name' => 'هرات'],
            ['country_id' => '1', 'name' => 'قندهار'],
            ['country_id' => '1', 'name' => 'خوست'],
            ['country_id' => '1', 'name' => 'بامیان'],
            ['country_id' => '1', 'name' => 'فراه'],
            ['country_id' => '1', 'name' => 'غور'],
            ['country_id' => '1', 'name' => 'لوگر'],
            ['country_id' => '1', 'name' => 'پکتیا'],
            ['country_id' => '1', 'name' => 'پکتیکا'],
            ['country_id' => '1', 'name' => 'پروان'],
            ['country_id' => '1', 'name' => 'سمنگان'],
            ['country_id' => '1', 'name' => 'تخار'],
            ['country_id' => '1', 'name' => 'غزنی'],
            ['country_id' => '1', 'name' => 'کندز'],
            ['country_id' => '1', 'name' => 'میدان وردک'],
            ['country_id' => '1', 'name' => 'نورستان'],
            ['country_id' => '1', 'name' => 'لغمان'],
            ['country_id' => '1', 'name' => 'بدخشان'],
            ['country_id' => '1', 'name' => 'بدغیس'],
            ['country_id' => '1', 'name' => 'بادغیس'],
            ['country_id' => '1', 'name' => 'سرپل'],
            ['country_id' => '1', 'name' => 'دایکندی'],
            ['country_id' => '1', 'name' => 'اوزبک'],
            ['country_id' => '1', 'name' => 'جوزجان'],
            ['country_id' => '1', 'name' => 'کاپیسا'],
            ['country_id' => '1', 'name' => 'نیمروز'],
            ['country_id' => '1', 'name' => 'زابل'],
            ['country_id' => '1', 'name' => 'اروزگان']
        ]);

        Appreciation::insert([
            ['name' => 'ممتاز'],
        ]);
        AddressType::insert([
            ['name' => 'داخل'],
            ['name' => 'خارج']
        ]);
        NicType::insert([
            ['name' => 'الکترونیکی'],
            ['name' => 'کاغذی']
        ]);
        Gender::insert([
            ['name_ps' => 'نارینه', 'name_dr' => 'مرد'],
            ['name_ps' => 'ښځینه', 'name_dr' => 'زن']
        ]);


        $this->call([
            PermissionSeeder::class
        ]);
    }
}
