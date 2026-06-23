<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HomeTable1Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('home_table1')->updateOrInsert(
            ['id' => 1],
            [
                'picture' => 'uploads/home/features.jpg',

                'title1' => 'Why Choose Us',

                'title1_content' => 'We are committed to providing high-quality services, innovative solutions, and exceptional customer support. Our experienced team works tirelessly to ensure that every client receives the best possible experience.',

                'title1_small_text' => 'Excellence • Innovation • Integrity',

                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}