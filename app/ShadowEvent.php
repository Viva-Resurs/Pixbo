<?php

namespace App;

use App\Event;
use App\EventMeta;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ShadowEvent extends Model implements \MaddHatter\LaravelFullcalendar\Event
{
    protected $fillable = [
        'title',
        'isAllDay',
        'start',
        'end',
    ];

    protected $touches = ['event'];

/**
 * Event association.
 *
 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
 */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

/**
 * Generate Shadow events from the given screengroup
 *
 * @return [type] [description]
 */
    public static function generateShadowEvents(EventMeta $meta)
    {
        //$meta = EventMeta::ofEvent($sg->getAttribute('id'))->first();

        switch ($meta->getAttribute('recur_type')) {
        case 'daily':
            ShadowEvent::generateDaily($meta);
            break;
        case 'weekly':
            ShadowEvent::generateWeekly($meta);
            break;
        case 'monthly':
            $sg->generateMonthly();
            break;
        case 'yearly':
            $sg->generateYearly();
            break;
        }
    }

/**
 * Generate shadow events with daily recursion with the given meta event
 *
 * @param  MetaEvent $meta
 * @return
 */
    public static function generateDaily($meta)
    {
        $id = $meta->getAttribute('event_id');

        $event = Event::where('id', $id)->first();

        $start_date = $event->getAttribute('date');
        $frequency = !is_null($meta->frequency) ? $meta->frequency : 1;
        $timeArray = extractTime($event->getAttribute('start_time'));

        // TODO: set duration in cfg file.
        $end = Carbon::parse($start_date)->addDays(90);

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

        for ($initial = Carbon::parse($start);
            $initial->lt($end);
            $initial = $initial->addDays($frequency)) {
            $initial->hour = $timeArray[0];
            $initial->minute = $timeArray[1];
            ShadowEvent::generateFromEvent(Carbon::parse($initial), $event);
        }
    }

    /**
     * Generates shadow events for weekly recurring events.
     *
     */
    protected function generateWeekly()
    {
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

        for ($initial = Carbon::parse($start);
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
 * Generates a shadow event from the given date with the info from given Event.
 *
 * @param  Carbon $start
 * @param  Event  $event
 */
    public static function generateFromEvent($start, Event $event)
    {
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
    public static function clearEvent($id)
    {
        $delete_rows = ShadowEvent::where('event_id', $id)->delete();
        return $delete_rows;
    }

/**
 * Removes all old shadow event with a given event id.
 *
 * @param  integer $id
 * @return bool|null
 */
    public static function clearOldEvents($id)
    {
        $now = Carbon::now();
        $delete_rows = ShadowEvent::where(function ($q) use ($id, $now) {
            $q->where('event_id', $id);
            $q->where('end', '<', $now);
        })->delete();
        return $delete_rows;
    }

    public function getTitle()
    {
        return $this->getAttribute('title');
    }

    public function isAllDay()
    {
        return ($this->getAttributes('isAllDay') ? true : false);
    }

    public function getStart()
    {
        return Carbon::parse($this->getAttribute('start'));
    }

    public function getEnd()
    {
        return Carbon::parse($this->getAttribute('end'));
    }
}
