@extends('layout.app')

@section('title', $contact->name)

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">
                    <i class="bi bi-person-badge"></i> Detalle del Contacto
                </h4>
                <div class="btn-group">
                    <a href="{{ route('contacts.edit', $contact) }}" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-pencil"></i> Editar
                    </a>
                    <a href="{{ route('contacts.index') }}" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-arrow-left"></i> Volver
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <h2 class="h4">{{ $contact->name }}</h2>
                        <span class="badge bg-{{ $contact->category == 'work' ? 'info' : ($contact->category == 'family' ? 'success' : 'secondary') }} fs-6">
                            {{ $contact->category }}
                        </span>
                        
                        <hr>
                        
                        <div class="contact-info">
                            @if($contact->email)
                            <p class="mb-2">
                                <strong><i class="bi bi-envelope text-primary"></i> Email:</strong><br>
                                <a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a>
                            </p>
                            @endif
                            
                            @if($contact->phone)
                            <p class="mb-2">
                                <strong><i class="bi bi-telephone text-success"></i> Teléfono:</strong><br>
                                <a href="tel:{{ $contact->phone }}">{{ $contact->phone }}</a>
                            </p>
                            @endif
                            
                            @if($contact->notes)
                            <p class="mb-2">
                                <strong><i class="bi bi-journal-text text-warning"></i> Notas:</strong><br>
                                {{ $contact->notes }}
                            </p>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="contact-avatar bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                             style="width: 100px; height: 100px; font-size: 2rem;">
                            <i class="bi bi-person-fill"></i>
                        </div>
                        <p class="text-muted small">
                            Creado: {{ $contact->created_at->format('d/m/Y') }}<br>
                            Actualizado: {{ $contact->updated_at->format('d/m/Y') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection