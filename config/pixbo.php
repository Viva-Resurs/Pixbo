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
    'domain' => "viva.se", // config('app.domain') Server can´t get this?
    'default_category_name' => "Ej schemalagda",
    'default_screengroup_dummy_name' => "Dummy"
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

        'category' => [
            'default_name' => $settings['default_category_name']
        ],

        'screengroup' => [
            'dummy_name' => $settings['default_screengroup_dummy_name']
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