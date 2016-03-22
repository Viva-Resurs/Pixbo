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

$route_partials = [
    'screengroups',
];

foreach ($route_partials as $partial) {
    $file = __DIR__ . '/Routes/' . $partial . '.php';

    if (!file_exists($file)) {
        $msg = "Route partial [{$partial}] not found.";
        throw new \Illuminate\Contracts\FileSystem\FileNotFoundException($msg);
    }
    require_once $file;
}

Route::patch('admin/settings/save', 'Admin\SettingsController@save');

Route::get('language', 'Admin\SettingsController@language');

Route::resource('play', 'PlayerController');

Route::get('/', 'PagesController@home');
Route::get('admin/dashboard', 'PagesController@dashboard');

Route::post('admin/screens/addphoto', 'Admin\ScreensController@addScreenFromPhoto');

Route::get('/api/screengroups', function () {
    $screengroups = App\Models\ScreenGroup::all(['id', 'name']);
    return $screengroups->map(function ($screengroups) {
        return [
            'text' => $screengroups->name,
            'value' => $screengroups->id,
        ];
    })->toArray();
});

Route::get('/api/tags', function () {
    $tags = App\Models\Tag::all(['id', 'name']);
    return $tags->map(function ($tags) {
        return [
            'name' => $tags->name,
            'id' => $tags->id,
        ];
    })->toArray();
});

Route::get('/api/screen/{id}', function ($id) {
    $screen = App\Models\Screen::where('id', $id)->with(['event', 'tags', 'screengroups'])->first();
    return $screen;
});

Route::get('/api/ticker/{id}', function ($id) {
    $ticker = App\Models\Ticker::where('id', $id)->with(['event', 'screengroups'])->first();
    return $ticker;
});

Route::post('/api/screen/{id}', 'Admin\ScreensController@update');

Route::group([
    'namespace' => 'Admin',
    'middleware' => 'auth',
], function () {

    Route::get('admin', function () {
        return redirect('/admin/dashboard');
    });
    Route::resource('admin/clients', 'ClientsController');
    Route::resource('admin/tickers', 'TickersController');
    Route::resource('admin/screengroups', 'ScreenGroupsController');
    Route::resource('admin/screens', 'ScreensController');
    Route::resource('admin/photos', 'PhotosController');
    Route::resource('admin/events', 'EventsController');
    Route::resource('admin/users', 'UsersController');
    Route::resource('admin/settings', 'SettingsController');
});

Route::controllers([
    'auth' => 'Auth\AuthController',
]);

/**
 * Top menu
 */
Menu::make('topNav', function ($menu) {

    $menu->add(trans('messages.screen_groups'), 'admin/screengroups');
    $menu->add(trans('messages.clients'), 'admin/clients');
    $menu->add(trans('messages.screens'), 'admin/screens');
    $menu->add(trans('messages.users'), 'admin/users');
    $menu->add(trans('messages.settings'), 'settings');
});
