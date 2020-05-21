<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use function OpenApi\scan;

class SwaggerController extends Controller
{
    protected $swagger;

    public function __construct()
    {
        $this->swagger = scan(app_path('Http/Controllers/'));
    }

    public function index()
    {
        return view('swagger/swagger');
    }

    //
    public function json()
    {
        return response()->json($this->swagger, 200);
    }
}
