<?php


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

Route::get('/api/screens/{id}', function ($id) {
    $screen = App\Models\Screen::where('id', $id)->with(['event', 'tags', 'screengroups'])->first();
    return $screen;
});

Route::get('api/screens', function() {
    $screens = App\Models\Screen::with('photo')->get();
    return $screens;
});

Route::get('/api/tickers/{id}', function ($id) {
    $ticker = App\Models\Ticker::where('id', $id)->with(['event', 'screengroups'])->first();
    return $ticker;
});

Route::get('/api/clients/{id}', function ($id) {
    $client = App\Models\Client::where('id', $id)->first();
    return [
        'name' => $client->name,
        'ip_address' => $client->ip_address,
        'screen_group_id' => $client->screen_group_id,
    ];
});

/**
 * Fetch language of a given scope.
 *
 * @return JSON
 */
Route::get('/api/locales', function() {

    $language_files = [
      'messages',
        'auth'
    ];
    $locales = [];
    foreach ($language_files as $key => $val) {
        $locales[$language_files[$key]] =  Lang::get($val);
    }

    return $locales;
}) ;

Route::post('/api/screens/{id}', 'Admin\ScreensController@update');