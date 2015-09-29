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

/**
 * Event association.
 *
 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
 */
	public function event() {
		return $this->belongsTo(Event::class);
	}

/**
 * Generates a shadow event from the given date with the info from given Event.
 *
 * @param  Carbon $start
 * @param  Event  $event
 */
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

		$event->event_shadows()->save($shadow);
	}

/**
 * Removes all shadow events from a given Event id.
 *
 * @param  integer $id event_id
 */
	public static function clearEvent($id) {
		$delete_rows = ShadowEvent::where('event_id', $id)->delete();
	}

}
