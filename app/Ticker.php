<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticker extends Model
{
    protected $table = 'tickers';

/**
 * The attributes that are mass assignable.
 * @var [type]
 */
    protected $fillable = [
        'text',
        'id',
    ];

    public function screengroup()
    {
        return $this->belongsTo(App\ScreenGroup::class);
    }
}
