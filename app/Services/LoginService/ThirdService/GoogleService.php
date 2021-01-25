<?php

namespace App\Services\LoginService\ThirdService;

use App\Repository\MemberRepository;
use App\Services\LoginService\LoginContract;
use App\Services\MemberService;

class GoogleService implements LoginContract
{
    protected $member;

    public function __construct(MemberRepository $member)
    {
        $this->member = $member;
    }

    public function login($member)
    {
        $memberService = app()->make(MemberService::class);
        $member = $memberService->getGoogleMember($member);

        return App('tymon.jwt')->fromSubject($member);
    }
}
