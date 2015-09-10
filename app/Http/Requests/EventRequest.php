<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class EventRequest extends Request {
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
			'date' => 'required|date',
			'start_time' => 'required|date_format:H:i',
			'end_time' => 'required|date_format:H:i',
			'recurring' => '',
		];
	}
}
