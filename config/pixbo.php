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
    ]
];

return [
    'settings'=> [
        'administration' => [
            'administrator' => [
                'username' => $settings['admin']['username'],
                // Generated from the username, do not change.
                'password' => env('PIXBO_ADMIN_PASSWORD', $settings['admin']['username']),
                'email' => $settings['admin']['username'].'@'.config('app.domain')
            ],
            'moderator' => [
                'username' => $settings['moderator']['username'],
                // Generated from the username, do not change.
                'email' => $settings['moderator']['username'].'@'.config('app.domain'),
                'password' => env('PIXBO_MOD_PASSWORD', $settings['moderator']['username']),
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