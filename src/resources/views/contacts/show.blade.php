@extends('layout.app')

@section('title', $contact->name)

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">
                    <i class="bi bi-person-badge"></i> Detalle del Contacto
                </h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <h2 class="h4">{{ $contact->last_name }}, {{ $contact->first_name }}</h2>
                        <span class="badge bg-{{ 
                            $contact->category == 'trabajo' ? 'purple' : 
                            ($contact->category == 'familia' ? 'success' : 
                            ($contact->category == 'amigos' ? 'warning' : 
                            ($contact->category == 'otro' ? 'secondary' : 'primary'))) 
                        }} fs-6">
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
            @php
                use Illuminate\Support\Str;
                $origin = session('contact_origin', route('contacts.index'));
                // Limpieza: si el origen es la misma página, ir a lista
                if (Str::contains($origin, ["/contacts/{$contact->id}", "/contacts/{$contact->id}/edit"])) {
                    $origin = route('contacts.index');
                }
            @endphp
            <div class="card-footer bg-transparent">
                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ $origin }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Volver
                    </a>
                    <div class="btn-group">
                        <a href="{{ route('contacts.edit', $contact) }}" class="btn btn-primary">
                            <i class="bi bi-pencil"></i> Editar Contacto
                        </a>
                        <button class="btn btn-outline-danger btn-delete" 
                                data-delete-url="{{ route('contacts.destroy', $contact) }}">
                            <i class="bi bi-trash"></i> Eliminar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection