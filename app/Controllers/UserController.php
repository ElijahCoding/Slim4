<?php

namespace App\Controllers;

use PDO;
use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UserController
{
    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function show(Request $request, Response $response, $args)
    {
        $query = $this->container->get('db')->prepare("
            SELECT *
            FROM USERS
            WHERE username = :username
        ");

        $query->execute([
            'username' => $args['username']
        ]);

        $user = $query->fetch(PDO::FETCH_OBJ);

        return $this->container->get('view')->render($response, 'users/show.twig', compact('user'));
    }
}
