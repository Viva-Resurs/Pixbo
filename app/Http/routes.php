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
    return view('pages.welcome');
});

Route::get('/dashboard', function () {
    return view('pages.dashboard');
});

Route::resource('clients', 'ClientsController');
Route::resource('screengroups', 'ScreenGroupsController');
Route::resource('screens', 'ScreensController');
Route::resource('events', 'EventsController');
Route::resource('images', 'ImagesController');

Route::controllers([
    'auth'     => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);

/**
 * Top menu
 */
Menu::make('topNav', function ($menu) {

    $menu->add('Home');
    $menu->add('Dashboard', 'dashboard');
    $menu->add('Profile', 'profile');
    $menu->add('Help', 'help');

});

/**
 * Side menu
 */
Menu::make('adminNav', function ($menu) {

    $menu->add('Overview', 'dashboard');

    $menu->add('Clients', 'clients');
    $menu->add('Screen Groups', 'screengroups');
    $menu->add('Screens', 'screens');
    $menu->add('Images', 'images');
    $menu->add('Calendar', 'calendars');
    $menu->add('Events', 'events');
    $menu->add('Event Metas', 'eventmetas');
    $menu->add('Users', 'users');
    $menu->add('User Groups', 'usergoups');
    //$menu->add('Group Permissions', 'grouppermissions');

});
