<?php

use Symfony\Component\HttpFoundation\Request;

require_once __DIR__.'/vendor/autoload.php';

$app = new Silex\Application();
$app['debug'] = true;

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/views',
));

$app->get('/', function () use ($app) {
    return $app['twig']->render('index.html.twig');
});

$app->post('/generate', function (Request $request) use ($app) {

    $data = $request->request->all();

    return $app['twig']->render('generate.html.twig', [
        'data' => $data
    ]);
});

$app->run();
