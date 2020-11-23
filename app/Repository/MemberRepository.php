<?php

namespace App\Repository;

use App\Model\Members;

class MemberRepository
{
    public function getMemberWithId($id)
    {
        return Members::select([
            'id',
            'source',
            'email',
            'name',
            'nickname',
        ])->find($id);
    }

    public function getMembers($take = 10)
    {
        return Members::select([
            'id',
            'source',
            'email',
            'name',
            'nickname',
        ])->paginate($take);
    }

    public function getMemberWithSourceRegister($email)
    {
        return Members::where('email', $email)
            ->where('source', Members::SOURCE_REGISTER)
            ->get();
    }
}
