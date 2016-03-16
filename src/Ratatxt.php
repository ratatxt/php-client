<?php //-->

namespace Modules;

use Resources\Device;

class Ratatxt
{
    /* Constants
    --------------------------------------------*/
    /* Public Properties
    --------------------------------------------*/
    public static $host = null;
    public static $token = null;
    public static $devices = array();
    public static $primaryDevice = null;
    public static $otherDevice = 'OTHER';

    /* Protected Properties
    --------------------------------------------*/
    /* Public Methods
    --------------------------------------------*/
    public static function init()
    {
        $setting = self::setting();
        self::$host = rtrim($setting['host'], '/');
        self::$token = $setting['token'];

        // assign devices
        foreach(Device::find() as $device) {
            self::$devices[$device['name']] = $device['number'];
        }

        self::$primaryDevice = current(array_keys(self::$devices));
    }

    public static function request($endpoint, $data = null)
    {
        self::init();

        $response = control('curl')
			->setUrl(self::$host . $endpoint)
            ->setHeaders('application-authorization', self::$token);

        if($data) {
            $response->setPostFields(json_encode($data));
        }

		return $response->getJsonResponse();
    }

    public static function getInbox()
    {
        return self::request('/inbox');
    }

    public static function postOutbox($origin, $address, $text)
    {
        return self::request('/outbox', array(
            'origin' => $origin,
            'address' => $address,
            'text' => $text
        ));
    }

    public static function addNumber($address, $notifyUrl = null)
    {
        self::init();

        return self::request('/number', array(
            'address' => $address,
            'notify_url' => $notifyUrl,
        ));
    }

    public static function read($options = array())
    {
        self::init();

        // get new messages
        $new = self::getInbox();

        // get devices from number
        $devices = array_flip(self::$devices);

        // result modifier
        // NOTE this will adapt to old data structure
        $data = array();
        foreach ($new as $key => $msg) {
            $msg['origin'] = ltrim($msg['origin'], '+');

            if(!isset($devices[$msg['origin']])) {
                continue;
            }

            $data[] = array(
                'id' => $msg['id'],
                'device' => $devices[$msg['origin']],
                'address' => $msg['address'],
                'text' => $msg['text'],
            );
        }

        return $data;
    }

    public static function send($deviceId, $address, $text)
    {
        self::init();

        // check device id
        switch ($deviceId) {
        case 'other':
            // primary device
            $deviceId = self::$primaryDevice;
            break;
        case 'auto':
            // auto mode is not allowed when detected network
            // is equal to other
            $network = strtoupper(Helper::detectNetwork($address));
            if($network == self::$otherDevice) {
                return;
            }

            // search numbers on devices based on network
            foreach(self::$devices as $name => $number) {
                if($network == strtoupper(Helper::detectNetwork($number))) {
                    $deviceId = $name;
                    break;
                }
            }

            // no network based device number
            // use primary
            if($deviceId == 'auto') {
                $deviceId = self::$primaryDevice;
            }

            break;
        }

        if(empty($deviceId) || empty($address) || empty($text)) {
            return false;
        }

        // normalize address
        if(strlen($address) > 10 && !Helper::normalizeNumber($address)) {
            return false;
        }

        // check origin device
        if(!isset(self::$devices[$deviceId])) {
            return false;
        }

        // to send post to oubox
        $result = self::postOutbox(self::$devices[$deviceId], $address, $text);

        return array('result' => $result);
    }

    public static function stat()
    {
    }

    public static function config()
    {
        self::init();

        $devices = array();

        foreach (self::$devices as $key => $number) {
            $devices[] = array(
                'id' => $key,
                'number' => $number,
            );
        }

        return array('devices' => $devices);
    }

    /* Protected Methods
    --------------------------------------------*/
    /* Private Methods
    --------------------------------------------*/
    protected static function setting()
    {
        return Helper::getSetting('sms');
    }
}
