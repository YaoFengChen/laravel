<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;

class LoginController extends Controller
{
    /**
     * @OA\Post(
     *     path="/login",
     *     summary="登入取得 token",
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
        if ($token = auth('api')->attempt($member->only(['email', 'password']))) {
            return response()->json(['token' => $token]);
        }

        return response()->json([], 401);
    }

    /**
     * @OA\get(
     *     path="/logout",
     *     summary="註銷 token",
     *     @OA\Parameter(
     *     name="token",
     *     in="query",
     *     description="jwt token",
     *     required=true,
     *     ),
     *     @OA\Response(response="200", description="logout success. invalidate token."),
     *     @OA\Response(response="402",description="error token"),
     * )
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth('api')->logout();

        return response()->json([]);
    }
}
