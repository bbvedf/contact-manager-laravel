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
            
        </div>
    </div>
 


    <!-- Selector de vista Y ordenación -->
<div class="d-flex justify-content-between align-items-center mb-3">
    <div class="text-muted small">
        <i class="bi bi-info-circle"></i>
        Mostrando {{ $contacts->count() }} contacto(s)
        @if($search || $category)
            @if($search) para "{{ $search }}" @endif
            @if($category) en {{ $categories[$category] }} @endif
            <a href="#" wire:click="clearFilters" class="text-danger ms-2">
                <i class="bi bi-x-circle"></i> Limpiar filtros
            </a>
        @endif
    </div>
    
    <div class="d-flex align-items-center gap-2">
        <!-- Ordenación -->
        <div class="dropdown">
            <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                <i class="bi bi-sort-down"></i>
                Ordenar por 
                @if($sortField === 'first_name') Nombre
                @elseif($sortField === 'last_name') Apellido
                @elseif($sortField === 'email') Email
                @elseif($sortField === 'phone') Teléfono
                @elseif($sortField === 'category') Categoría
                @elseif($sortField === 'created_at') Fecha
                @endif
                ({{ $sortDirection === 'asc' ? 'Asc' : 'Desc' }})
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#" wire:click.prevent="sortBy('first_name')">
                    <i class="bi bi-sort-alpha-down"></i> Nombre
                </a></li>
                <li><a class="dropdown-item" href="#" wire:click.prevent="sortBy('last_name')">
                    <i class="bi bi-sort-alpha-down"></i> Apellido
                </a></li>
                <li><a class="dropdown-item" href="#" wire:click.prevent="sortBy('email')">
                    <i class="bi bi-envelope"></i> Email
                </a></li>
                <li><a class="dropdown-item" href="#" wire:click.prevent="sortBy('phone')">
                    <i class="bi bi-telephone"></i> Teléfono
                </a></li>
                <li><a class="dropdown-item" href="#" wire:click.prevent="sortBy('category')">
                    <i class="bi bi-tags"></i> Categoría
                </a></li>
                <li><a class="dropdown-item" href="#" wire:click.prevent="sortBy('created_at')">
                    <i class="bi bi-calendar"></i> Fecha creación
                </a></li>
            </ul>
        </div>

        <!-- Selector de vista -->
        <div class="btn-group btn-group-sm" role="group">
            <button type="button" class="btn btn-{{ $viewMode === 'cards' ? 'primary' : 'outline-primary' }}" 
                    wire:click="$set('viewMode', 'cards')">
                <i class="bi bi-grid-3x3-gap"></i> Tarjetas
            </button>
            <button type="button" class="btn btn-{{ $viewMode === 'list' ? 'primary' : 'outline-primary' }}" 
                    wire:click="$set('viewMode', 'list')">
                <i class="bi bi-list-ul"></i> Lista
            </button>
        </div>
    </div>
</div>
    
    <!-- Resultados -->
    @if($contacts->count() > 0)
        @if($viewMode === 'cards')
            <!-- Vista Tarjetas (la actual) -->
            <div class="row">
                @foreach($contacts as $contact)
                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">{{ $contact->last_name }}, {{ $contact->first_name }}</h5>
                            <h6 class="card-subtitle mb-2 text-muted">
                                <span class="badge bg-{{ 
                                    $contact->category == 'trabajo' ? 'purple' : 
                                    ($contact->category == 'familia' ? 'success' : 
                                    ($contact->category == 'amigos' ? 'warning' : 
                                    ($contact->category == 'otro' ? 'secondary' : 'primary'))) 
                                }}">
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
                            <div class="btn-group btn-group-sm w-100" role="group">
                                <a href="{{ route('contacts.show', $contact) }}" class="btn btn-outline-primary rounded-0 rounded-start">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('contacts.edit', $contact) }}" class="btn btn-outline-secondary rounded-0">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button class="btn btn-outline-danger rounded-0 rounded-end btn-delete" 
                                        data-delete-url="{{ route('contacts.destroy', $contact) }}">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <!-- Vista Lista -->
            <div class="card">
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @foreach($contacts as $contact)
                        <div class="list-group-item">
                            <div class="row align-items-center">
                                <div class="col-md-3">
                                    <h6 class="mb-1">{{ $contact->last_name }}, {{ $contact->first_name }}</h6>
                                    <span class="badge bg-{{ 
                                        $contact->category == 'trabajo' ? 'purple' : 
                                        ($contact->category == 'familia' ? 'success' : 
                                        ($contact->category == 'amigos' ? 'warning' : 
                                        ($contact->category == 'otro' ? 'secondary' : 'primary'))) 
                                    }}">
                                        {{ $contact->category }}
                                    </span>
                                </div>
                                <div class="col-md-3">
                                    @if($contact->email)
                                    <div class="text-muted small">
                                        <i class="bi bi-envelope"></i> {{ $contact->email }}
                                    </div>
                                    @endif
                                    @if($contact->phone)
                                    <div class="text-muted small">
                                        <i class="bi bi-telephone"></i> {{ $contact->phone }}
                                    </div>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    @if($contact->notes)
                                    <div class="text-muted small">
                                        {{ Str::limit($contact->notes, 80) }}
                                    </div>
                                    @endif
                                </div>
                                <div class="col-md-2 text-end">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('contacts.show', $contact) }}" class="btn btn-outline-primary rounded-0 rounded-start">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('contacts.edit', $contact) }}" class="btn btn-outline-secondary rounded-0">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    <button class="btn btn-outline-danger rounded-0 rounded-end btn-delete" 
                                            data-delete-url="{{ route('contacts.destroy', $contact) }}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
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