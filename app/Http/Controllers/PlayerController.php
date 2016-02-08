<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\ShadowEvent;
use Auth;
use Carbon\Carbon;
use Request as R;

class PlayerController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {
		//dd(R::get('ip'));
		//dd(Auth::user()->client);
		if (Auth::check() && !is_null(Auth::user()->client)) {
			$client = Auth::user()->client->with(['screengroup.screens.event', 'screengroup.screens.photo', 'screengroup.tickers.event'])->first();
			$client_id = $client->pluck('id');
			$screengroup = $client->screengroup;
			$screens = $screengroup->screens->keyBy('id');
			$tickers = $screengroup->tickers->keyBy('id');
			//dd($screens);
			$event_ids = [];

			// Get all events associated with the screengroup
			foreach ($client->screengroup->screens as $screen) {
				$event_ids[] = implode($screen->event->pluck('id')->toArray());
			}
			foreach ($client->screengroup->tickers as $ticker) {
				$event_ids[] = implode($ticker->event->pluck('id')->toArray());
			}
			//dd($event_ids);

// Get all shadow events associated with events given and are happening right now
			$shadows = ShadowEvent::whereIn('event_id', $event_ids)
				->with('event')
				->where('start', '<=', Carbon::now())
				->where('end', '>=', Carbon::now())
				->get();

//            dd($shadows);

			// Collect the type and ID of the scheduled events.
			$shadow_event_id = collect([]);
			foreach ($shadows as $shadow) {
				//dd($shadow);
				$shadow_event_id->push([
					'type' => $shadow->event->getAttribute('eventable_type'),
					'id' => $shadow->event->eventable->getAttribute('id'),
				]);
			}

			//dd($shadow_event_id);

			// Group the collection for easier handling.
			$scheduled_screens = $shadow_event_id->groupBy('type')->get('App\Models\Screen')->keyBy('id');
			$scheduled_tickers = $shadow_event_id->groupBy('type')->get('App\Models\Ticker');

			//dd($scheduled_screens);
			//dd($scheduled_tickers);

			if (is_null($scheduled_screens)) {
				return abort(404, 'No screens available.');
			}

			$photo_list;
			$ticker_list;

			foreach ($scheduled_screens as $screen) {
				$screen_element = $screens->where('id', $screen['id'])->first();
				$photo_list[] = $screen_element['photo'];
			}

			foreach ($scheduled_tickers as $ticker) {
				$ticker_element = $tickers->where('id', $ticker['id'])->first();
				$ticker_list[] = $ticker_element;
			}
			//dd($ticker_list);
			/*
	        foreach ($scheduled_tickers as $ticker) {
	        $tickers[] = $ticker->toArray();
	        }
*/
			if (!empty($screens)) {
				//dd([$tickers, $screens]);
				return view('player.index')->with(['list' => $photo_list, 'tickers' => $ticker_list]);

			} else {
				return abort(404, 'No screens available.');
			}
		}
		return abort(403, trans('auth.access_denied'));
	}
}
