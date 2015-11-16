<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ScreenRequest;
use App\Screen;
use App\ScreenGroup;
use Auth;
use Request;

class ScreensController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $screens = Screen::all();

        if (Request::wantsJson()) {
            return $screens;
        } else {
            $data = Screen::paginate(10);
            return view('screens.index')->with('data', $data);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $screens = new Screen;
        $screenGroups = ScreenGroup::lists('name', 'id')->all();

        return view('screens.create', compact(['screens', 'screenGroups']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $screen = new Screen($request->all());
        flash()->success('Screen created successfully.');
        Auth::user()->screens()->save($screen);
        $event = $screen->createAndReturnEvent();
        $event_meta = $event->createAndReturnMeta();

        if (Request::wantsJson()) {
            return $screen;
        } else {
            return redirect()->action('Admin\ScreensController@edit', compact(['screen', 'event', 'event_meta']));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  Screen  $screen
     * @return Response
     */
    public function show(Screen $screen)
    {
        $event = $screen->getEvent();
        $event_meta = $event->getEventMeta();

        if (Request::wantsJson()) {
            return $screen;
        } else {
            return view('screens.show', compact(['screen', 'event', 'event_meta']));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Screen  $screen
     * @return Response
     */
    public function edit(Screen $screen)
    {
        $event = $screen->getEvent();
        $event_meta = $event->getEventMeta();

        return view('screens.edit', compact(['screen', 'event', 'event_meta']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  Screen  $screen
     * @return Response
     */
    public function update(ScreenRequest $request, Screen $screen)
    {
        if ($screen->update($request->all())) {
            flash()->success('Screen updated successfully.');
            if (Request::wantsJson()) {
                return $screen;
            } else {
                return redirect()->back();
            }
        } else {
            return abort(500, 'Unable to update the screen');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Screen  $screen
     * @return Response
     */
    public function destroy(Screen $screen)
    {
        $deleted = $screen->delete();
        if ($deleted) {
            flash()->success('Screen removed successfully.');
        } else {
            flash()->error('Was not able to remove the screen.');
        }

        if (Request::wantsJson()) {
            return (string) $deleted;
        } else {
            return redirect('screens');
        }
    }
}
