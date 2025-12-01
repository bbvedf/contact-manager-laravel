// ===== INTEGRACIÓN CON COMPRAS =====

document.addEventListener('DOMContentLoaded', function () {
    initializeAuthBridge();
    initializeMenu();
    initializeThemeSync();
});

// ------------------------------------------------------------------
// 1. AUTH BRIDGE (sin cambios)
function initializeAuthBridge() {
    setTimeout(() => {
        if (window.AuthBridge && window.AuthBridge.getToken) {
            const token = window.AuthBridge.getToken();
            if (token) {
                document.cookie = `compras_token=${token}; path=/; samesite=lax`;

                if (window.Livewire) {
                    window.Livewire.hook('request', ({ options }) => {
                        options.headers['X-Compras-Token'] = token;
                    });
                }
            }
        }
    }, 100);
}

// ------------------------------------------------------------------
// 2. MENÚ HAMBURGUESA
function initializeMenu() {
    const hamburgerButton = document.getElementById('hamburger-menu');
    const menuDropdown = document.getElementById('menu-dropdown');

    if (hamburgerButton && menuDropdown) {
        hamburgerButton.addEventListener('click', function (e) {
            e.stopPropagation();
            menuDropdown.classList.toggle('show');
        });

        document.addEventListener('click', () => menuDropdown.classList.remove('show'));
    }
}

// ------------------------------------------------------------------
// 3. APLICAR TEMA DE FORMA INSTANTÁNEA (¡sin flash!)
function applyThemeInstantly(theme) {
    theme = theme === 'dark' ? 'dark' : 'light'; // seguridad
    document.documentElement.setAttribute('data-bs-theme', theme);
    const logo = document.querySelector('.header-logo');
    if (logo) logo.src = `/logo_${theme}.png`;
}

// ------------------------------------------------------------------
// 4. SINCRONIZAR TEMA CON SESIÓN DE LARAVEL (en segundo plano)
function saveThemeToLaravel(theme) {
    fetch('/contactos/theme-toggle', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
        },
        body: JSON.stringify({ theme: theme })
    });
    // NO esperamos respuesta ni recargamos → ya lo tenemos aplicado
}

// ------------------------------------------------------------------
// 5. SINCRONIZACIÓN INICIAL + ESCUCHA DE CAMBIOS
function initializeThemeSync() {
    const comprasTheme = localStorage.getItem('theme') || 'light';
    const currentTheme = document.documentElement.getAttribute('data-bs-theme') || 'light';

    // Aplicar inmediatamente el tema de Compras (elimina el flash)
    if (comprasTheme !== currentTheme) {
        applyThemeInstantly(comprasTheme);
    }

    // Guardar en sesión de Laravel (para la próxima visita)
    saveThemeToLaravel(comprasTheme);

    // Escuchar cambios futuros desde Compras u otras pestañas
    window.addEventListener('storage', (e) => {
        if (e.key === 'theme' && e.newValue) {
            const newTheme = e.newValue;
            if (newTheme !== document.documentElement.getAttribute('data-bs-theme')) {
                applyThemeInstantly(newTheme);
                saveThemeToLaravel(newTheme);
            }
        }
    });
}

// ------------------------------------------------------------------
// 6. TOGGLE DESDE EL MENÚ DE CONTACTOS
function toggleTheme() {
    const current = document.documentElement.getAttribute('data-bs-theme') || 'light';
    const newTheme = current === 'light' ? 'dark' : 'light';

    // Aplicar en Contactos inmediatamente
    applyThemeInstantly(newTheme);

    // Guardar en Compras (para que todas las pestañas lo pillen)
    localStorage.setItem('theme', newTheme);

    // Guardar también en sesión de Laravel
    saveThemeToLaravel(newTheme);
}

// ---------------------------------------------------------------
// ACTUALIZAR EL ICONO Y TEXTO DEL BOTÓN DEL MENÚ EN TIEMPO REAL
function updateThemeButton() {
    const current = document.documentElement.getAttribute('data-bs-theme') || 'light';
    const icon = document.getElementById('theme-icon');
    const text = document.getElementById('theme-text');

    if (current === 'light') {
        icon.classList.replace('bi-sun-fill', 'bi-moon-fill');
        text.textContent = 'Modo Oscuro';
    } else {
        icon.classList.replace('bi-moon-fill', 'bi-sun-fill');
        text.textContent = 'Modo Claro';
    }
}

// Llamarlo cada vez que cambiemos el tema
const originalApply = applyThemeInstantly;
window.applyThemeInstantly = function(theme) {
    originalApply(theme);
    updateThemeButton();
};

// También al cargar la página (por si acaso)
document.addEventListener('DOMContentLoaded', updateThemeButton);

// ------------------------------------------------------------------
// LIVEWIRE FIXES (sin cambios, los dejo tal cual)
window.livewireDisabled = true;

const originalFetch = window.fetch;
window.fetch = function (url, options = {}) {
    if (typeof url === 'string') {
        if (url.includes('/livewire/update') && !url.includes('/contactos/')) {
            url = url.replace('/livewire/update', '/contactos/livewire/update');
        }
        if (url.includes('/vendor/livewire/livewire.js') && !url.includes('/contactos/')) {
            return Promise.reject(new Error('Livewire bloqueado'));
        }
    }
    return originalFetch(url, options);
};

const originalXHROpen = XMLHttpRequest.prototype.open;
XMLHttpRequest.prototype.open = function (method, url, async, user, password) {
    if (typeof url === 'string' && url.includes('/livewire/update') && !url.includes('/contactos/')) {
        url = url.replace('/livewire/update', '/contactos/livewire/update');
    }
    return originalXHROpen.call(this, method, url, async, user, password);
};

document.addEventListener('DOMContentLoaded', function () {
    setTimeout(() => {
        const script = document.createElement('script');
        script.src = 'https://ryzenpc.mooo.com/contactos/vendor/livewire/livewire.js';
        script.onload = () => {
            if (window.Livewire) {
                Livewire.start();
                console.log('Livewire cargado correctamente');
            }
        };
        document.head.appendChild(script);
    }, 100);
});

// ===== FIN INTEGRACIÓN CON COMPRAS =====