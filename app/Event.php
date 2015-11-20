<?php

namespace App;

use App\EventMeta;
use Illuminate\Database\Eloquent\Model;

class Event extends Model {
	use HasShadowEvents;
	/**
	 * [$table description]
	 * @var string
	 */
	protected $table = "events";

/**
 * [$fillable description]
 * @var array
 */
	protected $fillable = [
		'date',
		'start_time',
		'end_time',
		'eventmeta_id',
		'eventable_id',
		'eventable_type',
		'recurring',
	];

	protected $touches = ['eventable', 'meta'];

/**
 * Morph relation
 *
 * @return \Illuminate\Database\Eloquent\Relations\MorphTo
 */
	public function eventable() {
		return $this->morphTo();
	}

/**
 * MetaEvent association
 *
 * @return \Illuminate\Database\Eloquent\Relations\HasOne
 */
	public function meta() {
		return $this->hasOne(EventMeta::class);
	}

/**
 * Get the EventMeta object
 *
 * @return EventMeta
 */
	public function getEventMeta() {
		return EventMeta::where(
			'event_id', $this->getAttribute('id')
		)->get()->first();
	}

/**
 * Creates and returns a new EventMeta for the Event.
 *
 * @return [type] [description]
 */
	public function createAndReturnMeta() {
		$event_meta = new EventMeta;
		$event_meta->fill([
			'frequency'     => null,
			'recur_type'    => null,
			'recur_day_num' => null,
			'recur_day'     => null,
			'recur_end'     => null,
		]);
		$this->meta()->save($event_meta);

		return $event_meta;
	}
}
