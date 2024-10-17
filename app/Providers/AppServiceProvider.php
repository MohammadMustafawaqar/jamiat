<?php

namespace App\Providers;

use App\Models\School;
use App\Models\Student;
use App\Models\Supervisor;
use App\Models\SupervisorStudent;
use App\Observers\UserActionObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        School::observe(UserActionObserver::class);
        Student::observe(UserActionObserver::class);
        Supervisor::observe(UserActionObserver::class);
        SupervisorStudent::observe(UserActionObserver::class);
    }
}
