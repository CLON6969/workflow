<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                // Basic Info
                'user_type' => 'individual',
                'name' => 'Admin User',
                'username' => 'admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'profile_picture' => null,
                'account_status' => 'active',

                // Social login
                'provider' => null,
                'provider_id' => null,

                // Contact Info
                'phone' => '0977000000',
                'whatsapp' => '0977000000',
                'address' => 'Lusaka',
                'city' => 'Lusaka',
                'state' => null,
                'postal_code' => null,
                'country' => 'Zambia',
                'website' => null,

                // Security
                'two_factor_enabled' => false,
                'email_verified' => true,
                'email_verified_at' => now(),

                // Extra
                'bio' => 'System administrator account',
                'job_title' => 'Admin',
                'referral_source' => null,

                // Relationships (set null unless roles exist)
                'parent_account_id' => null,
                'account_type' => 'main',
                'role_id' => 1,

                // Auth
                'remember_token' => null,

                // Onboarding
                'onboarding_complete' => true,

                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'user_type' => 'individual',
                'name' => 'Test Applicant',
                'username' => 'reviewer',
                'email' => 'applicant@example.com',
                'password' => Hash::make('password'),
                'profile_picture' => null,
                'account_status' => 'active',

                'provider' => null,
                'provider_id' => null,

                'phone' => null,
                'whatsapp' => null,
                'address' => null,
                'city' => null,
                'state' => null,
                'postal_code' => null,
                'country' => 'Zambia',
                'website' => null,

                'two_factor_enabled' => false,
                'email_verified' => true,
                'email_verified_at' => now(),

                'bio' => null,
                'job_title' => 'Reviewer',
                'referral_source' => null,

                'parent_account_id' => null,
                'account_type' => 'main',
                'role_id' => 4,

                'remember_token' => null,
                'onboarding_complete' => true,

                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}