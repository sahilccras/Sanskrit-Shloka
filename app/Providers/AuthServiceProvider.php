<?php

namespace App\Providers;

use App\Models\QAPair;
use App\Models\User;
use App\Policies\QAPairPolicy;
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
        QAPair::class => QAPairPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('export', function (User $user) {
            return in_array($user->role, [
                'admin',
                'approver',
                'fixed_entry',
                'variable_entry',
            ]);
        });
    }
}
