    function toggleDarkMode() {
        document.body.classList.toggle('dark-mode');
        // Sauvegarde de l'état dans le localStorage
        if (document.body.classList.contains('dark-mode')) {
            localStorage.setItem('darkMode', 'enabled');
        } else {
            localStorage.setItem('darkMode', 'disabled');
        }
    }

    // Charger l'état du mode sombre depuis le localStorage
    window.onload = function() {
        if (localStorage.getItem('darkMode') === 'enabled') {
            document.body.classList.add('dark-mode');
        }
    }
