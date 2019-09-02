<?php

use DI\Container;
use Slim\Factory\AppFactory;
use App\Controllers\{
    HomeController, UserController
};

$container = new Container();
AppFactory::setContainer($container);

$container->set('db', function () {
    return new PDO('mysql:host=127.0.0.1;dbname=fresh;port=8889', 'root', 'root');
});

$container->set(HomeController::class, function ($container) {
    return new HomeController($container);
});

$container->set(UserController::class, function ($container) {
    return new UserController($container);
});
