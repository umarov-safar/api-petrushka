<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use \App\Http\Controllers\Api\Admin\V1\AbilityController;
use \App\Http\Controllers\Api\Admin\V1\RoleController;
use App\Http\Controllers\Api\Admin\V1\UserController as UserForAdminController;
use App\Http\Controllers\Api\Admin\V1\PartnerController;
use App\Http\Controllers\Api\Admin\V1\CompanyController;
use App\Http\Controllers\Api\Admin\V1\CompanyUserController;
use \App\Http\Controllers\Api\Admin\V1\PartnerUserController;

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


// routes for admin
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

        //companies
        $server->resource('companies', CompanyController::class);

        //company users
        $server->resource('companyuser', CompanyUserController::class);

        //partners routes
        $server->resource('partners', PartnerController::class);

        //partner users routes
        $server->resource('partneruser', PartnerUserController::class);

    });


// Routes for all users
JsonApiRoute::server('V1')
    ->prefix('v1')
    ->middleware('auth:sanctum')
    ->resources(function ($server) {

    });


//Routes for partners
JsonApiRoute::server('Partner\V1')
    ->prefix('partner/v1')
    ->middleware('auth:sanctum')
    ->resources(function ($server) {

    });
