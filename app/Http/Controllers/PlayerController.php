<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Auth;
use Request as R;

class PlayerController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {
		//dd(R::get('ip'));

		$client = Auth::user()->client->with(['screengroup.screens.photo', 'screengroup.event'])->get();

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
