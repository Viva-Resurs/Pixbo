<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShadowEvent extends Model {
	protected $fillable = [
		'title',
		'isAllDay',
		'start',
		'end',
	];

	public function event() {
		return $this->belongsTo(App\Event::class);
	}

}
