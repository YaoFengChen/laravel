<?php

namespace App\Http\Controllers;

use App\Services\MemberService;
use Illuminate\Http\Request;

/**
 * @OA\Schema()
 */
class MemberController extends Controller
{
    /**
     * @OA\Get(
     *     path="/member/1",
     *     summary="取得會員資料",
     *     @OA\Response(response="200", description="回傳會員資料"),
     *     @OA\Response(response="404", description="找不到會員")
     * )
     *
     * @param MemberService $memberService
     * @param int $id
     */
    public function getMember(MemberService $memberService, $id)
    {
        $member = $memberService->getMember($id);

        if (is_null($member)) {
            abort(404);
        }

        return response()->json($member);
    }

    /**
     * @OA\Get(
     *     path="/members",
     *     @OA\Response(response="200", description="會員列表 預設 10筆")
     * )
     *
     */
    public function getMembers(Request $request, MemberService $memberService)
    {
        $members = $memberService->getMembers($request->get('take', 10));

        return response()->json($members, 200);
    }
}
