<?php

namespace Bitempest\LaravelSettings;

use Illuminate\Support\ServiceProvider;

class SettingsServiceProvider extends ServiceProvider
{

    protected $settingsContract = 'Bitempest\LaravelSettings\SettingsContract';

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

        $this->app->singleton($this->settingsContract, function ($app) {
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
    }

}
