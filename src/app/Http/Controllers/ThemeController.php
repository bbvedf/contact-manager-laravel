<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ThemeController extends Controller
{
    public function toggle(Request $request)
    {
        $request->validate([
            'theme' => 'required|in:light,dark'
        ]);

        // Guardamos en sesión (esto es lo importante)
        session(['theme' => $request->theme]);

        return response()->json([
            'success' => true,
            'theme'   => $request->theme
        ]);
    }
}