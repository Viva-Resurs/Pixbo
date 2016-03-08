<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Photo;
use Gate;
use Illuminate\Http\Request as Requests;
use Input;
use Request;
use Validator;

class PhotosController extends Controller {

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  Request  $request
	 * @return Response
	 */
	public function store(Requests $request) {

		$photo = $request->photo;
		if (Gate::denies('add_screens')) {
			abort(403);
		}

		if (Input::hasFile('photo')) {
			// validate
			$rules = [
				'photo' => 'required|mimes:jpeg,jpg,png,bmp',
			];
			$validator = Validator::make($request->all(), $rules);
			$id        = null;

			// move
			// store
			//
			if ($validator->fails()) {
				//flash()->error($validator->errors());
				return redirect()->back()->withErrors($validator->errors());
			} else {
				return redirect()->action('Admin\ScreensController@create', ['photo' => $id]);
			}

		} else {
			flash()->error(trans('exceptions.file_not_found'));
			return redirect()->back();
			//abort(404, trans('exceptions.file_not_found'));
		}

		//dd($request);
		/*
	$results = DB::transaction(function () use ($request) {
	Photo::getOrCreate($request->file('photo'))->move($request->file('photo'))->save();
	});

	if (is_null($results)) {
	flash()->success(trans('messages.photo_uploaded_ok'));
	} else {
	flash()->error(trans('messages.photo_uploaded_failed'));
	}
	 */
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  Image  $image
	 * @return Response
	 */
	public function destroy(Photo $image) {

		if (Gate::denies('remove_screens')) {
			abort(403);
		}

		$deleted = $image->delete();
		if ($deleted) {
			flash()->success(trans('messages.image_removed_ok'));
		} else {
			flash()->error(trans('messages.image_removed_failed'));
		}

		if (Request::wantsJson()) {
			return (string) $deleted;
		} else {
			return redirect('images');
		}
	}
}
