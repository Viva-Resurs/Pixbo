<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Category extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'category';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * User association
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo(User::class);
    }

    /**
     * Screen association
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function screens() {
        return $this->belongsToMany(Screen::class, 'category_screen')->withTimestamps();
    }

    public function isOwner(User $user) {
        return $user->id == $this->user_id;
    }

}
