<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;


class Client extends Model
{
    /**
     * Table name of model.
     * @var string
     */
    protected $table = 'clients';
    /**
     * [$fillable variables allowed for massallocation]
     * @var [String]
     */
    protected $fillable = [
        'name',
        'ip_address',
        'screen_group_id',
        'activity',
    ];
    protected $appends = ['group'];
    /**
     * ScreenGroup association
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function screengroup()
    {
        return $this->belongsTo(ScreenGroup::class, 'screen_group_id');
    }
    /**
     * User association
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getActivityAttribute($value)
    {
        if (!is_null($value)) {
            $time = Carbon::now()->timestamp($value);
            return $time->diffForHumans();
        } else {
            return trans('messages.unknown');
        }
    }

    public function getGroupAttribute()
    {
        return $this->screengroup->name;
    }

    public function updateActivity()
    {
        $this->activity = time();
    }

    public function getData() {

        $screengroup = $this->screengroup;
        $screens     = $screengroup->screens->keyBy('id');
        $tickers     = $screengroup->tickers->keyBy('id');

        $screens = $screens->load(['event', 'event.shadow_events']);
        $tickers = $tickers->load(['event', 'event.shadow_events']);

        //$se = $screengroup->shadow_events()->now()->get();

        /*
        $photos = $screens->map(function ($screen) {
            $event = $screen->event->first()->shadow_events()->now()->get();
            if(!$event->isEmpty()) {
                $photo = $screen->photo;
                return collect(['image' => $photo->pluck('path')]);
            }
        });
*/
        // Get the images from the available screens
        $photo_list = [];
        foreach($screens as $screen) {
            $event = $screen->event->first();
            $se = $event->shadow_events()->now()->get();
            if(!$se->isEmpty()) {
                $photo = $screen->photo;
                $photo_list[] = [
                    'image' => $photo->path
                ];
            }
        }

        // Get the available tickers
        $ticker_list = [];
        foreach($tickers as $ticker) {
            $event = $ticker->event->first();
            $se = $event->shadow_events()->now()->get();
            if(!$se->isEmpty()) {
                $ticker_list[] = [
                    'text' => $ticker->text
                ];
            }
        }

        // Get settings
        //$settings = Config::get('app.player');
        $settings = Settings::getSettings();

        return [
            'photo_list' => $photo_list,
            'tickers'    => $ticker_list,
            'updated_at' => $screengroup->updated_at->toDateTimeString(),
            'settings'   => $settings,
            'reboot'     => true
        ];
    }
}
