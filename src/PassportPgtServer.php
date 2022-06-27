<?php

namespace Fld3\PassportPgtServer;

use Fld3\PassportPgtServer\Abstracts\BaseAuthServerController;
use Fld3\PassportPgtServer\Http\Controllers\AuthServerController;
use Fld3\PassportPgtServer\Traits\HasAuthServerGetSelfTrait;
use Fld3\PassportPgtServer\Traits\HasAuthServerLogoutTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Routing\Controller;
use Illuminate\Support\Carbon;
use Laravel\Passport\Passport;
use RuntimeException;
use Throwable;

/**
 * Class PassportPgtServer
 *
 * @author James Carlo Luchavez <jamescarlo.luchavez@fligno.com>
 */
class PassportPgtServer
{
    /**
     * @var string
     */
    protected string $authServerController;

    /**
     * @var array
     */
    protected array $logoutAuthController = [];

    /**
     * @var array
     */
    protected array $meAuthController = [];

    /**
     * @param string|null $authServerControllerClass
     */
    public function __construct(string $authServerControllerClass = null)
    {
        if ($authServerControllerClass) {
            try {
                $this->setAuthServerController($authServerControllerClass);
            } catch (Throwable) {
            }
        }

        if (! isset($this->authServerController)) {
            $this->authServerController = AuthServerController::class;
        }
    }

    /**
     * @link https://laravel.com/docs/8.x/passport#installation
     *
     * @return void
     */
    public function setPassportAsApiDriver(): void
    {
        $key = 'auth.guards.api';

        $value = [
            'driver' => 'passport',
            'provider' => 'users',
        ];

        $apiAuthConfig = config($key);

        if ($apiAuthConfig && isset($apiAuthConfig['driver'])) {
            if ($apiAuthConfig['driver'] !== $value['driver']) {
                throw new RuntimeException('Failed to set passport as api driver. Another driver already set.');
            }
        } else {
            config([$key => $value]);
        }
    }

    /**
     * @param string $authServerControllerClass
     */
    public function setAuthServerController(string $authServerControllerClass): void
    {
        if (is_subclass_of($authServerControllerClass, BaseAuthServerController::class)) {
            $this->authServerController = $authServerControllerClass;
        } else {
            throw new RuntimeException('Controller class does not extend BaseAuthServerController class.');
        }
    }

    /**
     * @return string|BaseAuthServerController
     */
    public function getAuthServerController(): string|BaseAuthServerController
    {
        return $this->authServerController;
    }

    /**
     * @param string $logoutAuthControllerClass
     * @return void
     */
    public function setLogoutAuthController(string $logoutAuthControllerClass): void
    {
        if (is_subclass_of($logoutAuthControllerClass, Controller::class)) {
            if (class_uses_trait($logoutAuthControllerClass, HasAuthServerLogoutTrait::class)) {
                $this->logoutAuthController = [$logoutAuthControllerClass, 'logout'];
            } else {
                $this->logoutAuthController = [$logoutAuthControllerClass];
            }
        }
    }

    /**
     * @return array
     */
    public function getLogoutAuthController(): array
    {
        if (count($this->logoutAuthController)) {
            return $this->logoutAuthController;
        }

        return [$this->authServerController, 'logout'];
    }

    /**
     * @param array $meAuthController
     * @return void
     */
    public function setMeAuthController(array $meAuthController): void
    {
        if (is_subclass_of($meAuthController, Controller::class)) {
            if (class_uses_trait($meAuthController, HasAuthServerGetSelfTrait::class)) {
                $this->meAuthController = [$meAuthController, 'me'];
            } else {
                $this->meAuthController = [$meAuthController];
            }
        }
    }

    /**
     * @return array
     */
    public function getMeAuthController(): array
    {
        if (count($this->meAuthController)) {
            return $this->meAuthController;
        }

        return [$this->authServerController, 'me'];
    }

    /***** TOKEN EXPIRATIONS *****/

    /**
     * @return bool
     */
    public function hashClientSecrets(): bool
    {
        return config('passport-pgt-server.hash_client_secrets');
    }

    /**
     * @return string
     */
    public function getTokensExpiresInUnit(): string
    {
        return config('passport-pgt-server.access_token_expires_in.time_unit');
    }

    /**
     * @return int
     */
    public function getTokensExpiresInValue(): int
    {
        return config('passport-pgt-server.access_token_expires_in.time_value');
    }

    /**
     * @return Carbon
     */
    public function getTokensExpiresIn(): Carbon
    {
        return now()->add($this->getTokensExpiresInValue() . ' ' . $this->getTokensExpiresInUnit());
    }

    /**
     * @return string
     */
    public function getRefreshTokensExpiresInUnit(): string
    {
        return config('passport-pgt-server.access_token_expires_in.time_unit');
    }

    /**
     * @return int
     */
    public function getRefreshTokensExpiresInValue(): int
    {
        return config('passport-pgt-server.access_token_expires_in.time_value');
    }

    /**
     * @return Carbon
     */
    public function getRefreshTokensExpiresIn(): Carbon
    {
        return now()->add($this->getRefreshTokensExpiresInValue() . ' ' . $this->getRefreshTokensExpiresInUnit());
    }

    /**
     * @return string
     */
    public function getPersonalAccessTokensExpiresInUnit(): string
    {
        return config('passport-pgt-server.access_token_expires_in.time_unit');
    }

    /**
     * @return int
     */
    public function getPersonalAccessTokensExpiresInValue(): int
    {
        return config('passport-pgt-server.access_token_expires_in.time_value');
    }

    /**
     * @return Carbon
     */
    public function getPersonalAccessTokensExpiresIn(): Carbon
    {
        return now()->add($this->getPersonalAccessTokensExpiresInValue() . ' ' . $this->getPersonalAccessTokensExpiresInUnit());
    }

    /***** MODELS & BUILDERS *****/

    /**
     * @return string
     */
    public function getTokenModel(): string
    {
        return Passport::tokenModel();
    }

    /**
     * @return Builder
     */
    public function getTokenBuilder(): Builder
    {
        return Passport::tokenModel()::query();
    }

    /**
     * @return string
     */
    public function getRefreshTokenModel(): string
    {
        return Passport::refreshTokenModel();
    }

    /**
     * @return Builder
     */
    public function getRefreshTokenBuilder(): Builder
    {
        return Passport::refreshTokenModel()::query();
    }

    /**
     * @return string
     */
    public function getPersonalAccessTokenModel(): string
    {
        return Passport::personalAccessClientModel();
    }

    /**
     * @return Builder
     */
    public function getPersonalAccessTokenBuilder(): Builder
    {
        return Passport::personalAccessClientModel()::query();
    }

    /**
     * @return string
     */
    public function getClientModel(): string
    {
        return Passport::clientModel();
    }

    /**
     * @return Builder
     */
    public function getClientBuilder(): Builder
    {
        return Passport::clientModel()::query();
    }
}
