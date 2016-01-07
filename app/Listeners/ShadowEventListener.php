<?php

namespace App\Listeners;

use App\Event;
use App\EventMeta;
use App\ShadowEvent;
use Carbon\Carbon;

class ShadowEventListener
{
    /**
     * Config on how far into the future the reccuring events should be generated.
     * @var array
     */
    protected $duration = [
        'daily' => 90, // days
        'weekly' => 12, // weeks
        'monthly' => 3, // months
        'yearly' => 2, // years
    ];

    /**
     * Week days
     * @var array
     */
    protected $days = [
        0 => 'sunday',
        1 => 'monday',
        2 => 'tuesday',
        3 => 'wednesday',
        4 => 'thursday',
        5 => 'friday',
        6 => 'saturday',
    ];

/**
 * Ordering
 * @var array
 */
    protected $order = [
        1 => 'first',
        2 => 'second',
        3 => 'third',
        4 => 'fourth',
        5 => 'last',
    ];

/**
 * Months
 * @var array
 */
    protected $months = [
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

/**
 * Fires when EventMeta has changed.
 *
 * @param  EventMeta $meta
 * @return
 */
    public function whenEventMetaChanged(EventMeta $meta)
    {
        $this->generateShadowEvents($meta);
    }

/**
 * Fires when Event has changed.
 * @param  Event  $event [description]
 * @return [type]        [description]
 */
    public function whenEventChanged(Event $event)
    {
        $this->generateShadowEvents($event->meta);
    }

/**
 * Fires when an Event is removed.
 * @param  Event  $event
 * @return [type]        [description]
 */
    public function whenEventRemoved(Event $event)
    {
        ShadowEvent::clearEvent($event->getAttribute('id'));
    }

/**
 * Generate shadow events for a given EventMeta.
 *
 * @param  EventMeta $meta
 * @return
 */
    private function generateShadowEvents(EventMeta $meta)
    {
        switch ($meta->getAttribute('recur_type')) {

        case 'daily':
            $this->generateDaily($meta);
            break;
        case 'weekly':
            $this->generateWeekly($meta);
            break;
        case 'monthly':
            $this->generateMonthly($meta);
            break;
        case 'yearly':
            $this->generateYearly($meta);
            break;
        }
    }

/**
 * Generate daily shadow events.
 *
 * @param  EventMeta $meta
 * @return
 */
    private function generateDaily(EventMeta $meta)
    {
        $id = $meta->getAttribute('event_id');

        $event = Event::where('id', $id)->first();

        $start_date = $event->getAttribute('date');
        $frequency = !is_null($meta->frequency) ? $meta->frequency : 1;
        $timeArray = extractTime($event->getAttribute('start_time'));

        $end = Carbon::parse($start_date)->addDays($this->duration['daily']);
        if ($event->getAttribute('recurring') == 0) {
            $end = Carbon::parse($start_date);
        }

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
            $initial->lte($end);
            $initial = $initial->addDays($frequency)) {
            $initial->hour = $timeArray[0];
            $initial->minute = $timeArray[1];
            ShadowEvent::generateFromEvent(Carbon::parse($initial), $event);
        }
    }

/**
 * Generate weekly shadow events.
 * @param  EventMeta $meta
 * @return
 */
    private function generateWeekly(EventMeta $meta)
    {
        $id = $meta->getAttribute('event_id');
        $event = Event::where('id', $id)->first();

        $start_date = $event->getAttribute('date');
        $weekDays = unserialize($meta->recur_day);

        $frequency = !is_null($meta->frequency) ? $meta->frequency : 1;
        $timeArray = extractTime($event->getAttribute('start_time'));

        $started = Carbon::parse($start_date);

        $end = Carbon::parse($start_date)->addWeeks($this->duration['weekly']);
        if ($event->getAttribute('recurring') == 0) {
            $end = Carbon::parse($start_date);
        }

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
            $initial->lte($end);
            $initial = $initial->addWeeks($frequency)) {
            for ($i = 1; $i < 8; $i++) {
                $day = Carbon::parse($initial)
                    ->subDays($initial->dayOfWeek)
                    ->addDays($i);

                if (in_array($day->dayOfWeek, $weekDays)
                    && $day->lte($end)
                    && $day->gte($start)) {
                    $day->hour = $timeArray[0];
                    $day->minute = $timeArray[1];
                    ShadowEvent::generateFromEvent(Carbon::parse($day), $event);
                }
            }
        }
    }

/**
 * Generate monthly shadow events.
 *
 * @param  EventMeta $meta
 * @return
 */
    private function generateMonthly(EventMeta $meta)
    {
        $id = $meta->getAttribute('event_id');
        $event = Event::where('id', $id)->first();

        $start_date = $event->getAttribute('date');
        $weekDay = unserialize($meta->recur_day);
        $week_in_month = $meta->getAttribute('recur_day_num');

        $frequency = !is_null($meta->frequency) ? $meta->frequency : 1;
        $timeArray = extractTime($event->getAttribute('start_time'));

        $started = Carbon::parse($start_date);

        $end = Carbon::parse($start_date)->addMonths($this->duration['monthly']);
        if ($event->getAttribute('recurring') == 0) {
            $end = Carbon::parse($start_date);
        }

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
            $initial->lte($end);
            $initial = $initial->addMonths($frequency)) {
            $date_string = $this->order[$week_in_month] . ' ' .
            $this->days[$weekDay] . ' ' .
            $this->months[$initial->month] . ' ' .
            $initial->year;
            $date = Carbon::parse($date_string);
            if ($date->gte($start) && $date->lte($end)) {
                ShadowEvent::generateFromEvent(Carbon::parse($date), $event);
            }
        }
    }

/**
 * Generate yearly shadow events.
 *
 * @param  EventMeta $meta
 * @return
 */
    private function generateYearly(EventMeta $meta)
    {
        $id = $meta->getAttribute('event_id');
        $event = Event::where('id', $id)->first();

        $start_date = $event->getAttribute('date');

        $frequency = !is_null($meta->frequency) ? $meta->frequency : 1;
        $timeArray = extractTime($event->getAttribute('start_time'));

        $started = Carbon::parse($start_date);

        $end = Carbon::parse($start_date)->addYears($this->duration['yearly']);
        if ($event->getAttribute('recurring') == 0) {
            $end = Carbon::parse($start_date);
        }

        $start = ShadowEvent::where(function ($q) use ($id, $frequency, $started) {
            $q->where('event_id', $id);
            $q->where('start', '>=', $started);
            $q->where('start', '>=', $started->subYears($frequency));
            $q->where('start', '<=', $started->addYears($frequency));
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
            $initial->lte($end);
            $initial = $initial->addYears($frequency)) {
            if ($initial->gte($start) && $initial->lte($end)) {
                ShadowEvent::generateFromEvent(Carbon::parse($initial), $event);
            }
        }
    }
}