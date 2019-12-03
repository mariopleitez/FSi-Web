<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\Models\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'facebook' => [
        'client_id' => '150996382280278',
        'client_secret' => 'd8bdd558329fac57886807e100c1fb7e',
        'redirect' => 'http://50.18.144.251/demos/funda-sierra/public/auth/facebook/callback',
    ],

    'twitter' => [
        'client_id' => 'VXzeyOEO447Zs3w6WGF2psUeD',
        'client_secret' => 'vuGfsdpJaBQ8hEJz2i2zG7ZN0wv2VlLeL2OHy9EzU54v6BPfJZ',
        'redirect' => 'http://50.18.144.251/demos/funda-sierra/public/auth/twitter/callback',
    ],

    'google' => [
        'client_id' => '188669778006-gsclenf6ro4a946evi184jcf6gs7itu8.apps.googleusercontent.com',
        'client_secret' => '1Ub15g5UAEF6p5iBV71sXTLn',
        'redirect' => 'http://fundasierra.test/auth/google/callback',
    ],

    'onesignal' => [
        'app_id' => env('ONESIGNAL_APP_ID'),
        'rest_api_key' => env('ONESIGNAL_REST_API_KEY')
    ],

];
