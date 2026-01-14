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
                @if(isset($is_approved) && $is_approved === true)
                    <!-- --- SECCIÓN: NAVEGACIÓN --- -->
                    <div class="menu-section-header">Navegación</div>
                    <button class="menu-item" onclick="window.location.href='https://ryzenpc.mooo.com/'">
                        <i class="bi bi-house-fill"></i> Dashboard Principal
                    </button>
                    @if(isset($is_admin) && $is_admin === true)
                        <button class="menu-item" onclick="window.location.href='https://ryzenpc.mooo.com/#/dashboard?tab=configuracion'">
                            <i class="bi bi-people-fill"></i> Gestión de Usuarios
                        </button>
                    @endif

                    <div class="menu-divider"></div>

                    <!-- --- SECCIÓN: APLICACIONES --- -->
                    <div class="menu-section-header">Aplicaciones</div>
                    
                    <!-- Finanzas (Colapsable) -->
                    <div class="submenu">
                        <div class="menu-item-container">
                            <div class="menu-item-header" onclick="toggleSubmenu('finanzas', event)">
                                <i class="bi bi-wallet2"></i> <span>Finanzas Personales</span>
                            </div>
                            <button class="submenu-toggle" onclick="toggleSubmenu('finanzas', event)">
                                <i class="bi bi-chevron-down" id="toggle-icon-finanzas"></i>
                            </button>
                        </div>
                        <div class="submenu-content" id="submenu-finanzas" style="display: none;">
                            <button class="menu-sub-item menu-item" onclick="window.location.href='https://ryzenpc.mooo.com/finanzas/categories'">
                                <i class="bi bi-folder2-open"></i> Categorías
                            </button>
                            <button class="menu-sub-item menu-item" onclick="window.location.href='https://ryzenpc.mooo.com/finanzas/transactions'">
                                <i class="bi bi-cash-stack"></i> Transacciones
                            </button>
                            <button class="menu-sub-item menu-item" onclick="window.location.href='https://ryzenpc.mooo.com/finanzas/stats'">
                                <i class="bi bi-graph-up-arrow"></i> Estadísticas
                            </button>
                        </div>
                    </div>

                    <!-- Geo-Data (Colapsable) -->
                    <div class="submenu">
                        <div class="menu-item-container">
                            <div class="menu-item-header" onclick="toggleSubmenu('geo', event)">
                                <i class="bi bi-geo-alt-fill"></i> <span>Geo-Data Analytics</span>
                            </div>
                            <button class="submenu-toggle" onclick="toggleSubmenu('geo', event)">
                                <i class="bi bi-chevron-down" id="toggle-icon-geo"></i>
                            </button>
                        </div>
                        <div class="submenu-content" id="submenu-geo" style="display: none;">
                            <button class="menu-sub-item menu-item" onclick="window.location.href='https://ryzenpc.mooo.com/geo/'">
                                <i class="bi bi-speedometer2"></i> Inicio
                            </button>
                            <button class="menu-sub-item menu-item" onclick="window.location.href='/geo/dataset/covid'">
                                <i class="bi bi-virus"></i> COVID España
                            </button>
                            <button class="menu-sub-item menu-item" onclick="window.location.href='/geo/dataset/weather'">
                                <i class="bi bi-cloud-sun-fill"></i> Clima España
                            </button>
                            <button class="menu-sub-item menu-item" onclick="window.location.href='/geo/dataset/elections'">
                                <i class="bi bi-bar-chart-fill"></i> Resultados Electorales
                            </button>
                            <button class="menu-sub-item menu-item" onclick="window.location.href='/geo/dataset/airquality'">
                                <i class="bi bi-wind"></i> Calidad del Aire
                            </button>
                            <button class="menu-sub-item menu-item" onclick="window.location.href='/geo/dataset/housing'">
                                <i class="bi bi-house-door-fill"></i> Precios Vivienda
                            </button>
                        </div>
                    </div>

                    @if(isset($is_admin) && $is_admin === true)
                        <button class="menu-item" onclick="window.location.href='https://ryzenpc.mooo.com/tickets/'">
                            <i class="bi bi-ticket-perforated-fill"></i> Sistema de Tickets
                        </button>
                    @endif

                    <!-- Agenda (Activo) -->
                    <button class="menu-item" onclick="window.location.href='/contactos/'">
                        <i class="bi bi-person-lines-fill"></i> Agenda de Contactos
                    </button>

                    <div class="menu-divider"></div>

                    <!-- --- SECCIÓN: HERRAMIENTAS --- -->
                    <div class="menu-section-header">Herramientas</div>
                    <button class="menu-item" onclick="window.location.href='https://ryzenpc.mooo.com/#/dashboard?tab=calculadora'">
                        <i class="bi bi-calculator-fill"></i> Interés Compuesto
                    </button>
                    <button class="menu-item" onclick="window.location.href='https://ryzenpc.mooo.com/#/dashboard?tab=mortgage'">
                        <i class="bi bi-house-door-fill"></i> Hipoteca
                    </button>
                    <button class="menu-item" onclick="window.location.href='https://ryzenpc.mooo.com/#/dashboard?tab=basic-calculator'">
                        <i class="bi bi-percent"></i> Calculadora Básica
                    </button>

                    <div class="menu-divider"></div>
                @else
                    <div class="menu-section-header">Sistema</div>
                @endif

                <!-- --- SECCIÓN: SISTEMA --- -->
                <button onclick="toggleTheme()" class="menu-item" type="button">
                    <i id="theme-icon" class="bi bi-moon-stars-fill"></i>
                    <span id="theme-text">Modo Oscuro</span>
                </button>

                <button onclick="forceLogout()" class="menu-item logout-item">
                    <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
                </button>

                <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const hamburger = document.getElementById('hamburger-menu');
                    const dropdown = document.getElementById('menu-dropdown');
                    
                    if (hamburger && dropdown) {
                        hamburger.addEventListener('click', function(e) {
                            e.stopPropagation();
                            dropdown.classList.toggle('active');
                        });
                    }
                });

                function toggleSubmenu(name, event) {
                    event.preventDefault();
                    event.stopPropagation();
                    const content = document.getElementById('submenu-' + name);
                    const icon = document.getElementById('toggle-icon-' + name);
                    const isOpen = content.style.display === 'block';

                    content.style.display = isOpen ? 'none' : 'block';
                    icon.className = isOpen ? 'bi bi-chevron-down' : 'bi bi-chevron-up';
                }

                // Cerrar menú al hacer clic fuera
                document.addEventListener('click', function (event) {
                    const dropdown = document.getElementById('menu-dropdown');
                    const hamburger = document.getElementById('hamburger-menu');
                    if (!dropdown.contains(event.target) && !hamburger.contains(event.target)) {
                        dropdown.classList.remove('active');
                    }
                });

                function forceLogout() {
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
                    window.location.href = 'https://ryzenpc.mooo.com/#/login?force_logout=true&t=' + Date.now();
                }
                </script>
            </div>
        </div>
    </div>
</header>

<div class="header-spacer"></div>