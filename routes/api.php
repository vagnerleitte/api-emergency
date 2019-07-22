<?php
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

Route::group(['prefix' => 'v1/', 'middleware' => 'auth:api'], function () {
    /*Routes Admin*/
    Route::group(['prefix' => 'admin', 'namespace' => 'Api\V1\Manager'], function () {
        /*Users*/
        Route::post('user', 'UsersController@store');
        Route::post('user/upload', 'UsersController@upload');
        Route::get('authenticated', 'UsersController@authenticated');
        Route::get('user', 'UsersController@index');
        Route::get('user/{id}', 'UsersController@edit');
        Route::put('user/{id}', 'UsersController@update');
        Route::delete('user/{id}', 'UsersController@delete');
        Route::patch('user/{id}', 'UsersController@updateStatus');
    });
});
