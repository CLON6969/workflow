<?php

namespace App\Policies;

use App\Models\Application;
use App\Models\User;

class ApplicationPolicy
{
    /**
     * Determine whether the user can view any applications.
     */
    public function viewAny(User $user): bool
    {
        return true; // Allow authenticated users to view their own list
    }

    /**
     * Determine whether the user can view the application.
     */
    public function view(User $user, Application $application): bool
    {
        // Applicant can view their own application
        if ($application->belongsToUser($user)) {
            return true;
        }

        // Reviewer can view any application
        return $user->isReviewer();
    }

    /**
     * Determine whether the user can create applications.
     */
    public function create(User $user): bool
    {
        return $user->isApplicant();
    }

    /**
     * Determine whether the user can update the application.
     * Only drafts owned by the applicant can be updated.
     */
    public function update(User $user, Application $application): bool
    {
        return $application->canBeEditedBy($user);
    }

    /**
     * Determine whether the user can delete the application.
     */
    public function delete(User $user, Application $application): bool
    {
        return $application->isDraft() && $application->belongsToUser($user);
    }

    /**
     * Determine whether the user can submit the application.
     */
    public function submit(User $user, Application $application): bool
    {
        return $application->isDraft() && $application->belongsToUser($user);
    }

    /**
     * Determine whether the user can review (approve/reject/return) the application.
     */
    public function review(User $user, Application $application): bool
    {
        return $user->isReviewer() && 
               in_array($application->status, ['submitted', 'under_review', 'returned']);
    }
}