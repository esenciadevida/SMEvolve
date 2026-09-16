<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Analytics Configuration
    |--------------------------------------------------------------------------
    |
    | Google Analytics 4 is loaded from the server-side configuration only.
    | The measurement ID is never exposed to frontend tooling or committed to
    | source; it is read from the environment at runtime.
    |
    */

    'measurement_id' => env('GA_MEASUREMENT_ID'),

    /*
    | Analytics must only ever load on the production site so local, CI, and
    | staging activity is never sent to Google (and so obvious bot traffic is
    | not counted). Consent handling for visitors is a separate, later step.
    */
    'production_only' => true,
];
