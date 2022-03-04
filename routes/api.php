<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::post('/register', 'RegisterController@register');

Route::post('/registerAdmin', [AuthController::class, 'registerAdmin']);
Route::post('/login_admin', [AuthController::class, 'loginAdmin']);
Route::post('/checkPhoneNumber', [RegisterController::class, 'checkPhoneNumber']);


Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('/inputCheck', [RegisterController::class, 'inputCheck']);
    Route::get('/users', [UserController::class, 'index']);
    Route::post('/users/edit', [UserController::class, 'editUser']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::post('/listMemberTable', 'MemberController@listMemberTable');

Route::post('/login', 'LoginController@login');
