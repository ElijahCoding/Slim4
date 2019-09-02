<?php

namespace App\Controllers;

use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class HomeController
{
    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function index(Request $request, Response $response)
    {
        return $this->container->get('view')->render($response, 'home.twig');
    }
}
