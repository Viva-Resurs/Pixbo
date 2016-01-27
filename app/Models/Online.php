<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Session;

class Online extends Model
{
    public $table = 'sessions';

    public $timestamps = false;

    public function scopeGuests($query)
    {
        return $query->whereNull('user_id');
    }

    public function scopeRegistered($query)
    {
        return $query->whereNotNull('user_id')->with('user');
    }

    public function scopeUpdateCurrent($query)
    {
        //dd([Session::getId(), Auth::check(), Auth::user()]);
        return $query->where('id', Session::getId())->update(array('user_id' => Auth::check() ? Auth::user()->id : null));
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
