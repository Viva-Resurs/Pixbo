<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\User;
use Gate;
use Illuminate\Http\Request;
use Request as RF;

class UsersController extends Controller {
	public function index() {
		if (Gate::denies('view_users')) {
			abort(403, trans('auth.access_denied'));
		}
		$users = User::whereHas('roles', function ($q) {
			return $q->where('name', '<>', 'client');
		})->get();

		if (RF::wantsJson()) {
			return $users;
		} else {
			return view('users.index')->with('users', $users);
		}
	}

	public function edit(User $user) {
		if (Gate::denies('view_users')) {
			abort(403, trans('auth.access_denied'));
		}
		return $user;
	}

	public function update(User $user, Request $request) {
	}

	public function create() {
		$roles = Role::where('name', '<>', 'client')->lists('name', 'id')->all();

		return view('users.create', compact(['roles']));
	}

	public function store(User $user, Request $request) {
	}

	public function getProfile() {
	}

	public function postProfile() {
	}

	public function show(User $user) {
		if (Gate::denies('view_users')) {
			abort(403, trans('auth.access_denied'));
		}
	}
}
