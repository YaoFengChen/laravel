<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SwaggerController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\LoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => 'jwt'], function () {
    Route::get('/member/{id}', [MemberController::class, 'getMember']);
    Route::get('/members', [MemberController::class, 'getMembers']);
});

Route::post('/member', [MemberController::class, 'addMember']);

Route::post('/login', [LoginController::class, 'login']);

Route::get('/api/swagger', [SwaggerController::class, 'json']);
Route::get('/swagger', [SwaggerController::class, 'index']);
