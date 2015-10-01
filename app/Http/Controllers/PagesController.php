<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\ShadowEvent;

class PagesController extends Controller {
	public function __construct() {
		parent::__construct();
	}
	public function home() {
		return view('pages.home');
	}

	public function dashboard() {
		return view('pages.dashboard');
	}

	public function calendars() {

		$eloquentEvent = ShadowEvent::first(); //EventModel implements MaddHatter\LaravelFullcalendar\Event

		$calendar = \Calendar::addEvent($eloquentEvent, [ //set custom color fo this event
			'color' => '#800',
		])->setOptions([ //set fullcalendar options
			'firstDay' => 1,
		])->setCallbacks([ //set fullcalendar callback options (will not be JSON encoded)
			'viewRender' => 'function() {alert("Callbacks!");}',
		]);

		return view('pages.calendar', compact('calendar'));
		//return view('pages.calendar');
	}
}
