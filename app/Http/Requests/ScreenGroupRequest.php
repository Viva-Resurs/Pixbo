<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ScreenGroupRequest extends Request
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
        //dd($this->screengroups->id);
        return [
            //'name'     => 'required|unique:screengroups,name,' . $this->screengroups->id,
            'desc'     => 'required',
            'rss_feed' => 'url',
        ];
    }
}
