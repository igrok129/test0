<?php

return [
    'countries' => [
        'base_uri' => env('COUNTRIES_API_VALIDATION_BASE_URI', 'https://restcountries.com'),
        'version'  => env('COUNTRIES_API_VALIDATION_VERSION', 'v3.1'),
        'methods'  => ['list' => 'all'],
    ],

    'timezones' => [
        'base_uri' => env('TIMEZONES_API_VALIDATION_BASE_URI', 'https://worldtimeapi.org'),
        'methods'  => ['list' => 'api/timezone'],
    ],
];
