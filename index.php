<?php

use Knp\Snappy\Pdf;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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

    $html = $app['twig']->render('generate.html.twig', [
        'data' => $data
    ]);

    $snappy = new Pdf(__DIR__.'/vendor/h4cc/wkhtmltopdf-amd64/bin/wkhtmltopdf-amd64');

    $filename = $data['title'].' - '.$data['student'].'.pdf';
    $response = new Response($snappy->getOutputFromHtml($html), 200, [
        'Content-Type' => 'application/pdf',
        'Content-Disposition' => 'attachment; filename="'.$filename.'"',
    ]);

    return $response;
});

$app->run();
