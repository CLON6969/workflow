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
                'picture' => 'bbNBph4bkaLDjx800b880WPM7y50TWlPs6sQooTg.png',
                'picture2' => 'bbNBph4bkaLDjx800b880WPM7y50TWlPs6sQooTg.png',
                'title' => 'My Website',
                'home_url' => '/',
                'background_picture' => 'OVx70fjQ6Q3FBMWfus3Vmb4CTgUlZqmqp1MQWlEl.jpg',

                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}