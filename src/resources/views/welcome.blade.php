@extends('layout.app')

@section('title', 'Inicio')

@section('content')
<div class="text-center py-5">
    <div class="container">
        <i class="bi bi-people-fill display-1 text-primary mb-4"></i>
        <h1 class="display-4 fw-bold text-dark mb-3">Contact Manager</h1>
        <p class="lead text-muted mb-4">
            Gestiona tus contactos de forma fácil y rápida. 
            Mantén organizada tu agenda personal y profesional.
        </p>
        
        <div class="row justify-content-center mb-5">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <i class="bi bi-plus-circle display-6 text-primary mb-3"></i>
                                <h5>Agregar</h5>
                                <p class="text-muted">Crea nuevos contactos fácilmente</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <i class="bi bi-search display-6 text-success mb-3"></i>
                                <h5>Buscar</h5>
                                <p class="text-muted">Encuentra contactos rápidamente</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <i class="bi bi-tags display-6 text-info mb-3"></i>
                                <h5>Organizar</h5>
                                <p class="text-muted">Categoriza tus contactos</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-grid gap-2 d-md-flex justify-content-center">
            <a href="{{ route('contacts.index') }}" class="btn btn-primary btn-lg px-4 me-md-2">
                <i class="bi bi-people-fill"></i> Ver Mis Contactos
            </a>
            <a href="{{ route('contacts.create') }}" class="btn btn-outline-primary btn-lg px-4">
                <i class="bi bi-plus-circle"></i> Agregar Contacto
            </a>
        </div>

        @if($contactsCount = \App\Models\Contact::count())
        <div class="mt-4">
            <p class="text-muted">
                <i class="bi bi-info-circle"></i> 
                Actualmente tienes <strong>{{ $contactsCount }}</strong> contacto(s) en tu agenda
            </p>
        </div>
        @endif
    </div>
</div>
@endsection