<?php

/*
 * You can place your custom package configuration in here.
 */
return [

    'guards' => [
        'apikey' => [
            // access_token is what we defined inside Auth::extend
            // you can name this anything BUT should match with
            // Auth::extend('HERE');
            'driver' => 'api_key',
        ],
    ],
];
