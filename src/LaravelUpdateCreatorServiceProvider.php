<?php

namespace MrWolfGb\LaravelUpdateCreator;

use Illuminate\Support\ServiceProvider;
use MrWolfGb\LaravelUpdateCreator\Console\Commands\UpdateCreatorCommand;

class LaravelUpdateCreatorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/config.php' => config_path('laravel-update-creator.php'),
            ], 'config');

            $this->commands([
                UpdateCreatorCommand::class,
            ]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'laravel-update-creator');

    }
}
