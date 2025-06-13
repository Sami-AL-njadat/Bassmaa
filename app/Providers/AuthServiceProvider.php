<?php

namespace App\Providers;

 
// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

use Carbon\Carbon;
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
        Passport::tokensExpireIn(Carbon::now()->addMinutes(60)); // Access tokens expire in 60 minutes
        Passport::refreshTokensExpireIn(Carbon::now()->addDays(30)); // Refresh tokens expire in 30 days
        Passport::personalAccessTokensExpireIn(Carbon::now()->addMinutes(60));
        //
    }
}
