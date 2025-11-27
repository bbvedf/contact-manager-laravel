<!DOCTYPE html>
<html lang="es" data-bs-theme="{{ session('theme', 'light') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Contact Manager</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Nuestros estilos -->
    <link href="{{ asset('css/themes.css') }}" rel="stylesheet">
    
    

<!-- BLOQUEO TOTAL de Livewire auto-mágico -->
<script>
// 1. BLOQUEAR cualquier intento de cargar Livewire automáticamente
window.livewireDisabled = true;

// 2. Interceptar y REDIRIGIR todas las peticiones problemáticas
const originalFetch = window.fetch;
window.fetch = function(url, options = {}) {
    if (typeof url === 'string') {
        if (url.includes('/livewire/update') && !url.includes('/contactos/')) {
            console.log('🚀 Redirigiendo Livewire update a subcarpeta');
            url = url.replace('/livewire/update', '/contactos/livewire/update');
        }
        if (url.includes('/vendor/livewire/livewire.js') && !url.includes('/contactos/')) {
            console.log('🚀 BLOQUEANDO Livewire malo');
            return Promise.reject(new Error('Livewire bloqueado')); // ← BLOQUEAR el malo
        }
    }
    return originalFetch(url, options);
};

// 3. También interceptar XMLHttpRequest
const originalXHROpen = XMLHttpRequest.prototype.open;
XMLHttpRequest.prototype.open = function(method, url, async, user, password) {
    if (typeof url === 'string' && url.includes('/livewire/update') && !url.includes('/contactos/')) {
        console.log('🚀 Redirigiendo XHR Livewire update');
        url = url.replace('/livewire/update', '/contactos/livewire/update');
    }
    return originalXHROpen.call(this, method, url, async, user, password);
};

// 4. CARGAR SOLO el Livewire bueno
document.addEventListener('DOMContentLoaded', function() {
    // Esperar un poco para que no se cargue el malo
    setTimeout(() => {
        const script = document.createElement('script');
        script.src = 'https://ryzenpc.mooo.com/contactos/vendor/livewire/livewire.js';
        script.onload = function() {
            if (window.Livewire) {
                Livewire.start();
                console.log('✅ Livewire bueno cargado');
            }
        };
        document.head.appendChild(script);
    }, 100);
});
</script>
    
    

</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="{{ route('index') }}">
                <i class="bi bi-person-lines-fill"></i> Contact Manager
            </a>
            
            <!-- Switch de tema oscuro - MOSTRAR EN TODAS LAS PÁGINAS -->
            <div class="d-flex align-items-center">
                <i class="bi bi-sun-fill text-warning me-2"></i>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="themeSwitch" 
                           {{ session('theme', 'light') == 'dark' ? 'checked' : '' }}>
                    <label class="form-check-label text-white" for="themeSwitch">
                        <i class="bi bi-moon-stars-fill"></i>
                    </label>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Script para el tema oscuro - FUNCIONA EN TODAS LAS PÁGINAS -->
    <script>
        // Aplicar tema inmediatamente
        document.documentElement.setAttribute('data-bs-theme', '{{ session('theme', 'light') }}');

        document.addEventListener('DOMContentLoaded', function() {
            const themeSwitch = document.getElementById('themeSwitch');
            
            if (themeSwitch) {
                themeSwitch.addEventListener('change', function() {
                    const theme = this.checked ? 'dark' : 'light';
                    document.documentElement.setAttribute('data-bs-theme', theme);
                    
                    // Guardar preferencia en el servidor
                    fetch('/theme-toggle', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ theme: theme })
                    }).then(response => {
                        if (response.ok) {
                            console.log('Tema guardado:', theme);
                        }
                    });
                });
            }
        });
    </script>    
    
    @stack('scripts')

    <!-- Script para preview de avatar -->
    <script>
function previewAvatar(event) {
    const file = event.target.files[0];
    if (!file) return;

    if (!file.type.match('image.*')) {
        alert('Solo se permiten imágenes');
        return;
    }
    if (file.size > 2 * 1024 * 1024) {
        alert('La imagen no puede pesar más de 2MB');
        event.target.value = '';
        return;
    }

    const reader = new FileReader();
    reader.onload = function(e) {
        document.getElementById('current-avatar').src = e.target.result;
    }
    reader.readAsDataURL(file);
}
</script>

    <!-- Modal de confirmación para eliminar -->
    <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteConfirmModalLabel">
                        <i class="bi bi-exclamation-triangle text-warning"></i> Confirmar eliminación
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>¿Estás seguro de que quieres eliminar este contacto?</p>
                    <p class="text-muted small">Esta acción no se puede deshacer.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Cancelar
                    </button>
                    <form id="deleteForm" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash"></i> Sí, eliminar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Script para el modal de eliminación -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
            let deleteForm = document.getElementById('deleteForm');
            
            // Configurar todos los botones de eliminar
            document.querySelectorAll('.btn-delete').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Configurar el formulario con la acción correcta
                    const deleteUrl = this.getAttribute('data-delete-url');
                    deleteForm.action = deleteUrl;
                    
                    // Mostrar modal
                    deleteModal.show();
                });
            });
        });
    </script>
</body>
</html>
