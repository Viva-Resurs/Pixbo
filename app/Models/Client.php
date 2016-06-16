<?php

namespace App\Models;

use Carbon\Carbon;
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
        'address',
        'screen_group_id',
        'activity',
        'user_id'
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
    
    public function getLastUpdated() {
        return $this->screengroup->updated_at->toDateTimeString();
    }

    public function getTickers() {
        return $this->screengroup->getActiveTickers();
    }
    
    public function getPhotos() {
        return $this->screengroup->getActivePhotos();
    }
}
