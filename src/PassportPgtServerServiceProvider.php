<?php

namespace Fld3\PassportPgtServer;

use Illuminate\Support\ServiceProvider;

class PassportPgtServerServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'fld3');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'fld3');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/passport-pgt-server.php', 'passport-pgt-server');

        // Register the service the package provides.
        $this->app->singleton('passport-pgt-server', function ($app) {
            return new PassportPgtServer;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['passport-pgt-server'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/passport-pgt-server.php' => config_path('passport-pgt-server.php'),
        ], 'passport-pgt-server.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/fld3'),
        ], 'passport-pgt-server.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/fld3'),
        ], 'passport-pgt-server.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/fld3'),
        ], 'passport-pgt-server.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
