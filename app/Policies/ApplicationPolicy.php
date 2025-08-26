<?php

namespace App\Policies;

use App\Models\Application;
use App\Models\Job;
use App\Models\User;

class ApplicationPolicy
{
    public function apply(User $user, Job $job)
    {
        return $user->isWorker() && $user->id !== $job->user_id;
    }

    public function viewApplications(User $user)
    {
        return $user->isWorker();
    }

    public function viewJobApplications(User $user, Job $job)
    {
        return $user->isBoss() && $user->id === $job->user_id;
    }

    public function updateApplication(User $user, Application $application)
    {
        return $user->isBoss() && $user->id === $application->job->user_id;
    }

    public function deleteApplication(User $user, Application $application)
    {
        return $user->id === $application->user_id;
    }
} 