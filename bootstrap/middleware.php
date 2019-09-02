<?php

use Slim\Middleware\ErrorMiddleware;
use Slim\Exception\HttpNotFoundException;
use Slim\Views\{
    TwigMiddleware, Twig
};
use Slim\Psr7\Response;

$errorMiddleware = new ErrorMiddleware(
    $app->getCallableResolver(),
    $app->getResponseFactory(),
    true,
    false,
    false
);

$errorMiddleware->setErrorHandler(HttpNotFoundException::class, function ($request, $exceptio) use ($container) {
    $response = new Response();

    return $container->get('view')->render($response->withStatus(404), 'errors/404.twig');
});

$app->add($errorMiddleware);

$twig = new Twig('../views', [
    'cache' => false
]);

$twigMiddleware = new TwigMiddleware(
    $twig,
    $container,
    $app->getRouteCollector()->getRouteParser()
);

$app->add($twigMiddleware);
