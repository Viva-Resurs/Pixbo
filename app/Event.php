<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model {
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
		'user_id',
		'eventable_id',
		'eventable_type',
		'recurring',
	];

/**
 * Morph relation
 *
 * @return \Illuminate\Database\Eloquent\Relations\MorphTo
 */
	public function eventable() {
		return $this->morphTo();
	}
}