<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Nav1Seeder extends Seeder
{
    public function run(): void
    {
        // Clear existing data
        DB::table('nav1')->truncate();

        // Parent Menus
        $homeId = DB::table('nav1')->insertGetId([
            'name' => 'Home',
            'name_url' => '/',
            'parent_id' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $contactId = DB::table('nav1')->insertGetId([
            'name' => 'Singin',
            'name_url' => 'login',
            'parent_id' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        $contactId = DB::table('nav1')->insertGetId([
            'name' => 'Signup',
            'name_url' => 'register',
            'parent_id' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $aboutId = DB::table('nav1')->insertGetId([
            'name' => 'About Us',
            'name_url' => '/about',
            'parent_id' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $servicesId = DB::table('nav1')->insertGetId([
            'name' => 'Services',
            'name_url' => '#',
            'parent_id' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $contactId = DB::table('nav1')->insertGetId([
            'name' => 'Contact',
            'name_url' => '/contact',
            'parent_id' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);



        // Services Dropdown Items
        DB::table('nav1')->insert([
            [
                'name' => 'Web Development',
                'name_url' => '/services/web-development',
                'parent_id' => $servicesId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mobile Apps',
                'name_url' => '/loading_count_down',
                'parent_id' => $servicesId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'IT Consultancy',
                'name_url' => '/loading_count_down',
                'parent_id' => $servicesId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // About Us Dropdown Items
        DB::table('nav1')->insert([
                        [
                'name' => 'About Us',
                'name_url' => '/about',
                'parent_id' => $aboutId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Our Mission',
                'name_url' => '/loading_count_down',
                'parent_id' => $aboutId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Our Team',
                'name_url' => '/loading_count_down',
                'parent_id' => $aboutId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}