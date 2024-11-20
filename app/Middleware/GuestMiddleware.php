<?php

namespace App\Middleware;

use Slim\Http\Request;
use Slim\Http\Response;


class GuestMiddleware
{
    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function __invoke(Request $request, Response $response, $next)
    {
        // Jika sudah login, redirect ke dashboard
        if (isset($_SESSION['user_id'])) {
            return $response->withRedirect($this->container->router->pathFor('tester'));
        }

        return $next($request, $response);
    }
}
