<?php

require '../vendor/autoload.php';
date_default_timezone_set('America/New_York');

$app = new \Slim\Slim(array(
	'mode' => 'production'
));

require '../app/config.php';

require '../app/hooks.php';

require '../app/routes.php';

$app->run();
