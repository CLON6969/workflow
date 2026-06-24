<?php

namespace App\Services;

use App\Enums\ApplicationStatus;
use App\Models\Application;
use App\Models\ApplicationLog;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;

class ApplicationWorkflowService
{
    public function transition(
        Application $application,
        string $action,
        User $user,
        ?string $comment = null
    ): Application {

        $oldStatus = $application->status;
        $newStatus = $this->resolveStatusFromAction($action);

        $this->validateTransition($application, $oldStatus, $newStatus, $user, $comment);

        return DB::transaction(function () use ($application, $oldStatus, $newStatus, $user, $comment) {

            if ($user->isReviewer()) {
                $application->current_reviewer_id = $user->id;
            }

            $application->status = $newStatus;
            $application->save();

            ApplicationLog::create([
                'application_id' => $application->id,
                'user_id' => $user->id,
                'old_status' => $oldStatus,
                'new_status' => $newStatus,
                'comment' => $comment,
            ]);

            return $application->fresh(['logs', 'user', 'currentReviewer']);
        });
    }

    private function resolveStatusFromAction(string $action): ApplicationStatus
    {
        return match ($action) {
            'submit'  => ApplicationStatus::UNDER_REVIEW,
            'approve' => ApplicationStatus::APPROVED,
            'reject'  => ApplicationStatus::REJECTED,
            'return'  => ApplicationStatus::RETURNED_FOR_CHANGES,
            default   => throw new Exception("Invalid action: {$action}"),
        };
    }

    private function validateTransition(
        Application $application,
        ApplicationStatus $oldStatus,
        ApplicationStatus $newStatus,
        User $user,
        ?string $comment
    ): void {

        if ($oldStatus === $newStatus) {
            throw new Exception("No status change detected.");
        }

        // Applicant rules
        if ($oldStatus === ApplicationStatus::DRAFT) {

            if (!$application->belongsToUser($user)) {
                throw new Exception("Only the applicant can submit drafts.");
            }

            if ($newStatus !== ApplicationStatus::UNDER_REVIEW) {
                throw new Exception("Draft can only be submitted.");
            }

            return;
        }

        // block applicants from modifying submitted apps
        if ($application->belongsToUser($user) && !$user->isReviewer()) {
            throw new Exception("Applicants cannot modify submitted applications.");
        }

        // Reviewer rules
        if (!$user->isReviewer()) {
            throw new Exception("Only reviewers can perform this action.");
        }

        $allowedTransitions = [
            ApplicationStatus::UNDER_REVIEW->value => [
                ApplicationStatus::APPROVED,
                ApplicationStatus::REJECTED,
                ApplicationStatus::RETURNED_FOR_CHANGES,
            ],

            ApplicationStatus::RETURNED_FOR_CHANGES->value => [
                ApplicationStatus::UNDER_REVIEW,
            ],
        ];

        if (
            !isset($allowedTransitions[$oldStatus->value]) ||
            !in_array($newStatus, $allowedTransitions[$oldStatus->value], true)
        ) {
            throw new Exception(
                "Invalid transition from {$oldStatus->label()} to {$newStatus->label()}."
            );
        }

        if (
            in_array($newStatus, [
                ApplicationStatus::REJECTED,
                ApplicationStatus::RETURNED_FOR_CHANGES,
            ]) && empty($comment)
        ) {
            throw new Exception("Comment is required for this action.");
        }
    }
}