<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\ShadowEvent;
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

		$client      = Auth::user()->client->with(['screengroup.event', 'screengroup.screens.event'])->first();
		$client_id   = $client->pluck('id');
		$event_ids[] = $client->screengroup->event->pluck('id')[0];

		foreach ($client->screengroup->screens as $screen) {
			$event_ids[] = implode($screen->event->pluck('id')->toArray());
		}

		//dd($event_ids);

		$shadows = ShadowEvent::where(function ($q) use ($event_ids) {
			// Get all Shadow Events matching current time.
			$q->where('start', '<=', Carbon::now());
			$q->where('end', '>=', Carbon::now());
			$q->whereIn('event_id', $event_ids);
		})->get();

		dd($shadows);

		if ($client->count() > 0) {
			$client  = $client->toArray();
			$screens = $client[0]['screengroup']['screens'];
			$list;

			foreach ($screens as $screen) {
				$list[] = $screen['photo'];
			}
			if (!empty($list)) {
				return view('player.index')->with('list', $list);
			} else {
				return abort(500, 'No screen available.');
			}

		}
		return abort(404, 'You lack permission to view this content.');
	}
}
