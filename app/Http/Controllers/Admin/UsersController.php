<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;

class UsersController extends Controller
{
    public function index()
    {
        return User::all();
    }

    public function profile()
    {
    }

    public function show(User $user)
    {
        //$full = User::where('id', $user->id)->with('online')->first();
        dd($user->last_activity);
    }
}
