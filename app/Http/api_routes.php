<?php
	
$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {

	$api->post('auth/login', 'App\Api\V1\Controllers\AuthController@login');
	$api->post('auth/signup', 'App\Api\V1\Controllers\AuthController@signup');
	$api->post('auth/recovery', 'App\Api\V1\Controllers\AuthController@recovery');
	$api->post('auth/reset', 'App\Api\V1\Controllers\AuthController@reset');

	// example of protected route
	$api->get('protected', ['middleware' => ['api.auth'], function () {		
		return \App\Models\User::all();
    }]);

	// example of free route
	$api->get('free', function() {
		return \App\Models\User::all();
	});
	$api->group(['middleware' => 'api.auth'], function ($api) {
		$api->resource('client', 'App\Api\V1\Controllers\ClientController');
		$api->resource('screengroup', 'App\Api\V1\Controllers\ScreenGroupController');
		$api->resource('screen', 'App\Api\V1\Controllers\ScreenController');
		$api->resource('ticker', 'App\Api\V1\Controllers\TickerController');

		$api->get('users/me', function() {
			return JWTAuth::parseToken()->authenticate();
		});
	});

});
