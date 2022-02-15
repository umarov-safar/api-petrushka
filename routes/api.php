<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use \App\Http\Controllers\Api\Admin\V1\AbilityController;
use \App\Http\Controllers\Api\Admin\V1\RoleController;
use App\Http\Controllers\Api\Admin\V1\UserController as UserForAdminController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('auth/phone', [AuthController::class, 'login']);
Route::post('auth/phone/{phone}', [AuthController::class, 'checkCode'])->whereNumber('phone');

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('auth/logout', [AuthController::class, 'logout']); // logout

    // User routes
    Route::resource('users', UserController::class);
});



JsonApiRoute::server('Admin\V1')
    ->prefix('admin/v1')
    ->middleware('auth:sanctum')
    ->resources(function ($server) {
        //roles routes
        $server->resource('roles', RoleController::class)
            ->relationships(function ($relationships) {
            $relationships->hasMany('abilities');
            $relationships->hasMany('users');
        });
        //abilities routes
        $server->resource('abilities', AbilityController::class);

        //users routes
        $server->resource('users', UserForAdminController::class);
    });
