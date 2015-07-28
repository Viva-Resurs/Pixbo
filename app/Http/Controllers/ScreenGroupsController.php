<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ScreenGroupRequest;
use App\ScreenGroup;
use Auth;
use Request;

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
			return view('screengroups.index', compact('screenGroups'));
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
		//$screenGroup = ScreenGroup::create($request->all());

		if (Request::wantsJson()) {
			return $screenGroup;
		} else {
			return redirect('screengroups');
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
	 * @param  int  $id
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
}
