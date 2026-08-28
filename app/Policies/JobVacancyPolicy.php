<?php

namespace App\Policies;

use App\Models\JobVacancy;
use App\Models\User;

class JobVacancyPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, JobVacancy $jobVacancy): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, JobVacancy $jobVacancy): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, JobVacancy $jobVacancy): bool
    {
        return $user->isAdmin();
    }

    public function toggleStatus(User $user, JobVacancy $jobVacancy): bool
    {
        return $user->isAdmin();
    }

    public function apply(User $user, JobVacancy $jobVacancy): bool
    {
        return $user->isJobSeeker() && $jobVacancy->is_open && $jobVacancy->is_active;
    }
}
