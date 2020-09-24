<?php

namespace App\Services\jwt;

use App\Entities\Members;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class JWT
{
    /**
     * JWT constructor.
     *
     * it get token from request only.
     */
    public function __construct()
    {
        app('tymon.jwt')->getToken();
    }

    public function check($getPayload = false)
    {
        return app('tymon.jwt')->check($getPayload);
    }

    public function getToken()
    {
        try {
            if ($this->check()) {
                return app('tymon.jwt')->getToken()->get();
            }

            return app('tymon.jwt')->fromSubject(new Members());

        } catch (TokenExpiredException $e) {
            return app('tymon.jwt')->refresh();
        }
    }

    /**
     * @param int|array $data
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function response($data = [], $code = 200)
    {
        if (is_numeric($data)) {
            $code = $data;
            $data = [];
        }

        return response()
            ->json($data, $code)
            ->header('Authorization', 'Bearer ' . $this->getToken())
            ->header('Access-Control-Expose_Headers', 'Authorization')
            ->header('Access-Control-Allow-Origin', '*');
    }
}
