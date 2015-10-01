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

	public $days = [
		0 => 'sunday',
		1 => 'monday',
		2 => 'tuesday',
		3 => 'wednesday',
		4 => 'thursday',
		5 => 'friday',
		6 => 'saturday',
	];

	public $order = [
		1 => 'first',
		2 => 'second',
		3 => 'third',
		4 => 'fourth',
		5 => 'last',
	];

	public $months = [
		1 => 'january',
		2 => 'february',
		3 => 'march',
		4 => 'april',
		5 => 'may',
		6 => 'june',
		7 => 'july',
		8 => 'august',
		9 => 'september',
		10 => 'october',
		11 => 'november',
		12 => 'december',
	];

	public $duration = [
		'daily' => 90,
		'weekly' => 12,
		'monthly' => 3,
		'yearly' => 2,
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
 * Delegates to the different shadow generators.
 */
	public function generateShadowEvents() {
		$meta = $this->getEventMeta();
		switch ($meta->getAttributes('recur_type')) {
		case 'daily':
			$this->generateDaily();
			break;
		case 'weekly':
			$this->generateWeekly();
			break;
		case 'monthly':
			$this->generateMonthly();
			break;
		case 'yearly':
			break;
		default:
			abort(404, 'Error generating Shadow Events.');
			break;
		}

	}

/**
 * Generates shadow event for daily recurring events.
 */
	protected function generateDaily() {

		$id = $this->getAttribute('id');
		$meta = $this->getEventMeta();
		$start_date = $this->getAttribute('date');
		$frequency = !is_null($meta->frequency) ? $meta->frequency : 1;
		$timeArray = extractTime($this->getAttribute('start_time'));

		$end = Carbon::parse($start_date)->addDays($this->duration['daily']);

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

	/**
	 * Generates shadow events for weekly recurring events.
	 */
	protected function generateWeekly() {
		$id = $this->getAttribute('id');
		$meta = $this->getEventMeta();
		$start_date = $this->getAttribute('date');
		$weekDays = unserialize($meta->recur_day);

		$frequency = !is_null($meta->frequency) ? $meta->frequency : 1;
		$timeArray = extractTime($this->getAttribute('start_time'));

		$started = Carbon::parse($start_date);
		$end = Carbon::parse($start_date)->addWeeks($this->duration['weekly']);

		$start = ShadowEvent::where(function ($q) use ($id, $frequency, $started) {
			$q->where('event_id', $id);
			$q->where('start', '>=', $started);
			$q->where('start', '>=', $started->subWeeks($frequency));
			$q->where('start', '<=', $started->addWeeks($frequency));
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
			$initial = $initial->addWeeks($frequency)) {

			for ($i = 1; $i < 8; $i++) {
				$day = Carbon::parse($initial)
					->subDays($initial->dayOfWeek)
					->addDays($i);

				if (in_array($day->dayOfWeek, $weekDays)
					&& $day->lt($end)
					&& $day->gt($start)) {
					$day->hour = $timeArray[0];
					$day->minute = $timeArray[1];
					ShadowEvent::generateFromEvent(Carbon::parse($day), $this);
				}
			}
		}
	}

/**
 * Generates shadow events for monthly recurring events.
 */
	public function generateMonthly() {
		$id = $this->getAttribute('id');
		$meta = $this->getEventMeta();
		$start_date = $this->getAttribute('date');
		$weekDay = unserialize($meta->recur_day);
		$week_in_month = $meta->getAttribute('recur_day_num');

		$frequency = !is_null($meta->frequency) ? $meta->frequency : 1;
		$timeArray = extractTime($this->getAttribute('start_time'));

		$started = Carbon::parse($start_date);
		$end = Carbon::parse($start_date)->addMonths($this->duration['monthly']);

		$start = ShadowEvent::where(function ($q) use ($id, $frequency, $started) {
			$q->where('event_id', $id);
			$q->where('start', '>=', $started);
			$q->where('start', '>=', $started->subMonths($frequency));
			$q->where('start', '<=', $started->addMonths($frequency));
		})->first();

		if (is_null($start)) {
			$start = Carbon::parse($start_date);
		} else {
			$start = Carbon::parse($start['start']);
		}

		$start->hour = $timeArray[0];
		$start->minute = $timeArray[1];

		ShadowEvent::clearEvent($id);

		for ($initial = Carbon::parse($start);
			$initial->lt($end);
			$initial = $initial->addMonths($frequency)) {

			$date_string = $this->order[$week_in_month] . ' ' .
			$this->days[$weekDay] . ' ' .
			$this->months[$initial->month] . ' ' .
			$initial->year;
			$date = Carbon::parse($date_string);
			if ($date->gt($start) && $date->lt($end)) {
				ShadowEvent::generateFromEvent(Carbon::parse($date), $this);
			}

		}
	}
}

/*
$b = App\Event::join('event_metas', 'event_metas.event_id', '=', 'events.id')->whereNotNull('recur_type')->groupBy('events.id')->get(['recur_type', 'events.id']);
 */