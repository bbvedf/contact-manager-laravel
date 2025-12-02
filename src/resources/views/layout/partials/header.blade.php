<header class="app-header">
    <div class="header-content">
        <div class="header-logo-section">
            <img src="logo_light.png" class="header-logo" alt="Logo" id="app-logo">
            <h1 class="app-title mb-0">Contactos</h1>
        </div>

        <div class="theme-menu-container">
            <button id="hamburger-menu" class="hamburger-button" type="button" aria-label="Menú">
                <span></span><span></span><span></span>
            </button>

            <div id="menu-dropdown" class="menu-dropdown">

                <!-- INICIO -->
                <button class="menu-item" onclick="window.location.href='https://ryzenpc.mooo.com/'">
                    <i class="bi bi-house-fill"></i> Inicio
                </button>

                <!-- GESTIÓN DE USUARIOS (solo admin) -->
                @if(isset($is_admin) && $is_admin === true)
                    <button class="menu-item" onclick="window.location.href='https://ryzenpc.mooo.com/dashboard?tab=configuracion'">
                        <i class="bi bi-people-fill"></i> Gestión de Usuarios
                    </button>
                @endif

                <!-- FINANZAS (submenú) -->
                @if(isset($is_admin) && $is_admin === true)
                    <div class="submenu">
                        <div class="submenu-header">
                            <i class="bi bi-wallet2"></i> Finanzas
                        </div>
                        <button class="menu-item" onclick="window.location.href='https://ryzenpc.mooo.com/finanzas/categories'">
                            <i class="bi bi-folder-fill"></i></i> Categorías
                        </button>
                        <button class="menu-item" onclick="window.location.href='https://ryzenpc.mooo.com/finanzas/transactions'">
                            <i class="bi bi-credit-card-fill"></i> Transacciones
                        </button>
                        <button class="menu-item" onclick="window.location.href='https://ryzenpc.mooo.com/finanzas/stats'">
                            <i class="bi bi-bar-chart-fill"></i> Estadísticas
                        </button>
                    </div>
                    <div class="menu-divider"></div>
                @endif

                <!-- CALCULADORAS (solo admin) -->
                @if(isset($is_admin) && $is_admin === true)
                    <button class="menu-item" onclick="window.location.href='https://ryzenpc.mooo.com/#calculadora'">
                        <i class="bi bi-calculator-fill"></i> Interés Compuesto
                    </button>
                    <button class="menu-item" onclick="window.location.href='https://ryzenpc.mooo.com/#mortgage'">
                        <i class="bi bi-graph-up"></i> Amortización Hipoteca
                    </button>
                    <button class="menu-item" onclick="window.location.href='https://ryzenpc.mooo.com/#basic-calculator'">
                        <i class="bi bi-percent"></i> Calculadora Básica
                    </button>
                    <div class="menu-divider"></div>
                @endif

                <!-- CONTACTOS -->
                <button class="menu-item" onclick="window.location.href='https://ryzenpc.mooo.com/contactos/'">
                    <i class="bi bi-person-lines-fill"></i> Contactos
                </button>

                <div class="menu-divider"></div>

                <!-- TEMA -->
                <button onclick="toggleTheme()" class="menu-item menu-theme-toggle" type="button">
                    <i id="theme-icon" class="bi bi-moon-fill"></i>
                    <span id="theme-text">Modo Oscuro</span>
                </button>

                <!-- CERRAR SESIÓN -->
                <a href="javascript:void(0)" onclick="showLogoutModal()" class="menu-item text-danger">
                    <i class="bi bi-box-arrow-right"></i> Cerrar sesión
                </a>

                <script>
               function forceLogout() {
    // EL QUE SÍ FUNCIONABA
    const domains = ['', '.ryzenpc.mooo.com', 'ryzenpc.mooo.com'];
    const cookies = ['compras_token', 'token', 'auth_token', 'laravel_session', 'XSRF-TOKEN'];
    const paths = ['/', '/contactos'];
    
    domains.forEach(domain => {
        cookies.forEach(cookie => {
            paths.forEach(path => {
                document.cookie = `${cookie}=; expires=Thu, 01 Jan 1970 00:00:00 UTC; domain=${domain}; path=${path};`;
            });
        });
    });
    
    localStorage.clear();
    sessionStorage.clear();
    
    // Esta parte SÍ funcionaba
    window.location.href = 'https://ryzenpc.mooo.com/#/login?force_logout=true&t=' + Date.now();
}


                </script>

            </div>
        </div>
    </div>
</header>

<div class="header-spacer"></div>