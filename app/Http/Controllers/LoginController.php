<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Services\jwt\Facade\JWT;

class LoginController extends Controller
{
    /**
     * @OA\Post(
     *     path="/login",
     *     @OA\Response(response="200", description="login success"),
     *     @OA\Response(response="402", description="login failed")
     * )
     *
     * @param LoginRequest $member
     * @return mixed
     */
    public function login(LoginRequest $member)
    {
        if (auth('api')->user()) {
            return JWT::response();
        }

        if (auth('api')->attempt($member->only(['email', 'password']))) {
            return JWT::response();
        }

        return JWT::response(402);
    }
}
