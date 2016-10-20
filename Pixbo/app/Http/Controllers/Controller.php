<?php

namespace App\Http\Controllers;

use App\Models\Online;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

abstract class Controller extends BaseController
{
    use DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        view()->share('signedIn', Auth::check());
        view()->share('user', Auth::user());

        Online::updateCurrent();
    }
}
