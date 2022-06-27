<?php

namespace Fld3\PassportPgtServer\Abstracts;

use App\Http\Controllers\Controller;
use Fld3\PassportPgtServer\Traits\HasAuthServerGetSelfTrait;
use Fld3\PassportPgtServer\Traits\HasAuthServerLogoutTrait;

/**
 * Class BaseAuthServerController
 *
 * @author James Carlo Luchavez <jamescarlo.luchavez@fligno.com>
 */
abstract class BaseAuthServerController extends Controller
{
    use HasAuthServerLogoutTrait;
    use HasAuthServerGetSelfTrait;
}
