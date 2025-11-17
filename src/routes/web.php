<?php

use App\Http\Controllers\ContactController;
use App\Models\Contact;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome', ['contactsCount' => Contact::count()]);
});

Route::resource('contacts', ContactController::class);