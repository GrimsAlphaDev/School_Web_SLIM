<?php

namespace App\Middleware;

use Slim\Http\Request;
use Slim\Http\Response;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;

class AuthMiddleware
{
    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function __invoke(Request $request, Response $response, $next)
    {
        // Cek Session
        if (!isset($_SESSION['user_id'])) {
            setFlash('info', 'Silahkan Login');
            return $response->withRedirect($this->container->router->pathFor('login'));
        }

        
        // Validasi Token JWT
        try {
            $token = $_SESSION['token'];
            
            // Decode token
            $decoded = JWT::decode(
                $token, 
                new \Firebase\JWT\Key($_ENV['JWT_SECRET'], 'HS256'),
                [
                    'algorithms' => ['HS256'],
                    'kid' => $_ENV['JWT_KID'] 
                    ]
                );
                
        } catch (\Firebase\JWT\ExpiredException $e) {
            // Token expired
            $_SESSION = [];
            session_destroy();
            return $response->withRedirect('/login')
                ->withHeader('X-Auth-Error', 'Token expired');
        } catch (\Exception $e) {
            // Error lainnya
            $_SESSION = [];
            session_destroy();
            return $response->withRedirect('/login')
                ->withHeader('X-Auth-Error', $e->getMessage());
        }

        // Lanjutkan request
        return $next($request, $response);
    }
}
