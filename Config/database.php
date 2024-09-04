<?php

return [
    'connection' => [
        'default' => [
            'driver' => 'pdo_mysql',
            'charset' => 'utf8mb4',
            'host' => env('DB_MYSQL_HOST'),
            'port' => env('DB_MYSQL_PORT'),
            'username' => env('DB_MYSQL_USER'),
            'password' => env('DB_MYSQL_PASSWORD'),
            'database' => env('DB_MYSQL_DATABASE'),
        ],
        'test' => [
            'driver' => 'pdo_mysql',
            'charset' => 'utf8mb4',
            'host' => env('DB_MYSQL_HOST_TEST'),
            'port' => env('DB_MYSQL_PORT_TEST'),
            'username' => env('DB_MYSQL_USER_TEST'),
            'password' => env('DB_MYSQL_PASSWORD_TEST'),
            'database' => env('DB_MYSQL_DATABASE_TEST'),
        ]
    ]
];
