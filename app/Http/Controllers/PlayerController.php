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
			$client               = Auth::user()->client->with(['screengroup.event', 'screengroup.screens.event'])->first();
			$client_id            = $client->pluck('id');
			$screengroup          = $client->screengroup;
			$screengroup_event_id = $screengroup->event->pluck('id')[0];
			$event_ids[]          = $client->screengroup->event->pluck('id')[0];

			// Get all events associated with the screengroup
			foreach ($client->screengroup->screens as $screen) {
				$event_ids[] = implode($screen->event->pluck('id')->toArray());
			}

			// Get all shadow events associated with events given and are happening right now
			$shadows = ShadowEvent::whereIn('event_id', $event_ids)
				->with('event.eventable')
				->where('start', '<=', Carbon::now())
				->where('end', '>=', Carbon::now())
				->get();

			//dd($shadows);

			// Collect the type and ID of the scheduled events.
			$shadow_event_id = collect([]);
			foreach ($shadows as $shadow) {
				$shadow_event_id->push([
					'type' => $shadow->event->getAttribute('eventable_type'),
					'id'   => $shadow->event->eventable->getAttribute('id'),
				]);
			}
			//dd($shadow_event_id);

			// Group the collection for easier handling.
			$scheduled_screens      = $shadow_event_id->groupBy('type')->get('App\Screen');
			$scheduled_screengroups = $shadow_event_id->groupBy('type')->get('App\ScreenGroup');

			//dd($scheduled_screens);

			if (is_null($scheduled_screengroups)) {
				return abort(404, 'No screens available.');
			}

			// Create the list of photos to show and send the list to the view.
			foreach ($scheduled_screengroups as $scheduled_screengroup) {
				if ($scheduled_screengroup['id'] == $screengroup->getAttribute('id')) {
					$screens = $screengroup['screens'];
					$list;

					//dd($scheduled_screens);

					foreach ($screens as $screen) {
						if ($screen['scheduled'] == 0) {
							$list[] = $screen['photo'];
						} else {
							foreach ($scheduled_screens as $scheduled_screen) {
								if ($scheduled_screen['id'] == $screen['id']) {
									if ($scheduled_screen['id'] == 2) {
										dd($scheduled_screen);
									}
									$list[] = $screen['photo'];
								}
							}
						}
					}
					//dd($list);

					if (!empty($list)) {
						return view('player.index')->with('list', $list);
					} else {
						return abort(404, 'No screens available.');
					}
				}
			}
		}
		return abort(403, trans('auth.access_denied'));
	}
}
