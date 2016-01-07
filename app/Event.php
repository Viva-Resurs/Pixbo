<?php

namespace App;

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
		'start_date',
		'end_date',
		'start_time',
		'end_time',
		'frequency',
		'recur_type',
		'recur_day_num',
		'recur_day',
		'days_before_event',
		'eventable_id',
		'eventable_type',
	];

	protected $touches = ['eventable'];

/**
 * Morph relation
 *
 * @return \Illuminate\Database\Eloquent\Relations\MorphTo
 */
	public function eventable() {
		return $this->morphTo();
	}
}
