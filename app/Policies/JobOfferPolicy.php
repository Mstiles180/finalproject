<?php

namespace App\Policies;

use App\Models\JobOffer;
use App\Models\Job;
use App\Models\User;

class JobOfferPolicy
{
    public function viewOffers(User $user)
    {
        return $user->isWorker();
    }

    public function viewJobOffers(User $user, Job $job)
    {
        return $user->isBoss() && $user->id === $job->user_id;
    }

    public function createOffer(User $user, Job $job)
    {
        return $user->isBoss() && $user->id === $job->user_id;
    }

    public function respondToOffer(User $user, JobOffer $jobOffer)
    {
        return $user->isWorker() && $user->id === $jobOffer->worker_id;
    }

    public function deleteOffer(User $user, JobOffer $jobOffer)
    {
        return $user->isBoss() && $user->id === $jobOffer->job->user_id;
    }
} 