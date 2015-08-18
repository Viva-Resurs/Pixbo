<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class EventMetaRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'frequency' => 'integer',
            'recur_type' => 'string'
            'recur_day_num' => 'integer',
            'recur_day' => 'string',
            'recur_start' => 'date',
            'recur_end' => 'date',
        ];
    }
}
