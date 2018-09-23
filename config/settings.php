<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],

        // Rebrandly API Settings
        'rebrandly' => [
            'url' => 'https://api.rebrandly.com/v1/links',
            'token' => '1977a75fd0a4401c914909505d2fe313'
        ],

        // Bitly API Settings
        'bitly' => [
            'url' => 'https://api-ssl.bitly.com/v4/shorten',
            'token' => 'Bearer 2dd5aa39f7cf3009aa1daa5f60fe9fc2691a9693'
        ],
    ],
];
