<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\ChangeLocale;
use Illuminate\Http\Request;
use App\Settings;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settings = Settings::first();
        return view('settings.index')->with(compact(['settings']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Settings $settings)
    {
        if ($settings->update([
            'vegas_delay' => $request->input('vegas_delay'),
            'ticker_pauseOnItems' => $request->input('ticker_pauseOnItems'),
        ])) {
            flash()->success(trans('messages.settings_updated_ok'));
        } else {
            flash()->error(trans('messages.settings_updated_fail'));
        }

        return redirect()->back();
    }

    public function language(Request $request) {
        $changeLocale = new ChangeLocale($request->input('lang'));
        $this->dispatch($changeLocale);

        return redirect()->back();
    }
}
