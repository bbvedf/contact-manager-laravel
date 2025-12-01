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
    $token = $request->query('token') ?? $request->cookie('compras_token');

    if (!$token) {
        \Log::warning('Token no encontrado en query o cookie');
        return redirect('https://ryzenpc.mooo.com/#/login');
    }

    try {
        $decoded = JWT::decode($token, new Key(env('JWT_SECRET', 'mi_secreto'), 'HS256'));

        // VERIFICACIÓN
        if (!isset($decoded->role) || $decoded->role !== 'admin') {
            \Log::warning('Acceso denegado: role no es admin', (array)$decoded);
            return redirect('https://ryzenpc.mooo.com/#/login');
        }

        if (!isset($decoded->isApproved) || $decoded->isApproved !== true) {
            \Log::warning('Acceso denegado: isApproved no es true', (array)$decoded);
            return redirect('https://ryzenpc.mooo.com/#/login');
        }

        \Log::info('JWT válido - Acceso permitido', [
            'email' => $decoded->email,
            'role' => $decoded->role,
            'isApproved' => $decoded->isApproved
        ]);

        // COMPARTIR VARIABLES CON TODAS LAS VISTAS
        view()->share('jwt_user', $decoded);
        view()->share('is_admin', $decoded->role === 'admin');
        
        $request->attributes->set('compras_user', $decoded);

    } catch (\Exception $e) {
        \Log::error('JWT ERROR: ' . $e->getMessage());
        return redirect('https://ryzenpc.mooo.com/#/login');
    }

    return $next($request);
    }
}