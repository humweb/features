

# Features Toggle

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[ ![Build Status](https://codeship.com/projects/79a7e160-fb9e-0132-e7f2-0ea73193a6c8/status?branch=master)](https://codeship.com/projects/87216)

Feature Toggle component.

## Install

Via Composer

``` bash
$ composer require humweb/features
```

## Usage

``` php
    $features = new Features();

    $features->create('testFeature', 'Feature test collection')
        ->add('StrategyKey', 'DataTime', [
                'start'  =>'2100-11-10',
                'end'    => '2100-12-10',
                'strict' => false
        ])
        ->setThreshold(1);
    
    if ($this->features->isEnabled('testFeature')) {
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

- [ryun](https://github.com/ryun)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.