<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Screengroup;
use App\Models\Ticker;
use DB;
use Gate;
use Illuminate\Http\Request;
use Request as RF;

class TickersController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {
		if (Gate::denies('view_tickers')) {
			abort(403, trans('auth.access_denied'));
		}

		$tickers = Ticker::all();

		if (RF::wantsJson()) {
			return $tickers;
		} else {
			return view('tickers.index', compact('tickers'));
		}
	}

	public function create() {
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
	public function store(Request $request) {
		if (Gate::denies('add_tickers')) {
			abort(403, trans('auth.access_denied'));
		}

		if ($ticker = new Ticker($request->all())) {
			$results = DB::transaction(function () use ($ticker) {
				$ticker->save();
				$event = new Event;
				$event->fill(['start_date' => date('Y-m-d')]);
				$ticker->event()->save($event);
			});
			if (is_null($results)) {
				flash()->success(trans('messages.ticker_created_ok'));
			} else {
				flash()->error(trans('messages.ticker_created_failed'));
			}

			if (RF::wantsJson()) {
				return $ticker;
			} else {
				return redirect('/admin/dashboard/');
			}
		}
	}

	public function show(Ticker $ticker) {
		if (Gate::denies('edit_tickers')) {
			abort(403, trans('auth.access_denied'));
		}
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
	public function update(Request $request, Ticker $ticker) {
		if (Gate::denies('edit_tickers')) {
			abort(403, trans('auth.access_denied'));
		}
		$event                  = $request->get('event');
		$day_num                = $request->get('day_num');
		$event['recur_day_num'] = json_encode(($day_num));
		$ticker_data            = $request->get('modelObject');

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
	public function destroy(ScreenGroup $screengroup, Request $request) {
		if (Gate::denies('remove_tickers')) {
			abort(403, trans('auth.access_denied'));
		}
		$ticker_request = $request->all();
		$ticker         = Ticker::where(['id' => $ticker_request['id']])->first();

		$deleted = $ticker->delete();
		if (RF::wantsJson()) {
			return (string) $deleted;
		}
	}
}
