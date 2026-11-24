<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Paystack, Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'paystack' => [
        'public_key' => env('PAYSTACK_PUBLIC_KEY'),
        'secret_key' => env('PAYSTACK_SECRET_KEY'),
        'payment_url' => env('PAYSTACK_PAYMENT_URL', 'https://api.paystack.co'),
    ],

    // Direct bank transfer details shown at checkout.
    'bank' => [
        'name' => env('BANK_NAME', 'Guaranty Trust Bank (GTBank)'),
        'account_number' => env('BANK_ACCOUNT_NUMBER', '0123456789'),
        'account_name' => env('BANK_ACCOUNT_NAME', '800BYPD Ltd'),
    ],

    // PD's Spotify channel. Paste the share links from Spotify
    // (e.g. https://open.spotify.com/show/... and https://open.spotify.com/episode/...).
    'spotify' => [
        'show_url' => env('SPOTIFY_SHOW_URL', 'https://open.spotify.com/show/3UMtHeHP6cM3YBaH6xtSoO'),
        'episode_url' => env('SPOTIFY_EPISODE_URL', 'https://open.spotify.com/episode/4G1tyUMLpBOFjdeCu1GH6X'),
    ],

];
