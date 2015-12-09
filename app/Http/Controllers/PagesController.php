<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('screen_client');
        parent::__construct();
    }

    public function home()
    {
        return view('pages.home');
    }

    public function dashboard(Request $request)
    {
        return view('pages.dashboard');
    }

//     public function calendars()
    //     {
    //         $events = ShadowEvent::all(); //EventModel implements MaddHatter\LaravelFullcalendar\Event

//         $calendar = \Calendar::addEvents($events, [ //set custom color fo this event
    //             'color' => '#800',
    //         ])->setOptions([ //set fullcalendar options
    //             'firstDay' => 1,
    //         ]) /*->setCallbacks([ //set fullcalendar callback options (will not be JSON encoded)
    //                 'viewRender' => 'function() {alert("Callbacks!");}',
    // */;

//         return view('pages.calendar', compact('calendar'));
    //         return view('pages.calendar');
    //     }
}
