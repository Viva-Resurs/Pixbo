<?php

namespace App\Http\Controllers;

use App\Event;
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

		$client               = Auth::user()->client->with(['screengroup.event', 'screengroup.screens.event'])->first();
		$client_id            = $client->pluck('id');
		$screengroup          = $client->screengroup;
		$screengroup_event_id = $screengroup->event->pluck('id')[0];
		$event_ids[]          = $client->screengroup->event->pluck('id')[0];

		// Get all events associated with the screengroup
		foreach ($client->screengroup->screens as $screen) {
			$event_ids[] = implode($screen->event->pluck('id')->toArray());
		}
		//dd($screen_ids);

		// Get all shadow events associated with events given and are happening right now
		$shadows = ShadowEvent::whereIn('event_id', $event_ids)
			->with('event.eventable')
			->where('start', '<=', Carbon::now())
			->where('end', '>=', Carbon::now())
			->get();

		dd($shadows);

		dd($shadows->events);

		$events = Event::with('eventable')->whereIn('id', $shadow_ids)->get();

		dd($events);
		//$events = Event::

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
