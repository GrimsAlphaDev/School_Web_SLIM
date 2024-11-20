<?php

use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;

$app->get('/login', 'AuthController:login')->setName('login')->add(new GuestMiddleware($container));
$app->post('/login', 'AuthController:postLogin')->setName('post.login')->add(new GuestMiddleware($container));
$app->get('/logout', 'AuthController:logout')->setName('logout');

$app->get('/test', function ($request, $response) {
    return 'test aja';
})->add(new AuthMiddleware($container))->setName('tester');