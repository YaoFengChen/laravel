<?php

namespace App\Services;

use App\Model\Members;
use App\Exceptions\MemberException;
use App\Repository\MemberRepository;
use Illuminate\Support\Facades\Hash;

class MemberService
{
    protected $member;

    /**
     * MemberService constructor.
     * @param MemberRepository $member
     */
    public function __construct(MemberRepository $member)
    {
        $this->member = $member;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getMember($id)
    {
        return $this->member->getMemberWithId($id);
    }

    /**
     * @param int $take
     * @return mixed
     */
    public function getMembers($take = 10)
    {
        return $this->member->getMembers($take);
    }

    /**
     * @param $registerMember
     * @throws MemberException
     * @throws \Exception
     */
    public function addMember($registerMember)
    {
        $members = $this->member->getMemberWithSourceRegister($registerMember->get('email'));

        if ($members->count() > 0) {
            throw new MemberException('會員已存在');
        }

        $newMember = new Members;
        $newMember->email = $registerMember->get('email');
        $newMember->source = Members::SOURCE_REGISTER;
        $newMember->password = Hash::make($registerMember->get('password'));
        $newMember->name = $registerMember->get('name', '');
        $newMember->nickname = $registerMember->get('name', '');
        if (!$newMember->save()) {
            throw new \Exception('未預期錯誤');
        }
    }
}
