<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\HasEvents;


class Ticker extends Model
{

    use HasEvents;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'ticker';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'text',
        'id',
    ];

    protected $touches = ['screengroups'];

    /**
     * ScreenGroup association
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function screengroups()
    {
        return $this->belongsToMany(ScreenGroup::class, 'screengroup_ticker')->withTimestamps();
    }

}
