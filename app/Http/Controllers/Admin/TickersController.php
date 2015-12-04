<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Screengroup;
use App\Ticker;
use Illuminate\Http\Request;
use Request as RF;

class TickersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(ScreenGroup $screengroup)
    {
        return $screengroup->tickers;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(ScreenGroup $screengroup, Request $request)
    {
        dd($request->all());
        $ticker = new Ticker($request->all());

        $screengroup->save($ticker);

        if (RF::wantsJson()) {
            return $screen;
        } else {
            abort(500, 'API only returns JSON.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(ScreenGroup $screengroup, Request $request)
    {
        $ticker_request = $request->all();
        $ticker = Ticker::where(['id' => $ticker_request['id']])->first();

        if ($ticker->update($request->all())) {
            if (RF::wantsJson()) {
                return $screengroup;
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(ScreenGroup $screengroup, Request $request)
    {
        $ticker_request = $request->all();
        $ticker = Ticker::where(['id' => $ticker_request['id']])->first();

        $deleted = $ticker->delete();
        if (RF::wantsJson()) {
            return (string) $deleted;
        }
    }
}
