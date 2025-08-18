<?php

namespace App\Providers;

use App\Models\Course;
use App\Models\User;
use App\Observers\LogObserver;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

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
        User::observe(LogObserver::class);
        Inertia::share([
            'authUser' => function () {
                return auth()->user() ? [
                    'id' => auth()->id(),
                    'name' => auth()->user()->name,
                    'email' => auth()->user()->email,
                    'profile' => auth()->user()->profile,
                ] : null;
            },
        ]);
    }
}
