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

	public static function generateFromEvent($start, Event $event) {
		$shadow = new static;
		$base_model = get_class($event->eventable()->getRelated());
		$model = $base_model::find(['id' => $event->id])->first();

		$shadow->title = $model['name'];
		$shadow->start = $start;

		$endArray = explode(':', $event['end_time']);
		$end = $start;
		$end->hour = $endArray[0];
		$end->minute = $endArray[1];

		$shadow->end = $end;
		$shadow->isAllDay = 1;

		$event->event_shadows()->save($shadow);
	}

}
