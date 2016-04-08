<?php //-->

include_once '../init.php';

// NOTE this assumes that your phone already connected

// dev mode
Ratatxt\Sms::setHost('http://api.ratatxt.dev');
// set token
// NOTE get your token on dashboard
Ratatxt\Sms::setToken('key_MS5kZjEwYWQzOTdkZTYyMzRhZmI3NWY5MzM5OTk4NGRmYjM3YjA5OTkz');

// send a message
try {
    $send = Ratatxt\Sms::send(array(
        // sender number
        // NOTE you can have multiple origins. check you origins on dashboard
        'origin' => '639353708667',
        // receiver number
        'address' => '09353708662',
        // text message
        'text' => 'hello from ratatxt'
    ));

    print_r($send);
} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}

// getting new message
try {
    // NOTE this will only get new messages.
    $get = Ratatxt\Sms::get();
    print_r($get);
} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}
