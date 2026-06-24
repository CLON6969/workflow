<?php

namespace Database\Seeders;

use App\Enums\ApplicationStatus;
use App\Models\Application;
use App\Models\User;
use Illuminate\Database\Seeder;

class ApplicationSeeder extends Seeder
{
    public function run(): void
    {
        // =========================
        // Get roles safely via DB
        // =========================
        $applicantRoleId = \DB::table('roles')
            ->where('name', 'applicant')
            ->value('id');

        $reviewerRoleId = \DB::table('roles')
            ->where('name', 'reviewer')
            ->value('id');

        if (!$applicantRoleId || !$reviewerRoleId) {
            throw new \Exception("Roles (applicant/reviewer) not found in roles table.");
        }

        // =========================
        // Get users
        // =========================
        $applicants = User::where('role_id', $applicantRoleId)->get();
        $reviewers  = User::where('role_id', $reviewerRoleId)->get();

        if ($applicants->isEmpty() || $reviewers->isEmpty()) {
            return;
        }

        foreach ($applicants as $applicant) {

            // =========================
            // 1. Draft Application
            // =========================
            Application::create([
                'user_id' => $applicant->id,
                'title' => 'Draft Application - ' . $applicant->name,
                'category' => 'leave',
                'description' => 'This is a draft application',
                'amount' => null,
                'date' => now(),
                'status' => ApplicationStatus::DRAFT->value,
            ]);

            // =========================
            // 2. Under Review
            // =========================
            Application::create([
                'user_id' => $applicant->id,
                'title' => 'Submitted Application - ' . $applicant->name,
                'category' => 'expense',
                'description' => 'Submitted for review',
                'amount' => 250.00,
                'date' => now()->subDays(1),
                'status' => ApplicationStatus::UNDER_REVIEW->value,
                'current_reviewer_id' => $reviewers->random()->id,
            ]);

            // =========================
            // 3. Returned for Changes
            // =========================
            Application::create([
                'user_id' => $applicant->id,
                'title' => 'Returned Application - ' . $applicant->name,
                'category' => 'procurement',
                'description' => 'Needs corrections',
                'amount' => 500.00,
                'date' => now()->subDays(2),
                'status' => ApplicationStatus::RETURNED_FOR_CHANGES->value,
                'current_reviewer_id' => $reviewers->random()->id,
            ]);

            // =========================
            // 4. Approved
            // =========================
            Application::create([
                'user_id' => $applicant->id,
                'title' => 'Approved Application - ' . $applicant->name,
                'category' => 'reimbursement',
                'description' => 'Fully approved',
                'amount' => 120.00,
                'date' => now()->subDays(5),
                'status' => ApplicationStatus::APPROVED->value,
                'current_reviewer_id' => $reviewers->random()->id,
            ]);
        }
    }
}