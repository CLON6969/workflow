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


    /*
    |--------------------------------------------------------------------------
    | social auth Providers
    |--------------------------------------------------------------------------
    */


'google' => [
    'client_id' => env('GOOGLE_CLIENT_ID'),
    'client_secret' => env('GOOGLE_CLIENT_SECRET'),
    'redirect' => env('GOOGLE_REDIRECT_URI'),
],

'facebook' => [
    'client_id' => env('FACEBOOK_CLIENT_ID'),
    'client_secret' => env('FACEBOOK_CLIENT_SECRET'),
    'redirect' => env('FACEBOOK_REDIRECT_URI'),
],

// Twitter/X uses 'twitter' key in config/services.php (OAuth 1.0a or 2.0)
'twitter' => [
    'client_id' => env('TWITTER_CLIENT_ID'),
    'client_secret' => env('TWITTER_CLIENT_SECRET'),
    'redirect' => env('TWITTER_REDIRECT_URI'),
],

// Apple **NOT** built-in; requires package: composer require socialiteproviders/apple
// Then extend in AppServiceProvider::boot() (Laravel 11+) or EventServiceProvider.php (older):
// Event::listen(function (\SocialiteProviders\Manager\SocialiteWasCalled $event) {
//     $event->extendSocialite('apple', \SocialiteProviders\Apple\Provider::class);
// });
'apple' => [
    'client_id' => env('APPLE_CLIENT_ID'),
    'client_secret' => env('APPLE_CLIENT_SECRET'),
    'redirect' => env('APPLE_REDIRECT_URI'),
],



    /*
    |--------------------------------------------------------------------------
    | Mobile Money Providers
    |--------------------------------------------------------------------------
    */


    

'zamtel' => [
    'base_url'        => env('ZAMTEL_BASE_URL'),
    'third_party_id'  => env('ZAMTEL_THIRD_PARTY_ID'),
    'password'        => env('ZAMTEL_PASSWORD'),
    'shortcode'       => env('ZAMTEL_SHORTCODE'),

    // Security
    'callback_secret' => env('ZAMTEL_CALLBACK_SECRET'),
    'allowed_ips'     => env('ZAMTEL_ALLOWED_IPS'),

    // Sandbox
    'sandbox'         => env('ZAMTEL_SANDBOX', false),
],



];
