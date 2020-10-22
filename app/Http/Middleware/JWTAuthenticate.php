<?php

namespace App\Http\Middleware;

use App\Services\jwt\Facade\JWT;
use Closure;
use Illuminate\Http\Request;

class JWTAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!auth('api')->user()) {
            return response()->json([], 402);
        }

        return $next($request);
    }
}
