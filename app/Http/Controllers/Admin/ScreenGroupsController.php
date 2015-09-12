<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ScreenGroupRequest;
use App\Photo;
use App\ScreenGroup;
use Auth;
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
        $screenGroups = ScreenGroup::all();

        if (Request::wantsJson()) {
            return $screenGroups;
        } else {
            $data = ScreenGroup::paginate(10);
            return view('screengroups.index')->with('data', $data);
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
        flash()->success('ScreenGroup created successfully.');
        $screenGroup = new ScreenGroup($request->all());
        Auth::user()->screengroups()->save($screenGroup);
        $event      = $screenGroup->createAndReturnEvent();
        $event_meta = $event->createAndReturnMeta();

        if (Request::wantsJson()) {
            return $screenGroup;
        } else {
            $event_meta = "";
            return redirect()->action('Admin\ScreenGroupsController@edit', compact(['screenGroup', 'event', 'event_meta']));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  ScreenGroup $screenGroup
     * @return \Illuminate\View\View
     */
    public function show(ScreenGroup $screenGroup)
    {
        if (Request::wantsJson()) {
            return $screenGroup;
        } else {
            return view('screengroups.show', compact('screenGroup'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  ScreenGroup $screenGroup
     * @return \Illuminate\View\View
     */
    public function edit(ScreenGroup $screenGroup)
    {
        $event      = $screenGroup->getEvent();
        $event_meta = $event->getEventMeta();

        return view('screengroups.edit', compact(['screenGroup', 'event', 'event_meta']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ScreenGroupRequest $request
     * @param  ScreenGroup $screenGroup
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function update(ScreenGroupRequest $request, ScreenGroup $screenGroup)
    {
        if ($screenGroup->update($request->all())) {
            flash()->success('ScreenGroup updated successfully.');
            if (Request::wantsJson()) {
                return $screenGroup;
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
}
