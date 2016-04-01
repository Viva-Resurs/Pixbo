<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ScreenGroup;
use Illuminate\Http\Request;

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
}
