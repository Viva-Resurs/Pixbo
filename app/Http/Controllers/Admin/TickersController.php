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
    public function index()
    {
        $tickers = Ticker::all();

        if (RF::wantsJson()) {
            return $tickers;
        } else {
            return view('tickers.index', compact('tickers'));
        }
    }

    public function create()
    {
        $ticker = new Ticker;

        return view('tickers.create', compact('ticker'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        if ($ticker = new Ticker($request->all())) {
            $ticker->save();

            flash()->success(trans('messages.ticker_created_ok'));

            if (RF::wantsJson()) {
                return $ticker;
            } else {
                return redirect('/admin/dashboard/');
            }
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Ticker $ticker, Request $request)
    {
        if ($ticker->update($request->all())) {
            flash()->success(trans('messages.ticker_updated_ok'));
            if (Request::wantsJson()) {
                return $ticker;
            } else {
                return redirect()->back();
            }
        } else {
            return abort(500, trans('messages.ticker_updated_failed'));
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
