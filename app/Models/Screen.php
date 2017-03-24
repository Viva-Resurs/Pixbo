<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\HasEvents;


class Screen extends Model
{

    use HasEvents;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'screen';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'created_at',
        'updated_at',
    ];

    protected $touches = ['screengroups'];

    /**
     * ScreenGroup association
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function screengroups()
    {
        return $this->belongsToMany(ScreenGroup::class, 'screengroup_screen')->withTimestamps();
    }

    /**
     * Photo association
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function photo()
    {
        return $this->hasOne(Photo::class);
    }

    /**
     * Category association
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_screen')->withTimestamps();
    }

}
