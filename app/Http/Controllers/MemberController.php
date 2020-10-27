<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddMemberRequest;
use App\Services\MemberService;
use Illuminate\Http\Request;

/**
 * @OA\Schema()
 */
class MemberController extends Controller
{
    /**
     * @OA\Get(
     *     path="/member/{id}",
     *     summary="取得會員資料",
     *     @OA\Parameter(
     *     name="token",
     *     in="query",
     *     description="jwt token",
     *     required=true,
     *     ),
     *     @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="member's id",
     *     required=true,
     *     ),
     *     @OA\Response(response="200", description="回傳會員資料"),
     *     @OA\Response(response="402", description="授權失敗"),
     *     @OA\Response(response="404", description="找不到會員")
     * )
     *
     * @param MemberService $memberService
     * @param int $id
     * @return mixed
     */
    public function getMember(MemberService $memberService, $id)
    {
        $member = $memberService->getMember($id);

        if (is_null($member)) {
            return response()->json([], 404);
        }

        return response()->json($member);
    }

    /**
     * @OA\Get(
     *     path="/members",
     *     summary="取得會員列表",
     *     @OA\Parameter(
     *     name="token",
     *     in="query",
     *     description="jwt token",
     *     required=true,
     *     ),
     *     @OA\Parameter(
     *     name="take",
     *     in="query",
     *     description="page size. default 10.",
     *     ),
     *     @OA\Parameter(
     *     name="page",
     *     in="query",
     *     description="page. default 1.",
     *     ),
     *     @OA\Response(response="200", description="會員列表 預設 10筆"),
     *     @OA\Response(response="402", description="授權失敗")
     * )
     *
     * @param Request $request
     * @param MemberService $memberService
     * @return mixed
     */
    public function getMembers(Request $request, MemberService $memberService)
    {
        $members = $memberService->getMembers($request->get('take', 10));

        return response()->json($members);
    }

    /**
     * @OA\post(
     *     path="/member",
     *     summary="新增會員",
     *     @OA\Parameter(
     *     name="email",
     *     in="query",
     *     description="email is account and unique email",
     *     required=true,
     *     ),
     *     @OA\Parameter(
     *     name="password",
     *     in="query",
     *     description="password",
     *     required=true,
     *     ),
     *     @OA\Parameter(
     *     name="name",
     *     in="query",
     *     description="it is account's name",
     *     required=true,
     *     ),
     *     @OA\Response(response="200", description="會員新增成功"),
     *     @OA\Response(response="203", description="會員已存在"),
     *     @OA\Response(response="500", description="未預期錯誤")
     * )
     * @param AddMemberRequest $member
     * @param MemberService $memberService
     * @return mixed
     */
    public function addMember(AddMemberRequest $member, MemberService $memberService)
    {
        $memberService->addMember($member);

        if ($token = auth('api')->attempt($member->only(['email', 'password']))) {
            return response()->json(['token' => $token]);
        }

        return response()->json([], 500);
    }
}
