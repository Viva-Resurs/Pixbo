<?php

namespace App\Models;

use App\Traits\HasEvents as HasEvents;
use Illuminate\Database\Eloquent\Model;

class Ticker extends Model
{
    use HasEvents;
    protected $table = 'tickers';

/**
 * The attributes that are mass assignable.
 * @var [type]
 */
    protected $fillable = [
        'text',
        'id',
    ];

    protected $touches = ['screengroups'];

    public function screengroups()
    {
        return $this->belongsToMany(ScreenGroup::class, 'screen_group_ticker')->withTimestamps();
    }

    public function event()
    {
        return $this->morphMany('\App\Models\Event', 'eventable');
    }
}
