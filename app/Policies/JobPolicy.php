<?php

namespace App\Policies;

use App\Models\Job;
use App\Models\User;

class JobPolicy
{
    public function create(User $user)
    {
        return $user->isBoss();
    }

    public function update(User $user, Job $job)
    {
        return $user->id === $job->user_id;
    }

    public function delete(User $user, Job $job)
    {
        return $user->id === $job->user_id;
    }

    public function viewMyJobs(User $user)
    {
        return $user->isBoss();
    }

    public function createOffer(User $user, Job $job)
    {
        return $user->isBoss() && $user->id === $job->user_id;
    }
} 