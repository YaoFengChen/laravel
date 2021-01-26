<?php

namespace App\Services\LoginService;

class LoginService implements LoginContract
{
    /**
     * @param $member
     * @return bool | string
     */
    public function login($member)
    {
        return auth('api')->attempt($member->only(['email', 'password']));
    }
}
