<?php

/**
 * @author James Carlo Luchavez <jamescarlo.luchavez@fligno.com>
 */

use Fld3\PassportPgtServer\PassportPgtServer;

if (! function_exists('passportPgtServer')) {
    /**
     * @param string|null $authServerControllerClass
     * @return PassportPgtServer
     */
    function passportPgtServer(string $authServerControllerClass = null): PassportPgtServer
    {
        return resolve('passport-pgt-server', [
            'auth_server_controller' => $authServerControllerClass
        ]);
    }
}

if (! function_exists('passport_pgt_server')) {
    /**
     * @param string|null $authServerControllerClass
     * @return PassportPgtServer
     */
    function passport_pgt_server(string $authServerControllerClass = null): PassportPgtServer
    {
        return passportPgtServer($authServerControllerClass);
    }
}
