<?php
namespace App\Traits;

use App\Jobs\AddShadowEvent;
use App\Models\Event;
use App\Models\ShadowEvent;
use Carbon\Carbon;
use Illuminate\Foundation\Bus\DispatchesJobs;

trait HasShadowEvents
{
    use DispatchesJobs;
    public function shadow_events()
    {
        return $this->hasMany(ShadowEvent::class, 'event_id');
    }

    public function getActiveShadowEvents() {
        return $this->shadow_events()->now()->get();
    }

    /**
     * Config on how far into the future the reccuring events should be generated.
     * @var array
     */
    protected $duration = [
        'daily' => 14, // days
        'weekly' => 2, // weeks
        'monthly' => 6, // months
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
     * Validate frequency
     * @return int
     */
    protected function validateFrequency($frequency) {
        if (is_null($frequency) || (int) $frequency <= 0)
            return 1;
        return (int) $frequency;
    };

    protected function findShadowInRange($start, $begin, $end) {
        $first_match = $this->shadow_events()
            ->where('start', '>=',$start)
            ->where('start', '>=',$begin)
            ->where('start', '<=',$end)
            ->first();

        if (is_null($first_match)) {
            return $start;
        } else {
            return Carbon::parse($first_match);
        }
    }

    /**
     * Generate shadow events for a given EventMeta.
     *
     * @param  Event $event
     * @return
     */
    public function generateShadowEvents(Event $event)
    {
        $type = 'generate'.ucfirst($event->recur_type);
        $this->$type($event);
    }

    private function generateNone(Event $event)
    {
        $date = $this->getStartDate($event);

        ShadowEvent::clearEvent($event->id);

        $addShadowEvent = new AddShadowEvent($date, $event);
        $this->dispatch($addShadowEvent);
    }

    private function getStartDate(Event $event)
    {
        $timeArray = (!is_null($event->start_time)) ? extractTime($event->start_time) : ["00","00","00"];

        $date = Carbon::parse($event->start_date);

        $date->hour = $timeArray[0];
        $date->minute = $timeArray[1];
        $date->second = "00";

        return $date;
    }

    private function getEndDate(Event $event, $type, $duration)
    {
        // Hämtar dagens datum och lägger till x dagar framåt
        $parsedType = 'add'.ucfirst($type);
        $today = $this->getToday($this->start_time);
        $maxEndDate = Carbon::parse($today)->$parsedType($duration);
        $givenDate = null;
        $returnDate = null;


        // Kollar om det finns slut datumm
        // Hämtar när det är tänkt det skall sluta
        $givenDate = (!is_null($event->end_date)) ? Carbon::parse($event->end_date) : $maxEndDate;

        // Kollar om det som finns är kortare än x dagar framåt
        $returnDate = ($givenDate->lte($maxEndDate)) ? $givenDate : $maxEndDate;
        $timeArray = (!is_null($event->end_time)) ? extractTime($event->end_time) : ["00","00","00"];

        $returnDate->hour = $timeArray[0];
        $returnDate->minute = $timeArray[1];
        $returnDate->second = "00";

        return $returnDate;
    }

    private function getToday($start_date)
    {
        $date = Carbon::parse($start_date);
        $timeArray = [$date->hour, $date->minute, $date->second];
        $today = Carbon::now();
        $today->hour = $timeArray[0];
        $today->minute = $timeArray[0];
        $today->second = "00";

        return $today;
    }

    /**
     * Generate daily shadow events.
     *
     * @param  Event $event
     */
    private function generateDaily(Event $event)
    {
        $start_date = $this->getStartDate($event);
        $today = $this->getToday($start_date);
        $end_date = $this->getEndDate($event, 'days', $this->duration['daily']);
        $frequency = $this->validateFrequency($event->frequency);

        $start = $this->findShadowInRange(
            $start_date,
            $today->subDays($frequency),
            $today->addDays($frequency)
        );

        for ($initial = Carbon::parse($start);
             $initial->lte($end_date);
             $initial = $initial->addDays($frequency)) {

            $addShadowEvent = new AddShadowEvent(Carbon::parse($initial), $event);
            $this->dispatch($addShadowEvent);
        }
    }

    /**
     * Generate weekly shadow events.
     * @param  Event $event
     * @return
     */
    private function generateWeekly(Event $event)
    {

        $start_date = $this->getStartDate($event);
        $today = $this->getToday($start_date);
        $end_date = $this->getEndDate($event, 'weeks', $this->duration['weekly']);
        $frequency = $this->validateFrequency($event->frequency);
        $weekDays = json_decode(($event->weekly_day_num));

        $start = $this->findShadowInRange(
            $start_date,
            $today->subWeeks($frequency),
            $today->addWeeks($frequency)
        );

        for ($initial = Carbon::parse($start);
             $initial->lte($end_date);
             $initial = $initial->addWeeks($frequency)) {
            for ($i = 1; $i < 8; $i++) {
                $day = Carbon::parse($initial)
                    ->subDays($initial->dayOfWeek)
                    ->addDays($i);

                if (in_array($day->dayOfWeek, $weekDays)
                    && $day->lte($end_date)
                    && $day->gte($start)) {
                    $day->hour = $start_date->hour;
                    $day->minute = $start_date->minute;
                    $addShadowEvent = new AddShadowEvent(Carbon::parse($day), $event);
                    $this->dispatch($addShadowEvent);
                }
            }
        }
    }

    /**
     * Generate monthly shadow events.
     *
     * @param  Event $event
     */
    private function generateMonthly(Event $event)
    {
        $start_date = $this->getStartDate($event);
        $end_date = $this->getEndDate($event, 'month', $this->duration['monthly']);
        $today = $this->getToday($start_date);
        $frequency = $this->validateFrequency($event->frequency);
        $weekDay = $event->recur_day;
        $week_in_month = (int) $event->monthly_day_num;
        $days_ahead = $event->days_before_event;


        $start = $this->findShadowInRange(
            $start_date,
            $today->subMonths($frequency),
            $today->addMonths($frequency)
        );

        for ($initial = Carbon::parse($start);
             $initial->lte($end_date);
             $initial = $initial->addMonths($frequency)) {
                $date_string = $this->order[$week_in_month] . ' ' .
                    $this->days[$weekDay] . ' ' .
                    $this->months[$initial->month] . ' ' .
                    $initial->year;
            $date = Carbon::parse($date_string);

            if ($date->gte($start) && $date->lte($end_date)) {
                $date->hour = $start_date->hour;
                $date->minute = $start_date->minute;

                if (!is_null($days_ahead) && $days_ahead > 0) {
                    for ($i = $days_ahead; $i >= 0; $i--) {
                        $ahead_date = Carbon::parse($date)->subDays($i);

                        $addShadowEvent = new AddShadowEvent($ahead_date, $event);
                        $this->dispatch($addShadowEvent);

                    }
                } else {
                    $addShadowEvent = new AddShadowEvent(Carbon::parse($date), $event);
                    $this->dispatch($addShadowEvent);
                }
            }
        }
    }

    /**
     * Generate yearly shadow events.
     *
     * @param  Event $event
     */
    private function generateYearly(Event $event)
    {
        $start_date = $this->getStartDate($event);
        $end_date = $this->getEndDate($event, 'year', $this->duration['yearly']);
        $today = $this->getToday($start_date);
        $frequency = $this->validateFrequency($event->frequency);

        $start = $this->findShadowInRange(
            $start_date,
            $today->subYears($frequency),
            $today->addYears($frequency)
        );

        for ($initial = Carbon::parse($start);
             $initial->lte($end_date);
             $initial = $initial->addYears($frequency)) {
            if ($initial->gte($start) && $initial->lte($end_date)) {
                $addShadowEvent = new AddShadowEvent(Carbon::parse($initial), $event);
                $this->dispatch($addShadowEvent);
            }
        }
    }
}
