<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
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
        // Forzar la base URL de Livewire para subcarpeta
        //Livewire::forceAssetBaseUrl(config('app.livewire_asset_url'));
        
        // Configurar rutas de Livewire
        Livewire::setUpdateRoute(function ($handle) {
            return \Route::post('/livewire/update', $handle);
        });        
        
        Livewire::component('search-contacts', \App\Http\Livewire\SearchContacts::class);

        if (env('FORCE_HTTPS', false) || request()->header('X-Forwarded-Proto') === 'https') {
            URL::forceScheme('https');
        }

    }
}


