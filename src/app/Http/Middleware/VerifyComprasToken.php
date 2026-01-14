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
        setcookie('auth_token', $token, time() + 86400, '/');
        // Redirigir SIN token en URL
        return redirect('/contactos');
    }
    
    // 3. Si no, usar cookie
    $token = $_COOKIE['auth_token'] ?? null;
    
    if (!$token) {
        return redirect('https://ryzenpc.mooo.com/#/login');
    }
    
    // 4. Validar
    try {
        $decoded = JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));
        
        $is_approved = !isset($decoded->isApproved) || $decoded->isApproved === true;
        $is_admin = (isset($decoded->role) && $decoded->role === 'admin');
        
        view()->share('is_approved', $is_approved);
        view()->share('is_admin', $is_admin);
        view()->share('jwt_user', $decoded);
        
    } catch (\Exception $e) {
        setcookie('auth_token', '', time() - 3600, '/');
        return redirect('https://ryzenpc.mooo.com/#/login');
    }
    
    return $next($request);
}
}