<div class="container-fluid">
    <!-- Welcome Banner -->
    <div class="card border-0 shadow-sm p-4 mb-4 position-relative overflow-hidden"
        style="background: linear-gradient(135deg, #facc15 0%, #eab308 100%); border-radius: 20px;">
        <!-- Decoration Icon -->
        <div class="position-absolute top-50 end-0 translate-middle-y opacity-10 pe-4 d-none d-md-block" style="pointer-events: none;">
            <i class="bi bi-box-seam" style="font-size: 8rem; color: #000;"></i>
        </div>
        
        <div class="row align-items-center position-relative z-1">
            <div class="col-12 col-md-8">
                <h3 class="fw-bold mb-2 text-dark">Halo, <?= esc(session()->get('nama')) ?>! 👋</h3>
                <p class="mb-0 text-dark opacity-75 fs-6">
                    Selamat datang di panel kontrol inventaris. <br class="d-none d-md-block">
                    Pantau aset dan kelola peminjaman dengan mudah hari ini.
                </p>
            </div>
            <div class="col-12 col-md-4 text-md-end mt-3 mt-md-0">
                <a href="<?= site_url('home/log') ?>" class="btn btn-dark rounded-pill px-4 py-2 fw-bold shadow-sm">
                    <i class="bi bi-clock-history me-2"></i> Riwayat
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="row g-3 mb-4">
        <!-- Total Barang -->
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm p-3 h-100 theme-card hover-scale">
                <div class="d-flex align-items-center mb-2">
                    <div class="icon-box bg-primary bg-opacity-10 text-primary rounded-circle p-2 me-2">
                        <i class="bi bi-box-seam fs-4"></i>
                    </div>
                    <span class="small text-muted fw-bold text-uppercase">Total Aset</span>
                </div>
                <h2 class="fw-bold mb-0 text-main counter" data-target="<?= $totalBarang ?>">0</h2>
                <small class="text-secondary" style="font-size: 0.7rem;">Unit Barang</small>
            </div>
        </div>

        <!-- Barang Dipakai -->
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm p-3 h-100 theme-card hover-scale">
                <div class="d-flex align-items-center mb-2">
                    <div class="icon-box bg-warning bg-opacity-10 text-warning rounded-circle p-2 me-2">
                        <i class="bi bi-hand-index-thumb fs-4"></i>
                    </div>
                    <span class="small text-muted fw-bold text-uppercase">Dipinjam</span>
                </div>
                <h2 class="fw-bold mb-0 text-main counter" data-target="<?= $barangDipakai ?>">0</h2>
                <small class="text-secondary" style="font-size: 0.7rem;">Unit Sedang Keluar</small>
            </div>
        </div>

        <!-- Barang Tersedia (Calculated) -->
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm p-3 h-100 theme-card hover-scale">
                <div class="d-flex align-items-center mb-2">
                    <div class="icon-box bg-success bg-opacity-10 text-success rounded-circle p-2 me-2">
                        <i class="bi bi-check-circle fs-4"></i>
                    </div>
                    <span class="small text-muted fw-bold text-uppercase">Tersedia</span>
                </div>
                <h2 class="fw-bold mb-0 text-main counter" data-target="<?= $totalBarang - $barangDipakai ?>">0</h2>
                <small class="text-secondary" style="font-size: 0.7rem;">Siap Dipinjam</small>
            </div>
        </div>

        <!-- Total User -->
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm p-3 h-100 theme-card hover-scale">
                <div class="d-flex align-items-center mb-2">
                    <div class="icon-box bg-info bg-opacity-10 text-info rounded-circle p-2 me-2">
                        <i class="bi bi-people fs-4"></i>
                    </div>
                    <span class="small text-muted fw-bold text-uppercase">Pengguna</span>
                </div>
                <h2 class="fw-bold mb-0 text-main counter" data-target="<?= $totalUser ?>">0</h2>
                <small class="text-secondary" style="font-size: 0.7rem;">Terdaftar</small>
            </div>
        </div>
    </div>

    <!-- Quick Shortcuts -->
    <h5 class="fw-bold text-main mb-3"><i class="bi bi-grid-fill me-2 text-yellow"></i>Akses Cepat</h5>
    <div class="row g-3">
        <div class="col-12 col-md-4">
            <a href="<?= site_url('home/barang') ?>" class="card border-0 shadow-sm p-3 theme-card text-decoration-none hover-scale h-100 d-flex flex-row align-items-center">
                <div class="bg-yellow text-dark rounded-3 p-3 me-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                    <i class="bi bi-search fs-4"></i>
                </div>
                <div>
                    <h6 class="fw-bold text-main mb-1">Cari Barang</h6>
                    <p class="text-muted small mb-0">Lihat katalog & stok.</p>
                </div>
            </a>
        </div>
        
        <div class="col-12 col-md-4">
            <a href="<?= site_url('home/log') ?>" class="card border-0 shadow-sm p-3 theme-card text-decoration-none hover-scale h-100 d-flex flex-row align-items-center">
                <div class="bg-yellow text-dark rounded-3 p-3 me-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                    <i class="bi bi-plus-lg fs-4"></i>
                </div>
                <div>
                    <h6 class="fw-bold text-main mb-1">Pinjam Barang</h6>
                    <p class="text-muted small mb-0">Buat permohonan baru.</p>
                </div>
            </a>
        </div>

        <?php if(session()->get('role') === 'admin' || session()->get('role') === 'asistant'): ?>
        <div class="col-12 col-md-4">
            <a href="<?= site_url('home/log?status=menunggu_persetujuan') ?>" class="card border-0 shadow-sm p-3 theme-card text-decoration-none hover-scale h-100 d-flex flex-row align-items-center">
                <div class="bg-yellow text-dark rounded-3 p-3 me-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                    <i class="bi bi-check2-square fs-4"></i>
                </div>
                <div>
                    <h6 class="fw-bold text-main mb-1">Verifikasi Request</h6>
                    <p class="text-muted small mb-0">Cek permintaan masuk.</p>
                </div>
            </a>
        </div>
        <?php else: ?>
        <div class="col-12 col-md-4">
            <a href="<?= site_url('home/log?status=dipinjam') ?>" class="card border-0 shadow-sm p-3 theme-card text-decoration-none hover-scale h-100 d-flex flex-row align-items-center">
                <div class="bg-yellow text-dark rounded-3 p-3 me-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                    <i class="bi bi-box-arrow-in-down fs-4"></i>
                </div>
                <div>
                    <h6 class="fw-bold text-main mb-1">Barang Aktif</h6>
                    <p class="text-muted small mb-0">Cek barang bawaan Anda.</p>
                </div>
            </a>
        </div>
        <?php endif; ?>
    </div>
</div>

<style>
    .theme-card {
        background-color: var(--bg-card) !important;
        color: var(--text-main);
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .text-main {
        color: var(--text-main) !important;
    }
    .bg-yellow {
        background-color: var(--primary-yellow) !important;
    }
    .text-yellow {
        color: var(--primary-yellow) !important;
    }
    .hover-scale:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1)!important;
    }
    .icon-box {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>

<script>
    // Animasi Counter Angka
    document.addEventListener("DOMContentLoaded", () => {
        const counters = document.querySelectorAll('.counter');
        counters.forEach(counter => {
            const target = +counter.getAttribute('data-target');
            const duration = 800; 
            const increment = target / (duration / 16);
            
            let current = 0;
            const updateCounter = () => {
                current += increment;
                if (current < target) {
                    counter.innerText = Math.ceil(current);
                    requestAnimationFrame(updateCounter);
                } else {
                    counter.innerText = target;
                }
            };
            updateCounter();
        });
    });
</script>
