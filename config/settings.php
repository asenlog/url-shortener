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

        // Cache Settings
        'fileAdapterCache' => [
            'namespace' => 'api.fileAdapter.cache',
            'expires' => '3600',  //1 hour,
            'dir' =>  __DIR__ . '/../cache'
        ],

        // Rebrandly API Settings
        'rebrandly' => [
            'url' => 'https://api.rebrandly.com/v1/links',
            'token' => ''
        ],

        // Bitly API Settings
        'bitly' => [
            'url' => 'https://api-ssl.bitly.com/v4/shorten',
            'token' => ''
        ],
    ],
];
