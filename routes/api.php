<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use \LaravelJsonApi\Laravel\Http\Controllers\JsonApiController;
use \App\Http\Controllers\Api\Admin\V1\AbilityController;
use \App\Http\Controllers\Api\Admin\V1\RoleController;
use App\Http\Controllers\Api\Admin\V1\UserController as UserForAdminController;
use App\Http\Controllers\Api\Admin\V1\PartnerController;
use App\Http\Controllers\Api\Admin\V1\CompanyController;
use App\Http\Controllers\Api\Admin\V1\CompanyUserController;
use \App\Http\Controllers\Api\Admin\V1\PartnerUserController;
use \App\Http\Controllers\Api\Admin\V1\AccountController;
use \App\Http\Controllers\Api\Admin\V1\AttributeController;

//Controller of customer
use App\Http\Controllers\Api\Customer\V1\CompanyUserContorller as CustomerCompanyUserController;
use \App\Http\Controllers\Api\Customer\V1\AccountController as CustomerAccountController;

//Partner Controllers
use \App\Http\Controllers\Api\Partner\V1\EmployeeController as PartnerEmployeeController;
use \App\Http\Controllers\Api\Partner\V1\CompanyController as PartnerCompanyController;
use \App\Http\Controllers\Api\Partner\V1\PartnerController as PartnerPartnerController;
use \App\Http\Controllers\Api\Partner\V1\AccountController as PartnerAccountController;
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

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

// Route::post('auth/phone', [AuthController::class, 'login']);
// Route::post('auth/phone/{phone}', [AuthController::class, 'checkCode'])->whereNumber('phone');

//Route::group(['middleware' => 'auth:sanctum'], function () {
    //Route::post('auth/logout', [AuthController::class, 'logout']); // logout

    // User routes
    //Route::resource('users', UserController::class); // не json-api спецификация!
//});

Route::prefix('admin/v1')
    ->group(function(){
    //Route::post('auth/phone', [AuthController::class, 'loginAdmin']);
    Route::post('/auth', [AuthController::class, 'loginAdmin']);
    //Route::post('auth/phone/{phone}', [AuthController::class, 'checkCodeAdmin'])->whereNumber('phone');
    Route::post('/auth/{phone}', [AuthController::class, 'checkCodeAdmin'])->whereNumber('phone');
    /*Route::group(['namespace'=>'Api/Admin/V1'], function (){
        Route::post('/auth2/{phone}', [UserForAdminController::class, 'checkCode'])->whereNumber('phone');
    });*/

    });

Route::prefix('partner/v1')
    ->group(function(){
        Route::post('/auth', [AuthController::class, 'loginPartner']);
        Route::post('/auth/{phone}', [AuthController::class, 'checkCodePartner'])->whereNumber('phone');
    });

Route::prefix('customer/v1')
    ->group(function(){
        Route::post('/auth', [AuthController::class, 'loginCustomer']);
        Route::post('/auth/{phone}', [AuthController::class, 'checkCodeCustomer'])->whereNumber('phone');
    });


// routes for admin
JsonApiRoute::server('Admin\V1')
    ->prefix('admin/v1')
    ->middleware('auth:sanctum')
    ->resources(function ($server) {
        //Route::post('auth/logout', [AuthController::class, 'logout']); // logout

        $server->resource('account', AccountController::class);
        Route::delete('account', [AccountController::class, 'logout']); // logout
        /**
         * POST     /account - изменить аккаунт
         * GET      /account - посмотреть данные по аккаунту
         * DELETE  /account  - выход из системы
         */

        //roles routes
        $server->resource('roles', RoleController::class)
            ->only('index', 'show')
            ->relationships(function ($relationships) {
            $relationships->hasMany('abilities');
            $relationships->hasMany('users');
        });
        //abilities routes
        $server->resource('abilities', AbilityController::class)
            ->only('index', 'show');

        //users routes
        $server->resource('users', UserForAdminController::class)
            ->actions('-actions', function ($actions) {
                $actions->get('me', 'showMe');
                $actions->post('me', 'updateMe');
                // $actions->post('auth/logout','logout');
        });

        //companies
        $server->resource('companies', CompanyController::class)
            ->relationships(function($relationships) {
               $relationships->hasMany('companyUsers'); // только просмотр // ?
               $relationships->hasOne('owner')->only('related', 'show'); // ?
            });

        //company users
        $server->resource('company-users', CompanyUserController::class);

        //partners routes
        $server->resource('partners', PartnerController::class)
            ->relationships(function($relationships) {
                $relationships->hasMany('partnerUsers'); // только просмотр  // ?
                $relationships->hasOne('owner')->only('related', 'show'); // ?
            });

        //partner users routes
        $server->resource('partner-users', PartnerUserController::class); // переименовать в partner-users

        // PRODUCTS ROUTES
        $server->resource('attributes', JsonApiController::class);
    });


// Routes for all users
JsonApiRoute::server('Customer\V1')
    ->prefix('customer/v1')
    ->middleware('auth:sanctum')
    ->resources(function ($server) {
        //Route::post('auth/logout', [AuthController::class, 'logout']); // logout
        $server->resource('account', CustomerAccountController::class);
        Route::delete('account', [CustomerAccountController::class, 'logout']); // logout
        // company user routes
        $server->resource('company-users', CustomerCompanyUserController::class); // => employees
        // partners
        // companies
    });



// Routes for all users
JsonApiRoute::server('Partner\V1')
    ->prefix('partner/v1')
    ->middleware('auth:sanctum')
    ->resources(function ($server) {
        //Route::post('auth/logout', [AuthController::class, 'logout']); // logout
        // company user routes
        //$server->resource('companies', JsonApiController::class);
        $server->resource('companies', PartnerCompanyController::class);
        $server->resource('account', PartnerAccountController::class);
        Route::delete('account', [PartnerAccountController::class, 'logout']); // logout
        $server->resource('partners', PartnerPartnerController::class);
        // customers
        // my-companies , т.е. это partners
        $server->resource('employees', PartnerEmployeeController::class);
        // $server->resource('customers', EmployeeController::class); // Покупатели, реализовать в следующих релизах
    });
