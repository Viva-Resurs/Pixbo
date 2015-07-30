<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ScreenRequest extends Request {
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize() {
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
		return [
			'name' => 'required',
			//'screengroup_id' => '',
			//'event_id' => '',
			//'image_id' => '',
			'user_id' => 'required',
			'created_at',
			'updated_at',
		];
	}
}