<?php

namespace App\Providers;

use App\Repositories\PropertyRepository;
use App\Services\TextUniqueSlugService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(TextUniqueSlugService::class, TextUniqueSlugService::class);

        // repositories
        $this->app->bind(PropertyRepository::class, PropertyRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
