<?php

namespace App;

use App\EventMeta;
use Carbon\Carbon;
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

/**
 * MetaEvent association
 *
 * @return \Illuminate\Database\Eloquent\Relations\HasOne
 */
	public function meta() {
		return $this->hasOne(EventMeta::class);
	}

	public function shadow_events() {
		return $this->hasMany(ShadowEvent::class);
	}

/**
 * Get the EventMeta object
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
			'frequency' => null,
			'recur_type' => null,
			'recur_day_num' => null,
			'recur_day' => null,
			'recur_end' => null,
		]);
		$this->meta()->save($event_meta);

		return $event_meta;
	}

/**
 * Get events for today for the given model.
 *
 * @param  string $model
 * @param integer $model_id
 * @return array
 */
	public function scopeGetTodaysEvents() {
		return static::with('meta')->where(['date' => date('Y-m-d')])->get();
	}

/**
 * Checks if a given date matches the events date.
 *
 * @param  string $date
 * @return boolean
 */
	public function matchDate(string $date) {
		if ($this->attributes('date') == $date) {
			return true;
		} else if ($this->attributes('recurring') == 0) {
			return false;
		} else {
			return $this->matchRecurrence($date);
		}
	}

	protected function matchRecurrence(string $date) {

	}

	private function generateShadowEvent($date) {

	}

	protected function generateShadowEvents() {
		$meta = $this->getEventMeta();
		switch ($meta->getAttributes('recur_type')) {
		case 'daily':
			generateDaily();
			break;
		case 'weekly':
			break;
		case 'monthly':
			break;
		case 'yearly':
			break;
		default:
			break;
		}

	}

	public function generateDaily() {
		$meta = $this->getEventMeta();
		$end = Carbon::now()->addMonth();
		$frequency = $meta->frequency;

		for ($initial = Carbon::now();
			$initial->lt($end);
			$initial->addDays($frequency)) {
			return ShadowEvent::generateFromEvent($initial, $this);
		}

	}

}

/*
$b = App\Event::join('event_metas', 'event_metas.event_id', '=', 'events.id')->whereNotNull('recur_type')->groupBy('events.id')->get(['recur_type', 'events.id']);
 */