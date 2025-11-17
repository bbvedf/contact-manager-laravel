@extends('layout.app')

@section('title', 'Todos los Contactos')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>
        <i class="bi bi-people-fill"></i> Mis Contactos
    </h1>
    <a href="{{ route('contacts.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Nuevo Contacto
    </a>
</div>

<livewire:search-contacts />
@endsection