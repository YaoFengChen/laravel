<?php

namespace App\Services\jwt\Facade;

use Illuminate\Support\Facades\Facade;

class JWT extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'jwt';
    }
}
