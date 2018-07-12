# php-bitstamp-api
A PHP implementation of the Bitstamp API

## Requirements
- php: ^5.6 || ^7.0
- paragonie/random_compat: >=2
- guzzlehttp/guzzle: ^6.3

## Installation
Using Composer
```
composer require jkosmetos/php-bitstamp-api
```
## Examples
The API `KEY` and `SECRET` can be obtained via your Bitstamp profile.

#### Public Methods
```php
$client = new Client();
$pairs = $client->getTradingPairsInfo();

var_dump($pairs);
```
## Coming soon
 - Private methods
 - More examples
 - Unit tests
 - Better documentation

## Authors

* **John Kosmetos** - [jkosmetos](https://github.com/jkosmetos)

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details
