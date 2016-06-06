<?php

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {

    $api->post('auth/login', 'App\Api\V1\Controllers\AuthController@login');
    $api->post('auth/signup', 'App\Api\V1\Controllers\AuthController@signup');
    $api->post('auth/recovery', 'App\Api\V1\Controllers\AuthController@recovery');
    $api->post('auth/reset', 'App\Api\V1\Controllers\AuthController@reset');
    $api->get('auth/refresh', 'App\Api\V1\Controllers\AuthController@token');
    $api->post('validate', 'App\Api\V1\Controllers\ValidationController@validateUnique');

    $api->get('users/me', 'App\Api\V1\Controllers\UserController@me');

    $api->group(['middleware' => ['api.auth']], function ($api) {

        // Screen association
        $api->post('screengroups/{screengroup}/screen/{screen}', 'App\Api\V1\Controllers\ScreenScreenGroupController@store');
        $api->delete('screengroups/{screengroup}/screen/{screen}', 'App\Api\V1\Controllers\ScreenScreenGroupController@destroy');

        // Ticker association
        $api->post('screengroups/{screengroup}/ticker/{ticker}', 'App\Api\V1\Controllers\TickerScreenGroupController@store');
        $api->delete('screengroups/{screengroup}/ticker/{ticker}', 'App\Api\V1\Controllers\TickerScreenGroupController@destroy');


        $api->resource('clients', 'App\Api\V1\Controllers\ClientController');
        $api->resource('categories', 'App\Api\V1\Controllers\CategoryController');
        // TODO: Fix Dump frontend is dumb
        $api->resource('categorys', 'App\Api\V1\Controllers\CategoryController');
        $api->resource('screengroups', 'App\Api\V1\Controllers\ScreenGroupController');
        $api->resource('screens', 'App\Api\V1\Controllers\ScreenController');
        $api->resource('tickers', 'App\Api\V1\Controllers\TickerController');
        $api->resource('users', 'App\Api\V1\Controllers\UserController');
        $api->get('roles', 'App\Api\V1\Controllers\RoleController@index');

    });
});
