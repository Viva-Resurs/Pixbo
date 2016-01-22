<?php

namespace App\Http\Controllers\Admin;

use App\Event;
use App\Http\Controllers\Controller;
use App\Screengroup;
use App\Ticker;
use DB;
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
            $event = new Event;
            $event->fill(['start_date' => date('Y-m-d')]);
            $ticker->event()->save($event);

            flash()->success(trans('messages.ticker_created_ok'));

            if (RF::wantsJson()) {
                return $ticker;
            } else {
                return redirect('/admin/dashboard/');
            }
        }
    }

    public function show(Ticker $ticker)
    {
        if (RF::wantsJson()) {
            return $screen;
        } else {
            return view('tickers.show', compact(['ticker']));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, Ticker $ticker)
    {
        $event = $request->get('event');
        $day_num = $request->get('day_num');
        $event['recur_day_num'] = json_encode(($day_num));
        $ticker_data = $request->get('modelObject');

        $screengroups = $request->get('selected_screengroups');

        $result = DB::transaction(function () use ($ticker, $ticker_data, $event, $screengroups) {
            $e = Event::find($event['id']);
            $e->update($event);
            $ticker->update($ticker_data);
            $ticker->screengroups()->sync($screengroups);
        });

        if (is_null($result)) {
            return ['type' => 'success', 'dismissible' => true, 'content' => trans('messages.ticker_updated_ok'), 'timeout' => 3000];
        } else {
            return ['type' => 'danger', 'dismissible' => true, 'content' => trans('messages.ticker_updated_fail'), 'timeout' => false];
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
