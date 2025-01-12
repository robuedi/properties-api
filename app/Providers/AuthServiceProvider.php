<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Property;
use App\Policies\PropertyPolicy;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Gate::policy(Property::class, PropertyPolicy::class);
    }
}
