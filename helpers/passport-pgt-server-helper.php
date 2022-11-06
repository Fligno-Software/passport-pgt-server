<?php

/**
 * @author James Carlo Luchavez <jamescarlo.luchavez@fligno.com>
 */

use Fld3\PassportPgtServer\Services\PassportPgtServer;

if (! function_exists('passportPgtServer')) {
    /**
     * @param  string|null  $auth_server_controller_class
     * @return PassportPgtServer
     */
    function passportPgtServer(string $auth_server_controller_class = null): PassportPgtServer
    {
        return resolve('passport-pgt-server', [
            'auth_server_controller' => $auth_server_controller_class,
        ]);
    }
}

if (! function_exists('passport_pgt_server')) {
    /**
     * @param  string|null  $auth_server_controller_class
     * @return PassportPgtServer
     */
    function passport_pgt_server(string $auth_server_controller_class = null): PassportPgtServer
    {
        return passportPgtServer($auth_server_controller_class);
    }
}
