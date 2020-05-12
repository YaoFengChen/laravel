<?php

namespace App\Services;

use App\Repository\MemberRepository;

class MemberService
{
    protected $member;

    public function __construct(MemberRepository $member)
    {
        $this->member = $member;
    }

    public function getMember($id)
    {
        return $this->member->getMember($id);
    }
}
