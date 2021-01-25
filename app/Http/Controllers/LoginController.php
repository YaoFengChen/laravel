<?php

namespace App\Http\Controllers;

use App\Http\Requests\ThirdLoginRequest;
use App\Http\Requests\LoginRequest;
use App\Services\LoginService\LoginManager;
use App\Services\LoginService\LoginService;

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
     * @param LoginManager $loginManager
     * @return mixed
     */
    public function login(LoginRequest $member, LoginManager $loginManager)
    {
        /**
         * @method LoginService login
         */
        $token = $loginManager->login($member);

        if ($token) {
            return response()->json(['token' => $token]);
        }

        return response('', 402);
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
     * @return void
     */
    public function logout()
    {
        auth('api')->logout();
    }

    /**
     * @OA\post(
     *     path="/google/login",
     *     summary="google 登入",
     *     @OA\Parameter(
     *     name="email",
     *     in="query",
     *     description="email",
     *     required=true,
     *     ),
     *     @OA\Parameter(
     *     name="name",
     *     in="query",
     *     description="name",
     *     ),
     *     @OA\Parameter(
     *     name="token",
     *     in="query",
     *     description="google's token",
     *     required=true,
     *     ),
     *     @OA\Response(response="200", description="login success"),
     *     @OA\Response(response="402",description="error token"),
     * )
     * @param ThirdLoginRequest $member
     * @param LoginManager $loginManager
     *
     * @param $thirdService
     * @return mixed
     */
    public function thirdLogin(ThirdLoginRequest $member, LoginManager $loginManager, $thirdService)
    {
        $token = $loginManager->thirdService($thirdService)->login($member);

        if ($token) {
            return response()->json(['token' => $token]);
        }

        return response('', 402);
    }
}
