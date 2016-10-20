<?php

namespace App\Http\Controllers;

use Config;
use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Event;
use Illuminate\Http\Request;
use Request as R;
use App\Settings;

class PlayerController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request) {
		$mac     = $request->input('mac');
		$preview = $request->input('preview');

		$client = Client::where('ip_address', $mac)->first();
		if (is_null($client)) {
			return abort(404, trans('exceptions.no_screens_found'));
		}
		$clientData = $this->getDataFromClient($client);

		if (is_null($preview)) {
			$client->updateActivity();
			$client->save();
		}

		if (!is_null($clientData)) {
			$tickers    = $clientData['tickers'];
			$photo_list = $clientData['photo_list'];

			if (!empty($photo_list)) {
				if (R::wantsJson()) {
					return ['list' => $photo_list, 'tickers' => $tickers];
				} else {
					return view('player.index')->with([
						'screens'    => $photo_list,
						'tickers'    => $tickers,
						'client'     => $client->id,
						'updated_at' => $clientData['updated_at'],
						'preview'    => $preview,
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

		if (!is_null($client)) {
			$screengroup = $client->screengroup;
			$screens     = $screengroup->screens->keyBy('id');
			$tickers     = $screengroup->tickers->keyBy('id');

			$screens = $screens->load(['event', 'event.shadow_events']);
			$tickers = $tickers->load(['event', 'event.shadow_events']);

			//$se = $screengroup->shadow_events()->now()->get();

			// Get the images from the available screens
			$photo_list = [];
			foreach($screens as $screen) {
				$event = $screen->event->first();
				$se = $event->shadow_events()->now()->get();
				if(!$se->isEmpty()) {
					$photo = $screen->photo;
					$photo_list[] = [
						'image' => $photo->path
					];
				}
			}

			// Get the available tickers
			$ticker_list = [];
			foreach($tickers as $ticker) {
				$event = $ticker->event->first();
				$se = $event->shadow_events()->now()->get();
				if(!$se->isEmpty()) {
					$ticker_list[] = [
					  'text' => $ticker->text
					];
				}
			}

			// Get settings
			//$settings = Config::get('app.player');
			$settings = Settings::getSettings();

			return [
				'photo_list' => $photo_list,
				'tickers'    => $ticker_list,
				'updated_at' => $screengroup->updated_at->toDateTimeString(),
				'settings'   => $settings
			];
		}
	}
}
