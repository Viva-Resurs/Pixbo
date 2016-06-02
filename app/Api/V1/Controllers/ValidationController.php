<?php

namespace App\Api\V1\Controllers;

use App\Http\Requests;

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
    public function validateUnique(Request $request, $id = null) {
        $field = $request->get('field');
        $value = $request->get('value');

        // TODO: Refactor this to match all models
        $result = Client::where($field, $value)->first();

        if(!is_null($id)) {
            if(!is_null($result)) {
                return $result->id === $id;
            } else {
                return true;
            }
        } else {
            return $result === null;
        }
    }
}