<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

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
		$events = [];

		$events[] = \Calendar::event(
			'Event One', //event title
			false, //full day event?
			'2015-09-17T0800', //start time (you can also use Carbon instead of DateTime)
			'2015-08-17T0800', //end time (you can also use Carbon instead of DateTime)
			0//optionally, you can specify an event ID
		);

		$events[] = \Calendar::event(
			"Valentine's Day", //event title
			true, //full day event?
			new \DateTime('2015-02-14'), //start time (you can also use Carbon instead of DateTime)
			new \DateTime('2015-02-14'), //end time (you can also use Carbon instead of DateTime)
			'stringEventId' //optionally, you can specify an event ID
		);

		//$eloquentEvent = EventModel::first(); //EventModel implements MaddHatter\LaravelFullcalendar\Event

		$calendar = \Calendar::addEvents($events) //add an array with addEvents
		//->addEvent($eloquentEvent, [ //set custom color fo this event
		/*	'color' => '#800',
		]) */->setOptions([ //set fullcalendar options
			'firstDay' => 1,
		]) /*->setCallbacks([ //set fullcalendar callback options (will not be JSON encoded)
		'viewRender' => 'function() {alert("Callbacks!");}',
		])*/;

		return view('pages.calendar', compact('calendar'));
		//return view('pages.calendar');
	}
}
