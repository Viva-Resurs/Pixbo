<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\User;
use Gate;
use Illuminate\Http\Request;
use Request as RF;
use Validator;

class UsersController extends Controller
{
    public function index()
    {
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

    public function edit(User $user)
    {
        if (Gate::denies('edit_users')) {
            abort(403, trans('auth.access_denied'));
        }

        $roles = Role::where('name', '<>', 'client')->lists('name', 'id')->all();
        return view('users.edit', compact(['user', 'roles']));
    }

    /**
     * Update the user
     *
     * TODO: need to hash password before it's stored in the DB.
     * 
     * @param User $user
     * @param Request $request
     * @return mixed
     */
    public function update(User $user, Request $request)
    {
        if (Gate::denies('edit_users') && !auth()->user()->id == $user->id) {
            abort(403, trans('auth.access_denied'));
        }

        if($user->update($request->all())) {
            flash()->success(trans('auth.success'));
        } else {
            flash()->error(trans('auth.failed'));
        }
        return redirect()->back();
    }

    public function create()
    {
        $roles = Role::where('name', '<>', 'client')->lists('name', 'id')->all();

        return view('users.create', compact(['roles']));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);

        $result = User::createUserFromRequest($request);
        if (is_null($result)) {
            flash()->success(trans('messages.user_created_ok'));
        } else {
            flash()->success(trans('messages.user_created_fail'));
        }

        return redirect()->action('Admin\UsersController@index');
    }

    public function show(User $user)
    {
        if (Gate::denies('view_users')) {
            abort(403, trans('auth.access_denied'));
        }
    }
}
