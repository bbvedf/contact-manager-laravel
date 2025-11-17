@extends('layout.app')

@section('title', 'Editar: ' . $contact->name)

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">
                    <i class="bi bi-pencil-square"></i> Editar Contacto
                </h4>
            </div>
            <div class="card-body">
                <form action="{{ route('contacts.update', $contact) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Nombre *</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name', $contact->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email', $contact->email) }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="phone" class="form-label">Teléfono</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                       id="phone" name="phone" value="{{ old('phone', $contact->phone) }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="category" class="form-label">Categoría *</label>
                        <select class="form-select @error('category') is-invalid @enderror" 
                                id="category" name="category" required>
                            <option value="">Seleccionar categoría...</option>
                            <option value="personal" {{ old('category', isset($contact) ? $contact->category : '') == 'personal' ? 'selected' : '' }}>Personal</option>
                            <option value="familia" {{ old('category', isset($contact) ? $contact->category : '') == 'familia' ? 'selected' : '' }}>Familia</option>
                            <option value="trabajo" {{ old('category', isset($contact) ? $contact->category : '') == 'trabajo' ? 'selected' : '' }}>Trabajo</option>
                            <option value="amigos" {{ old('category', isset($contact) ? $contact->category : '') == 'amigos' ? 'selected' : '' }}>Amigos</option>
                            <option value="otro" {{ old('category', isset($contact) ? $contact->category : '') == 'otro' ? 'selected' : '' }}>Otro</option>
                        </select>
                        @error('category')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label">Notas</label>
                        <textarea class="form-control @error('notes') is-invalid @enderror" 
                                  id="notes" name="notes" rows="3">{{ old('notes', $contact->notes) }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
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
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-check-circle"></i> Actualizar Contacto
        </button>
    </div>
</div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

