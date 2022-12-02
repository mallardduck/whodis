# Whodis - Easy to use Whois client for PHP
# Danger: WIP - this project will eat your cat

[![Latest Version](https://img.shields.io/github/release/php-http/package.svg?style=flat-square)](https://github.com/mallardduck/whodis/releases)
[![Total Downloads](https://img.shields.io/packagist/dt/php-http/package.svg?style=flat-square)](https://packagist.org/packages/mallardduck/whodis)

## Purpose

A simple to use high-level Whois client for PHP.

## TODO Before V1
- Add result parsing features,
- Refactor lookup output to provide POPO of info,
- Allow output as plain text, or POPOs; maybe different methods?

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
$response = $whodis->lookup('danpock.me');
echo $response; // Prints the WHOIS results string, same as if you ran `whois danpock.me` in shell.
```

## Testing

``` bash
$ composer test
```


## Contributing

Please see our [contributing guide](http://docs.php-http.org/en/latest/development/contributing.html).


## Security

If you discover any security related issues, please contact us at [security@php-http.org](mailto:security@php-http.org).


## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
