<?php

namespace App\Services\LoginService;

use App\Services\LoginService\ThirdService\GoogleService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Manager;

class LoginManager extends Manager
{
    public function thirdService($thirdService)
    {
        return $this->driver($thirdService);
    }

    public function createGoogleDriver()
    {
        return App::make(GoogleService::class);
    }

    public function getDefaultDriver()
    {
        return App::make(LoginService::class);
    }
}
