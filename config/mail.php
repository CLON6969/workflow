<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Mailer
    |--------------------------------------------------------------------------
    */
    'default' => env('MAIL_MAILER', 'smtp'),

    /*
    |--------------------------------------------------------------------------
    | Mailer Configurations
    |--------------------------------------------------------------------------
    */
    'mailers' => [

        /*
        |--------------------------------------------------------------------------
        | DEFAULT SMTP (SWITCHED BY PROVIDER)
        |--------------------------------------------------------------------------
        */
        'smtp' => [
            'transport' => 'smtp',
            'host' => env('MAIL_PROVIDER') === 'gmail'
                ? env('GMAIL_HOST')
                : env('HOSTINGER_HOST'),

            'port' => env('MAIL_PROVIDER') === 'gmail'
                ? env('GMAIL_PORT')
                : env('HOSTINGER_PORT'),

            'encryption' => env('MAIL_PROVIDER') === 'gmail'
                ? env('GMAIL_ENCRYPTION')
                : env('HOSTINGER_ENCRYPTION'),

            'username' => env('MAIL_PROVIDER') === 'gmail'
                ? env('GMAIL_USERNAME')
                : env('HOSTINGER_SUPPORT_USERNAME'),

            'password' => env('MAIL_PROVIDER') === 'gmail'
                ? env('GMAIL_PASSWORD')
                : env('HOSTINGER_SUPPORT_PASSWORD'),

            'timeout' => null,
            'auth_mode' => null,
        ],

        /*
        |--------------------------------------------------------------------------
        | SUPPORT MAILER
        |--------------------------------------------------------------------------
        */
        'support' => [
            'transport' => 'smtp',
            'host' => env('MAIL_PROVIDER') === 'gmail'
                ? env('GMAIL_HOST')
                : env('HOSTINGER_HOST'),

            'port' => env('MAIL_PROVIDER') === 'gmail'
                ? env('GMAIL_PORT')
                : env('HOSTINGER_PORT'),

            'encryption' => env('MAIL_PROVIDER') === 'gmail'
                ? env('GMAIL_ENCRYPTION')
                : env('HOSTINGER_ENCRYPTION'),

            'username' => env('MAIL_PROVIDER') === 'gmail'
                ? env('GMAIL_USERNAME')
                : env('HOSTINGER_SUPPORT_USERNAME'),

            'password' => env('MAIL_PROVIDER') === 'gmail'
                ? env('GMAIL_PASSWORD')
                : env('HOSTINGER_SUPPORT_PASSWORD'),
        ],

        /*
        |--------------------------------------------------------------------------
        | SALES MAILER
        |--------------------------------------------------------------------------
        */
        'sales' => [
            'transport' => 'smtp',
            'host' => env('MAIL_PROVIDER') === 'gmail'
                ? env('GMAIL_HOST')
                : env('HOSTINGER_HOST'),

            'port' => env('MAIL_PROVIDER') === 'gmail'
                ? env('GMAIL_PORT')
                : env('HOSTINGER_PORT'),

            'encryption' => env('MAIL_PROVIDER') === 'gmail'
                ? env('GMAIL_ENCRYPTION')
                : env('HOSTINGER_ENCRYPTION'),

            'username' => env('MAIL_PROVIDER') === 'gmail'
                ? env('GMAIL_USERNAME')
                : env('HOSTINGER_SALES_USERNAME'),

            'password' => env('MAIL_PROVIDER') === 'gmail'
                ? env('GMAIL_PASSWORD')
                : env('HOSTINGER_SALES_PASSWORD'),
        ],

        'log' => [
            'transport' => 'log',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Global "From" Address
    |--------------------------------------------------------------------------
    */
    'from' => [
        'address' => env('MAIL_FROM_ADDRESS'),
        'name' => env('MAIL_FROM_NAME'),
    ],
];
