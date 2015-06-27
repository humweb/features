

# Features Toggle

[![Build Status](https://img.shields.io/travis/humweb/features/master.svg?style=flat-square)](https://travis-ci.org/humweb/features)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/humweb/features/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/humweb/features/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/humweb/features/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/humweb/features/?branch=master)
[![Total Downloads](https://img.shields.io/packagist/dt/humweb/features.svg?style=flat-square)](https://packagist.org/packages/humweb/features)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/humweb/features.svg?style=flat-square)](https://packagist.org/packages/humweb/features)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)


Feature Toggle allows developers to toggle on/off features in the system using one or multiple Strategies.

## Install

Via Composer

``` bash
$ composer require humweb/features
```

## Usage

``` php
$features = new Features();

$features->create('test.feature', 'Example feature description')
    ->add('StrategyKeyString', 'DataTime', [
            'start'  =>'2100-11-10',
            'end'    => '2100-12-10',
            'strict' => false
    ])
    ->setThreshold(1);

if ($features->isEnabled('testFeature')) {
    // Do something special
});

```

``` php
$features = new Features();

$features->create('business.hours', 'Match days of week')
    ->add('StrategyKeyString', 'DaysOfWeek', [
            'days' => ['wed', 'thu', 'fri']
    ])
    ->add('StrategyKeyString', 'DataTime', [
            'start'  =>'9pm',
            'end'    => '5pm',
            'strict' => true
    ])
    ->setThreshold(2);
    
if ($features->isEnabled('business.hours')) {
    // Do something special
});

```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email ryun@humboldtweb.com instead of using the issue tracker.

## Credits

- [Ryan Shofner (Maintainer)](https://github.com/ryun)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.