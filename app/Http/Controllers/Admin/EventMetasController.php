<?php

namespace App\Http\Controllers\Admin;

use App\EventMeta;
use App\Http\Controllers\Controller;
use App\Http\Requests\EventMetaRequest;
use Request;

class EventMetasController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(EventMetaRequest $request, EventMeta $eventmeta)
    {
        $validator = $eventmeta->decodeAndUpdate($request->all());

        if ($validator->fails()) {
            flash()->error($validator->errors());
        } else {
            flash()->success('EventMeta updated successfully.');
        }

        if (Request::wantsJson()) {
            return $eventmeta;
        } else {
            return redirect()->back();
        }
    }
}
