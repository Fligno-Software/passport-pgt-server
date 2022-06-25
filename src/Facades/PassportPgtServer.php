<?php

namespace Fld3\PassportPgtServer\Facades;

use Illuminate\Support\Facades\Facade;

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
