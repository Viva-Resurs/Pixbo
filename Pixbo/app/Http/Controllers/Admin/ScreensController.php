<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Screen;
use App\Models\ScreenGroup;
use DB;
use Gate;
use Illuminate\Http\Request;
use Request as Requests;
use App\Http\Requests\ScreenUpdateForm;
use App\Http\Requests\FileUploadForm;

class ScreensController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        if (Gate::denies('view_screens')) {
            abort(403, trans('auth.access_denied'));
        }

        $screens = Screen::all();

        if (Requests::wantsJson()) {
            return $screens;
        } else {
            return view('screens.index2', compact('screens'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Request $request)
    {
        if (Gate::denies('add_screens')) {
            abort(403, trans('auth.access_denied'));
        }
        $screen = new Screen;
        $screenGroups = ScreenGroup::lists('name', 'id')->all();

        return view('screens.create', compact(['screen', 'screenGroups', 'photo']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        if (Gate::denies('add_screens')) {
            abort(403, trans('auth.access_denied'));
        }

        DB::transaction(function () use ($request) {
            if ($screen = new Screen($request->all())) {
                flash()->success(trans('messages.screen_created_ok'));
            } else {
                flash()->error(trans('messages.screen_created_fail'));
            }

            $event = new Event;
            $event->fill(['start_date' => date('Y-m-d')]);
            $screen->event()->save($event);

        });

        return redirect()->action('Admin\ScreensController@edit', compact(['screen', 'event']));

    }

    /**
     * Display the specified resource.
     *
     * @param  Screen  $screen
     * @return Response
     */
    public function show(Screen $screen)
    {
        if (Gate::denies('edit_screens')) {
            abort(403, trans('auth.access_denied'));
        }
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
        if (Gate::denies('edit_screens')) {
            abort(403, trans('auth.access_denied'));
        }
        $event = $screen->getEvent();
        $screengroups = Screengroup::all();

        return view('screens.edit', compact(['screen', 'event', 'screengroups']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  Screen  $screen
     * @return Response
     */
    public function update(ScreenUpdateForm $form, $screen)
    {
        if (Gate::denies('edit_screens')) {
            abort(403, trans('auth.access_denied'));
        }

        $result = $form->persist($screen);

        if (is_null($result)) {
            return ['type' => 'success', 'dismissible' => true, 'content' => trans('messages.screen_updated_ok'), 'timeout' => 2000];
        } else {
            return ['type' => 'danger', 'dismissible' => true, 'content' => trans('messages.screen_updated_fail'), 'timeout' => false];
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
        if (Gate::denies('remove_screens')) {
            abort(403, trans('auth.access_denied'));
        }

        $deleted = $screen->delete();
        if ($deleted) {
            flash()->success(trans('messages.screen_delete_ok'));

        } else {
            flash()->error(trans('messages.screen_delete_failed'));
        }

        if (Requests::wantsJson()) {
            return (string) $deleted;
        } else {
            return redirect()->back();
        }
    }

    /**
     * Add or find a screen from given file and attatch it to the screengroup,
     * then returns the new screen object.
     *
     * @param ScreenGroup $screengroup
     * @param Request $request
     * @return Screen $screen
     */
    public function addScreenFromPhoto(FileUploadForm $form)
    {

        if (Gate::denies('add_screens')) {
            abort(403, trans('auth.access_denied'));
        }


        return $form->persist();
    }
}
