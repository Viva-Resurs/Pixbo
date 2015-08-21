<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class PagesController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }
    public function home()
    {
        return view('pages.home');
    }

    public function dashboard()
    {
        return view('pages.dashboard');
    }

    public function calendars()
    {
        return view('pages.calendar');
    }
}
