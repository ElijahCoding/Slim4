<?php

use App\Controllers\{HomeController, UserController};

$app->get('/', HomeController::class)->setName('home');

$app->get('/users/{username}', UserController::class . ':show')->setName('users.show');
