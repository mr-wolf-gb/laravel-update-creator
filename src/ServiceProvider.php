<?php

namespace MrWolfGb\LaravelUpdateCreator;

use Illuminate\Support\ServiceProvider;
use MrWolfGb\LaravelUpdateCreator\Console\Commands\UpdateCreatorCommand;

class ServiceProvider extends ServiceProvider
{
    const CONFIG_PATH = __DIR__.'/../config/config.php';
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->publishes([self::CONFIG_PATH => config_path('laravel-update-creator.php')], 'config');

        if ($this->app->runningInConsole()) {
            $this->commands([UpdateCreatorCommand::class]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(self::CONFIG_PATH , 'laravel-update-creator');
    }
}
