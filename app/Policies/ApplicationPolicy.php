<?php

namespace App\Policies;

use App\Enums\ApplicationStatus;
use App\Models\Application;
use App\Models\User;

class ApplicationPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Application $application): bool
    {
        return $application->belongsToUser($user) || $user->isReviewer();
    }

    public function create(User $user): bool
    {
        return $user->isApplicant();
    }

    public function update(User $user, Application $application): bool
    {
        return $application->canBeEditedBy($user);
    }

    public function delete(User $user, Application $application): bool
    {
        return $application->status === ApplicationStatus::DRAFT
            && $application->belongsToUser($user);
    }

    public function submit(User $user, Application $application): bool
    {
        return $application->status === ApplicationStatus::DRAFT
            && $application->belongsToUser($user);
    }

    public function review(User $user, Application $application): bool
    {
        return $user->isReviewer()
            && $application->status === ApplicationStatus::UNDER_REVIEW;
    }
}