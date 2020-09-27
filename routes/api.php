<?php

use App\Http\Middleware\CheckUpdate;
use Illuminate\Http\Request;
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

Route::prefix('auth')
    ->name('admin')
    ->namespace('Api')
    ->group(function () {

        Route::post('login', 'AuthController@login');
        Route::post('register', 'AuthController@register');

        Route::middleware(['jwt.auth', CheckUpdate::class])->group(function () {

            Route::get('settings', 'AuthController@settings');
            Route::get('refresh', 'AuthController@refresh');
            Route::post('logout', 'AuthController@logout');

            Route::namespace('users')->group(function (){
                Route::apiResource('users','UsersController');
            });

            Route::apiResource('profile','ProfileController');
            Route::apiResource('rooms','RoomController');
            Route::post('rooms/messageStore/{id}', 'RoomController@messageStore');

            Route::namespace('system')->group(function (){
                Route::get('system/getRoleAndPermissions', 'SystemController@getRoleAndPermissions');
            });

        });

    });
