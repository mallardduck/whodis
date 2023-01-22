# Whodis - Easy to use Whois client for PHP

[![Source Code](https://img.shields.io/static/v1?label=source&message=mallardduck/whodis&color=blue&style=for-the-badge)](https://packagist.org/packages/mallardduck/whodis)
[![License](https://img.shields.io/packagist/l/mallardduck/whodis?style=for-the-badge)](https://packagist.org/packages/mallardduck/whodis)
[![PHP Version](https://img.shields.io/packagist/php-v/mallardduck/whodis.svg?style=for-the-badge)](https://packagist.org/packages/mallardduck/whodis)
[![Latest Stable Version](https://img.shields.io/packagist/v/mallardduck/whodis?logo=packagist&label=Release&style=for-the-badge)](https://packagist.org/packages/mallardduck/whodis)
[![Total Download Count](https://img.shields.io/packagist/dt/mallardduck/whodis?logo=packagist&style=for-the-badge)](https://packagist.org/packages/mallardduck/whodis/stats)

## Purpose

A simple to use high-level Whois client for PHP.

## Requirements
* PHP >= 8.0

## Installation
The best installation method is to simply use composer.

https://packagist.org/packages/mallardduck/whodis

### Stable version

```bash
composer require mallardduck/whodis
```

## Example Usage
```php
require __DIR__ . '/vendor/autoload.php';

use MallardDuck\Whodis\Whodis;

$whodis = new Whodis();
$response = $whodis->lookup('danpock.me', fullResults: true);
echo $response; // Prints WHOIS results identical to running `whois danpock.me` in shell*.
```

> * = Varies based on CLI `whois` client, docs assume your client matches BSD `whois` which provides recursive results by default.

## Testing

``` bash
$ composer test
```

> Note: Due to how fast PHP tests run false-negatives can spawn. Whois servers may disconnect during a test resulting in empty response and failing tests.

## TODO Before V2
- Add result parsing features,
- Refactor lookup output to provide POPO of info,
- Allow output as plain text, or POPOs; maybe different methods?

## Contributing

Please see our [contributing guide](http://docs.php-http.org/en/latest/development/contributing.html).


## Security

If you discover any security related issues, please contact us at [security@php-http.org](mailto:security@php-http.org).


## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
