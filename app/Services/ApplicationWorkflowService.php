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

            // assign reviewer only when reviewer acts
            if ($user->isReviewer()) {
                $application->current_reviewer_id = $user->id;
            }

            $application->status = $newStatus;
            $application->save();

            ApplicationLog::create([
                'application_id' => $application->id,
                'user_id'        => $user->id,
                'old_status'     => $oldStatus,
                'new_status'     => $newStatus,
                'comment'        => $comment,
            ]);

            return $application->fresh(['logs', 'user', 'currentReviewer']);
        });
    }

    /**
     * Convert UI action → status
     */
    private function resolveStatusFromAction(string $action): ApplicationStatus
    {
        return match ($action) {

            // applicant actions
            'submit'   => ApplicationStatus::UNDER_REVIEW,
            'resubmit' => ApplicationStatus::UNDER_REVIEW,

            // reviewer actions
            'approve'  => ApplicationStatus::APPROVED,
            'reject'   => ApplicationStatus::REJECTED,
            'return'   => ApplicationStatus::RETURNED_FOR_CHANGES,

            default => throw new Exception("Invalid action: {$action}"),
        };
    }

    /**
     * Validate workflow rules
     */
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

        /*
        |-------------------------------------------------
        | 1. APPLICANT RULES
        |-------------------------------------------------
        */
        if ($application->belongsToUser($user) && !$user->isReviewer()) {

            // Applicant can only act in these states
            if (!in_array($oldStatus, [
                ApplicationStatus::DRAFT,
                ApplicationStatus::RETURNED_FOR_CHANGES,
            ], true)) {
                throw new Exception("You cannot modify this application at this stage.");
            }

            // Applicant can ONLY send forward (submit/resubmit)
            if ($newStatus !== ApplicationStatus::UNDER_REVIEW) {
                throw new Exception("Invalid applicant action.");
            }

            return; // IMPORTANT: stop here for applicant
        }

        /*
        |-------------------------------------------------
        | 2. REVIEWER RULES
        |-------------------------------------------------
        */
        if (!$user->isReviewer()) {
            throw new Exception("Only reviewers can perform this action.");
        }

        $allowedTransitions = [

            ApplicationStatus::UNDER_REVIEW->value => [
                ApplicationStatus::APPROVED,
                ApplicationStatus::REJECTED,
                ApplicationStatus::RETURNED_FOR_CHANGES,
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

        /*
        |-------------------------------------------------
        | 3. COMMENT RULES
        |-------------------------------------------------
        */
        if (
            in_array($newStatus, [
                ApplicationStatus::REJECTED,
                ApplicationStatus::RETURNED_FOR_CHANGES,
            ], true) && empty($comment)
        ) {
            throw new Exception("Comment is required for this action.");
        }
    }
}