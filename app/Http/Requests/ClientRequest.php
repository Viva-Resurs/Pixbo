<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Request as Requests;

class ClientRequest extends Request
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
                    'name' => 'required|unique:clients',
                    'ip_address' => 'required|ip',
                    'mac_address' => array('required', 'unique:clients', 'regex:/^(([0-9a-fA-F]{2}-){5}|([0-9a-fA-F]{2}:){5})[0-9a-fA-F]{2}$/'),
                    //'user_id' => 'required',
                    'screengroup_id' => 'required',
                    //'is_active' => 'required',
                ];
            }
        case 'PUT':
        case 'PATCH':
            {
                return [
                    'name' => 'required|unique:clients,name' . Request::get('name'),
                    'mac_address' => array('required', 'unique:clients,mac_address' . Request::get('mac_address'), 'regex:/^(([0-9a-fA-F]{2}-){5}|([0-9a-fA-F]{2}:){5})[0-9a-fA-F]{2}$/'),
                ];
            }
        default:break;
        }
    }
}
