<?php
namespace App\Middleware;

class FlashMiddleware
{
    public function __invoke($request, $response, $next)
    {
        // Pastikan $_SESSION ada dan diinisialisasi
        if (!isset($_SESSION)) {
            $_SESSION = [];
        }

        // Simpan flash messages
        $flashMessages = $_SESSION['__flash_messages'] ?? [];
        
        // Tambahkan flash messages ke request attributes
        $request = $request->withAttribute('flash_messages', $flashMessages);
        
        // Bersihkan flash messages
        unset($_SESSION['__flash_messages']);
        
        $response = $next($request, $response);

        return $response;
    }
}