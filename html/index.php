<?php

require __DIR__ . '/../vendor/autoload.php';
//TODO: retire Silex with something else: https://symfony.com/blog/the-end-of-silex
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

error_reporting(E_ERROR | E_PARSE);


//TODO: move to entry and route
$app = new Silex\Application();
$app['debug'] = true;

$app->post('/ip', function (Request $request) use ($app) {
	//TODO: check content-type
	//TODO: check input format
	//TODO: make a cache in frontend
	$res = getIP(json_decode($request->getContent(), true)['ip']);
	//TODO: exception control
    return $app->json($res, 200);
});


$app->run();
