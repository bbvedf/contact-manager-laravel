<?php
// ~/prog/contact-manager-laravel/src/app/Http/Middleware/VerifyComprasToken.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class VerifyComprasToken
{
    public function handle(Request $request, Closure $next)
    {
        // 1. Primero token de URL (de AuthBridge)
        $token = $request->query('token');
        
        // 2. Si no, token de cookie (fallback)
        if (!$token) {
            $token = $request->cookie('compras_token');
        }

        if (!$token) {
            return redirect('https://ryzenpc.mooo.com/#/login');
        }

        // Verificar JWT
        try {
            $secret = env('JWT_SECRET', 'mi_secreto');
            $decoded = JWT::decode($token, new Key($secret, 'HS256'));
            
            \Log::info('Token válido para usuario: ' . $decoded->email);
            
            $request->attributes->set('compras_user', $decoded);
            
        } catch (\Exception $e) {
            \Log::error('Token inválido: ' . $e->getMessage());
            return redirect('https://ryzenpc.mooo.com/#/login');
        }

        return $next($request);
    }
    
}