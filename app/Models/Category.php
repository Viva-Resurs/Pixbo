<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function screens() {
        return $this->belongsToMany(Screen::class, 'category_screen')->withTimestamps();
    }

    public function addScreen(Screen $screen) {
        $this->screens()->attach($screen->id);
    }

    public function removeScreen(Screen $screen) {
        $this->screens()->detach($screen->id);
    }
}
