<?php
namespace App;

use Carbon\Carbon;

trait HasShadowEvents
{
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

    public function event_shadows()
    {
        return $this->hasMany(ShadowEvent::class);
    }

    /**
     * Delegates to the different shadow generators.
     */
    public function generateShadowEvents()
    {
        $meta = $this->getEventMeta();
        switch ($meta->getAttribute('recur_type')) {
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
            $this->generateYearly();
            break;
        }
    }

/**
 * Generates shadow event for daily recurring events.
 */
    protected function generateDaily()
    {
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

        for ($initial = Carbon::parse($start);
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
 * Generates shadow events for monthly recurring events.
 */
    public function generateMonthly()
    {
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

    public function generateYearly()
    {
        $id = $this->getAttribute('id');
        $meta = $this->getEventMeta();
        $start_date = $this->getAttribute('date');

        $frequency = !is_null($meta->frequency) ? $meta->frequency : 1;
        $timeArray = extractTime($this->getAttribute('start_time'));

        $started = Carbon::parse($start_date);
        $end = Carbon::parse($start_date)->addYears($this->duration['yearly']);

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
            $initial->lt($end);
            $initial = $initial->addYears($frequency)) {
            if ($initial->gt($start) && $initial->lt($end)) {
                ShadowEvent::generateFromEvent(Carbon::parse($initial), $this);
            }
        }
    }
}
