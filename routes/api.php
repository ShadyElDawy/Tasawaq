<?php

use Illuminate\Http\Request;

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');
    Route::get('user/{user}', 'AuthController@show');

    Route::group([
        'middleware' => 'auth:api'
    ], function() {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');

    });
});





   ////////////////////////////////////////////////////////////////////

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::apiResource('/products','Api\ProductController')->except('update'); //for postman purpose
Route::post('/products/{product}','Api\ProductController@update');
Route::group(['prefix' => 'products'],function (){
    Route::apiResource('/{product}/reviews','Api\ReviewController');
});
