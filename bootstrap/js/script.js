function toggleDarkMode() {
    const body = document.body;
    body.classList.toggle('dark-mode');
    
    // Optionnel : Enregistrer le mode préféré dans le localStorage
    if (body.classList.contains('dark-mode')) {
        localStorage.setItem('theme', 'dark');
    } else {
        localStorage.setItem('theme', 'light');
    }
}

// Optionnel : Charger le thème préféré depuis le localStorage au chargement de la page
document.addEventListener('DOMContentLoaded', function() {
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme === 'dark') {
        document.body.classList.add('dark-mode');
    }
});
