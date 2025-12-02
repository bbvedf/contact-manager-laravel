<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class VerifyComprasToken
{
    public function handle(Request $request, Closure $next)
{
    // 1. Token de query string (primer acceso)
    $token = $_GET['token'] ?? null;
    
    // 2. Si hay token en URL, ponerlo en cookie
    if ($token) {
        setcookie('compras_token', $token, time() + 86400, '/');
        // Redirigir SIN token en URL
        return redirect('/contactos');
    }
    
    // 3. Si no, usar cookie
    $token = $_COOKIE['compras_token'] ?? null;
    
    if (!$token) {
        return redirect('https://ryzenpc.mooo.com/#/login');
    }
    
    // 4. Validar
    try {
        $decoded = JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));
        
        if ($decoded->role !== 'admin' || !$decoded->isApproved) {
            return redirect('https://ryzenpc.mooo.com/#/login');
        }
        
        view()->share('is_admin', true);
        view()->share('jwt_user', $decoded);
        
    } catch (\Exception $e) {
        setcookie('compras_token', '', time() - 3600, '/');
        return redirect('https://ryzenpc.mooo.com/#/login');
    }
    
    return $next($request);
}
}