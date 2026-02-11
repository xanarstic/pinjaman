<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-main">
            <i class="bi bi-clock-history me-2 text-yellow"></i>
            <?= (session()->get('role') === 'user') ? 'Riwayat Peminjaman Saya' : 'Manajemen Log Peminjaman' ?>
        </h3>
        <button class="btn btn-primary px-4 shadow-sm fw-bold" data-bs-toggle="modal" data-bs-target="#modalPinjam">
            <i class="bi bi-plus-lg me-1"></i> Pinjam Barang
        </button>
    </div>

    <ul class="nav nav-pills mb-4 p-1 rounded-pill theme-tab-bg" style="width: fit-content;">
        <li class="nav-item">
            <a class="nav-link rounded-pill px-4 <?= ($filter['status'] ?? '') === 'dipinjam' ? 'active' : 'text-secondary' ?>"
                href="<?= site_url('home/log?status=dipinjam') ?>">Aktif</a>
        </li>
        <li class="nav-item">
            <a class="nav-link rounded-pill px-4 <?= ($filter['status'] ?? '') === 'menunggu_konfirmasi' ? 'active' : 'text-secondary' ?>"
                href="<?= site_url('home/log?status=menunggu_konfirmasi') ?>">
                Menunggu Verifikasi
                <?php if (session()->get('role') !== 'user'): ?>
                    <span class="badge bg-danger ms-1" style="font-size: 0.6rem;">Cek</span>
                <?php endif; ?>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link rounded-pill px-4 <?= ($filter['status'] ?? '') === 'all' ? 'active' : 'text-secondary' ?>"
                href="<?= site_url('home/log?status=all') ?>">Semua</a>
        </li>
    </ul>

    <div class="card border-0 shadow-sm overflow-hidden theme-card" style="border-radius: 20px;">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 theme-table">
                <thead class="bg-yellow text-dark">
                    <tr>
                        <th class="ps-4 py-3 border-0">PEMINJAM</th>
                        <th class="py-3 border-0">DAFTAR BARANG</th>
                        <th class="py-3 text-center border-0">WAKTU PINJAM</th>
                        <th class="py-3 text-center border-0">STATUS SISTEM</th>
                        <th class="pe-4 py-3 text-end border-0">KENDALI</th>
                    </tr>
                </thead>
                <tbody class="text-main">
                    <?php if (empty($logs)): ?>
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <i class="bi bi-info-circle display-4 text-muted opacity-25"></i>
                                <p class="text-muted mt-3">Tidak ada data peminjaman yang sesuai filter.</p>
                            </td>
                        </tr>
                    <?php endif; ?>

                    <?php foreach ($logs as $l): ?>
                        <tr>
                            <td class="ps-4">
                                <span class="fw-bold d-block"><?= esc($l['user_nama']) ?></span>
                                <small class="text-secondary small">ID: #<?= $l['user_id'] ?></small>
                            </td>
                            <td>
                                <?php $items = explode(', ', $l['barang_nama']);
                                foreach ($items as $item): ?>
                                    <span class="badge bg-yellow text-dark mb-1 fw-bold shadow-sm border-0"
                                        style="font-size: 0.7rem;">
                                        <?= esc($item) ?>
                                    </span>
                                <?php endforeach; ?>
                            </td>
                            <td class="text-center">
                                <div class="small fw-bold"><?= date('d/m/y', strtotime($l['jam_mulai'])) ?></div>
                                <div class="text-secondary small"><?= date('H:i', strtotime($l['jam_mulai'])) ?> WIB</div>
                            </td>
                            <td class="text-center">
                                <?php if ($l['status'] === 'dipinjam'): ?>
                                    <span class="badge rounded-pill px-3 py-2 status-pinjam">Dipakai</span>
                                <?php elseif ($l['status'] === 'menunggu_konfirmasi'): ?>
                                    <span class="badge rounded-pill px-3 py-2 status-tunggu anim-pulse-tunggu">Menunggu
                                        Verifikasi</span>
                                <?php else: ?>
                                    <span class="badge rounded-pill px-3 py-2 status-kembali">Selesai</span>
                                <?php endif; ?>
                            </td>
                            <td class="pe-4 text-end">
                                <div
                                    class="btn-group border border-secondary border-opacity-25 rounded shadow-sm overflow-hidden">
                                    <?php
                                    $role = session()->get('role');
                                    $uid = session()->get('user_id');
                                    ?>

                                    <?php if ($l['status'] === 'dipinjam' && ($l['user_id'] == $uid || $role === 'admin')): ?>
                                        <a href="<?= site_url('home/selesai/' . $l['user_id'] . '/' . urlencode($l['jam_mulai'])) ?>"
                                            class="btn btn-sm btn-theme-action text-warning px-3 py-2"
                                            onclick="return confirm('Kirim permintaan pengembalian?')"
                                            title="Kembalikan Barang">
                                            <i class="bi bi-arrow-left-right fs-5"></i>
                                        </a>
                                    <?php endif; ?>

                                    <?php if ($l['status'] === 'menunggu_konfirmasi' && ($role === 'admin' || $role === 'asistant')): ?>
                                        <a href="<?= site_url('home/konfirmasi/' . $l['user_id'] . '/' . urlencode($l['jam_mulai'])) ?>"
                                            class="btn btn-sm btn-theme-action text-success px-3 py-2"
                                            onclick="return confirm('Konfirmasi barang?')">
                                            <i class="bi bi-check-all fs-5"></i>
                                        </a>
                                    <?php endif; ?>

                                    <?php if ($role === 'admin'): ?>
                                        <button
                                            onclick="confirmDelLog('<?= $l['user_id'] ?>', '<?= urlencode($l['jam_mulai']) ?>')"
                                            class="btn btn-sm btn-theme-action text-danger px-3 py-2" title="Hapus Log">
                                            <i class="bi bi-trash fs-5"></i>
                                        </button>
                                    <?php endif ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modalPinjam" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <form action="<?= site_url('home/pinjamLog') ?>" method="post" class="modal-content border-0 theme-modal">
            <div class="modal-header bg-yellow text-dark border-0">
                <h5 class="modal-title fw-bold">Peminjaman Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <?php if (session()->get('role') === 'admin'): ?>
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-muted text-uppercase">Input Atas Nama</label>
                        <select name="user_id" class="form-select theme-input border-2" required>
                            <option value="" disabled selected>-- Pilih Nama User --</option>
                            <?php foreach ($users as $user): ?>
                                <option value="<?= $user['id'] ?>"><?= esc($user['nama']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                <?php else: ?>
                    <div class="mb-4 p-3 rounded border border-warning border-opacity-25 theme-info-box">
                        <label class="form-label fw-bold small text-muted text-uppercase d-block">Identitas Peminjam</label>
                        <span class="fw-bold text-main"><i class="bi bi-person-circle me-1"></i>
                            <?= session()->get('nama') ?></span>
                        <input type="hidden" name="user_id" value="<?= session()->get('user_id') ?>">
                    </div>
                <?php endif; ?>

                <div class="mb-0">
                    <label class="form-label fw-bold small text-muted text-uppercase">Pilih Barang Tersedia</label>
                    <div class="row g-3 overflow-auto px-1" style="max-height: 350px;">
                        <?php foreach ($barang as $brg): ?>
                            <div class="col-md-6">
                                <label
                                    class="d-flex align-items-center p-2 border rounded-3 cursor-pointer theme-item-hover"
                                    for="brg-<?= $brg['id'] ?>">
                                    <div class="form-check m-0 pe-2">
                                        <input class="form-check-input" type="checkbox" name="barang_id[]"
                                            value="<?= $brg['id'] ?>" id="brg-<?= $brg['id'] ?>">
                                    </div>
                                    <div class="me-3 border rounded overflow-hidden shadow-sm bg-dark"
                                        style="width: 45px; height: 45px;">
                                        <img src="<?= $brg['foto'] ? base_url('uploads/barang/' . $brg['foto']) : 'https://placehold.co/45?text=No+Img' ?>"
                                            style="width: 100%; height: 100%; object-fit: cover;">
                                    </div>
                                    <span
                                        class="small fw-bold text-main text-truncate"><?= esc($brg['nama_barang']) ?></span>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="submit" class="btn btn-primary w-100 py-3 fw-bold shadow-sm">SIMPAN TRANSAKSI</button>
            </div>
        </form>
    </div>
</div>

<style>
    /* VARIABEL ADAPTIF TEMA */
    .theme-card {
        background-color: var(--bg-card) !important;
        color: var(--text-main);
    }

    .theme-table {
        color: var(--text-main) !important;
    }

    .theme-modal {
        background-color: var(--bg-card) !important;
        color: var(--text-main);
    }

    .theme-tab-bg {
        background-color: rgba(255, 255, 255, 0.05);
    }

    .btn-theme-action {
        background-color: rgba(255, 255, 255, 0.05);
        transition: 0.2s;
    }

    .btn-theme-action:hover {
        background-color: rgba(255, 255, 255, 0.15);
    }

    /* STATUS BADGES DENGAN WORKFLOW BARU */
    .status-kembali {
        background-color: rgba(25, 135, 84, 0.1) !important;
        color: #198754 !important;
        border: 1px solid rgba(25, 135, 84, 0.2);
    }

    .status-pinjam {
        background-color: rgba(255, 193, 7, 0.1) !important;
        color: #ffc107 !important;
        border: 1px solid rgba(255, 193, 7, 0.2);
    }

    .status-tunggu {
        background-color: rgba(13, 110, 253, 0.1) !important;
        color: #0d6efd !important;
        border: 1px solid rgba(13, 110, 253, 0.2);
    }

    .anim-pulse-tunggu {
        animation: pulse-blue 2s infinite;
    }

    @keyframes pulse-blue {
        0% {
            opacity: 1;
        }

        50% {
            opacity: 0.6;
        }

        100% {
            opacity: 1;
        }
    }

    /* INPUT & HOVER SINKRONISASI TEMA */
    .theme-input {
        background-color: var(--bg-body) !important;
        color: var(--text-main) !important;
        border-color: rgba(255, 255, 255, 0.1) !important;
    }

    .theme-info-box {
        background-color: rgba(250, 204, 21, 0.05);
    }

    .theme-item-hover:hover {
        background-color: rgba(250, 204, 21, 0.1);
        border-color: var(--primary-yellow) !important;
    }

    .cursor-pointer {
        cursor: pointer;
    }

    .bg-yellow {
        background-color: var(--primary-yellow) !important;
    }
</style>