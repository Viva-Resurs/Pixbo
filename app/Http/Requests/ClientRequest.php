<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

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
    public function rules()
    {
        switch ($this->method()) {
        case 'GET':
        case 'DELETE':
        case 'POST':
            {
                return [
                    'name' => 'required|unique:clients',
                    'ip_address' => 'required|ip|unique:clients',
                    'screen_group_id' => 'required',
                ];
            }
        case 'PUT':
        case 'PATCH':
            {
                return [
                    'name' => 'required|unique:clients,name,' . Request::get('client_id'),
                    'ip_address' => 'required|ip|unique:clients,ip_address,' . Request::get('client_id'),
                ];
            }
        default:break;
        }
    }
}
