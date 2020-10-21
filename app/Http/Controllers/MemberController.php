<?php

namespace App\Http\Controllers;

use App\Exceptions\MemberException;
use App\Http\Requests\AddMemberRequest;
use App\Services\jwt\Facade\JWT;
use App\Services\MemberService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
     *     name="id",
     *     in="path",
     *     description="member's id",
     *     required=true,
     *     ),
     *     @OA\Response(response="200", description="回傳會員資料"),
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
            return JWT::response(404);
        }

        return JWT::response($member);
    }

    /**
     * @OA\Get(
     *     path="/members",
     *     @OA\Response(response="200", description="會員列表 預設 10筆")
     * )
     *
     * @param Request $request
     * @param MemberService $memberService
     * @return mixed
     */
    public function getMembers(Request $request, MemberService $memberService)
    {
        $members = $memberService->getMembers($request->get('take', 10));

        return JWT::response($members);
    }

    /**
     * @OA\post(
     *     path="/register",
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
     *     @OA\Response(response="404", description="未預期錯誤")
     * )
     * @param AddMemberRequest $member
     * @param MemberService $memberService
     * @return mixed
     */

    public function registerMember(AddMemberRequest $member, MemberService $memberService)
    {
        try {
            $memberService->addMember($member);
            return JWT::response();
        } catch (MemberException $e) {
            return JWT::response(203);
        } catch (\Exception $e) {
            Log::error($e);
            return JWT::response(404);
        }
    }
}
