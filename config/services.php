<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'google' => [
        'client_id' => '555021309918-dheuvp6l095sg717ugk7rplukdfe3st9.apps.googleusercontent.com',
        'client_secret' => 'hteZMmVhrm2xVlMjtRgmXZB0',
        'redirect' => 'http://eshop.vn/admin/google/callback' 

    ],
    'facebook' => [
        'client_id' => '369884351100888',  //client face của bạn
        'client_secret' => '4177f5fec5391b8f22175e4ff57eb43d',  //client app service face của bạn
        'redirect' => 'http://eshop.vn/admin/facebook/callback' //callback trả về
    ],


];
