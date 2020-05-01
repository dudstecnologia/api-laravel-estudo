<?php

Route::namespace('Api')->middleware('api')->prefix('auth')->group(function () {

    Route::post('login', 'AuthController@login');
    Route::post('register', 'AuthController@register');

    // Route::middleware('auth:api')->group(function () {

    //     Route::post('logout', 'AuthController@logout');
    //     Route::post('refresh', 'AuthController@refresh');
    //     Route::post('me', 'AuthController@me');

    // });
});
