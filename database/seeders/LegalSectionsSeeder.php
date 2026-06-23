<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LegalSectionsSeeder extends Seeder
{
    public function run(): void
    {
        $terms = DB::table('legal_documents')
            ->where('slug', 'terms-of-service')
            ->first();

        $privacy = DB::table('legal_documents')
            ->where('slug', 'privacy-policy')
            ->first();

        DB::table('legal_sections')->insert([
            [
                'legal_document_id' => $terms->id,
                'heading' => '1. Acceptance of Terms',
                'body' => 'By using our services, you confirm your acceptance of these terms. If you do not agree, please do not use our services.',
                'order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'legal_document_id' => $terms->id,
                'heading' => '2. Description of Services',
                'body' => 'We provide digital education and enterprise solutions including customized platforms and mobile apps to improve institutional performance.',
                'order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'legal_document_id' => $privacy->id,
                'heading' => '1. Data We Collect',
                'body' => 'We collect personal, usage, and technical data to improve services.',
                'order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'legal_document_id' => $privacy->id,
                'heading' => '2. Your Rights',
                'body' => 'You may access, modify, or delete your data at any time.',
                'order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}