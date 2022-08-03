<?php

namespace Tests\Unit\Middlewares;

use App\Http\Middleware\SetApiHeaders;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use PHPUnit\Framework\TestCase;

class SetApiHeadersTest extends TestCase
{
    /**
     * Testing SetApiHeaders middleware.
     *
     * @return void
     */
    public function test_set_api_headers(): void
    {
        $middleware = new SetApiHeaders();

        $middleware->handle(new Request(), function (Request $request) {
            $this->assertSame('application/json', $request->header('accept'));

            return new Response();
        });
    }
}
