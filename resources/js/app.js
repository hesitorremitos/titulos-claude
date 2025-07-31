import './bootstrap';

// Toggle de tema oscuro/claro
document.addEventListener('DOMContentLoaded', function() {
    const themeToggle = document.getElementById('theme-toggle');
    const html = document.documentElement;
    
    // Función para aplicar tema
    function setTheme(theme) {
        console.log('Aplicando tema:', theme);
        
        if (theme === 'dark') {
            html.classList.add('dark');
            if (themeToggle) {
                themeToggle.title = 'Cambiar a tema claro';
            }
        } else {
            html.classList.remove('dark');
            if (themeToggle) {
                themeToggle.title = 'Cambiar a tema oscuro';
            }
        }
        
        localStorage.setItem('theme', theme);
        console.log('Clases HTML después del cambio:', html.className);
        console.log('Tema guardado en localStorage:', theme);
    }
    
    // Obtener tema inicial
    const initialTheme = localStorage.getItem('theme') || 'light';
    console.log('Tema inicial:', initialTheme);
    setTheme(initialTheme);
    
    // Manejar click del toggle
    if (themeToggle) {
        themeToggle.addEventListener('click', function(e) {
            e.preventDefault();
            const currentTheme = localStorage.getItem('theme') || 'light';
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            console.log('Toggle clicked - Cambiando de', currentTheme, 'a', newTheme);
            setTheme(newTheme);
        });
    }
    
    // Menú móvil
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    const mobileMenuClose = document.getElementById('mobile-menu-close');
    const mobileMenuOverlay = document.getElementById('mobile-menu-overlay');
    
    function toggleMobileMenu() {
        if (mobileMenu.style.display === 'none' || !mobileMenu.style.display) {
            mobileMenu.style.display = 'block';
            document.body.style.overflow = 'hidden';
        } else {
            mobileMenu.style.display = 'none';
            document.body.style.overflow = '';
        }
    }
    
    if (mobileMenuButton) {
        mobileMenuButton.addEventListener('click', toggleMobileMenu);
    }
    
    if (mobileMenuClose) {
        mobileMenuClose.addEventListener('click', toggleMobileMenu);
    }
    
    if (mobileMenuOverlay) {
        mobileMenuOverlay.addEventListener('click', toggleMobileMenu);
    }

    // Dropdown del perfil de usuario
    const userMenuButton = document.getElementById('user-menu-button');
    const userMenu = document.getElementById('user-menu');
    
    if (userMenuButton && userMenu) {
        // Toggle del dropdown
        userMenuButton.addEventListener('click', function(e) {
            e.stopPropagation();
            const isHidden = userMenu.classList.contains('hidden');
            
            if (isHidden) {
                userMenu.classList.remove('hidden');
                userMenuButton.setAttribute('aria-expanded', 'true');
            } else {
                userMenu.classList.add('hidden');
                userMenuButton.setAttribute('aria-expanded', 'false');
            }
        });
        
        // Cerrar dropdown al hacer click fuera
        document.addEventListener('click', function(e) {
            if (!userMenuButton.contains(e.target) && !userMenu.contains(e.target)) {
                userMenu.classList.add('hidden');
                userMenuButton.setAttribute('aria-expanded', 'false');
            }
        });
        
        // Cerrar dropdown con tecla Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !userMenu.classList.contains('hidden')) {
                userMenu.classList.add('hidden');
                userMenuButton.setAttribute('aria-expanded', 'false');
                userMenuButton.focus();
            }
        });
    }
});
