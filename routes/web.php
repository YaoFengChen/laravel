<?php

use Illuminate\Support\Facades\Route;

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

//Route::group(['middleware' => 'jwt'], function () {
//    Route::get('/members', 'MemberController@getMembers');
//});

Route::post('/login', 'LoginController@login');

Route::get('/member/{id}', 'MemberController@getMember');
Route::get('/members', 'MemberController@getMembers');

Route::post('/member', 'MemberController@addMember');

Route::get('/api/swagger', 'SwaggerController@json');
Route::get('/swagger', 'SwaggerController@index');
