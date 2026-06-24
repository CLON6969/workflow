<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AboutTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('about_table')->insert([
            [
                'picture'            => 'gshq4LtOrTRgRljTjhHgZtmDoYJQGVrG4FVJFaRh.jpg',
                'title1'             => 'About Our Platform',
                'title1_content'     => 'This platform is designed to manage applications and workflows efficiently.',
                'title1_small_text'  => 'Simple. Fast. Reliable.',

                'created_at'         => now(),
                'updated_at'         => now(),
            ],

            [
                'picture'            => 'ToPHD0QWq02bp7rhZdz8z0AjqgBRSz7BWdoTM5Rk.jpg',
                'title1'             => 'Our Mission',
                'title1_content'     => 'We aim to simplify approval workflows and improve transparency in organizations.',
                'title1_small_text'  => 'Transparency first.',

                'created_at'         => now(),
                'updated_at'         => now(),
            ],

            [
                'picture'            => 'hMinDHiHtxABUELnQANsRxXyHX3neOyFZ1rudesT.jpg',
                'title1'             => 'Why Choose Us',
                'title1_content'     => 'We combine modern technology with user-friendly design to deliver the best experience.',
                'title1_small_text'  => 'Built for efficiency.',

                'created_at'         => now(),
                'updated_at'         => now(),
            ],
        ]);
    }
}