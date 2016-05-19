<?php

/**
 * Pixbo default settings, only used when setting up the database.
 */

$settings = [
    'admin' => [
        'username' => 'admin',
    ],
    'moderator' => [
        'username' => 'moderator',
    ],
    'domain' => config('app.domain')
];

return [
    'settings'=> [
        'administration' => [
            'administrator' => [
                'username' => $settings['admin']['username'],
                // Generated from the username, do not change.
                'password' => env('PIXBO_ADMIN_PASSWORD', $settings['admin']['username']),
                'email' => $settings['admin']['username'].'@'.$settings['domain']
            ],
            'moderator' => [
                'username' => $settings['moderator']['username'],
                // Generated from the username, do not change.
                'password' => env('PIXBO_MOD_PASSWORD', $settings['moderator']['username']),
                'email' => $settings['moderator']['username'].'@'.$settings['domain']
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