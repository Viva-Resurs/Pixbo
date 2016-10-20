<?php

namespace App\Http\Requests;

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
        if ($ticker = new Ticker($vm->all())) {
            $results = DB::transaction(function () use ($ticker) {
                $ticker->save();
                $event = new Event;
                $event->fill(['start_date' => date('Y-m-d')]);
                $ticker->event()->save($event);
                $ticker->save();
            });
            
            return $results;
                
        } else {
            abort(trans('messages.ticker_created_fail'), 500);
        }
    }
}
