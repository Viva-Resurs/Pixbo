<?php

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {

    $api->post('auth/login', 'App\Api\V1\Controllers\AuthController@login');
    $api->post('auth/signup', 'App\Api\V1\Controllers\AuthController@signup');
    $api->post('auth/recovery', 'App\Api\V1\Controllers\AuthController@recovery');
    $api->post('auth/reset', 'App\Api\V1\Controllers\AuthController@reset');


    $api->get('users/me', function () {
        return JWTAuth::parseToken()->authenticate();
    });

    $api->group(['middleware' => ['api.auth']], function ($api) {
        $api->resource('clients', 'App\Api\V1\Controllers\ClientController');
        $api->resource('tags', 'App\Api\V1\Controllers\TagController');
        $api->resource('screengroups', 'App\Api\V1\Controllers\ScreenGroupController');
        $api->resource('screens', 'App\Api\V1\Controllers\ScreenController');
        $api->resource('tickers', 'App\Api\V1\Controllers\TickerController');
        $api->resource('users', 'App\Api\V1\Controllers\UserController');


    });
});
