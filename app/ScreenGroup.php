<?php

namespace App;

use App\Event;
use Auth;
use Illuminate\Database\Eloquent\Model;

class ScreenGroup extends Model
{
    /**
     * Database table
     * @var string
     */
    protected $table = 'screengroups';

/**
 * The attributes that are mass assignable.
 * @var [type]
 */
    protected $fillable = [
        'name',
        'desc',
        'rss_feed',
        'event_id',
        'user_id',
        'created_at',
        'updated_at',
    ];

    protected static function boot()
    {
    }

/**
 * Screen association
 * @return [type] [description]
 */
    public function screens()
    {
        return $this->belongsToMany('App\Screen', 'screen_screen_group')->withTimestamps();
    }

/**
 * Client association
 * @return [type] [description]
 */
    public function client()
    {
        return $this->hasMany('\App\Client');
    }

/**
 * User association
 * @return [type] [description]
 */
    public function user()
    {
        return $this->belongsTo('\App\User');
    }

/**
 * Event association
 * @return [type] [description]
 */
    public function event()
    {
        return $this->morphMany('\App\Event', 'eventable');
    }

    public function getEvent()
    {
        return Event::where([
            'eventable_type' => 'App\ScreenGroup',
            'eventable_id'   => $this->getAttribute('id'),
        ])->get()->first();
    }

    public function createAndReturnEvent()
    {
        $event = new Event;
        $event->fill([
            'eventable_id'   => $this->getAttribute('id'),
            'eventable_type' => 'App\ScreenGroup',
            'date'           => date('Y-m-d'),
            'start_time'     => '07:00',
            'end_time'       => '18:00',
            'recurring'      => false,
        ]);
        $this->event()->save($event);
        return $event;
    }

    public function assignIfNeeded($photo)
    {
        $screen = $photo->screen;

        if (!is_null($screen)) {
            if (!$screen->screengroups->contains($this->getAttribute('id'))) {
                $this->screens()->save($screen);
            }
        } else {
            $screen = new Screen;
            $screen->fill([
                'name'            => $photo->name,
                'screen_group_id' => $this->getAttribute('id'),
                'event_id'        => null,
                'user_id'         => Auth::user()->id,
            ]);
            $screen->save();
            $screen->photo()->save($photo);
            $this->screens()->attach($screen);
        }
    }
}

//$screengroup = App\ScreenGroup::create(['name' => 'SG1', 'desc' => 'test1', 'rss_feed' => 'bla', 'event_id' => 0, 'created_by' => 0]);

