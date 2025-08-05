<!-- Scripts para navegación suave y modo oscuro -->
<script>
    // Navegación suave para los enlaces de la guía
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Resaltar sección activa en navegación
    const sections = document.querySelectorAll('section[id]');
    const navLinks = document.querySelectorAll('nav a[href^="#"]');

    window.addEventListener('scroll', () => {
        let current = '';
        sections.forEach(section => {
            const sectionTop = section.offsetTop;
            const sectionHeight = section.clientHeight;
            if (scrollY >= sectionTop - 200) {
                current = section.getAttribute('id');
            }
        });

        navLinks.forEach(link => {
            link.classList.remove('text-primary-600', 'dark:text-primary-400');
            link.classList.add('text-gray-700', 'dark:text-gray-300');
            if (link.getAttribute('href') === `#${current}`) {
                link.classList.remove('text-gray-700', 'dark:text-gray-300');
                link.classList.add('text-primary-600', 'dark:text-primary-400');
            }
        });
    });

    // Dark Mode con Alpine.js (Esperando que Alpine esté listo)
    // Función Alpine.js para Dark Mode Toggle
    function darkModeToggle() {
        return {
            isDark: false,
            
            init() {
                // Inicializar tema basado en preferencia guardada o sistema
                const savedTheme = localStorage.getItem('theme');
                const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                
                this.isDark = savedTheme === 'dark' || (!savedTheme && systemPrefersDark);
                this.applyTheme();
                
                // Escuchar cambios en preferencia del sistema
                window.matchMedia('(prefers-color-scheme: dark)')
                      .addEventListener('change', (e) => {
                    if (!localStorage.getItem('theme')) {
                        this.isDark = e.matches;
                        this.applyTheme();
                    }
                });
            },
            
            toggle() {
                this.isDark = !this.isDark;
                this.applyTheme();
                localStorage.setItem('theme', this.isDark ? 'dark' : 'light');
            },
            
            applyTheme() {
                document.documentElement.classList.toggle('dark', this.isDark);
            }
        }
    }
</script>
