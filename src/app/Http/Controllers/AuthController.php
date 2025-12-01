<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class AuthController extends Controller
{
    public function logout(Request $request)
{
    $jwtUser = $request->attributes->get('compras_user');
    $email = $jwtUser->email ?? 'unknown';
    
    \Log::info('Logout desde Contactos', [
        'email' => $email,
        'ip' => $request->ip()
    ]);
    
    // Eliminar cookie local
    $cookie = Cookie::forget('compras_token');
    
    // Redirigir a login de Compras con parámetro de logout forzado
    // Esto asume que Compras en su login verifica un parámetro que fuerza logout
    return redirect('https://ryzenpc.mooo.com/#/login?logout=true&from=contactos')
        ->withCookie($cookie)
        ->with('logout_message', 'Sesión cerrada correctamente');
    }
}