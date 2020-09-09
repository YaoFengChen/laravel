<?php

namespace App\Services\jwt\Provider;

use App\Services\jwt\JWT;
use Illuminate\Support\ServiceProvider;

class JWTProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('jwt', function()
        {
            return new JWT;
        });
    }

}
