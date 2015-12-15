<?php

namespace IonutMilica\LaravelSettings;

use Illuminate\Support\ServiceProvider;

class SettingsServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/config.php', 'settings'
        );

        $this->app->singleton('settings.manager', function ($app) {
            return new SettingsManager($app);
        });

        $this->app->singleton('IonutMilica\LaravelSettings\SettingsContract', function ($app) {
            return $app->make('settings.manager')->driver();
        });

        require __DIR__.'/helpers.php';
    }

    /**
     * Boot service provider
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/config.php' => config_path('settings.php')
        ], 'config');

        $this->publishes([
            __DIR__.'/../database/migrations/' => database_path('migrations')
        ], 'migrations');
    }

}
