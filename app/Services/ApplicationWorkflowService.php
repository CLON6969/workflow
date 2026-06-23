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
    /**
     * Transition an application to a new status with strict rules
     */
    public function transition(Application $application, ApplicationStatus $newStatus, User $user, string $comment = null): Application
    {
        $oldStatus = ApplicationStatus::from($application->status);

        // Validate the transition
        $this->validateTransition($application, $oldStatus, $newStatus, $user, $comment);

        return DB::transaction(function () use ($application, $oldStatus, $newStatus, $user, $comment) {
            
            // Update application status
            $application->status = $newStatus->value;
            
            // If reviewer is taking action, set current_reviewer_id
            if ($user->isReviewer()) {
                $application->current_reviewer_id = $user->id;
            }

            $application->save();

            // Log the transition
            ApplicationLog::create([
                'application_id' => $application->id,
                'user_id' => $user->id,
                'old_status' => $oldStatus->value,
                'new_status' => $newStatus->value,
                'comment' => $comment,
            ]);

            return $application->fresh(['logs']);
        });
    }

    /**
     * Validate if transition is allowed
     */
    private function validateTransition(
        Application $application, 
        ApplicationStatus $oldStatus, 
        ApplicationStatus $newStatus, 
        User $user, 
        ?string $comment
    ): void {
        
        // Same status - no transition
        if ($oldStatus === $newStatus) {
            throw new Exception("No status change detected.");
        }

        // Rule 1: Only owner can edit/submit DRAFT
        if ($oldStatus === ApplicationStatus::DRAFT) {
            if (!$application->belongsToUser($user)) {
                throw new Exception("Only the applicant can modify their draft.");
            }
            
            if ($newStatus !== ApplicationStatus::SUBMITTED) {
                throw new Exception("Draft can only be submitted.");
            }
            return;
        }

        // Rule 2: Applicant cannot edit after leaving DRAFT
        if ($application->belongsToUser($user) && !$user->isReviewer()) {
            throw new Exception("You cannot modify an application after submission.");
        }

        // Rule 3: Only Reviewer can perform review actions
        if (!$user->isReviewer()) {
            throw new Exception("Only reviewers can perform this action.");
        }

        // Define allowed transitions
        $allowedTransitions = [
            ApplicationStatus::SUBMITTED->value   => [ApplicationStatus::UNDER_REVIEW],
            ApplicationStatus::UNDER_REVIEW->value => [
                ApplicationStatus::APPROVED,
                ApplicationStatus::REJECTED,
                ApplicationStatus::RETURNED
            ],
            ApplicationStatus::RETURNED->value    => [ApplicationStatus::SUBMITTED],
        ];

        if (!isset($allowedTransitions[$oldStatus->value]) || 
            !in_array($newStatus, $allowedTransitions[$oldStatus->value])) {
            
            throw new Exception("Invalid status transition from {$oldStatus->label()} to {$newStatus->label()}.");
        }

        // Rule 4: Reject and Return require comment
        if (in_array($newStatus, [ApplicationStatus::REJECTED, ApplicationStatus::RETURNED]) && empty($comment)) {
            throw new Exception("A comment is required when rejecting or returning an application.");
        }
    }

    /**
     * Check if user can edit the application
     */
    public function canEdit(Application $application, User $user): bool
    {
        return $application->canBeEditedBy($user);
    }
}