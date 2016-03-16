# PHP Ratatxt

You can sign up for a Ratatxt account at http://ratatxt.com.

## Composer

You can install the bindings via [Composer](http://getcomposer.org/). Run the following command:

```bash
composer require ratatxt/php-sms
```

To use the bindings, use Composer's [autoload](https://getcomposer.org/doc/00-intro.md#autoloading):

```php
require_once('vendor/autoload.php');
```

## Manual Installation

If you do not wish to use Composer, you can download the [latest release](https://github.com/ratatxt/php-sms/releases). Then, to use the bindings, include the `init.php` file.

```php
require_once('/path/to/ratatxt-php-sms/init.php');
```

## Getting Started

Simple usage looks like:

```php
    Ratatxt\Sms::setToken('sampleToken');
    $send = Ratatxt\Sms::send(array(
        'origin' => '09353708662',
        'address' => '09353708663',
        'text' => 'hello from ratatxt'
    ));

    print_r($send);
```

## Documentation

Please see http://ratatxt.com/docs for up-to-date documentation.
