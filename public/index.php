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

	$app->get('/lastfm', function() use ($app) {
		$app->response->headers->set('Content-Type', 'application/json');

		$url = "http://ws.audioscrobbler.com/1.0/user/ZackKitzmiller/recenttracks.rss";
		$xml = simplexml_load_file($url);
		$last_played = $xml->channel->item;

		$ret = array(
			"title" => (string)$last_played->title[0],
			'url' => (string)$last_played->link
		);

		$json = json_encode($ret);
		$app->etag(md5($json));
		$app->expires('+10 Minutes');

		echo $json;
	});

	$app->run();
