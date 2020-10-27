<?php

namespace App\Exceptions;

use Exception;

class MemberException extends Exception
{
    public function report()
    {
    }

    public function render()
    {
        return response()->json([], 203);
    }
}
