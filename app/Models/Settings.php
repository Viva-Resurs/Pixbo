<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    protected $table = 'settings';

    /**
     * The attributes that are mass assignable.
     *
     * @var arrayP
     */
    protected $fillable = ['vegas_delay', 'ticker_pauseOnItems'];
    protected $hidden = ['id', 'created_at', 'updated_at'];

    public static function getSettings() {
        $rawSettings = Settings::first()->get()->toArray();
        $keys = array_keys($rawSettings[0]);
        $settings = array();

        foreach ($rawSettings as $k => $val) {
            foreach ($val as $key => $value)
            {
                $keys = explode('_', $key);

                if ($keys[0]=='vegas') {
                    $branch = array($keys[1] => $value);
                    $settings[] = array('vegas' => $branch);
                }
                else if($keys[0]=='ticker') {
                    $branch = array($keys[1] => $value);
                    $settings[] = array('ticker' => $branch);
                }
            }
        }
        return $settings;
    }
}
