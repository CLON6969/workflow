<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HomeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('home')->insert([
            [
                'background_picture' => 'pSVO0muoZfqjcgvTWYw3dYOxEyBkTZu5qthKTHir.jpg',
                'picture1' => 'uploads/home/about.jpg',
                'background_picture2' => '1tXbaNlvnjKchQzWBnhjSVEPt93K2Y4AuSuHhH6C.jpg',

                'title1' => 'Welcome to Our Website',
                'title1_content' => 'We provide quality services and innovative solutions.',
                'title1_sub_content' => 'Your success is our priority.',

                'title2' => 'About Us',
                'title2_content' => 'We are committed to delivering excellence in every project we undertake.',

                'title3' => 'Our Services',
                'title3_content' => 'Web Development, Mobile Applications, and IT Consultancy.',
                'title3_sub_content' => 'Tailored solutions for businesses of all sizes.',

                'title4' => 'Contact Us',
                'title4_content' => 'Get in touch with our team for inquiries and support.',
                'title4_sub_content' => 'We are available Monday to Friday.',

                'button1_name' => 'Learn More',
                'button1_url' => '/about',

                'button2_name' => 'Our Services',
                'button2_url' => '/services',

                'button3_name' => 'Contact Us',
                'button3_url' => '/contact',

                'button4_name' => 'Get Started',
                'button4_url' => '/register',

                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}