<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SocialsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $socials = [
            [
                'icon' => 'fab fa-facebook-f',
                'name_url' => 'https://facebook.com',
                'sort_order' => 1,
            ],
            [
                'icon' => 'fab fa-x-twitter',
                'name_url' => 'https://x.com',
                'sort_order' => 2,
            ],
            [
                'icon' => 'fab fa-instagram',
                'name_url' => 'https://instagram.com',
                'sort_order' => 3,
            ],
            [
                'icon' => 'fab fa-linkedin-in',
                'name_url' => 'https://linkedin.com',
                'sort_order' => 4,
            ],
            [
                'icon' => 'fab fa-youtube',
                'name_url' => 'https://youtube.com',
                'sort_order' => 5,
            ],
        ];

        foreach ($socials as $social) {
            DB::table('socials')->updateOrInsert(
                ['icon' => $social['icon']],
                [
                    'name_url' => $social['name_url'],
                    'sort_order' => $social['sort_order'],
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}