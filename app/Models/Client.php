<?php

namespace App\Models;

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
        'user_id',
        'screengroup_id',
        'created_at',
        'updated_at',
    ];

    protected $appends = ['activity'];

/**
 * ScreenGroup association
 *
 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
 */
    public function screengroup()
    {
        return $this->belongsTo(ScreenGroup::class);
    }

/**
 * User association
 *
 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
 */
    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }

    public function getActivityAttribute()
    {
        return $this->user->last_activity;
    }
}
