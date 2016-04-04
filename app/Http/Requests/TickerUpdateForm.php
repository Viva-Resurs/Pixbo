<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use DB;
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
            'text' => 'required'
        ];
    }

    public function persist(Ticker $ticker) {
        $vm = $this;
        $event = $vm->get('event');
        $day_num = $vm->get('day_num');
        $event['recur_day_num'] = json_encode(($day_num));
        $ticker_data = $vm->get('modelObject');

        $screengroups = $vm->get('selected_screengroups');

        $result = DB::transaction(function () use ($ticker, $ticker_data, $event, $screengroups) {
            $e = Event::find($event['id']);
            $e->update($event);
            $ticker->update($ticker_data);
            $ticker->screengroups()->sync($screengroups);
            $ticker->save();
        });

        return $result;
    }
}
