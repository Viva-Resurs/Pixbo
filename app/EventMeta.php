<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Validator;

class EventMeta extends Model
{
    /**
     * Variables allowed to be mass assigned.
     * @var [array]
     */
    protected $fillable = [
        'frequency',
        'recur_type',
        'recur_day_num',
        'recur_day',
        'recur_end',
    ];

/**
 * Event Association.
 *
 * @return \Illuminate\Database\Eloquent\Relations\HasMany
 */
    public function events()
    {
        return $this->belongsTo('App\Event')->withTimestamps();
    }

/**
 * Takes the request array and sends it to the corresponding update method.
 *
 * @param  Array $request
 * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
 */
    public function decodeAndUpdate($request)
    {
        $validator = null;

        switch ($request['recur_type']) {
        case 'daily':
            $validator = $this->updateDaily($request);
            break;
        case 'weekly':
            $validator = $this->updateWeekly($request);
            break;
        case 'monthly':
            $validator = $this->updateMonthly($request);
            break;
        case 'yearly':
            $validator = $this->updateYearly($request);
            break;
        default:
            abort(500, trans('messages.unable_to_determ_recur_type'));
            break;
        }
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }
    }

/**
 * Validate and update the daily recurrence.
 *
 * @param  Array $request
 * @return $validator
 */
    private function updateDaily($request)
    {
        $validator = Validator::make($request, [
            'daily_end_type'       => 'required',
            'daily_frequency'      => 'required|integer',
            'daily_meta_recur_end' => 'required_if:daily_end_type,at',
        ]);
        $recur_end = null;
        if ($request['daily_end_type'] == 'at') {
            $recur_end = $request['daily_meta_recur_end'];
        }

        $this->update([
            'frequency'     => $request['daily_frequency'],
            'recur_type'    => 'daily',
            'recur_end'     => $recur_end,
            'recur_day_num' => null,
            'recur_day'     => null,
        ]);

        return $validator;
    }

/**
 * Validate and update weekly recurrence.
 *
 * @param  Array $request
 * @return $validator
 */
    private function updateWeekly($request)
    {
        $validator = Validator::make($request, [
            'weekly_end_type'       => 'required',
            'weekly_recur_day'      => 'required|array',
            'weekly_frequency'      => 'required|integer',
            'weekly_meta_recur_end' => 'required_if:weekly_end_type,at',

        ]);

        $recur_end = null;
        if ($request['weekly_end_type'] == 'at') {
            $recur_end = $request['weekly_meta_recur_end'];
        }

        $this->update([
            'frequency'     => $request['weekly_frequency'],
            'recur_type'    => 'weekly',
            'recur_day'     => serialize($request['weekly_recur_day']),
            'recur_end'     => $recur_end,
            'recur_day_num' => null,
        ]);

        return $validator;
    }

/**
 * Validate and update the monthly recurrence.
 *
 * @return $validator
 */
    private function updateMonthly($request)
    {
        $validator = Validator::make($request, [
            'monthly_end_type'       => 'required',
            'monthly_recur_day'      => 'required|integer',
            'monthly_frequency'      => 'required|integer',
            'monthly_recur_day_num'  => 'required|integer',
            'monthly_meta_recur_end' => 'required_if:weekly_end_type,at',

        ]);

        $recur_end = null;

        if ($request['monthly_end_type'] == 'at') {
            $recur_end = $request['monthly_meta_recur_end'];
        }

        $this->update([
            'frequency'     => $request['monthly_frequency'],
            'recur_type'    => 'monthly',
            'recur_day'     => $request['monthly_recur_day'],
            'recur_end'     => $recur_end,
            'recur_day_num' => $request['monthly_recur_day_num'],
        ]);

        return $validator;
    }

    private function updateYearly($request)
    {
        $validator = Validator::make($request, [
            'yearly_end_type'       => 'required',
            'yearly_frequency'      => 'required|integer',
            'yearly_meta_recur_end' => 'required_if:weekly_end_type,at',

        ]);

        $recur_end = null;

        if ($request['yearly_end_type'] == 'at') {
            $recur_end = $request['yearly_meta_recur_end'];
        }

        $this->update([
            'frequency'     => $request['yearly_frequency'],
            'recur_type'    => 'yearly',
            'recur_day'     => null,
            'recur_end'     => $recur_end,
            'recur_day_num' => null,
        ]);

        return $validator;
    }

    /****************************************************************
     *	Yearly														*
     *****************************************************************/

