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

    public function dashboard(Request $request)
    {
        $screengroups = ScreenGroup::all();
        return view('pages.dashboard', compact('screengroups'));
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
