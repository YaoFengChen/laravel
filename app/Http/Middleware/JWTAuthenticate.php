<?php

namespace App\Http\Middleware;

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
        if (auth('api')->check()) {
            return $next($request);
        }

        return $this->unauthorized();
    }

    private function unauthorized()
    {
        return response()->json([], 402);
    }
}
