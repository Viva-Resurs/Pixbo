<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ScreenGroupRequest;
use App\Photo;
use App\Screen;
use App\ScreenGroup;
use Auth;
use Illuminate\Http\Request as Requests;
use Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ScreenGroupsController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {
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
	public function create() {
		return view('screengroups.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  Request  $request
	 * @return Response
	 */
	public function store(ScreenGroupRequest $request) {
		flash()->success('Client created successfully.');
		$screenGroup = new ScreenGroup($request->all());
		Auth::user()->screengroups()->save($screenGroup);

		if (Request::wantsJson()) {
			return $screenGroup;
		} else {
			return redirect('admin/screengroups');
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show(ScreenGroup $screenGroup) {
		if (Request::wantsJson()) {
			return $screenGroup;
		} else {
			return view('screengroups.show', compact('screenGroup'));
		}

	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit(ScreenGroup $screenGroup) {
		return view('screengroups.edit', compact('screenGroup'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  Request  $request
	 * @param  int  $id
	 * @return Response
	 */
	public function update(ScreenGroupRequest $request, ScreenGroup $screenGroup) {
		$screenGroup->update($request->all());

		if (Request::wantsJson()) {
			return $screenGroup;
		} else {
			return redirect('screengroups');
		}

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  ScreenGroup  $screenGroup
	 * @return Response
	 */
	public function destroy(ScreenGroup $screenGroup) {
		$deleted = $screenGroup->delete();

		if (Request::wantsJson()) {
			return (string) deleted;
		} else {
			return redirect('screengroups');
		}
	}

/**
 * Remove the given ScreenGroup
 *
 * @param ScreenGroup $screenGroup
 * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
 */
	public function delete(ScreenGroup $screenGroup) {
		$deleted = $screenGroup->delete();

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
	public function addScreenFromPhoto(Requests $request, ScreenGroup $screengroup) {
		$this->validate($request, [
			'photo' => 'required|mimes:jpg,jpeg,png,bmp',
		]);

		// find or create screen and add photo to it.
		$photo = Photo::getOrCreate($request->file('photo'))->move($request->file('photo'));
		$photo->save();

		// Get a the existing screen and attatch it to screengroup.
		// Otherwise create a new screen with the photo and then attatch it to the screengroup.
		$screen = Screen::where(['photo_id' => $photo->id])->first();
		if (!is_null($screen)) {
			$screengroup->screens()->save($screen);
		} else {
			$screengroup->screens()->create([
				'name' => $photo->name,
				'screen_group_id' => $screengroup->id,
				'event_id' => null,
				'photo_id' => $photo->id,
				'user_id' => Auth::user()->id,
			])->save();
		}

	}

/**
 * Make the photo from the given file.
 * @param  UploadedFile $file
 * @return Photo
 */
	public function makePhoto(UploadedFile $file) {
		return Photo::named($file->getClientOriginalName())
			->move($file);
	}
}
