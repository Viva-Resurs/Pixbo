<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Request as Requests;

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
    public function rules(Requests $request)
    {
        switch ($this->method()) {
        case 'GET':
        case 'DELETE':
        case 'POST':
            {
                return [
                    'name' => 'required|unique:screengroups',
                    'desc' => 'required',
                ];
            }
        case 'PUT':
        case 'PATCH':
            {
                return [
                    'name' => 'required|unique:screengroups,name' . Request::get('name'),
                    'desc' => 'required',
                ];
            }
        default:break;
        }
    }
}
