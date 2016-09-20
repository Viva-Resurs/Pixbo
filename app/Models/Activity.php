<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{

    protected $table = 'activity_log';

    /**
     * User association
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
