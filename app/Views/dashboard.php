<div class="container-fluid">
    <div class="card border-0 shadow-sm p-4 mb-4"
        style="background: linear-gradient(135deg, #facc15 0%, #fef08a 100%); border-radius: 20px;">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h3 class="fw-bold mb-1 text-dark">Selamat Datang, <?= session()->get('nama') ?>! 👋</h3>
                <p class="mb-0 text-dark opacity-75">Kelola operasional inventaris dengan lebih cerah hari ini.</p>
            </div>
        </div>
    </div>

    <div class="row g-4 text-dark">
        <?php
        $stats = [
            ['Total Barang', $totalBarang, 'box-seam', 'rgba(250, 204, 21, 0.2)'],
            ['Barang Dipakai', $barangDipakai, 'hand-index', 'rgba(255, 193, 7, 0.2)'],
            ['Total User', $totalUser, 'people', 'rgba(13, 202, 240, 0.2)']
        ];
        foreach ($stats as $s): ?>
            <div class="col-12 col-md-4">
                <div class="card border-0 shadow-sm p-4 h-100 shadow-sm" style="border-radius: 18px;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted d-block mb-1 fw-bold text-uppercase"
                                style="font-size: 0.7rem;"><?= $s[0] ?></small>
                            <h2 class="fw-bold mb-0 text-main-theme"><?= $s[1] ?></h2>
                        </div>
                        <div class="rounded-circle d-flex align-items-center justify-content-center shadow-sm"
                            style="background: <?= $s[3] ?>; color: #854d0e; width: 60px; height: 60px; min-width: 60px;">
                            <i class="bi bi-<?= $s[2] ?> fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<style>
    [data-bs-theme="dark"] .text-main-theme {
        color: #fff !important;
    }
</style>