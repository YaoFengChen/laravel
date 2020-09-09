<?php

namespace App\Http\Middleware;

use App\Services\jwt\Facade\JWT;
use Closure;

class JWTAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!auth('api')->user()) {
            return JWT::response(402);
        }

        return $next($request);
    }
}
