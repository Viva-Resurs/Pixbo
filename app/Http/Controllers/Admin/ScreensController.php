<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ScreenRequest;
use App\Photo;
use App\Screen;
use App\ScreenGroup;
use Auth;
use Illuminate\Http\Request;
use Request as Requests;

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

        if (Requests::wantsJson()) {
            return $screens;
        } else {
            return view('screens.index', compact('screens'));
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

        if (Requests::wantsJson()) {
            return $screen;
        } else {
            return view('screens.show', compact(['screen', 'event']));
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
        $screengroups = Screengroup::all();

        return view('screens.edit', compact(['screen', 'event', 'event_meta', 'screengroups']));
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
            return abort(500, trans('messages.screen_update_failed'));
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
            flash()->error(trans('messages.screen_delete_failed'));
        }

        if (Request::wantsJson()) {
            return (string) $deleted;
        } else {
            return redirect('screens');
        }
    }

    /**
     * Add or find a screen from given file and attatch it to the screengroup.
     *
     * @param ScreenGroup $screengroup
     * @param Request $request
     */
    public function addScreenFromPhoto(Request $request)
    {
        $this->validate($request, [
            'photo' => 'required|mimes:jpg,jpeg,png,bmp',
        ]);
        $screen = null;
        // find or create screen and add photo to it.
        $photo = Photo::getOrCreate($request->file('photo'))->move($request->file('photo'));
        if (!is_null($photo->screen)) {
            $screen = $photo->screen;
        } else {
            $screen = new Screen;
            $screen->save();
        }

        $screen->photo()->save($photo);

        // Get a the existing screen and attatch it to screengroup.
        // Otherwise create a new screen with the photo and then attatch it to the screengroup.
        // $screengroup->assignOrCreateAndAssign($photo);
    }
}
