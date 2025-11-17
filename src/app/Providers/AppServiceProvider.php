<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // AGREGAR ESTA LÍNEA - Registrar componente Livewire manualmente
        Livewire::component('search-contacts', \App\Http\Livewire\SearchContacts::class);
    }
}