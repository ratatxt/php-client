# php-sms

## usage

### sms send
```php
  Ratatxt\Sms::setToken('sampleToken');
  Ratatxt\Sms::send(array(
    'origin' => '09353708662',
    'address' => '09353708663',
    'text' => 'hello from ratatxt'
  ));
```
