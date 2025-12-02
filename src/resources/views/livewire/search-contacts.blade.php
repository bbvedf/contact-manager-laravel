<div>
    <!-- Título y botones PRIMERO -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <!--<h1>
            <i class="bi bi-people-fill"></i> Mis Contactos
        </h1>-->
        <div class="btn-group">
            <a href="/contactos/create" class="btn btn-primary">                
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
                        wire:model.live.debounce.300ms="search"
                    >
                </div>
                
                <div class="col-md-4">
                    <label for="category" class="form-label">Filtrar por categoría</label>
                    <select 
                        class="form-select" 
                        id="category"
                        wire:model.live.debounce.300ms="category"
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
            Mostrando {{ $contacts->firstItem() ?? 0 }}-{{ $contacts->lastItem() ?? 0 }} de {{ $contacts->total() }} contacto(s)
            @if($search || $category)
                @if($search) para "{{ $search }}" @endif
                @if($category) en {{ $categories[$category] }} @endif
                <a href="#" wire:click.prevent="clearFilters" class="text-danger ms-2">
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
                        wire:click="setViewMode('cards')">
                    <i class="bi bi-grid-3x3-gap"></i> Tarjetas
                </button>
                <button type="button" class="btn btn-{{ $viewMode === 'list' ? 'primary' : 'outline-primary' }}" 
                        wire:click="setViewMode('list')">
                    <i class="bi bi-list-ul"></i> Lista
                </button>
            </div>
        </div>
    </div>
    
        <!-- Paginación -->
    @if($contacts->hasPages())
        <div class="mt-4 hidden-pagination-text">
            {{ $contacts->links('livewire::bootstrap') }}
        </div>
    @endif

    <!-- Resultados -->
    @if($contacts->count() > 0)
        @if($viewMode === 'cards')
            <!-- Vista Tarjetas con avatares -->
            <div class="row">
                @foreach($contacts as $contact)
                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="card h-100">
                    <div class="card-body text-center d-flex flex-column justify-content-between" style="min-height: 220px;">
    <!-- Avatar -->
    <div class="mb-3">
        <img src="{{ $contact->profile_picture ? asset('storage/profiles/' . $contact->profile_picture) : $contact->avatar_url }}" 
             alt="{{ $contact->full_name }}"
             class="rounded-circle mb-3"
             style="width: 80px; height: 80px; object-fit: cover;">
        
        <h5 class="card-title mb-1">{{ $contact->last_name }}, {{ $contact->first_name }}</h5>
        <div class="mb-3">
            <span class="badge bg-{{ 
                $contact->category == 'trabajo' ? 'purple' : 
                ($contact->category == 'familia' ? 'success' : 
                ($contact->category == 'amigos' ? 'warning' : 
                ($contact->category == 'otro' ? 'secondary' : 'primary'))) 
            }}">
                {{ $contact->category }}
            </span>
        </div>
    </div>

    <!-- Info con espaciado uniforme -->
    <div class="text-start small">
        @if($contact->email)
            <div class="mb-2"><i class="bi bi-envelope text-primary me-2"></i>{{ $contact->email }}</div>
        @endif
        @if($contact->phone)
            <div class="mb-2"><i class="bi bi-telephone text-success me-2"></i>{{ $contact->phone }}</div>
        @endif
        @if($contact->notes)
            <div class="text-muted">{{ Str::limit($contact->notes, 60) }}</div>
        @endif
    </div>
</div>   


                        <div class="card-footer bg-transparent">
                            <div class="btn-group btn-group-sm w-100" role="group">
                                <a href="/contactos/{{ $contact->id }}" class="btn btn-outline-primary rounded-0 rounded-start">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="/contactos/{{ $contact->id }}/edit" class="btn btn-outline-secondary rounded-0">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button class="btn btn-outline-danger rounded-0 rounded-end btn-delete" 
                                        data-delete-url="/contactos/{{ $contact->id }}">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <!-- Vista Lista con avatares -->
            <div class="card">
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @foreach($contacts as $contact)
                        <div class="list-group-item">
                            <div class="row align-items-center">
                                <div class="col-md-3">
                                    <div class="d-flex align-items-center">
                                        <!-- NUEVO: Avatar pequeño -->
                                        <img src="{{ $contact->profile_picture ? asset('storage/profiles/' . $contact->profile_picture) : $contact->avatar_url }}" 
     alt="{{ $contact->full_name }}"
     class="rounded-circle flex-shrink-0"
     style="width: 42px; height: 42px; object-fit: cover;">
<div class="ms-3">
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
                                    </div>
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
                                        <a href="/contactos/{{ $contact->id }}" class="btn btn-outline-primary rounded-0 rounded-start">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="/contactos/{{ $contact->id }}/edit" class="btn btn-outline-secondary rounded-0">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    <button class="btn btn-outline-danger rounded-0 rounded-end btn-delete" 
                                            data-delete-url="/contactos/{{ $contact->id }}">
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
                    Intenta con otros términos de búsqueda o <a href="#" wire:click.prevent="clearFilters">limpiar los filtros</a>.
                @else
                    No hay contactos disponibles. <a href="/contactos/create">Crea el primero</a>.
                @endif
            </p>
        </div>
    @endif

    <!-- Indicador de carga -->
    <div wire:loading class="position-fixed top-50 start-50 translate-middle" style="z-index: 9999;">
        <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
            <span class="visually-hidden">Cargando...</span>
        </div>
    </div>
</div>