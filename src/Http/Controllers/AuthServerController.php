<?php

namespace Fld3\PassportPgtServer\Http\Controllers;

use Fld3\PassportPgtServer\Abstracts\BaseAuthServerController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Passport\RefreshTokenRepository;
use Laravel\Passport\TokenRepository;

/**
 * Class AuthServerController
 *
 * @author James Carlo Luchavez <jamescarlo.luchavez@fligno.com>
 */
class AuthServerController extends BaseAuthServerController
{
    /**
     * Logout
     *
     * @group Authentication
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $tokenId = $request->user()->token()->id;

        $tokenRepository = app(TokenRepository::class);
        $refreshTokenRepository = app(RefreshTokenRepository::class);

        // Revoke an access token...
        $tokenRepository->revokeAccessToken($tokenId);

        // Revoke all of the token's refresh tokens...
        $refreshTokenRepository->revokeRefreshTokensByAccessTokenId($tokenId);

        return customResponse()
            ->success()
            ->message('Successfully logged out.')
            ->generate();
    }

    /**
     * Refresh Token
     *
     * @group Authentication
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function me(Request $request): JsonResponse
    {
        return customResponse()
            ->data($request->user())
            ->success()
            ->message('Successfully fetched user.')
            ->generate();
    }
}
