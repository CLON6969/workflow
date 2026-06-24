<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OpportunitySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('opportunities')->insert([
            [
                'title'          => 'Graduate Internship Program',
                'summary'        => 'A 6-month internship opportunity for recent graduates to gain real-world experience.',
                'image'          => 'uploads/opportunities/internship.jpg',
                'overlay_intro'  => 'Kickstart your career',
                'overlay_details'=> 'This program is designed to equip graduates with hands-on skills in ICT, administration, and project management within a professional environment.',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],

            [
                'title'          => 'Scholarship Program',
                'summary'        => 'Fully funded scholarships for eligible students across Zambia.',
                'image'          => 'uploads/opportunities/scholarship.jpg',
                'overlay_intro'  => 'Study with support',
                'overlay_details'=> 'We offer scholarships to deserving students to pursue higher education in various accredited institutions locally and abroad.',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],

            [
                'title'          => 'Youth Skills Training',
                'summary'        => 'Short-term skills development program for youth empowerment.',
                'image'          => 'uploads/opportunities/training.jpg',
                'overlay_intro'  => 'Build your future',
                'overlay_details'=> 'This program focuses on practical skills such as ICT, entrepreneurship, and vocational training to empower young people in Zambia.',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
        ]);
    }
}