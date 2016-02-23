# Laravel Feature Flag

## Installation

Add the package to your project:

```
composer require kirschbaum/laravel-feature-flag
```

Add the following service provider:

```php
// config/app.php

'providers' => [
    ...
    Kirschbaum\LaravelFeatureFlag\ServiceProvider::class,
    ...
];
```

This package also comes with a facade, making it easy to retrieve the correct flags for the environment you are in:

```php
// config/app.php

'aliases' => [
    ...
    'FeatureFlag' => Kirschbaum\LaravelFeatureFlag\Facades\FeatureFlag::class,
    ...
]
```

Publish the config file using the arisan command:

```
php artisan vendor:publish --provider="Kirschbaum\LaravelFeatureFlag\ServiceProvider"
```

The configuration looks like this:

```php
<?php

return [

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

];
```

## Usage

General PHP use:

```php
if(FeatureFlag::isEnabled('feature-1'))
{
    // Only do stuff if feature is enabled.
}
```

If you need to pass your feature flags to a front-end JS framework like Angular or Vue.js, you can do so by using the getJavascriptFlags() method:

```php
$js->put(
            [
                'pusher_public_key' => env('PUSHER_PUBLIC'),
                'feature_flags'     => FeatureFlag::getJavascriptFlags()
            ]
        );
```

Because not all feature flags should be passed to the front-end, only features with the setting 'js_export = true' will be included. The end result is a simple array of features with the correct flags for the environment:

```php
array:2 [▼
  "feature-1" => true
  "feature-2" => false
]
```
