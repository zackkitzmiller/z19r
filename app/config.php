<?php

/**
 * Config for all environments
 */
$app->config(array(
	'templates.path' => '../templates'
));

/**
 * Config for 'production' environment
 */
$app->configureMode('production', function () use ($app) {
	$app->config(array(
		'log.enable' => true,
		'debug' => false
	));
});

/**
 * Config for 'development' environment
 */
$app->configureMode('development', function () use ($app) {
	$app->config(array(
		'log.enable' => false,
		'debug' => true
	));
});
