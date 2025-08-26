<?php

namespace App\Providers;

use App\Models\Job;
use App\Models\JobOffer;
use App\Models\Application;
use App\Policies\JobPolicy;
use App\Policies\JobOfferPolicy;
use App\Policies\ApplicationPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Job::class => JobPolicy::class,
        JobOffer::class => JobOfferPolicy::class,
        Application::class => ApplicationPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
} 