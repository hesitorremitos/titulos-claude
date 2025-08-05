import './bootstrap';

// Toggle de tema oscuro/claro
document.addEventListener('DOMContentLoaded', function() {
    const themeToggle = document.getElementById('theme-toggle');
    const html = document.documentElement;
    
    // Función para aplicar tema y actualizar UI
    function setTheme(theme) {
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
    }
    
    // Obtener tema inicial para sincronizar título del botón
    let currentTheme = localStorage.getItem('theme') || 
                      (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
    
    // Solo actualizar el título del botón (el tema ya fue aplicado por el script inline)
    if (themeToggle) {
        themeToggle.title = currentTheme === 'dark' ? 'Cambiar a tema claro' : 'Cambiar a tema oscuro';
        
        // Manejar click del toggle
        themeToggle.addEventListener('click', function(e) {
            e.preventDefault();
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            setTheme(newTheme);
            // Actualizar la variable para el próximo click
            currentTheme = newTheme;
        });
    }
});
