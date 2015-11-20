<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventMeta extends Model
{
    use HasMetaForm;
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

    protected $touches = ['events'];

/**
 * Event Association.
 *
 * @return \Illuminate\Database\Eloquent\Relations\HasMany
 */
    public function events()
    {
        return $this->belongsTo(Event::class);
    }

    public function scopeOfEvent($query, $id)
    {
        return $query->where('event_id', $id);
    }
}
