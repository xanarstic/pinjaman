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
<<<<<<< HEAD
    });

    // --- FITUR INTERAKTIF (SweetAlert2 & Loading State) ---

    // 1. Konfirmasi Logout
    function confirmLogout(url) {
        const isDark = document.documentElement.getAttribute('data-bs-theme') === 'dark';
        Swal.fire({
            title: 'Keluar Sistem?',
            text: "Sesi anda akan diakhiri sekarang.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Keluar',
            cancelButtonText: 'Batal',
            background: isDark ? '#1e293b' : '#fff',
            color: isDark ? '#f8fafc' : '#1e293b'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    }

    // 2. Notifikasi Flashdata Otomatis (Success/Error)
    <?php if (session()->getFlashdata('success')): ?>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '<?= session()->getFlashdata('success') ?>',
            timer: 3000,
            showConfirmButton: false,
            background: document.documentElement.getAttribute('data-bs-theme') === 'dark' ? '#1e293b' : '#fff',
            color: document.documentElement.getAttribute('data-bs-theme') === 'dark' ? '#f8fafc' : '#1e293b'
        });
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '<?= session()->getFlashdata('error') ?>',
            background: document.documentElement.getAttribute('data-bs-theme') === 'dark' ? '#1e293b' : '#fff',
            color: document.documentElement.getAttribute('data-bs-theme') === 'dark' ? '#f8fafc' : '#1e293b'
        });
    <?php endif; ?>

    // 3. Loading State pada Tombol Submit Form (Tambah/Edit)
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function() {
            const btn = this.querySelector('button[type="submit"]');
            if (btn) {
                btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Memproses...';
                btn.style.opacity = '0.8';
                btn.style.pointerEvents = 'none'; // Mencegah klik ganda
            }
        });
=======
        setTimeout(function () { $(".alert").fadeOut('slow'); }, 3000);
>>>>>>> 76654e63e3b235c2566e0adcd60cb34f8944b1fc
    });
</script>
</body>

</html>