@extends('layout.app')

@section('title', 'Nuevo Contacto')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">
                    <i class="bi bi-person-plus"></i> Nuevo Contacto
                </h4>
            </div>
            <div class="card-body">
                <form action="{{ route('contacts.store') }}" method="POST">
                    @csrf
                    
<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="first_name" class="form-label">Nombre *</label>
            <input type="text" class="form-control @error('first_name') is-invalid @enderror" 
                   id="first_name" name="first_name" value="{{ old('first_name', isset($contact) ? $contact->first_name : '') }}" required>
            @error('first_name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label for="last_name" class="form-label">Apellidos</label>
            <input type="text" class="form-control @error('last_name') is-invalid @enderror" 
                   id="last_name" name="last_name" value="{{ old('last_name', isset($contact) ? $contact->last_name : '') }}">
            @error('last_name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email') }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="phone" class="form-label">Teléfono</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                       id="phone" name="phone" value="{{ old('phone') }}">
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
                                  id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('contacts.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> Guardar Contacto
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection