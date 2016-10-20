<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TickerCreationForm;
use App\Models\ScreenGroup;
use App\Models\ShadowEvent;
use App\Models\Ticker;
use Gate;
use Illuminate\Http\Request;
use App\Http\Requests\TickerUpdateForm;

class TickersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        if (Gate::denies('view_tickers')) {
            abort(403, trans('auth.access_denied'));
        }
        
        $tickers = Ticker::all();
        
        return view('tickers.index', compact('tickers'));
    }

    public function create()
    {
        if (Gate::denies('add_tickers')) {
            abort(403, trans('auth.access_denied'));
        }
        
        $ticker = new Ticker;

        return view('tickers.create', compact('ticker'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(TickerCreationForm $form)
    {
        if (Gate::denies('add_tickers')) {
            abort(403, trans('auth.access_denied'));
        }
        $result = $form->persist();

        if (is_null($result)) {
            flash()->success(trans('messages.ticker_created_ok'));
        } else {
            flash()->error(trans('messages.ticker_created_failed'));
        }

        return redirect('/admin/tickers/');
    }

    public function show(Ticker $ticker)
    {
        if (Gate::denies('edit_tickers')) {
            abort(403, trans('auth.access_denied'));
        }

        return view('tickers.show', compact(['ticker']));
    }

    public function edit(Ticker $ticker)
    {
        if (Gate::denies('edit_tickers')) {
            abort(403, trans('auth.access_denied'));
        }
        $event = $ticker->getEvent();
        $screengroups = Screengroup::all();

        return view('tickers.edit', compact(['ticker', 'event', 'screengroups']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(TickerUpdateForm $form, Ticker $ticker)
    {
        if (Gate::denies('edit_tickers')) {
            abort(403, trans('auth.access_denied'));
        }

        $result = $form->persist($ticker);

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
    public function destroy(Ticker $ticker)
    {
        if (Gate::denies('remove_tickers')) {
            abort(403, trans('auth.access_denied'));
        }
        $sgs = $ticker->screengroups;
        $event = $ticker->event[0];

        if ($deleted = $ticker->delete()) {
            foreach ($sgs as $sg) {
                $sg->touch();
            }
            ShadowEvent::clearEvent($event->id);
        }

        return redirect()->back();
    }
}
