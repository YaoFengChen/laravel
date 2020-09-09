<?php

namespace App\Http\Middleware;

use App\Services\jwt\Facade\JWT;
use Closure;

class JWTVerifyCsrfToken
{
    public function handle($request, Closure $next)
    {
        if ($this->check($request)) {
            return $next($request);
        }

        return JWT::response(403);
    }

    private function check($request)
    {
        if ($request->method() === 'GET') {
            return true;
        }

        if (JWT::check()) {
            return true;
        }

        return false;
    }
}
