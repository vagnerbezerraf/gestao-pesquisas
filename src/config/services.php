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
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    // SendPulse SMTP email service
    'sendpulse' => [
        'user_id'      => env('SENDPULSE_USER_ID'),
        'secret'       => env('SENDPULSE_SECRET'),
        'sender_name'  => env('SENDPULSE_SENDER_NAME'),
        'sender_email' => env('SENDPULSE_SENDER_EMAIL'),
        'storage_path' => env('SENDPULSE_STORAGE_PATH', storage_path('app/sendpulse.json')),
    ],

];
