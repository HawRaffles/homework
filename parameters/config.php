<?php

return [
    'timeout' => 6,
    'responses' => [
        200 => true,
        301 => true,
        302 => true,
        404 => true
    ],
    'ua' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (HTML, like Gecko) Chrome/63.0.3239.84 Safari/537.36',
    'datafile' => __DIR__ . '/../storage/data.json',
    'log' => [
        'type' => [
            'error' => __DIR__ . '/../log/error.log',
            'warning' => __DIR__ . '/../log/warning.log',
            'info' => __DIR__ . '/../log/info.log',
        ],
        'channel' => 'general'
    ]
];