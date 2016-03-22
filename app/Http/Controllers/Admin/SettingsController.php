<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\ChangeLocale;
use Illuminate\Http\Request;
use Config;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vegas_delay = Config::get('app.player.vegas.delay');
        $ticker_delay = Config::get('app.player.ticker.pauseOnItems');
        return view('settings.index')->with(compact(['vegas_delay', 'ticker_delay']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request)
    {
        $vegas_delay = $request->input('vegas_delay');
        $ticker_delay = $request->input('ticker_delay');
        config(['app.player.vegas.delay' => $vegas_delay]);
        config(['app.player.ticker.pauseOnItems' => $ticker_delay]);
        return redirect()->back();
    }

    public function language(Request $request) {
        $changeLocale = new ChangeLocale($request->input('lang'));
        $this->dispatch($changeLocale);

        return redirect()->back();
    }
}
