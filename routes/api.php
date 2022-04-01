<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{
    Driver\AuthController as DriverAuthController,
    User\AuthController as UserAuthController,
    User\ActionController as UserActionController,
    Driver\ActionController as DriverActionController

}; 

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

Broadcast::routes(['middleware' => ['auth:sanctum']]);



Route::group(['prefix'=>"v1", 'middleware' => ['json.response']],function (){


    Route::group(['prefix'=>"driver"],function (){

        Route::post('login', [DriverAuthController::class, 'login']);


        Route::group(['middleware' => ['auth:drivers']], function (){

            Route::post('request/{model}', [DriverActionController::class, 'requestAction']);

        });
    
    });
    Route::group(['prefix'=>"user"],function (){

        Route::post('login', [UserAuthController::class, 'login']);

        Route::group(['middleware' => ['auth:users']], function (){

            Route::post('request/{driver}', [UserActionController::class, 'createRequest']);

            Route::get('getDrivers',[UserActionController::class,'getDrivers']);
        
        });
    
    });

});
