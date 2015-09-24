<?php

namespace App;

use Carbon\Carbon;
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

		$timeArray = extractTime($event['end_time']);
		$end = Carbon::parse($start);
		$end->hour = $timeArray[0];
		$end->minute = $timeArray[1];

		$shadow->end = $end;
		$shadow->isAllDay = 1;
		var_dump($start);

		$event->event_shadows()->save($shadow);
	}

	public static function clearEvent($id) {
		$delete_rows = ShadowEvent::where('event_id', $id)->delete();
	}

}
