<?php

namespace App\Api\V1\Requests;

use App\Http\Requests\Request;
use App\Models\Ticker;
use DB;
use App\Models\Event;

class TickerCreationForm extends Request
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
            //
        ];
    }

    public function persist() {

        $newTicker = $this->all();

        $screengroups = [];
        if ($this->has('screengroups'))
             $screengroups = $newTicker['screengroups'];

        $results = DB::transaction(function () use ($newTicker, $screengroups) {
            $ticker = new Ticker($newTicker);
            $ticker->save();
            $event = new Event(['start_date' => date('Y-m-d'), 'recur_type' => 'daily']);
            $ticker->event()->save($event);

            if (count($screengroups)>0)
                $ticker->screengroups()->sync($screengroups);

            $ticker->save();
            return $ticker;
        });

        return $results;
    }
}
