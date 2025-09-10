<?php

namespace App\Providers;

use App\Models\User;
use App\Observers\LogObserver;
use App\Observers\UserObserver;
use Illuminate\Support\Facades\Cache;
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
        User::observe([UserObserver::class, LogObserver::class]);

        Inertia::share([
            'authUser' => function () {
                $id = auth()->id();
                if (!$id) {
                    return null;
                }

                return Cache::remember(
                    "user:{$id}",
                    now()->addMinutes(30),
                    fn() => auth()->user()?->only([
                        'id',
                        'name',
                        'email',
                        'profile',
                        'role',
                    ])
                );
            },
        ]);
    }
}
