<?php

return [
    'api_site_key'                 => env('RECAPTCHA_SITE_KEY', ''),
    'api_secret_key'               => env('RECAPTCHA_SECRET_KEY', ''),
    'min_score'                    => env('RECAPTCHA_MIN_SCORE', 0),
];
