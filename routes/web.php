<?php

$app->get('/', function (Request $request, Response $response, $args) {
    return $this->get('view')->render($response, 'home.twig');
})
    ->setName('home');
