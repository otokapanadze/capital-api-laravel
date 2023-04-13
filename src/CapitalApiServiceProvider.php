<?php

namespace Otokapanadze\CapitalApi;

use Illuminate\Support\ServiceProvider;

class CapitalApiServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/config/capital-api.php' => config_path('capital-api.php'),
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/config/capital-api.php', 'capital-api'
        );
        $this->app->singleton(CapitalApiService::class, function ($app) {
            return new CapitalApiService($app->make(Contracts\ApiClientInterface::class));
        });
        $this->app->alias(CapitalApiService::class, 'capital-api-service');
    }
}
