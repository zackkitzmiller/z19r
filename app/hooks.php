<?php

$app->hook('slim.before.dispatch', function() use ($app) {
	$root_url    = str_replace('/index.php', '', $app->request->getUrl() . $app->request->getRootUri());

	$base_url    = $root_url . '/index.php';
	$assets_url  = $root_url . '/assets';

	$app->view()->appendData(array(
		'base_url'   => $base_url,
		'assets_url' => $assets_url,
	));
});
