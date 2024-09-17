<?php

return [
    'connection' => [
        'default' => [
            'driver' => env('DB_DRIVER', 'pdo_pgsql'),
            'charset' => 'UTF8',
            'host' => env('DB_HOST'),
            'port' => env('DB_PORT'),
            'username' => env('DB_USER'),
            'password' => env('DB_PASSWORD'),
            'database' => env('DB_DATABASE'),
        ],
        'test' => [
            'driver' => env('DB_DRIVER_TEST', 'pdo_pgsql'),
            'charset' => 'UTF8',
            'host' => env('DB_HOST_TEST'),
            'port' => env('DB_PORT_TEST'),
            'username' => env('DB_USER_TEST'),
            'password' => env('DB_PASSWORD_TEST'),
            'database' => env('DB_DATABASE_TEST'),
        ]
    ]
];
