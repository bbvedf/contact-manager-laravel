@extends('layout.app')

@section('title', 'Editar Contacto')

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
                <form action="{{ route('contacts.update', $contact) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="first_name" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="first_name" name="first_name" 
                                       value="{{ old('first_name', $contact->first_name) }}" required>
                                @error('first_name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="last_name" class="form-label">Apellido</label>
                                <input type="text" class="form-control" id="last_name" name="last_name" 
                                       value="{{ old('last_name', $contact->last_name) }}" required>
                                @error('last_name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" 
                                       value="{{ old('email', $contact->email) }}">
                                @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="phone" class="form-label">Teléfono</label>
                                <input type="text" class="form-control" id="phone" name="phone" 
                                       value="{{ old('phone', $contact->phone) }}">
                                @error('phone')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="category" class="form-label">Categoría</label>
                                <select class="form-select" id="category" name="category" required>
                                    <option value="personal" {{ old('category', $contact->category) == 'personal' ? 'selected' : '' }}>Personal</option>
                                    <option value="familia" {{ old('category', $contact->category) == 'familia' ? 'selected' : '' }}>Familia</option>
                                    <option value="trabajo" {{ old('category', $contact->category) == 'trabajo' ? 'selected' : '' }}>Trabajo</option>
                                    <option value="amigos" {{ old('category', $contact->category) == 'amigos' ? 'selected' : '' }}>Amigos</option>
                                    <option value="otro" {{ old('category', $contact->category) == 'otro' ? 'selected' : '' }}>Otro</option>
                                </select>
                                @error('category')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="notes" class="form-label">Notas</label>
                                <textarea class="form-control" id="notes" name="notes" rows="3">{{ old('notes', $contact->notes) }}</textarea>
                                @error('notes')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
    <div class="text-center">
        <!-- Avatar actual con botón flotante -->
        <div class="position-relative d-inline-block mb-4">
            <img src="{{ $contact->profile_picture 
                ? asset('storage/profiles/' . $contact->profile_picture) 
                : $contact->avatar_url }}" 
                 alt="{{ $contact->full_name }}"
                 class="rounded-circle shadow-sm"
                 style="width: 160px; height: 160px; object-fit: cover; border: 5px solid var(--bs-border-color);"
                 id="current-avatar">

            <!-- Botón flotante para cambiar foto -->
            <label for="profile_picture" class="btn btn-primary rounded-circle position-absolute bottom-0 end-0 shadow"
                   style="width: 44px; height: 44px; padding: 0; display: flex; align-items: center; justify-content: center;">
                <i class="bi bi-camera-fill"></i>
                <input type="file" 
                       id="profile_picture" 
                       name="profile_picture" 
                       accept="image/jpeg,image/png,image/webp"
                       class="d-none"
                       onchange="previewAvatar(event)">
            </label>
        </div>

        @error('profile_picture')
            <div class="text-danger small mt-2">{{ $message }}</div>
        @enderror

        <div class="form-text small text-muted mt-3">
            Formatos: JPG, PNG, WebP · Máximo: 2 MB
        </div>
    </div>

    <!-- Fechas -->
    <div class="mt-4 p-3 small text-muted">
        <p class="mb-1"><strong>Creado:</strong> {{ $contact->created_at->format('d/m/Y H:i') }}</p>
        <p class="mb-0"><strong>Actualizado:</strong> {{ $contact->updated_at->format('d/m/Y H:i') }}</p>
    </div>
</div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('contacts.show', $contact) }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> Actualizar Contacto
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

