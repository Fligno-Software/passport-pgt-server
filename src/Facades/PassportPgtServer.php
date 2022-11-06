<?php

namespace Fld3\PassportPgtServer\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class PassportPgtServer
 *
 * @author James Carlo Luchavez <jamescarlo.luchavez@fligno.com>
 *
 * @see \Fld3\PassportPgtServer\Services\PassportPgtServer
 */
class PassportPgtServer extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'passport-pgt-server';
    }
}
