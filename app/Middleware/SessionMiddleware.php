<?php
namespace App\Middleware;

class SessionMiddleware
{
    public function __invoke($request, $response, $next)
    {
        // Pastikan session dimulai
        if (session_status() == PHP_SESSION_NONE) {
            session_start([
                'cookie_httponly' => true,
                'cookie_secure' => false,   // ganti jika https
            ]);
        }

        return $next($request, $response);
    }
}