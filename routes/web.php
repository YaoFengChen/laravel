<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FileController;

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
    Route::put('/member', [MemberController::class, 'editMember']);

    Route::get('/profile', [ProfileController::class, 'getProfile']);
    Route::get('/logout', [LoginController::class, 'logout']);

    Route::get('/file/{name}', [FileController::class, 'downloadFile']);
    Route::post('/file', [FileController::class, 'saveFile']);
    Route::get('/files', [FileController::class, 'getFiles']);
    Route::delete('/file/{name}', [FileController::class, 'deleteFile']);
});

Route::post('/member', [MemberController::class, 'addMember']);

Route::post('/login', [LoginController::class, 'login']);
Route::post('/{thirdService}/login', [LoginController::class, 'thirdLogin'])
    ->where('thirdService', 'google');
