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
</head>
<body>
    @include('layout.partials.header')

<div class="container-fluid py-4">
    @yield('content')
</div>

    @livewireScripts  <!-- ← AÑADIR ESTO -->
    @include('layout.partials.scripts')
</body>
</html>