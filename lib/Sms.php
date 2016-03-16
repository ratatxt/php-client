<?php //-->

namespace Ratatxt;

class Sms extends Base
{
    /* Constants
    --------------------------------------------*/
    const OUTBOX = '/outbox';
    const INBOX = '/inbox';

    /* Public Properties
    --------------------------------------------*/
    /* Protected Properties
    --------------------------------------------*/
    /* Public Methods
    --------------------------------------------*/
    public static function send($data)
    {
        // check required

        return self::call(self::OUTBOX, $data);
    }

    public static function get($param = array())
    {
        // check param

        return self::call(self::INBOX);
    }

    /* Protected Methods
    --------------------------------------------*/
    /* Private Methods
    --------------------------------------------*/
}
