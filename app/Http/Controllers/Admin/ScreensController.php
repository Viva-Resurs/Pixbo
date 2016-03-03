<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Photo;
use App\Models\Screen;
use App\Models\ScreenGroup;
use App\Models\Tag;
use DB;
use Event as E;
use Gate;
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
        if (Gate::denies('view_screens')) {
            abort(403, trans('auth.access_denied'));
        }

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

        if (Request::wantsJson()) {
            return $screen;
        } else {
            return redirect()->action('Admin\ScreensController@edit', compact(['screen', 'event']));
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
    public function update(Request $request, $screen)
    {
        if (Gate::denies('edit_screens')) {
            abort(403, trans('auth.access_denied'));
        }

        $event = $request->get('event');
        $day_num = $request->get('day_num');
        $event['recur_day_num'] = json_encode(($day_num));
        $tags = $request->get('selected_tags');

        $screengroups = $request->get('selected_screengroups');

        $result = DB::transaction(function () use ($screen, $event, $tags, $screengroups) {
            $e = Event::find($event['id']);
            $e->update($event);

            $tagged = [];

            foreach ($tags as $tag) {
                $t = Tag::where('name', $tag['name'])->first();
                if (!is_null($t)) {
                    array_push($tagged, $t->id);
                } else {
                    $t = new Tag;
                    $t->fill([
                        'name' => $tag['name'],
                    ])->save();
                    array_push($tagged, $t->id);
                }
            }
            $screen->tags()->sync($tagged);

            $screen->screengroups()->sync($screengroups);
            $screen->save();
        });

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
        $sgs = $screen->screengroups;
        $event = $screen->event;
        $deleted = $screen->delete();
        if ($deleted) {
            flash()->success(trans('messages.screen_delete_ok'));
            foreach ($sg as $sgs) {
                $sg->touch();
            }
            ShadowEvent::clearEvent($event->id);
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
     * Add or find a screen from given file and attatch it to the screengroup.
     *
     * @param ScreenGroup $screengroup
     * @param Request $request
     */
    public function addScreenFromPhoto(Request $request)
    {
        if (Gate::denies('add_screens')) {
            abort(403, trans('auth.access_denied'));
        }
        $this->validate($request, [
            'photo' => 'required|mimes:jpg,jpeg,png,bmp',
        ]);

        $screen = DB::transaction(function () use ($request) {
            $screen = null;
            // find or create screen and add photo to it.
            $photo = Photo::getOrCreate($request->file('photo'))->move($request->file('photo'));
            if (!is_null($photo->screen)) {
                $screen = $photo->screen;
            } else {
                $screen = new Screen;
                $screen->save();
            }

            $event = new Event;
            $event->fill(['start_date' => date('Y-m-d')]);

            $screen->photo()->save($photo);
            $screen->event()->save($event);
            return $screen;
        });
        return $screen;
    }
}
