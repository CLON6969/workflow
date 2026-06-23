<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LegalListItemsSeeder extends Seeder
{
    public function run(): void
    {
        $dataCollection = DB::table('legal_sections')
            ->where('heading', '2. Data We Collect')
            ->first();

        $yourRights = DB::table('legal_sections')
            ->where('heading', '2. Your Rights')
            ->first();

        if ($dataCollection) {
            DB::table('legal_list_items')->insert([
                [
                    'legal_section_id' => $dataCollection->id,
                    'item_text' => 'Personal details (name, email, phone)',
                    'order' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'legal_section_id' => $dataCollection->id,
                    'item_text' => 'Institutional information',
                    'order' => 2,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'legal_section_id' => $dataCollection->id,
                    'item_text' => 'Usage data (IP, browser info)',
                    'order' => 3,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'legal_section_id' => $dataCollection->id,
                    'item_text' => 'Cookies and analytics',
                    'order' => 4,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }

        if ($yourRights) {
            DB::table('legal_list_items')->insert([
                [
                    'legal_section_id' => $yourRights->id,
                    'item_text' => 'Access your data',
                    'order' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'legal_section_id' => $yourRights->id,
                    'item_text' => 'Request changes or deletion',
                    'order' => 2,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'legal_section_id' => $yourRights->id,
                    'item_text' => 'Withdraw consent at any time',
                    'order' => 3,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }
    }
}