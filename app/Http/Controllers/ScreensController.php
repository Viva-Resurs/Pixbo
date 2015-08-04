<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ScreenRequest;
use App\Screen;
use App\ScreenGroup;
use Auth;
use Request;

class ScreensController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $screens = Screen::all();

        if (Request::wantsJson()) {
            return $screens;
        } else {
            $data = Screen::paginate(10);
            //dd($data);
            return view('screens.index')->with('data', $data);
            //return view('screens.index', compact('screens'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $screens      = new Screen;
        $screenGroups = ScreenGroup::lists('name', 'id')->all();

        return view('screens.create', compact('screens', 'screenGroups'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(ScreenRequest $request)
    {
        flash()->success('Screen created successfully.');

        $screen = new Screen($request->all());
        Auth::user()->screens()->save($screen);

        if (Request::wantsJson()) {
            return $screen;
        } else {
            return redirect('screens');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  Screen  $screen
     * @return Response
     */
    public function show(Screen $screen)
    {
        if (Request::wantsJson()) {
            return $screen;
        } else {
            return view('screens.show', compact('screen'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Screen  $screen
     * @return Response
     */
    public function edit(Screen $screen)
    {
        $screenGroups = ScreenGroup::lists('name', 'id')->all();

        return view('screens.edit', compact('screen', 'screenGroups'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  Screen  $screen
     * @return Response
     */
    public function update(ScreenRequest $request, Screen $screen)
    {
        flash()->success('Screen updated successfully.');
        $screen->update($request->all());

        if (Request::wantsJson()) {
            return $screen;
        } else {
            return redirect('screens');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Screen  $screen
     * @return Response
     */
    public function destroy(Screen $screen)
    {
        flash()->success('Screen removed successfully.');
        $deleted = $screen->delete();

        if (Request::wantsJson()) {
            return (string) $deleted;
        } else {
            return redirect('screens');
        }
    }
}
