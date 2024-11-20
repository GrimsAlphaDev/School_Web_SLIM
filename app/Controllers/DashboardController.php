<?php

namespace App\Controllers;

use Rakit\Validation\Validator;
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

$validator = new Validator;

class DashboardController
{

    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function index(Request $request, Response $response)
    {
        if(isset($_SESSION['__flash_messages'])) {
            $flashMessage = $_SESSION['__flash_messages'];
            unset($_SESSION['__flash_messages']);
        }

        return $this->container->view->render($response, 'dashboard/home.twig', [
            'title' => 'Dashboard',
            'flash' => $flashMessage ?? []
        ]);
    }
}