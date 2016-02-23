<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Feature Flags
    |--------------------------------------------------------------------------
    |
    | Here you may configure feature flags. You may set a default and / or
    | include environment specific (e.g. dev, stage, production) settings.
    |
    */

    'feature-1' => [
        'environments' => [
            'default'  => false,
            'local'    => true,
            'dev'      => false,
            'stage'    => false
        ],
        'js_export'    => true,
    ],

    'feature-2' => [
        'environments'   => [
            'default'    => false,
            'production' => true,
        ],
        'js_export'      => true,
    ],

    'feature-3' => [
        'environments' => [
            'default'  => false,
            'production'    => true,
        ],
    ],

];
