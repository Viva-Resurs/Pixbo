<?php

namespace App\Api\V1\Requests;

use App\Http\Requests\Request;
use App\Models\Ticker;

class TickerUpdateForm extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //'text' => 'required'
        ];
    }

    public function persist(Ticker $ticker) {
        $newTicker = $this->all();
        
        $newEvent = $newTicker['event'];
        $newScreengroups = $newTicker['screengroups'];

        //$ticker->load(['screengroups', 'event']);

        $event = $ticker->event->first();
        $event->update($newEvent);
        $event->touch();
        $ticker->screengroups()->sync($newScreengroups);

        if($ticker->update($newTicker)) {
            return true;
        }

        return false;

    }
}
