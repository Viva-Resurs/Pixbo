<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
 */

Route::get('/', function () {
	return view('welcome');
});

Menu::make('topNav', function ($menu) {

	$menu->add('Home');
	$menu->add('Dashboard', 'dashboard');
	$menu->add('Profile', 'profile');
	$menu->add('Help', 'help');

});

Menu::make('adminNav', function ($menu) {

	$menu->add('Overview', 'dashboard');

	$menu->add('Clients', 'client');
	$menu->add('Screen Groups', 'screengroup');
	$menu->add('Screens', 'screen');
	$menu->add('Calendar', 'calendar');
	$menu->add('Events', 'event');
	$menu->add('Event Metas', 'eventmeta');
	$menu->add('Users', 'user');
	$menu->add('User Groups', 'usergoup');
	//$menu->add('Group Permissions', 'grouppermissions');

});

Route::resource('client', 'ClientController');