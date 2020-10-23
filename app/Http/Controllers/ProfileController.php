<?php

namespace App\Http\Controllers;

class ProfileController extends Controller
{
    /**
     * @OA\Get(
     *     path="/profile",
     *     summary="取得登入的個人資料",
     *     @OA\Parameter(
     *     name="token",
     *     in="query",
     *     description="jwt token",
     *     required=true,
     *     ),
     *     @OA\Response(response="200", description="成功"),
     *     @OA\Response(response="402",description="授權失敗"),
     * )
     *
     * @return mixed
     */
    public function getProfile()
    {
        return response()->json(auth('api')->user());
    }
}
