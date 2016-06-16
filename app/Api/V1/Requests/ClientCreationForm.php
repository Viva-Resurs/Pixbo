<?php

namespace App\Api\V1\Requests;

use App\Http\Requests\Request;
use App\Models\Client;
use DB;
use JWTAuth;

class ClientCreationForm extends Request
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
        
        return DB::transaction(function () use ($vm) {
            $client = new Client;
            $client->fill($vm->only(['name', 'address', 'screen_group_id']));
            
            JWTAuth::parseToken()->authenticate()->clients()->save($client);
            return $client;
        
        });
    }
}
