<?php

namespace Database\Seeders;

use App\Enums\ApplicationStatus;
use App\Models\Application;
use App\Models\ApplicationLog;

use Illuminate\Database\Seeder;

class ApplicationLogSeeder extends Seeder
{
    public function run(): void
    {
        $applications = Application::all();

        if ($applications->isEmpty()) {
            return;
        }

        foreach ($applications as $application) {

            // Applicant submission log (if not draft)
            if ($application->status !== ApplicationStatus::DRAFT->value) {
                ApplicationLog::create([
                    'application_id' => $application->id,
                    'user_id'        => $application->user_id,
                    'old_status'     => ApplicationStatus::DRAFT->value,
                    'new_status'     => ApplicationStatus::UNDER_REVIEW->value,
                    'comment'        => 'Initial submission',
                ]);
            }

            // Reviewer action logs
            if ($application->current_reviewer_id) {

                $reviewerId = $application->current_reviewer_id;

                match ($application->status) {
                    ApplicationStatus::APPROVED->value => ApplicationLog::create([
                        'application_id' => $application->id,
                        'user_id'        => $reviewerId,
                        'old_status'     => ApplicationStatus::UNDER_REVIEW->value,
                        'new_status'     => ApplicationStatus::APPROVED->value,
                        'comment'        => 'Approved in seeder',
                    ]),

                    ApplicationStatus::REJECTED->value => ApplicationLog::create([
                        'application_id' => $application->id,
                        'user_id'        => $reviewerId,
                        'old_status'     => ApplicationStatus::UNDER_REVIEW->value,
                        'new_status'     => ApplicationStatus::REJECTED->value,
                        'comment'        => 'Rejected in seeder',
                    ]),

                    ApplicationStatus::RETURNED_FOR_CHANGES->value => ApplicationLog::create([
                        'application_id' => $application->id,
                        'user_id'        => $reviewerId,
                        'old_status'     => ApplicationStatus::UNDER_REVIEW->value,
                        'new_status'     => ApplicationStatus::RETURNED_FOR_CHANGES->value,
                        'comment'        => 'Returned for changes in seeder',
                    ]),

                    default => null
                };
            }
        }
    }
}