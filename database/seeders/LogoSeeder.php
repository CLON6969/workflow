<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LogoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('logo')->updateOrInsert(
            ['id' => 1],
            [
                'picture' => 'uploads/logo/logo.png',
                'picture2' => 'uploads/logo/logo2.png',
                'title' => 'My Website',
                'home_url' => '/',
                'background_picture' => 'uploads/logo/auth-background.jpg',

                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}