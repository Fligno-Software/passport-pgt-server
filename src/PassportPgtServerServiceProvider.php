<?php

namespace Fld3\PassportPgtServer;

use Fligno\StarterKit\Providers\BaseStarterKitServiceProvider;
use Laravel\Passport\Passport;

/**
 * Class PassportPgtServerServiceProvider
 *
 * @author James Carlo Luchavez <jamescarlo.luchavez@fligno.com>
 */
class PassportPgtServerServiceProvider extends BaseStarterKitServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        parent::boot();

        // Override Auth Config
        passportPgtServer()->setPassportAsApiDriver();

        // Add Passport Routes
        if (! $this->app->routesAreCached()) {
            Passport::routes();
        }

        // Hash Client Secrets
        if (passportPgtServer()->hashClientSecrets()) {
            Passport::hashClientSecrets();
        }

        // Set Expirations
        Passport::tokensExpireIn(passportPgtServer()->getTokensExpiresIn());
        Passport::refreshTokensExpireIn(passportPgtServer()->getRefreshTokensExpiresIn());
        Passport::personalAccessTokensExpireIn(passportPgtServer()->getPersonalAccessTokensExpiresIn());
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
        $this->app->singleton('passport-pgt-server', function ($app, $params) {
            return new PassportPgtServer(collect($params)->get('auth_server_controller'));
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides(): array
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
