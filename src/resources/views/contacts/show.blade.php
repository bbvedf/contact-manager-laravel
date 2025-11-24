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
                        }}">
                            {{ $contact->category }}
                        </span>
                        
                        <hr>
                        
                        <div class="contact-info mt-4">
                            @if($contact->email)
                            <div class="d-flex align-items-start gap-3 mb-4">
                                <i class="bi bi-envelope text-primary fs-4 mt-1"></i>
                                <div>
                                    <strong>Email:</strong>
                                    <a href="mailto:{{ $contact->email }}" class="text-decoration-none">{{ $contact->email }}</a>
                                </div>
                            </div>
                            @endif

                            @if($contact->phone)
                            <div class="d-flex align-items-start gap-3 mb-4">
                                <i class="bi bi-telephone text-success fs-4 mt-1"></i>
                                <div>
                                    <strong>Teléfono:</strong>
                                    <a href="tel:{{ $contact->phone }}" class="text-decoration-none">{{ $contact->phone }}</a>
                                </div>
                            </div>
                            @endif

                            @if($contact->notes)
                            <div class="d-flex align-items-start gap-3 mb-4">
                                <i class="bi bi-journal-text text-warning fs-4 mt-1"></i>
                                <div>
                                    <strong>Notas:</strong>
                                    <span class="text-muted">{{ nl2br(e($contact->notes)) }}</span>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4 text-center">
                        <!-- Avatar corregido -->
                        <img src="{{ $contact->profile_picture ? asset('storage/profiles/' . $contact->profile_picture) : $contact->avatar_url }}" 
                        alt="{{ $contact->full_name }}"
                        class="rounded-circle mb-3 shadow"
                        style="width: 120px; height: 120px; object-fit: cover; border: 4px solid var(--bs-card-border-color);">
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