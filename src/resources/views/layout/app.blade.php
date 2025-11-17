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
    
    @livewireStyles
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="{{ route('contacts.index') }}">
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
    
    @livewireScripts
    @stack('scripts')


<script>
    // Versión limpia - sin console.log
    function getCurrentTheme() {
        return localStorage.getItem('theme') || 'light';
    }

    function applyTheme(theme) {
        document.documentElement.setAttribute('data-bs-theme', theme);
        localStorage.setItem('theme', theme);
    }

    // Aplicar tema al cargar
    applyTheme(getCurrentTheme());

    document.addEventListener('DOMContentLoaded', function() {
        const themeSwitch = document.getElementById('themeSwitch');
        
        if (themeSwitch) {
            themeSwitch.checked = getCurrentTheme() === 'dark';
            
            themeSwitch.addEventListener('change', function() {
                const theme = this.checked ? 'dark' : 'light';
                applyTheme(theme);
                
                fetch('/theme-toggle', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ theme: theme })
                });
            });
        }
    });
</script>

</body>
</html>