<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Laravel CORS
    |--------------------------------------------------------------------------
    |
    | AllowedOrigins, allowedHeaders and allowedMethods can be set to array('*')
    | to accept any value, the allowed methods however have to be explicitly listed.
    |
    */
    'supportsCredentials' => true,
    'allowedOrigins' => ['http://localhost:8080'],
    'allowedHeaders' => ['*'],
    'allowedMethods' => ['GET', 'POST', 'PUT',  'DELETE'],
    'exposedHeaders' => [],
    'maxAge' => 0,
    'hosts' => [],
];
