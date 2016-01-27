<?php

namespace App\Models;

use DB;
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
        'created_at',
        'updated_at',
    ];

/**
 * Screen association
 *
 * @return [type] [description]
 */
    public function screens()
    {
        return $this->belongsToMany(Screen::class, 'screen_screen_group')->withTimestamps();
    }

    public function tickers()
    {
        return $this->belongsToMany(Ticker::class, 'screen_group_ticker')->withTimestamps();
    }

/**
 * Client association
 * @return [type] [description]
 */
    public function client()
    {
        return $this->hasMany(Client::class);
    }

    public function assignOrCreateAndAssign($photo)
    {
        $screen = $photo->screen;

        if (!is_null($screen)) {
            if (!$screen->screengroups->contains($this->getAttribute('id'))) {
                $this->screens()->save($screen);
                return true;
            }
        } else {
            $result = DB::transaction(function () use ($photo) {

                $screen = new Screen;
                $screen->fill([
                    'name' => $photo->name,
                ]);
                $screen->save();
                //$event = $screen->createAndReturnEvent();
                //$event->createAndReturnMeta();
                $screen->photo()->save($photo);
                $this->screens()->attach($screen);
            });

            return $result;
        }
    }
}

//$screengroup = App\ScreenGroup::create(['name' => 'SG1', 'desc' => 'test1', 'rss_feed' => 'bla', 'event_id' => 0, 'created_by' => 0]);

