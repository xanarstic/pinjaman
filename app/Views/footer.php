</main>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    const htmlTag = document.documentElement;

    function toggleTheme() {
        const currentTheme = htmlTag.getAttribute('data-bs-theme');
        const newTheme = currentTheme === 'light' ? 'dark' : 'light';
        htmlTag.setAttribute('data-bs-theme', newTheme);
        localStorage.setItem('theme', newTheme);
        syncThemeUI(newTheme);
    }

    function syncThemeUI(theme) {
        const toggles = document.querySelectorAll('.theme-toggle-class');
        const icons = document.querySelectorAll('.theme-icon-class');
        toggles.forEach(t => t.checked = (theme === 'dark'));
        icons.forEach(icon => {
            if (theme === 'dark') icon.classList.replace('bi-sun-fill', 'bi-moon-stars-fill');
            else icon.classList.replace('bi-moon-stars-fill', 'bi-sun-fill');
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        const currentTheme = htmlTag.getAttribute('data-bs-theme');
        syncThemeUI(currentTheme);
        setTimeout(function () { $(".alert").fadeOut('slow'); }, 3000);
    });
</script>
</body>

</html>