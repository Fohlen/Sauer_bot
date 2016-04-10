<?php
// Composer autoloader for required packages and dependencies
require_once('lib/autoload.php');

$f3 = Base::instance();

//$f3->config('app/config/configs.ini'); // This will pull all the necessary configuration files

// Fire it up
$f3->run();