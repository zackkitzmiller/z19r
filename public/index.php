<?php
	require '../vendor/autoload.php';
	date_default_timezone_set('America/New_York');

	$app = new \Slim\Slim();

	$app->config(array(
		'templates.path' => '../templates'
	));

	/**
	 * Home
	 */
	$app->get('/', function() use ($app) {
		$app->render('index.html');
	});

	/**
	 * Cache Github Contributors to avoid API Rate Limit
	 */
	$app->get('/contributors', function () use ($app) {
		$app->response->headers->set('Content-Type', 'application/json');

		$client = new \Github\Client(
			new \Github\HttpClient\CachedHttpClient(array('cache_dir' => '../cache'))
		);

		echo json_encode($client->api('repos')->contributors('zackkitzmiller', 'z19r'));
	});

	$app->run();