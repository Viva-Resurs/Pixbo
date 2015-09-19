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
		return $this->belongsTo(Event::class);
	}

	public static function generateFromEvent($date, Event $event) {
		$shadow = new static;

		$shadow->title = $event->with('eventable')->getResults();
		var_dump($shadow->title);

		return null;
	}

}
