<?php

use App\Http\Controllers\ContactController;
use App\Models\Contact;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome', ['contactsCount' => Contact::count()]);
});

Route::resource('contacts', ContactController::class);

// Rutas de exportación
Route::get('/contacts/export/excel', [ContactController::class, 'exportExcel'])->name('contacts.export.excel');
Route::get('/contacts/export/pdf', [ContactController::class, 'exportPdf'])->name('contacts.export.pdf');