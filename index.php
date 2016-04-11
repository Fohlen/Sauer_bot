<?php
// Composer autoloader for required packages and dependencies
require_once('lib/autoload.php');

$f3 = Base::instance();
$web = Web::instance();

$f3->config('app/config.ini'); // This will pull all the necessary configuration files

$f3->route('POST /' . $f3->get('bot.token'), function($f3) {
	// The update ID is not yet handled since not yet needed
	// Will be for spam protection
	if (isset($f3->get('POST.message'))) {
		$message = $f3->get('POST.message');
		Bot::instance()->respondMessage($message);
	}
});

// Fire it up
$f3->run();