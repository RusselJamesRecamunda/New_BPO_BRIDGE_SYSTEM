<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use App\Models\Interviews;
use App\Observers\InterviewObserver;
use App\Models\Employees;
use App\Models\EmployeeAssets;
use App\Observers\EmployeeObserver;

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
        Interviews::observe(InterviewObserver::class);
        // Register the EmployeeObserver for the Employees model
        Employees::observe(EmployeeObserver::class);
    }
}
