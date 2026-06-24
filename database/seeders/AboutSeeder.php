<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class AboutSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('about')->insert([
            [
                'background_picture'   => 'gQOLL9NxhTBWJCP8h1ojuECt7vTBEbwwSoH2xe6B.png',
                'title1'               => 'Who We Are',
                'title1_content'       => 'We are a modern organization focused on delivering structured workflow solutions.',
                'title2'               => 'Our Mission',
                'title2_content'       => 'To improve efficiency through digital transformation and workflow automation.',

                'button1_name'         => 'Learn More',
                'button1_url'          => '/about',

                'background_picture2'  => 'gQOLL9NxhTBWJCP8h1ojuECt7vTBEbwwSoH2xe6B.pn',

                'title3'               => 'What We Do',
                'title3_content'       => 'We build systems that simplify approvals, tracking, and decision making.',
                'title4'               => 'Why Choose Us',
                'title4_content'       => 'We provide scalable and reliable workflow solutions for organizations.',

                'title5'               => 'Get Started Today',

                'button2_name'         => 'Contact Us',
                'button2_url'          => '/contact',

                'title6'               => 'Let’s Build Something Great Together',

                'created_at'           => now(),
                'updated_at'           => now(),
            ]
        ]);
    }
}