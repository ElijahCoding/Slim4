<?php

use DI\Container;
use Slim\Factory\AppFactory;
use App\Controllers\HomeController;

$container = new Container();
AppFactory::setContainer($container);

$container->set(HomeController::class, function ($container) {
    return new HomeController($container);
});
