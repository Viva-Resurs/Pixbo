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
}
