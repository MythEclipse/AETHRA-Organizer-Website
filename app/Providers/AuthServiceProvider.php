<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // DEFINISIKAN GATE ANDA DI SINI
        Gate::define('admin', function (User $user) {
            return $user->role === 'admin';
        });
        Gate::define('view_admin', function (User $user) {
            // Izinkan akses jika kolom 'role' pada user bernilai 'admin'
            return $user->role === 'admin';
        });
    }
}
