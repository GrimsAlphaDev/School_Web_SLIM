<?php

use App\Controllers\AuthController;
use App\Controllers\DashboardController;
use App\Controllers\SchoolController;
use App\Middleware\FlashMiddleware;
use App\Middleware\SessionMiddleware;
use \Slim\App;
use \Slim\Container;
use Slim\Views\Twig;
use App\Middleware\CsrfMiddleware;

require __DIR__ . '/../vendor/autoload.php';

// Konfigurasi Keamanan Session
ini_set('session.cookie_httponly', 1);
ini_set('session.use_strict_mode', 1);
ini_set('session.cookie_samesite', 'Lax');

$container = new Container([
    'settings' => [
        'displayErrorDetails' => true
    ]
]);


// Tambahkan include konfigurasi database
require __DIR__ . '/../config/database.php';

// session
require __DIR__ . '/../src/session.php';

// flash
require __DIR__ . '/../src/flash.php';

// Gunakan $database global atau masukkan ke container
$container['database'] = function () use ($database) {
    return $database;
};


// Konfigurasi Twig View
$container['view'] = function ($container) {
    $view = new Twig(__DIR__ . '/../resources/views', [
        'cache' => false,
        'debug' => true
    ]);

    $view->addExtension(new \Twig\Extension\DebugExtension());

    // global variabel
    $baseUrl = $container->get('request')->getUri()->getBaseUrl();

    $view->getEnvironment()->addGlobal('base_url', $baseUrl);

    // Ambil flash messages sebelum rendering
    $request = $container->get('request');
    $flashMessages = $request->getAttribute('flash_messages', []);

    // Tambahkan sebagai global variable statis
    $view->getEnvironment()->addGlobal('flash', $flashMessages);


    $view->getEnvironment()->addGlobal('app', [
        'name' => 'School Web',
        'url' => $baseUrl
    ]);

    return $view;
};



$container['Admin'] = function ($container) {
    return new \App\Models\Admin($container->database);
};

$container['School'] = function ($container) {
    return new \App\Models\School($container->database);
};

$container['Students'] = function ($container) {
    return new \App\Models\Students($container->database);
};


// Dependency Injection untuk Controllers
$container['AuthController'] = function ($container) {
    return new AuthController($container);
};

$container['DashboardController'] = function ($container) {
    return new DashboardController($container);
};

$container['SchoolController'] = function ($container) {
    return new SchoolController($container);
};

$app = new App($container);
$app->add(new SessionMiddleware());
$app->add(new FlashMiddleware());

require __DIR__ . '/../routes/web.php';

// Jalankan Aplikasi
$app->run();
