<?php

return [

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

    'guards' => [
        // 'web' => [
        //     'driver' => 'session',
        //     'provider' => 'users',
        // ],

        // 'api' => [
        //     'driver' => 'token',
        //     'provider' => 'users',
        //     'hash' => false,
        // ],
        'customer' => [
            'driver' => 'session',
            'provider' => 'customers'
        ],
        'technicain' => [
            'driver' => 'session',
            'provider' => 'technicains'
        ],
        'employee' => [
            'driver' => 'session',
            'provider' => 'employees'
        ]
    ],

    'providers' => [
        // 'users' => [
        //     'driver' => 'eloquent',
        //     'model' => App\Models\User::class,
        // ],
        'customers' => [
            'driver' => 'eloquent',
            'model' => App\Models\Customer::class,
        ],
        'technicains' => [
            'driver' => 'eloquent',
            'model' => App\Models\Technicain::class,
        ],
        'employees' => [
            'driver' => 'eloquent',
            'model' => App\Models\Employee::class,
        ],

        // 'users' => [
        //     'driver' => 'database',
        //     'table' => 'users',
        // ],
    ],

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,

];