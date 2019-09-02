<?php

use DI\Container;
use Slim\Factory\AppFactory;
use Slim\Middleware\ErrorMiddleware;
use Slim\Routing\RouteCollectorProxy;
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
    return $this->get('view')->render($response, 'home.twig');
})
    ->setName('home');

$app->group('/users/{username}', function (RouteCollectorProxy $group) {
    $group->get('', function (Request $request, Response $response, $args) {
        return $this->get('view')->render($response, 'profile.twig', [
            'username' => $args['username']
        ]);
    });

    $group->get('/posts/{id}', function (Request $request, Response $response, $args) {
        return $this->get('view')->render($response, 'posts.twig', [
            'id' => $args['id']
        ]);
    });
});

$app->get('/json', function (Request $request, Response $response) {
    $data = [
        ['name' => 'elijah', 'email' => 'elijah@gmail.com'],
        ['name' => 'billy', 'email' => 'billy@gmail.com']
    ];

    $response->getBody()->write(json_encode($data));

    return $response->withHeader('Content-Type', 'application/json');
 });



$app->run();
