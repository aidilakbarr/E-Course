<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        \App\Models\Course::class => \App\Policies\MatakuliahPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('is-admin', function (User $user) {
            return $user->role === "ADMIN";
        });

        Gate::define('is-kaprodi-or-admin', function (User $user) {
            return in_array($user->role, ['ADMIN', 'KAPRODI']);
        });
    }
}
