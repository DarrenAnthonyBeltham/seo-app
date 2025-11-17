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

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'make_webhook' => [
        'url' => env('MAKE_WEBHOOK_URL', 'https://hook.eu2.make.com/tloehyubrkr5s3qjkw61w7494xikkdy7'),
        'api_key' => env('MAKE_WEBHOOK_API_KEY', 'dsay-apai-;:6Ums.E*h;^lj#T@Aikk/ue\\3r;}ISPL>h2q|"j8Q!Z4t%H_q@+z1`'),
    ],

];
