<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\TextUniqueSlugService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(TextUniqueSlugService::class, TextUniqueSlugService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
