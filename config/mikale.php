<?php

return [
    'venue_latitude' => (float) env('VENUE_LATITUDE', 41.042200),
    'venue_longitude' => (float) env('VENUE_LONGITUDE', 29.006700),
    'max_distance_meters' => (float) env('VENUE_MAX_DISTANCE_METERS', 20.0),
    'gps_verification_enabled' => (bool) env('GPS_VERIFICATION_ENABLED', true),
    'token_expiration_minutes' => (int) env('QR_TOKEN_EXPIRATION_MINUTES', 240),
    'turnstile' => [
        'enabled' => (bool) env('TURNSTILE_ENABLED', true),
        'site_key' => env('TURNSTILE_SITE_KEY', '1x00000000000000000000AA'),
        'secret_key' => env('TURNSTILE_SECRET_KEY', '1x0000000000000000000000000000000AA'),
    ],
];
