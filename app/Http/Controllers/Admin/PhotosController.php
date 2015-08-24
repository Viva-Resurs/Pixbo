<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Photo;
use Illuminate\Http\Request as Requests;
use Request;

class PhotosController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {
		$images = Photo::all();

		if (Request::wantsJson()) {
			return $images;
		} else {
			$data = Photo::paginate(10);
			return view('photos.index')->with('data', $data);
		}
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create() {
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  Request  $request
	 * @return Response
	 */
	public function store(Requests $request) {

		$this->validate($request, [
			'image' => 'required|mimes:jpeg,jpg,png,bmp',
		]);

		$file = $request->file('image');

		$name = time() . $file->getClientOriginalName();

		$file->move('screens/images', $name);

		$image = Photo::create([
			'name' => $file->getClientOriginalName(),
			'path' => "/screens/images/{$name}",
			'thumb_path' => "/screens/images/th_{$name}",
			'archived' => 0,
			'sha1' => sha1_file('screens/images/' . $name),
		]);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  Image  $image
	 * @return Response
	 */
	public function show(Photo $image) {
		dd($image);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  Image  $image
	 * @return Response
	 */
	public function edit(Photo $image) {
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  Request  $request
	 * @param  Image  $image
	 * @return Response
	 */
	public function update(Request $request, Photo $image) {
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  Image  $image
	 * @return Response
	 */
	public function destroy(Photo $image) {
		flash()->success('Image removed successfully.');
		$deleted = $image->delete();

		if (Request::wantsJson()) {
			return (string) $deleted;
		} else {
			return redirect('images');
		}
	}
}