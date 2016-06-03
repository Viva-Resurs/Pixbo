<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;



class ValidationController extends BaseController
{
    
    /**
     * Check if a given field and value pair exist, if they don't return true,
     * if the given pair exist but match the given id, return true, otherwise
     * return false.
     *
     * @param Request $request
     * @param null $id
     * @return bool
     */
    public function validateUnique(Request $request) {
        $field = $request->get('field');
        $value = strtolower($request->get('value'));
        $model = ucfirst($request->get('model'));
        $id    = $request->get('id');

        // TODO: Refactor this to match all models
        $result = Client::where($field, $value)->first();

        if(!is_null($id)) {
            if(!is_null($result)) {
                return (int)($result->id === $id);
            } else {
                return 1;
            }
        } else {
            return (int)($result === null);
        }
    }
}