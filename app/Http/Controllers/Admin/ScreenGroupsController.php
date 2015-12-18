<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ScreenGroupRequest;
use App\Photo;
use App\Screen;
use App\ScreenGroup;
use DB;
use Illuminate\Http\Request as Requests;
use Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ScreenGroupsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $screengroups = ScreenGroup::all();

        if (Request::wantsJson()) {
            return $screengroups;
        } else {
            return view('screengroups.index', compact('screengroups'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('screengroups.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(ScreenGroupRequest $request)
    {
        if ($screengroup = new ScreenGroup($request->all())) {
            $screengroup->save();
            $event = $screengroup->createAndReturnEvent();
            $event_meta = $event->createAndReturnMeta();
            flash()->success('ScreenGroup created successfully.');

            if (Request::wantsJson()) {
                return $screengroup;
            } else {
                return redirect('/admin/screengroups/');
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  ScreenGroup $screenGroup
     * @return \Illuminate\View\View
     */

    // TODO: NOT WORKING!
    public function show(ScreenGroup $screengroup)
    {
        //$screengroup = ScreenGroup::findOrFail($screengroup->id)->with(['event.meta'])->get();
        if (Request::wantsJson()) {
            return $screengroup;
        } else {
            return view('screengroups.show', compact('screengroup'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  ScreenGroup $screenGroup
     * @return \Illuminate\View\View
     */
    public function edit(ScreenGroup $screengroup)
    {
        $event = $screengroup->getEvent();
        $event_meta = $event->getEventMeta();
        $tickers = $screengroup->tickers;

        return view('screengroups.edit', compact(['screengroup', 'event', 'event_meta', 'tickers']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ScreenGroupRequest $request
     * @param  ScreenGroup $screenGroup
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function update(ScreenGroupRequest $request, ScreenGroup $screengroup)
    {
        if ($screengroup->update($request->all())) {
            flash()->success('ScreenGroup updated successfully.');
            //$screengroup->generateShadowEvents();
            if (Request::wantsJson()) {
                return $screengroup;
            } else {
                return redirect()->back();
            }
        } else {
            return abort(500, 'Unable to update the screengroup');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  ScreenGroup  $screenGroup
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function destroy(ScreenGroup $screenGroup)
    {
        $deleted = $screenGroup->delete();
        flash()->success('ScreenGroup removed successfully.');

        if (Request::wantsJson()) {
            return (string) deleted;
        } else {
            return redirect('screengroups');
        }
    }

/**
 * Add or find a screen from given file and attatch it to the screengroup.
 *
 * @param ScreenGroup $screengroup
 * @param Request $request
 */
    public function addScreenFromPhoto(Requests $request, ScreenGroup $screengroup)
    {
        $this->validate($request, [
            'photo' => 'required|mimes:jpg,jpeg,png,bmp',
        ]);

        // find or create screen and add photo to it.
        $photo = Photo::getOrCreate($request->file('photo'))->move($request->file('photo'));
        $photo->save();

        // Get a the existing screen and attatch it to screengroup.
        // Otherwise create a new screen with the photo and then attatch it to the screengroup.
        $screengroup->assignOrCreateAndAssign($photo);
    }

    public function screens(Request $request, ScreenGroup $screengroup)
    {
        return ScreenGroup::with('screens.photo')->where('id', $screengroup->id)->get()[0]['screens'];
    }

/**
 * Make the photo from the given file.
 * @param  UploadedFile $file
 * @return Photo
 */
    public function makePhoto(UploadedFile $file)
    {
        return Photo::named($file->getClientOriginalName())
            ->move($file);
    }

    private function createScreenGroupMetaData(ScreenGroupRequest $request)
    {
        $result = DB::transaction(function () use ($request) {

            //$screenGroup->generateShadowEvents();
        });

        return $result;
    }

    public function remove_association(Requests $request, ScreenGroup $screengroup, Screen $screen)
    {
        if (!is_null($screengroup) && !is_null($screen)) {
            $screengroup->screens()->detach($screen->id);
        }
    }
}
