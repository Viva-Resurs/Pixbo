<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Client
 *
 * @property integer $id
 * @property string $name
 * @property string $ip_address
 * @property integer $user_id
 * @property integer $screen_group_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\ScreenGroup $screengroup
 * @property-read \App\Models\User $user
 * @property-read mixed $activity
 * @property-read mixed $group
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Client whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Client whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Client whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Client whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Client whereScreenGroupId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Client whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Client whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
        'screen_group_id',
        'created_at',
        'updated_at',
        'activity',
    ];
    protected $appends = ['group'];
    /**
     * ScreenGroup association
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function screengroup()
    {
        return $this->belongsTo(ScreenGroup::class, 'screen_group_id');
    }
    /**
     * User association
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getActivityAttribute($value)
    {
        if (!is_null($value)) {
            $time = Carbon::now()->timestamp($value);
            return $time->diffForHumans();
        } else {
            return trans('messages.unknown');
        }
    }

    public function getGroupAttribute()
    {
        return $this->screengroup->name;
    }

    public function updateActivity()
    {
        $this->activity = time();
    }
}
