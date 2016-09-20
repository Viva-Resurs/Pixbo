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
        
        $model_string = $request->get('model');
        
        if($model_string=='screengroup')
            $model = 'App\\Models\\ScreenGroup';
        else
            $model = 'App\Models\\'.ucfirst($request->get('model'));
        
        $id = $request->get('id');

        // Fix to check against lowercased field
        $result = $model::where(function($q) use ($field, $value, $id) {
            $q->whereRaw('LOWER(`'.$field.'`) like ?', array($value));
            $q->where('id', '<>', $id);
        })->first();

        return (is_null($result)) ? 1 : 0;
    }

}
