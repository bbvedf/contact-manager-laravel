<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contactos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/integrated.css') }}?v={{ time() }}"><!-- Cache busting -->
    <!--<link rel="stylesheet" href="/css/integrated.css"> -->
    @livewireStyles  <!-- ← AÑADIR ESTO -->
    @stack('scripts')
</head>
<body>
    @include('layout.partials.header')

<div class="container-fluid py-4">
    @yield('content')
</div>

    @livewireScripts  <!-- ← AÑADIR ESTO -->
    @include('layout.partials.scripts')

<!-- Modal de confirmación para eliminar -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-exclamation-triangle text-warning"></i> Confirmar eliminación
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
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

<script>
// Script para el modal de eliminación
document.addEventListener('DOMContentLoaded', function() {
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
    const deleteForm = document.getElementById('deleteForm');
    
    // Configurar todos los botones de eliminar
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const deleteUrl = this.getAttribute('data-delete-url') || this.closest('form').action;
            deleteForm.action = deleteUrl;
            deleteModal.show();
        });
    });
});
</script>

</body>
</html>