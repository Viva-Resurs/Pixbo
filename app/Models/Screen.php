<?php

namespace App\Models;

use App\Traits\HasEvents;
use Illuminate\Database\Eloquent\Model;

class Screen extends Model
{
    use HasEvents;
    protected $table = 'screens';
    protected $touches = ['screengroups'];

    protected $fillable = [
        'created_at',
        'updated_at',
    ];

    /**
     * Boot method used to update associations depending on actions.
     *
     */
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
     * ScreenGroup association
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function screengroups()
    {
        return $this->belongsToMany(ScreenGroup::class, 'screen_screen_group')->withTimestamps();
    }

    /**
     * Photo association
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function photo()
    {
        return $this->hasOne(Photo::class);
    }

    /**
     * Tag association
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_screen')->withTimestamps();
    }
}
