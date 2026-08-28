<?php

namespace App\Policies;

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
        return $user->isAdmin() || $user->id === $application->user_id;
    }

    public function create(User $user): bool
    {
        return $user->isJobSeeker();
    }

    public function updateStatus(User $user, Application $application): bool
    {
        return $user->isAdmin();
    }

    public function scheduleInterview(User $user, Application $application): bool
    {
        return $user->isAdmin();
    }
}
