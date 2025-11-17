<div>
    <!-- Título y botones PRIMERO -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>
            <i class="bi bi-people-fill"></i> Mis Contactos
        </h1>
        <div class="btn-group">
            <a href="{{ route('contacts.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Nuevo Contacto
            </a>
            <button type="button" class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown">
                <i class="bi bi-download"></i> Exportar
            </button>
            <ul class="dropdown-menu">
                <li>
                    <a class="dropdown-item" href="#" wire:click.prevent="exportExcel">
                        <i class="bi bi-file-earmark-excel"></i> Excel (.xlsx)
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="#" wire:click.prevent="exportPdf">
                        <i class="bi bi-file-earmark-pdf"></i> PDF (.pdf)
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Barra de búsqueda y filtros DESPUÉS -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row g-3 align-items-end">
                <div class="col-md-5">
                    <label for="search" class="form-label">
                        <i class="bi bi-search"></i> Buscar contactos
                    </label>
                    <input 
                        type="text" 
                        class="form-control" 
                        id="search"
                        placeholder="Buscar por nombre, email, teléfono..."
                        wire:model.live="search"
                    >
                </div>
                
                <div class="col-md-4">
                    <label for="category" class="form-label">Filtrar por categoría</label>
                    <select 
                        class="form-select" 
                        id="category"
                        wire:model.live="category"
                    >
                        @foreach($categories as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-3">
                    <button 
                        class="btn btn-outline-secondary w-100" 
                        wire:click="clearFilters"
                        @if(!$search && !$category) disabled @endif
                    >
                        <i class="bi bi-arrow-clockwise"></i> Limpiar
                    </button>
                </div>
            </div>
            
            <!-- Contador de resultados -->
            @if($search || $category)
            <div class="mt-2">
                <small class="text-muted">
                    <i class="bi bi-info-circle"></i>
                    Mostrando {{ $contacts->count() }} contacto(s)
                    @if($search) para "{{ $search }}" @endif
                    @if($category) en {{ $categories[$category] }} @endif
                </small>
            </div>
            @endif
        </div>
    </div>


    <!-- Resultados -->
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
            <i class="bi bi-search display-1 text-muted"></i>
            <h3 class="text-muted">No se encontraron contactos</h3>
            <p class="text-muted">
                @if($search || $category)
                    Intenta con otros términos de búsqueda o <a href="#" wire:click="clearFilters">limpiar los filtros</a>.
                @else
                    No hay contactos disponibles. <a href="{{ route('contacts.create') }}">Crea el primero</a>.
                @endif
            </p>
        </div>
    @endif
</div>