<?php

namespace App\Http\Controllers;

use App\Exceptions\MemberException;
use App\Http\Requests\AddMemberRequest;
use App\Http\Requests\EditMemberRequest;
use App\Model\Members;
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
            return response('', 404);
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
     * @return mixed | void
     */
    public function addMember(AddMemberRequest $member, MemberService $memberService)
    {
        try {
            $memberService->addNormalMember($member);
        } catch (MemberException $e) {
            return response('', 203);
        } catch (\Exception $e) {
            return response('', 500);
        }
    }

    /**
     * @OA\put(
     *     path="/member",
     *     summary="編輯會員",
     *     @OA\Parameter(
     *     name="name",
     *     in="query",
     *     description="member's name",
     *     ),
     *     @OA\Parameter(
     *     name="nickname",
     *     in="query",
     *     description="member's nickname",
     *     ),
     *     @OA\Parameter(
     *     name="token",
     *     in="query",
     *     description="jwt token",
     *     required=true,
     *     ),
     *     @OA\Response(response="200", description="編輯成功"),
     *     @OA\Response(response="500", description="未預期錯誤")
     * )
     *
     * @param EditMemberRequest $updateMember
     * @return void
     * @throws \Exception
     */
    public function editMember(EditMemberRequest $updateMember)
    {
        $member = auth('api')->user();

        $member->name = $updateMember->get('name', $member->name);
        $member->nickname = $updateMember->get('nickname', $member->nickname);
        if (!$member->save()) {
            throw new \Exception('未預期錯誤');
        }
    }
}
