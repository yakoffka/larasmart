<?php

return [
    'user' => [
        'name' => env('USER_NAME', 'admin'),
        'email' => env('USER_EMAIL', 'example@site.com'),
        'password' => env('USER_PASSWORD', '11111111'),
    ],
    'device' => [
        'type' => env('TYPE_DEVICE', 'File'),
    ]
];
