<?php
session_start();
require '../vendor/autoload.php';

$app = new \Slim\App;

// routes
require '../src/routes.php';

$app->run();