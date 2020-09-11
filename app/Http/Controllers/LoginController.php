<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Services\jwt\Facade\JWT;

class LoginController extends Controller
{
    /**
     * @OA\Post(
     *     path="/login",
     *     @OA\Parameter(
     *     name="token",
     *     in="query",
     *     description="JWT token. Ex: xxx.xxx.xxx",
     *     required=true,
     *     ),
     *     @OA\Parameter(
     *     name="email",
     *     in="query",
     *     description="member's email. email is account",
     *     required=true,
     *     ),
     *     @OA\Parameter(
     *     name="password",
     *     in="query",
     *     description="account's password",
     *     required=true,
     *     ),
     *     @OA\Response(response="200", description="login success. it will response a login token in header"),
     *     @OA\Response(response="402",description="login failed"),
     *     @OA\Response(response="403",description="csrf token error")
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
