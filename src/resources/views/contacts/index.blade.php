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

@if($contacts->count() > 0)
    <div class="row">
        @foreach($contacts as $contact)
        <div class="col-md-6 col-lg-4 mb-3">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">{{ $contact->name }}</h5>
                    <h6 class="card-subtitle mb-2 text-muted">
                        <span class="badge bg-{{ $contact->category == 'work' ? 'info' : ($contact->category == 'family' ? 'success' : 'secondary') }}">
                            {{ $contact->category }}
                        </span>
                    </h6>
                    
                    @if($contact->email)
                    <p class="card-text">
                        <i class="bi bi-envelope"></i> {{ $contact->email }}
                    </p>
                    @endif
                    
                    @if($contact->phone)
                    <p class="card-text">
                        <i class="bi bi-telephone"></i> {{ $contact->phone }}
                    </p>
                    @endif

                    @if($contact->notes)
                    <p class="card-text text-muted small">
                        {{ Str::limit($contact->notes, 50) }}
                    </p>
                    @endif
                </div>
                <div class="card-footer bg-transparent">
                    <div class="btn-group btn-group-sm" role="group">
                        <a href="{{ route('contacts.show', $contact) }}" class="btn btn-outline-primary">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('contacts.edit', $contact) }}" class="btn btn-outline-secondary">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('contacts.destroy', $contact) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger" 
                                onclick="return confirm('¿Eliminar este contacto?')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@else
    <div class="text-center py-5">
        <i class="bi bi-people display-1 text-muted"></i>
        <h3 class="text-muted">No hay contactos aún</h3>
        <p class="text-muted">Comienza agregando tu primer contacto.</p>
        <a href="{{ route('contacts.create') }}" class="btn btn-primary btn-lg">
            <i class="bi bi-plus-circle"></i> Crear Primer Contacto
        </a>
    </div>
@endif
@endsection