<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
        'name',
    ];

    public function screens()
    {
        return $this->belongsToMany(Screen::class, 'screen_tag');
    }
}