/**
 * Gets the Yearly end type attribute for the yearly form.
 *
 * @param  $value
 * @return String
 */
    public function getYearlyEndTypeAttribute($value)
    {
        if (!is_null($this->getAttribute('recur_end')) && $this->getAttribute('recur_type') == 'yearly') {
            return 'at';
        } else {
            return 'never';
        }
    }

/**
 * Gets the Yearly recurrence end attribute for the yearly form.
 *
 * @param  $value
 * @return Date or null
 */
    public function getYearlyMetaRecurEndAttribute($value)
    {
        if (!is_null($this->getAttribute('recur_end')) && $this->getAttribute('recur_type') == 'yearly') {
            return $this->getAttribute('recur_end');
        } else {
            return null;
        }
    }

/**
 * [getYearlyFrequencyAttribute description]
 *
 * @param  $value
 * @return Integer
 */
    public function getYearlyFrequencyAttribute($value)
    {
        if ($this->getAttribute('recur_type') == 'yearly') {
            return $this->getAttribute('frequency');
        } else {
            return 1;
        }
    }

    /****************************************************************
     *	Monthly														*
     *****************************************************************/

    public function getMonthlyFrequencyAttribute($value)
    {
        if ($this->getAttribute('recur_type') == 'monthly') {
            return $this->getAttribute('frequency');
        } else {
            return 1;
        }
    }

    public function getMonthlyRecurDayNumAttribute($value)
    {
        if ($this->getAttribute('recur_type') == 'monthly') {
            return $this->getAttribute('recur_day_num');
        } else {
            return null;
        }
    }

    public function getMonthlyRecurDayAttribute($value)
    {
        if ($this->getAttribute('recur_type') == 'monthly') {
            return $this->getAttribute('recur_day');
        } else {
            return null;
        }
    }

    public function getMonthlyEndTypeAttribute($value)
    {
        if (!is_null($this->getAttribute('recur_end')) && $this->getAttribute('recur_type') == 'monthly') {
            return 'at';
        } else {
            return 'never';
        }
    }

    public function getMonthlyMetaRecurEndAttribute($value)
    {
        if (!is_null($this->getAttribute('recur_end')) && $this->getAttribute('recur_type') == 'monthly') {
            return $this->getAttribute('recur_end');
        } else {
            return null;
        }
    }

    /****************************************************************
     *	Weekly														*
     *****************************************************************/

    public function getWeeklyFrequencyAttribute($value)
    {
        if ($this->getAttribute('recur_type') == 'weekly') {
            return $this->getAttribute('frequency');
        } else {
            return 1;
        }
    }

    public function getWeeklyRecurDayAttribute($value)
    {
        if ($this->getAttribute('recur_type') == 'weekly') {
            return unserialize($this->getAttribute('recur_day'));
        } else {
            return null;
        }
    }

    public function getWeeklyEndTypeAttribute($value)
    {
        if (!is_null($this->getAttribute('recur_end')) && $this->getAttribute('recur_type') == 'weekly') {
            return 'at';
        } else {
            return 'never';
        }
    }

    public function getWeeklyMetaRecurEndAttribute($value)
    {
        if (!is_null($this->getAttribute('recur_end')) && $this->getAttribute('recur_type') == 'weekly') {
            return $this->getAttribute('recur_end');
        } else {
            return null;
        }
    }

    /****************************************************************
     *	Daily														*
     *****************************************************************/

    public function getDailyFrequencyAttribute($value)
    {
        if ($this->getAttribute('recur_type') == 'daily') {
            return $this->getAttribute('frequency');
        } else {
            return 1;
        }
    }

    public function getDailyEndTypeAttribute($value)
    {
        if (!is_null($this->getAttribute('recur_end')) && $this->getAttribute('recur_type') == 'daily') {
            return 'at';
        } else {
            return 'never';
        }
    }

    public function getDailyMetaRecurEndAttribute($value)
    {
        if (!is_null($this->getAttribute('recur_end')) && $this->getAttribute('recur_type') == 'daily') {
            return $this->getAttribute('recur_end');
        } else {
            return null;
        }
    }
}
