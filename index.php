<?php

use DI\Container;
use Slim\Factory\AppFactory;
use Slim\Middleware\ErrorMiddleware;
use Slim\Views\{
    TwigMiddleware, Twig
};
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

require 'vendor/autoload.php';

$container = new Container();
AppFactory::setContainer($container);

$app = AppFactory::create();

$errorMiddleware = new ErrorMiddleware(
    $app->getCallableResolver(),
    $app->getResponseFactory(),
    true,
    false,
    false
);

$app->add($errorMiddleware);

$twig = new Twig('views', [
    'cache' => false
]);

$twigMiddleware = new TwigMiddleware(
    $twig,
    $container,
    $app->getRouteCollector()->getRouteParser()
);

$app->add($twigMiddleware);

$app->get('/', function (Request $request, Response $response, $args) {
    $data = $request->getQueryParams();
    var_dump($data);
    die();

    return $this->get('view')->render($response, 'home.twig');
})
    ->setName('home');

$app->get('/contact', function (Request $request, Response $response, $args) {
    return $this->get('view')->render($response, 'contact.twig');
})
    ->setName('contact');

$app->post('/contact', function (Request $request, Response $response, $args) {
    $data = $request->getParsedBody();

    $response->getBody()->write($data['name']);

    return $response;
});

$app->run();
