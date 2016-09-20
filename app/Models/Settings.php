<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Settings extends Model
{

    protected $table = 'settings';

    protected $fillable = ['vegas_delay', 'ticker_pauseOnItems', 'vegas_timer'];
    
    protected $hidden = ['id', 'created_at', 'updated_at'];

    public static function getSettings() {

        $settings = Settings::first();
        
        $rawSettings = $settings->getAttributes();
        
        $vegas = [];
        $ticker = [];
        
        foreach ($rawSettings as $key => $value) {
            $keys = explode('_', $key);

            if ($keys[0]=='vegas')
                $vegas[$keys[1]] = $value;
            
            else if ($keys[0]=='ticker')
                $ticker[$keys[1]] = $value;
        }

        return [ 'vegas' => $vegas, 'ticker' => $ticker, 'updated' => $settings->updated_at ];
    }

}
