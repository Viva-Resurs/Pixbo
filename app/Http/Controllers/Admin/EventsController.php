<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\EventRequest;
use App\Models\Event;
use Request;

class EventsController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {
		$events = Event::all();

		if (Request::wantsJson()) {
			return $events;
		} else {
			$data = Event::paginate(10);
			return view('events.index')->with('data', $data);
		}
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create() {
		$event = new Event;

		return view('events.create', compact('event'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  EventRequest  $request
	 * @return Response
	 */
	public function store(EventRequest $request) {

		if ($event = new Event($request->all())) {
			flash()->success(trans('messages.event_created_ok'));
		} else {
			flash()->error(trans('messages.event_created_failed'));
		}

		if (Request::wantsJson()) {
			return $event;
		} else {
			return redirect('events');
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  Event $event
	 * @return Response
	 */
	public function show(Event $event) {
		if (Request::wantsJson()) {
			return $event;
		} else {
			return view('events.show', compact('event'));
		}
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  Event $event
	 * @return Response
	 */
	public function edit(Event $event) {
		return view('events.edit', compact('event'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  EventRequest  $request
	 * @param  Event  $event
	 * @return Response
	 */
	public function update(EventRequest $request, Event $event) {

		if ($event->update($request->all())) {
			flash()->success(trans('messages.event_updated_ok'));
		} else {
			flash()->error(trans('messages.event_updated_failed'));
		}
		if (Request::wantsJson()) {
			return $event;
		} else {
			return redirect()->back();
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  Event  $event
	 * @return Response
	 */
	public function destroy(Event $event) {

		$deleted = $event->delete();
		if ($deleted) {
			flash()->success(trans('messages.event_removed_ok'));
		} else {
			flash()->error(trans('messages.event_removed_failed'));
		}

		if (Request::wantsJson()) {
			return (string) $deleted;
		} else {
			return redirect('events');
		}
	}
}
