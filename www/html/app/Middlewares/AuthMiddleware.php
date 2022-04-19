<?php

namespace WJCrypto\Middlewares;

use Pecee\Http\Middleware\IMiddleware;
use Pecee\Http\Request;
use WJCrypto\Helpers;

class AuthMiddleware implements IMiddleware
{
    public function handle(Request $request): void
    {
        $session = Helpers::hasSession();
        if ($session) {
            http_response_code(200);
        } else {
            http_response_code(401);
            Helpers::response()->redirect('/');
        }
    }

}
