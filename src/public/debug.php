<?php
echo "=== DEBUG ROUTES ===\n";
echo "REQUEST_URI: " . ($_SERVER['REQUEST_URI'] ?? 'N/A') . "\n";
echo "SCRIPT_NAME: " . ($_SERVER['SCRIPT_NAME'] ?? 'N/A') . "\n";
echo "PATH_INFO: " . ($_SERVER['PATH_INFO'] ?? 'N/A') . "\n";
echo "app.url config: " . config('app.url') . "\n";

// Verificar si existe la ruta de Livewire
echo "\n=== Testing Livewire routes ===\n";
$router = app('router');
$routes = $router->getRoutes()->getRoutes();
foreach ($routes as $route) {
    if (strpos($route->uri, 'livewire') !== false) {
        echo "Route found: " . $route->uri . "\n";
    }
}
