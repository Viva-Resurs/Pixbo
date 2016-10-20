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
                'password' => env('PIXBO_ADMIN_PASSWORD', 'admin'),
                'email' => 'admin@viva.se'
            ],
            'moderator' => [
                'username' => 'moderator',
                // Generated from the username, do not change.
                'password' => env('PIXBO_MOD_PASSWORD', 'moderator'),
                'email' => 'moderator@viva.se'
            ]

        ],

        'category' => [
            'default_name' => "Ej schemalagda"
        ],

        'screengroup' => [
            'dummy_name' => "Dummy"
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