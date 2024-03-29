<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    /**
     * @OA\Swagger(
     *      swagger="2.0"
     * ),
     * @OA\Info(
     *     title="laravel 實驗場",
     *     version="2.2.3",
     *     description="這是實驗各種新功能的 api, 架設於 aws. 採用 `swoole`、jwt、swagger, 環境 php73 mysql8 redis nginx(proxy to swoole). [#url test, url test](http://google.com)",
     *     termsOfService="http://google.com",
     *     @OA\Contact(email="guy414548@gamil.com"),
     *     license={"name":"MIT","url":"https://zh.wikipedia.org/wiki/MIT%E8%A8%B1%E5%8F%AF%E8%AD%89"},
     * ),
     * @OA\SecurityScheme(
     *     securityScheme="Authorization",
     *     type="apiKey",
     *     name="Authorization",
     *     in="header",
     *     description="JWT token. 前面要補上 bearer. Ex: bearer hhh.ppp.sss",
     * ),
     * @OA\Server(
     *     url="http://18.190.3.152:8080",
     *     description="apache"
     * ),
     * @OA\Server(
     *     url="http://18.190.3.152",
     *     description="nginx - swoole"
     * ),
     * @OA\Server(
     *     url="http://localhost:8888",
     *     description="localhost"
     * )
     */
}
