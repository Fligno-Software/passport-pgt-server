<?php

namespace Fld3\PassportPgtServer\Feature\Http\Controllers;

use Tests\TestCase;

/**
 * Class AuthServerControllerTest
 *
 * @author James Carlo Luchavez <jamescarlo.luchavez@fligno.com>
 */
class AuthServerControllerTest extends TestCase
{
    /**
     * Example Test
     *
     * @test
     */
    public function example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
