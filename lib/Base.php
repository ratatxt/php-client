<?php //-->

namespace Ratatxt;

use Exception;

class Base
{
    /* Constants
    --------------------------------------------*/
    /* Public Properties
    --------------------------------------------*/
    public static $host = 'http://api.ratatxt.com';
    public static $token = null;

    /* Protected Properties
    --------------------------------------------*/
    /* Public Methods
    --------------------------------------------*/
    public static function setHost($host)
    {
        self::$host = $host;
    }

    public static function setToken($token)
    {
        self::$token = $token;
    }

    public static function call($endpoint, $data = null)
    {
        $response = control('curl')
			->setUrl(self::$host . $endpoint)
            ->setHeaders('Authorization', 'Basic ' . base64_encode(self::$token . ':'));

        if($data) {
            $response->setPostFields(json_encode($data));
        }

		$result = $response->getJsonResponse();

        // check for errors and throw them
        if(isset($result['error'])) {
            // unexpected error
            if($result['error']['panic']) {
                throw new Exception("something went wrong.", 1);
            }

            throw new Exception($result['error']['msg'], 1);
        }

        return $result;
    }

    /* Protected Methods
    --------------------------------------------*/
    /* Private Methods
    --------------------------------------------*/
}
