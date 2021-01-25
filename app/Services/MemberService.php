<?php

namespace App\Services;

use App\Model\Members;
use App\Exceptions\MemberException;
use App\Repository\MemberRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
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

    public function getGoogleMember($member)
    {
        $existMember = $this->member->getMemberWithSource($member->get('email'), Members::SOURCE_GOOGLE);

        if (!empty($existMember)) {
            return $existMember;
        }

        return $this->addMember($member, Members::SOURCE_GOOGLE);
    }

    public function addNormalMember($member)
    {
        $members = $this->member->getMemberWithSource($member->get('email'), Members::SOURCE_REGISTER);

        if (!is_null($members)) {
            throw new MemberException('會員已存在');
        }

        $this->addMember($member, Members::SOURCE_REGISTER);
    }

    /**
     * @param Request $registerMember
     * @param $source
     * @throws \Exception
     * @return Model
     */
    private function addMember(Request $registerMember, $source)
    {
        $newMember = new Members;
        $newMember->email = $registerMember->get('email');
        $newMember->source = $source;
        $newMember->name = $registerMember->get('name', '');
        $newMember->nickname = $registerMember->get('name', '');
        $newMember->password = Hash::make($registerMember->get('password', rand(0, 999)));

        if (!$newMember->save()) {
            throw new \Exception('未預期錯誤');
        }

        return $newMember;
    }
}
