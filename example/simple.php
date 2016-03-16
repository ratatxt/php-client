<?php //-->

include_once '../init.php';

// NOTE this assumes that your phone already connected

// dev mode
Ratatxt\Sms::setHost('http://api.ratatxt.dev');
// set token
// NOTE get your token on dashboard
Ratatxt\Sms::setToken('eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9zbXMuZmx1dHRydGV4dC5jb20ucGgiLCJhdWQiOiJodHRwOlwvXC9hcHAuZmx1dHRydGV4dC5jb20ucGgiLCJpYXQiOjEzNTY5OTk1MjQsIm5iZiI6MTM1NzAwMDAwMCwidXNlciI6eyJpZCI6Miwicm9sZV9pZCI6MSwibmFtZSI6InRlc3QiLCJlbWFpbCI6InRlc3RAb3Blbm92YXRlLmNvbSIsImNyZWF0ZWRfYXQiOiIyMDE2LTAxLTMxIDA5OjU3OjM3IiwidXBkYXRlZF9hdCI6IjIwMTYtMDEtMzEgMDk6NTc6MzcifX0.YTM9MJh3fyVMclofql_I2gFFKY9jeZlfumOZ68sykOs');

// send a message
try {
    $send = Ratatxt\Sms::send(array(
        // sender number
        // NOTE you can have multiple origins. check you origins on dashboard
        'origin' => '09751303274',
        // receiver number
        'address' => '09XXXXXXXXX',
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
