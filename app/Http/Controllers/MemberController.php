<?php

namespace App\Http\Controllers;

use App\Services\MemberService;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function getMember(MemberService $memberService, $id)
    {
        $member = $memberService->getMember($id);

        if (is_null($member)) {
            abort(404);
        }

        return response()->json([
            'id' => $member->id,
            'source' => $member->source,
            'email' => $member->email,
            'name' => $member->name,
            'nickname' => $member->nickname,
        ], 200);
    }
}