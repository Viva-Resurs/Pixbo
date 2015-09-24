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

	public function event_shadows() {
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

		$id = $this->getAttribute('id');
		$meta = $this->getEventMeta();
		$start_date = $this->getAttribute('date');
		$frequency = is_null($meta->frequency) ?: 1;
		$timeArray = extractTime($this->getAttribute('start_time'));

		$end = Carbon::parse($start_date)->addMonth();

		$start = ShadowEvent::where(function ($q) use ($id, $frequency, $start_date) {
			$q->where('event_id', $id);
			$q->where('start', '>=', $start_date);
			$q->where('start', '>=', Carbon::now()->subDays($frequency));
			$q->where('start', '<=', Carbon::now()->addDays($frequency));
		})->first();

		if (is_null($start)) {
			$start = Carbon::parse($start_date);
		} else {
			$start = Carbon::parse($start['start']);
		}

		$start->hour = $timeArray[0];
		$start->minute = $timeArray[1];

		ShadowEvent::clearEvent($id);

		for ($initial = $start;
			$initial->lt($end);
			$initial = $initial->addDays($frequency)) {
			$initial->hour = $timeArray[0];
			$initial->minute = $timeArray[1];
			ShadowEvent::generateFromEvent(Carbon::parse($initial), $this);
		}

	}

}

/*
$b = App\Event::join('event_metas', 'event_metas.event_id', '=', 'events.id')->whereNotNull('recur_type')->groupBy('events.id')->get(['recur_type', 'events.id']);
 */