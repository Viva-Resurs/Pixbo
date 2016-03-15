<?php

namespace App\Models;

use App\Traits\HasEvents as HasEvents;
use Illuminate\Database\Eloquent\Model;

class Screen extends Model
{
    use HasEvents;
    /**
     * Database table
     * @var string
     */
    protected $table = 'screens';
    protected $touches = ['screengroups'];

/**
 * The attributes that are mass assignable.
 * @var [type]
 */
    protected $fillable = [
        'created_at',
        'updated_at',
    ];

    public static function boot() {
        parent::boot();

        Screen::deleting(function ($screen) {
            $event = $screen->event->first();
            $sgs = $screen->screengroups();
            if(!is_null($event))
                $event->delete();

            foreach($sgs as $sg) {
                $sg->screens()->detach($screen);
                $sg->touch();
            }

        });

        Screen::updating(function($screen) {
            foreach($screen->screengroups() as $sg) {
                $sg->touch();
            }
        });
}

/**
 * [screengroups description]
 * @return [type] [description]
 */
    public function screengroups()
    {
        return $this->belongsToMany(ScreenGroup::class, 'screen_screen_group')->withTimestamps();
    }

    public function photo()
    {
        return $this->hasOne(Photo::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'screen_tag')->withTimestamps();
    }
}
