<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LegalDocumentsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('legal_documents')->insert([
            [
                'title' => 'Terms of Service',
                'slug' => Str::slug('Terms of Service'),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Privacy Policy',
                'slug' => Str::slug('Privacy Policy'),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}