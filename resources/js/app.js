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
    
});
