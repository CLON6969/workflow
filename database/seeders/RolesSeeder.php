<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class RolesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('roles')->insert([
            [
                'name' => 'Reviewer',
                'description' => 'System Revieweristrator with full access',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'staff',
                'description' => 'Active employee within the organization',
                'created_at' => now(),
                'updated_at' => now(),
            ],
                        [
                'name' => 'uploader',
                'description' => 'Human Resources manager responsible for recruitment and staff',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Applicant',
                'description' => 'Job seeker applying for available positions',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
