<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Screen extends Model
{
    use HasEvents;
    /**
     * Database table
     * @var string
     */
    protected $table = 'screens';

/**
 * The attributes that are mass assignable.
 * @var [type]
 */
    protected $fillable = [
        'name',
        'scheduled',
        'photo_id',
        'created_at',
        'updated_at',
    ];

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
}
