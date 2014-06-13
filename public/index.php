<?php
	require '../vendor/autoload.php';
	date_default_timezone_set('America/New_York');

	$app = new \Slim\Slim();

	$app->config(array(
		'templates.path' => '../templates'
	));

	$app->hook('slim.before.dispatch', function() use ($app) {
		$root_url    = str_replace('/index.php', '', $app->request->getUrl() . $app->request->getRootUri());

		$base_url    = $root_url . '/index.php';
		$assets_url  = $root_url . '/assets';

		$app->view()->appendData(array(
			'base_url'   => $base_url,
			'assets_url' => $assets_url,
		));
	});

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
