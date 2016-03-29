<?php

/**
 * Pixbo default settings, only used when setting up the database.
 */

return [
    'settings'=> [
        'administration' => [
            'administrator' => [
                'username' => 'admin',
                // Generated from the username, do not change.
                'password' => env('PIXBO_ADMIN_PASSWORD', config('pixbo.settings.administration.administrator.username')),
                'email' => config('pixbo.settings.administration.administrator.username').'@'.config('app.domain'),
            ],
            'moderator' => [
                'username' => 'moderator',
                // Generated from the username, do not change.
                'email' => config('pixbo.settings.administration.moderator.username').'@'.config('app.domain'),
                'password' => env('PIXBO_MOD_PASSWORD', config('pixbo.settings.administration.administrator.username')),
            ]

        ],

        'player' => [
            'ticker' => [
                'pauseOnItems' => 5000
            ],
            'vegas' => [
                'delay' => 10000
            ]
        ],
    ]
];