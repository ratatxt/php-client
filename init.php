<?php //-->

// dependecies
require(dirname(__FILE__) . '/vendor/autoload.php');

function control()
{
	$class = Eden\Core\Index::i();
	if (func_num_args() == 0) {
		return $class;
	}

	$args = func_get_args();
	return $class->__invoke($args);
}

// base class
require(dirname(__FILE__) . '/lib/Base.php');

// sms wrapper
require(dirname(__FILE__) . '/lib/Sms.php');

// api endpoints
require(dirname(__FILE__) . '/lib/Inbox.php');
require(dirname(__FILE__) . '/lib/Outbox.php');
