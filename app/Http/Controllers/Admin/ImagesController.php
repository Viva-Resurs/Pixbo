<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Image;
use Illuminate\Http\Request as Requests;
use Request;

class ImagesController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {
		$images = Image::all();

		if (Request::wantsJson()) {
			return $images;
		} else {
			$data = Image::paginate(10);
			return view('images.index')->with('data', $data);
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

		Image::create(['path' => "/screens/images/{$name}", 'archived' => 0]);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  Image  $image
	 * @return Response
	 */
	public function show(Image $image) {
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  Image  $image
	 * @return Response
	 */
	public function edit(Image $image) {
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  Request  $request
	 * @param  Image  $image
	 * @return Response
	 */
	public function update(Request $request, Image $image) {
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  Image  $image
	 * @return Response
	 */
	public function destroy(Image $image) {
		flash()->success('Image removed successfully.');
		$deleted = $image->delete();

		if (Request::wantsJson()) {
			return (string) $deleted;
		} else {
			return redirect('images');
		}
	}
}
