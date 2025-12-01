<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use Livewire\Livewire;
use App\Http\Controllers\AuthController;

// Ruta de tema
Route::post('/theme-toggle', function (Illuminate\Http\Request $request) {
    $request->validate(['theme' => 'required|in:light,dark']);
    session(['theme' => $request->theme]);
    return response()->json(['success' => true, 'theme' => $request->theme]);
});

// Rutas SIN prefijo (porque Nginx elimina /contactos/)
Route::get('/', function () { 
    return view('contacts.index');
})->name('index'); 

Route::get('/create', function () {
    return view('contacts.create');
})->name('create');

Route::post('/store', [ContactController::class, 'store'])->name('store');
Route::get('/{contact}/edit', [ContactController::class, 'edit'])->name('edit');
Route::put('/{contact}', [ContactController::class, 'update'])->name('update');
Route::get('/{contact}', [ContactController::class, 'show'])->name('show');
Route::delete('/{contact}', [ContactController::class, 'destroy'])->name('destroy');
Route::get('/export/excel', [ContactController::class, 'exportExcel'])->name('export.excel');
Route::get('/export/pdf', [ContactController::class, 'exportPdf'])->name('export.pdf');

// RUTA EXPLÍCITA para Livewire que FORCE el prefijo /contactos/
Route::get('/contactos/vendor/livewire/livewire.js', function () {
    // Redirigir a la ruta interna CORRECTA manteniendo el prefijo
    return redirect('/vendor/livewire/livewire.js');
});

// RUTA UPDATE EXPLÍCITA para subcarpeta
Route::post('/contactos/livewire/update', function () {
    return app(Livewire\Mechanisms\HandleRequests::class)->handleUpdate(request());
});

// RUTAS LIVEWIRE normales
Route::get('/vendor/livewire/livewire.js', [Livewire\Mechanisms\FrontendAssets::class, 'returnJavaScriptAsFile']);

// Ruta de depuración del token JWT
Route::get('/api/debug-token', function () {
    $token = request()->query('token') ?? request()->cookie('compras_token');
    if (!$token) return ['error' => 'no token'];
    try {
        $decoded = \Firebase\JWT\JWT::decode($token, new \Firebase\JWT\Key(env('JWT_SECRET','mi_secreto'), 'HS256'));
        return response()->json((array)$decoded);
    } catch (Exception $e) {
        return ['error' => $e->getMessage()];
    }
});

// Ruta para logout
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');