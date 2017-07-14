<?php

return [
    /**
     * Api key
     */
    'api_key' => env('API_KEY') ?? 'test',
    
    'base_uri' => 'http://testapi.com',

    'account' => 'fenix007',
    
    /**
     * Client options
     */
    'options' => [
        /**
         * Use https
         */
        'secure' => true,
        
        /*
         * Cache
         */
        'cache' => [
            'enabled' => true,
            // Keep the path empty or remove it entirely to default to storage/apiwrapper
            'path' => storage_path('apiwrapper')
        ],
        
        /*
         * Log
         */
        'log' => [
            'enabled' => true,
            // Keep the path empty or remove it entirely to default to storage/logs/apiwrapper.log
            'path' => storage_path('logs/apiwrapper.log')
        ]
    ],
    'headers' => [
        'Referer' => 'http://testapi.com/',
        'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/57.0.2987.133 Safari/537.36',
        'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
        'Accept-Language' => 'ru-RU,ru;q=0.8,en-US;q=0.6,en;q=0.4',
    ]
];
