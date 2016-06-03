<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;



class ValidationController extends BaseController
{
    
    /**
     * Check if a given field and value pair exist, if they don't return true,
     * if the given pair exist but match the given id, return true, otherwise
     * return false.
     *
     * @param Request $request
     * @return bool
     */
    public function validateUnique(Request $request) {
        $field = $request->get('field');
        $value = strtolower($request->get('value'));
        $model = 'App\Models\\'.ucfirst($request->get('model'));
        $id    = $request->get('id');

        // Fix to check against lowercased field
        $result = $model::where(function($q) use ($field, $value) {
            $q->whereRaw('LOWER(`'.$field.'`) like ?', array($value));
        })->first();

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