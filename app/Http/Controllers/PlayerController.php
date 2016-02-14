<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Event;
use Illuminate\Http\Request;
use Request as R;

class PlayerController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request) {
		$mac    = $request->input('mac');
		$client = Client::where('ip_address', $mac)->first();
		if (is_null($client)) {
			return abort(404, trans('exceptions.no_screens_found'));
		}

		$clientData = $this->getDataFromClient($client);

		if (!is_null($clientData)) {
			$tickers    = $clientData['tickers'];
			$photo_list = $clientData['photo_list'];

			if (!empty($photo_list)) {
				if (R::wantsJson()) {
					return ['list' => $photo_list, 'tickers' => $tickers];
				} else {
					return view('player.index')->with([
						'list'       => $photo_list,
						'tickers'    => $tickers,
						'client'     => $client->id,
						'updated_at' => $clientData['updated_at'],
					]);
				}
			} else {
				return abort(404, trans('exceptions.no_screens_found'));
			}
		} else {
			return abort(404, trans('exceptions.no_screens_found'));
		}
	}

	public function show(Request $request, $id) {
		$client = Client::where('id', $id)->first();
		$data   = $this->getDataFromClient($client);
		return $data;
	}

	private function getDataFromClient(Client $client) {
		$client->updateActivity();
		$client->save();
		if (!is_null($client)) {
			$screengroup = $client->screengroup;
			$screens     = $screengroup->screens->keyBy('id');
			$tickers     = $screengroup->tickers->keyBy('id');

			$se = $screengroup->shadow_events()->now()->get();

			// Collect the type and ID of the scheduled events.
			$shadow_event_id = collect([]);
			foreach ($se as $shadow) {
				$shadow_event_id->push([
					'type' => $shadow->event->getAttribute('eventable_type'),
					'id'   => $shadow->event->eventable->getAttribute('id'),
				]);
			}

			// Group the collection for easier handling.
			$scheduled_screens = $shadow_event_id->groupBy('type')->get('App\Models\Screen');
			$scheduled_tickers = $shadow_event_id->groupBy('type')->get('App\Models\Ticker');

			if (is_null($scheduled_screens)) {
				return abort(404, trans('exceptions.no_screens_found'));
			}

			$photo_list  = null;
			$ticker_list = null;

			if (!is_null($scheduled_screens)) {
				foreach ($scheduled_screens as $screen) {
					$screen_element = $screens->where('id', $screen['id'])->first();
					$photo_list[]   = $screen_element['photo'];
				}
			}
			if (!is_null($scheduled_tickers)) {
				foreach ($scheduled_tickers as $ticker) {
					$ticker_element = $tickers->where('id', $ticker['id'])->first();
					$ticker_list[]  = $ticker_element;
				}
			}

			$parsed_list = [];
			if (!is_null($photo_list)) {
				foreach ($photo_list as $photo) {
					$parsed_list[] = [
						'image' => $photo->path,
						'title' => $photo->name,
						'thumb' => $photo->thumb_path,
						'url'   => '',
					];
				}
			}

			return [
				'photo_list' => $parsed_list,
				'tickers'    => $ticker_list,
				'updated_at' => $screengroup->updated_at->toDateTimeString(),
			];
		}
	}
}
