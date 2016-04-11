<?php
// Composer autoloader for required packages and dependencies
require_once('lib/autoload.php');
// set 'always_populate_raw_post_data' to '-1' in php.ini
// Apparently F3 is not ready for that yet..

$f3 = Base::instance();
$f3->config('app/config.ini'); // This will pull all the necessary configuration files

$f3->route('POST /' . $f3->get('bot.token'), function($f3) {
	// The update ID is not yet handled since not yet needed
	// Will be for spam protection
	
	$json = file_get_contents('php://input'); // Support PHP 5.6+ upstream, see $HTTP_RAW_POST_DATA
	$obj = json_decode($json);
	
	if (isset($obj->message)) {
		$message = $obj->message;
		Bot::instance()->respondMessage($message);
	}
});

// Fire it up
$f3->run();