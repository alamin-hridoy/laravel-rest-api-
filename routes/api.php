<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'posts'], function() {
    Route::get('/', 'APIPostsController@index');
    Route::get('/{post}', 'APIPostsController@show');
    Route::post('/', 'APIPostsController@store')->middleware('auth:api');
    Route::patch('/{post}', 'APIPostsController@update')->middleware('auth:api');
    Route::delete('/{post}', 'APIPostsController@destroy')->middleware('auth:api');
});

Route::group(['prefix' => 'users'], function() {
    Route::get('/', 'APIUsersController@index')->middleware('auth:api');
    Route::get('/{user}', 'APIUsersController@show')->middleware('auth:api');
    Route::post('/', 'APIUsersController@store')->middleware('auth:api');
    Route::patch('/{user}', 'APIUsersController@update')->middleware('auth:api');
    Route::delete('/{user}', 'APIUsersController@destroy')->middleware('auth:api');
});