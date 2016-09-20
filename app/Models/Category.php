<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Category extends Model
{
    
    protected $fillable = ['name'];

    /**
     * Boot method used to update associations depending on actions.
     *
     */
    public static function boot() {
        parent::boot();

        Category::deleting(function ($category) {

            foreach ( $category->screens as $screen ){
                $category->screens()->detach($screen->id);
                $screen->categories()->sync([1]);
            }

        });
    }

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

    public function isOwner(User $user) {
        return $user->id == $this->user_id;
    }

}
