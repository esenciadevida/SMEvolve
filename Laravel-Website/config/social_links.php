<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Social Links
    |--------------------------------------------------------------------------
    |
    | Only platforms SMEvolve actively uses should be enabled. Each entry:
    | - platform: unique key
    | - label: accessible name
    | - href: profile URL (null until confirmed)
    | - enabled: whether to display
    |
    */

    'platforms' => [
        ['platform' => 'linkedin', 'label' => 'LinkedIn', 'href' => null, 'enabled' => false],
        ['platform' => 'facebook', 'label' => 'Facebook', 'href' => null, 'enabled' => false],
        ['platform' => 'instagram', 'label' => 'Instagram', 'href' => null, 'enabled' => false],
        ['platform' => 'x', 'label' => 'X (Twitter)', 'href' => null, 'enabled' => false],
    ],
];
