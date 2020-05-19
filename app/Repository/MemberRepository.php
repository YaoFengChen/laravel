<?php

namespace App\Repository;

use App\Entities\Members;

class MemberRepository
{
    public function getMember($id)
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
        ])
        ->take($take)
        ->get();
    }
}
