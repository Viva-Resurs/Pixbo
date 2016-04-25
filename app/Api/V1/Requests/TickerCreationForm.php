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
        $vm = $this;
        
        $results = DB::transaction(function () use ($vm) {
            $ticker = new Ticker($vm->all());
            $ticker->save();
            $event = new Event(['start_date' => date('Y-m-d')]);
            $ticker->event()->save($event);
            $ticker->save();
            return $ticker;
        });

        return $results;
    }
}
