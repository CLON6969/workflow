<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FooterItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $footerTitles = DB::table('footer_titles')
            ->pluck('id', 'title');

        $items = [

            // Quick Links
            [
                'footer_title' => 'Quick Links',
                'text' => 'Home',
                'url' => '/',
                'sort_order' => 1,
            ],
            [
                'footer_title' => 'Quick Links',
                'text' => 'About Us',
                'url' => '/about',
                'sort_order' => 2,
            ],
            [
                'footer_title' => 'Quick Links',
                'text' => 'Contact Us',
                'url' => '/contact',
                'sort_order' => 3,
            ],

            // Our Services
            [
                'footer_title' => 'Our Services',
                'text' => 'Web Development',
                'url' => '/services/web-development',
                'sort_order' => 1,
            ],
            [
                'footer_title' => 'Our Services',
                'text' => 'Mobile Applications',
                'url' => '/services/mobile-apps',
                'sort_order' => 2,
            ],
            [
                'footer_title' => 'Our Services',
                'text' => 'IT Consultancy',
                'url' => '/services/consultancy',
                'sort_order' => 3,
            ],

            // Resources
            [
                'footer_title' => 'Resources',
                'text' => 'Blog',
                'url' => '/blog',
                'sort_order' => 1,
            ],
            [
                'footer_title' => 'Resources',
                'text' => 'FAQs',
                'url' => '/faqs',
                'sort_order' => 2,
            ],

            // Contact Information
            [
                'footer_title' => 'Contact Information',
                'text' => '+260 977 123 456',
                'url' => null,
                'sort_order' => 1,
            ],
            [
                'footer_title' => 'Contact Information',
                'text' => 'info@example.com',
                'url' => 'mailto:info@example.com',
                'sort_order' => 2,
            ],
        ];

        foreach ($items as $item) {

            if (!isset($footerTitles[$item['footer_title']])) {
                continue;
            }

            DB::table('footer_items')->updateOrInsert(
                [
                    'footer_title_id' => $footerTitles[$item['footer_title']],
                    'text' => $item['text'],
                ],
                [
                    'url' => $item['url'],
                    'sort_order' => $item['sort_order'],
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}