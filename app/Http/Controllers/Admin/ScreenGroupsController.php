<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ScreenGroupRequest;
use App\Models\Photo;
use App\Models\Screen;
use App\Models\ScreenGroup;
use App\Models\Ticker;
use Gate;
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
		if (Gate::denies('view_screengroups')) {
			abort(403, trans('auth.access_denied'));
		}
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
	public function create() {
		if (Gate::denies('add_screengroups')) {
			abort(403, trans('auth.access_denied'));
		}
		return view('screengroups.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  Request  $request
	 * @return Response
	 */
	public function store(ScreenGroupRequest $request) {
		if (Gate::denies('add_screengroups')) {
			abort(403, trans('auth.access_denied'));
		}
		if ($screengroup = new ScreenGroup($request->all())) {
			if ($screengroup->save()) {
				flash()->success(trans('messages.screen_group_created_ok'));
			} else {
				flash()->error(trans('messages.screen_group_created_failed'));
			}

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
	public function show(ScreenGroup $screengroup) {
		if (Gate::denies('edit_screengroups')) {
			abort(403, trans('auth.access_denied'));
		}
		if (Request::wantsJson()) {
			return $screengroup;
		} else {
			$clients = $screengroup->clients;
			return view('screengroups.show', compact(['screengroup', 'clients']));
		}
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  ScreenGroup $screenGroup
	 * @return \Illuminate\View\View
	 */
	public function edit(ScreenGroup $screengroup) {
		if (Gate::denies('edit_screengroups')) {
			abort(403, trans('auth.access_denied'));
		}
		$event   = $screengroup->getEvent();
		$tickers = $screengroup->tickers;

		return view('screengroups.edit', compact(['screengroup', 'event', 'tickers']));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  ScreenGroupRequest $request
	 * @param  ScreenGroup $screenGroup
	 * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
	 */
	public function update(ScreenGroupRequest $request, ScreenGroup $screengroup) {
		if (Gate::denies('edit_screengroups')) {
			abort(403, trans('auth.access_denied'));
		}
		if ($screengroup->update($request->all())) {
			flash()->success(trans('messages.screen_group_updated_ok'));
			if (Request::wantsJson()) {
				return $screengroup;
			} else {
				return redirect()->back();
			}
		} else {
			flash()->success(trans('messages.screen_group_updated_failed'));
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  ScreenGroup  $screenGroup
	 * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
	 */
	public function destroy(ScreenGroup $screenGroup) {
		if (Gate::denies('remove_screengroups')) {
			abort(403, trans('auth.access_denied'));
		}
		$deleted = $screenGroup->delete();
		if ($deleted) {
			flash()->success(trans('messages.screen_group_removed_ok'));
		} else {
			flash()->error(trans('messages.screen_group_removed_failed'));
		}

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
		if (Gate::denies('add_screengroups')) {
			abort(403, trans('auth.access_denied'));
		}
		$this->validate($request, [
			'photo' => 'required|mimes:jpg,jpeg,png,bmp',
		]);

		// find or create screen and add photo to it.
		$results = DB::transaction(function () use ($request) {
			$photo = Photo::getOrCreate($request->file('photo'))->move($request->file('photo'));
			$photo->save();

			// Get a the existing screen and attatch it to screengroup.
			// Otherwise create a new screen with the photo and then attatch it to the screengroup.
			$screengroup->assignOrCreateAndAssign($photo);
		});
		if (is_null($results)) {
			flash()->success(trans('messages.screen_created_ok'));
		} else {
			flash()->error(trans('messages.screen_created_failed'));
		}
	}

	public function screens(Request $request, ScreenGroup $screengroup) {
		if (Gate::denies('view_screengroups')) {
			abort(403, trans('auth.access_denied'));
		}
		return ScreenGroup::with('screens.photo')->where('id', $screengroup->id)->get()[0]['screens'];
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

/**
 * Remove the association between a given screen and screengroup.
 *
 * @param  Requests    $request     [description]
 * @param  ScreenGroup $screengroup [description]
 * @param  Screen      $screen      [description]
 * @return [type]                   [description]
 */
	public function remove_screen_association(Requests $request, ScreenGroup $screengroup, Screen $screen) {
		if (!is_null($screengroup) && !is_null($screen)) {
			$screengroup->remove_screen($screen);
			flash()->success(trans('messages.screen_association_removed'));
		}
		$screengroup->touch();
		return redirect()->back();
	}

/**
 * Remove the association between a given ticker and screengroup.
 *
 * @param  Requests    $request     [description]
 * @param  ScreenGroup $screengroup [description]
 * @param  Ticker      $ticker      [description]
 * @return [type]                   [description]
 */
	public function remove_ticker_association(Requests $request, ScreenGroup $screengroup, Ticker $ticker) {
		if (!is_null($screengroup) && !is_null($ticker)) {
			$screengroup->remove_ticker($ticker);
			flash()->success(trans('messages.ticker_association_removed'));
		}
		$screengroup->touch();
		return redirect()->back();
	}
}
