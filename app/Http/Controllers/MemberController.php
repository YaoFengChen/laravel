<?php

namespace App\Http\Controllers;

use App\Services\MemberService;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * @OA\Get(
     *     path="/member",
     *     @OA\Response(response="200", description="An example resource")
     * )
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
     *     @OA\Response(response="200", description="An example resource")
     * )
     */
    public function getMembers(Request $request, MemberService $memberService)
    {
        $members = $memberService->getMembers($request->get('take', 10));

        return response()->json($members, 200);
    }
}
