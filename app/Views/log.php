<div class="container-fluid">
<<<<<<< HEAD
    <div class="row align-items-center mb-4 g-3">
        <div class="col-12 col-md">
            <h3 class="fw-bold text-main m-0">
                <i class="bi bi-clock-history me-2 text-yellow"></i>
                <?= (session()->get('role') === 'user') ? 'Riwayat Peminjaman Saya' : 'Manajemen Log Peminjaman' ?>
            </h3>
        </div>
        <div class="col-12 col-md-auto">
            <button class="btn btn-primary px-4 shadow-sm fw-bold w-100" data-bs-toggle="modal" data-bs-target="#modalPinjam">
                <i class="bi bi-plus-lg me-1"></i> Pinjam Barang
            </button>
        </div>
    </div>

    <!-- Filter & Search Section -->
    <div class="card border-0 shadow-sm mb-4 theme-card p-3">
        <form action="" method="get">
            <!-- Pertahankan status tab saat search -->
            <input type="hidden" name="status" value="<?= esc($filter['status'] ?? 'dipinjam') ?>">
            
            <div class="row g-2">
                <!-- Filter Tanggal (Semua Role) -->
                <div class="col-6 col-md-3">
                    <div class="input-group">
                        <span class="input-group-text theme-input border-end-0"><i class="bi bi-calendar-range"></i></span>
                        <input type="date" name="start_date" class="form-control theme-input border-start-0" value="<?= esc($filter['start_date'] ?? '') ?>" placeholder="Mulai">
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="input-group">
                        <span class="input-group-text theme-input border-end-0"><i class="bi bi-arrow-right"></i></span>
                        <input type="date" name="end_date" class="form-control theme-input border-start-0" value="<?= esc($filter['end_date'] ?? '') ?>" placeholder="Sampai">
                    </div>
                </div>

                <!-- Filter Keyword Barang (Semua Role) -->
                <div class="col-12 col-md-<?= (session()->get('role') === 'admin' || session()->get('role') === 'asistant') ? '2' : '4' ?>">
                    <input type="text" name="keyword" class="form-control theme-input" placeholder="Cari nama barang..." value="<?= esc($filter['keyword'] ?? '') ?>">
                </div>

                <!-- Filter Khusus Admin/Assistant -->
                <?php if (session()->get('role') === 'admin' || session()->get('role') === 'asistant'): ?>
                    <div class="col-12 col-md-3">
                        <select name="target_user" class="form-select theme-input">
                            <option value="" <?= empty($filter['target_user']) ? 'selected' : '' ?>>-- Tampilkan Semua User --</option>
                            <?php foreach ($users as $u): ?>
                                <option value="<?= $u['id'] ?>" <?= ($filter['target_user'] ?? '') == $u['id'] ? 'selected' : '' ?>>
                                    <?= esc($u['nama']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                <?php endif; ?>

                <div class="col-12 col-md-<?= (session()->get('role') === 'admin' || session()->get('role') === 'asistant') ? '1' : '2' ?>">
                    <button type="submit" class="btn btn-primary w-100 fw-bold"><i class="bi bi-search"></i></button>
                </div>
            </div>
        </form>
    </div>

    <div class="nav-adaptive mb-4 overflow-auto hide-scrollbar">
        <ul class="nav nav-pills p-1 rounded-pill theme-tab-bg flex-nowrap" style="width: max-content;">
        <li class="nav-item">
            <a class="nav-link rounded-pill px-4 <?= ($filter['status'] ?? '') === 'menunggu_persetujuan' ? 'active' : 'text-secondary' ?>"
                href="<?= site_url('home/log?status=menunggu_persetujuan') ?>">
                Request Baru
                <?php if (session()->get('role') !== 'user'): ?>
                    <span class="badge bg-warning text-dark ms-1" style="font-size: 0.6rem;">ACC</span>
                <?php endif; ?>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link rounded-pill px-4 text-nowrap <?= ($filter['status'] ?? '') === 'dipinjam' ? 'active' : 'text-secondary' ?>"
=======
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
>>>>>>> 76654e63e3b235c2566e0adcd60cb34f8944b1fc
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
<<<<<<< HEAD
            <a class="nav-link rounded-pill px-4 text-nowrap <?= ($filter['status'] ?? '') === 'selesai' ? 'active' : 'text-secondary' ?>"
                href="<?= site_url('home/log?status=selesai') ?>">Riwayat Selesai</a>
        </li>
        <li class="nav-item">
            <a class="nav-link rounded-pill px-4 text-nowrap <?= ($filter['status'] ?? '') === 'all' ? 'active' : 'text-secondary' ?>"
                href="<?= site_url('home/log?status=all') ?>">Semua</a>
        </li>
        </ul>
    </div>
=======
            <a class="nav-link rounded-pill px-4 <?= ($filter['status'] ?? '') === 'all' ? 'active' : 'text-secondary' ?>"
                href="<?= site_url('home/log?status=all') ?>">Semua</a>
        </li>
    </ul>
>>>>>>> 76654e63e3b235c2566e0adcd60cb34f8944b1fc

    <div class="card border-0 shadow-sm overflow-hidden theme-card" style="border-radius: 20px;">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 theme-table">
                <thead class="bg-yellow text-dark">
                    <tr>
                        <th class="ps-4 py-3 border-0">PEMINJAM</th>
                        <th class="py-3 border-0">DAFTAR BARANG</th>
                        <th class="py-3 text-center border-0">WAKTU PINJAM</th>
<<<<<<< HEAD
                        <th class="py-3 text-center border-0">WAKTU SELESAI</th>
=======
>>>>>>> 76654e63e3b235c2566e0adcd60cb34f8944b1fc
                        <th class="py-3 text-center border-0">STATUS SISTEM</th>
                        <th class="pe-4 py-3 text-end border-0">KENDALI</th>
                    </tr>
                </thead>
                <tbody class="text-main">
                    <?php if (empty($logs)): ?>
                        <tr>
<<<<<<< HEAD
                            <td colspan="6" class="text-center py-5">
=======
                            <td colspan="5" class="text-center py-5">
>>>>>>> 76654e63e3b235c2566e0adcd60cb34f8944b1fc
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
<<<<<<< HEAD
                                <?php $items = explode(', ', $l['barang_nama'] ?? '');
=======
                                <?php $items = explode(', ', $l['barang_nama']);
>>>>>>> 76654e63e3b235c2566e0adcd60cb34f8944b1fc
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
<<<<<<< HEAD

                            <td class="text-center">
                                <?php if (!empty($l['jam_selesai']) && $l['status'] === 'selesai'): ?>
                                    <div class="small fw-bold text-success"><?= date('d/m/y', strtotime($l['jam_selesai'])) ?></div>
                                    <div class="text-secondary small"><?= date('H:i', strtotime($l['jam_selesai'])) ?> WIB</div>
                                <?php else: ?>
                                    <span class="text-muted opacity-50 small">- Belum Selesai -</span>
                                <?php endif; ?>
                            </td>

=======
>>>>>>> 76654e63e3b235c2566e0adcd60cb34f8944b1fc
                            <td class="text-center">
                                <?php if ($l['status'] === 'dipinjam'): ?>
                                    <span class="badge rounded-pill px-3 py-2 status-pinjam">Dipakai</span>
                                <?php elseif ($l['status'] === 'menunggu_konfirmasi'): ?>
<<<<<<< HEAD
                                    <span class="badge rounded-pill px-3 py-2 status-tunggu anim-pulse-tunggu">Menunggu Verifikasi</span>
                                <?php elseif ($l['status'] === 'menunggu_persetujuan'): ?>
                                    <span class="badge rounded-pill px-3 py-2 status-request">Menunggu ACC</span>
=======
                                    <span class="badge rounded-pill px-3 py-2 status-tunggu anim-pulse-tunggu">Menunggu
                                        Verifikasi</span>
>>>>>>> 76654e63e3b235c2566e0adcd60cb34f8944b1fc
                                <?php else: ?>
                                    <span class="badge rounded-pill px-3 py-2 status-kembali">Selesai</span>
                                <?php endif; ?>
                            </td>
                            <td class="pe-4 text-end">
<<<<<<< HEAD
                                <div class="btn-group border border-secondary border-opacity-25 rounded shadow-sm overflow-hidden">
=======
                                <div
                                    class="btn-group border border-secondary border-opacity-25 rounded shadow-sm overflow-hidden">
>>>>>>> 76654e63e3b235c2566e0adcd60cb34f8944b1fc
                                    <?php
                                    $role = session()->get('role');
                                    $uid = session()->get('user_id');
                                    ?>

<<<<<<< HEAD
                                    <?php if ($l['status'] === 'menunggu_persetujuan'): ?>
                                        <?php if ($role === 'admin' || $role === 'asistant'): ?>
                                            <a href="<?= site_url('home/approvePinjam/' . $l['user_id'] . '/' . urlencode($l['jam_mulai'])) ?>"
                                                class="btn btn-sm btn-theme-action text-success px-3 py-2"
                                                title="Setujui Peminjaman">
                                                <i class="bi bi-check-lg fs-5"></i>
                                            </a>
                                        <?php endif; ?>
                                        
                                        <?php if ($l['user_id'] == $uid || $role === 'admin' || $role === 'asistant'): ?>
                                            <a href="<?= site_url('home/tolakPinjam/' . $l['user_id'] . '/' . urlencode($l['jam_mulai'])) ?>"
                                                class="btn btn-sm btn-theme-action text-danger px-3 py-2"
                                                onclick="event.preventDefault(); confirmAction(this.href, 'Batalkan request peminjaman ini?', 'warning')" title="Batalkan">
                                                <i class="bi bi-x-lg fs-5"></i>
                                            </a>
                                        <?php endif; ?>
                                    <?php endif; ?>

                                    <?php if ($l['status'] === 'dipinjam' && ($l['user_id'] == $uid || $role === 'admin')): ?>
                                        <a href="<?= site_url('home/selesai/' . $l['user_id'] . '/' . urlencode($l['jam_mulai'])) ?>"
                                            class="btn btn-sm btn-theme-action text-warning px-3 py-2"
                                            onclick="event.preventDefault(); confirmAction(this.href, 'Kirim permintaan pengembalian?', 'question')"
=======
                                    <?php if ($l['status'] === 'dipinjam' && ($l['user_id'] == $uid || $role === 'admin')): ?>
                                        <a href="<?= site_url('home/selesai/' . $l['user_id'] . '/' . urlencode($l['jam_mulai'])) ?>"
                                            class="btn btn-sm btn-theme-action text-warning px-3 py-2"
                                            onclick="return confirm('Kirim permintaan pengembalian?')"
>>>>>>> 76654e63e3b235c2566e0adcd60cb34f8944b1fc
                                            title="Kembalikan Barang">
                                            <i class="bi bi-arrow-left-right fs-5"></i>
                                        </a>
                                    <?php endif; ?>

                                    <?php if ($l['status'] === 'menunggu_konfirmasi' && ($role === 'admin' || $role === 'asistant')): ?>
                                        <a href="<?= site_url('home/konfirmasi/' . $l['user_id'] . '/' . urlencode($l['jam_mulai'])) ?>"
                                            class="btn btn-sm btn-theme-action text-success px-3 py-2"
<<<<<<< HEAD
                                            onclick="event.preventDefault(); confirmAction(this.href, 'Konfirmasi barang sudah diterima?', 'question')">
=======
                                            onclick="return confirm('Konfirmasi barang?')">
>>>>>>> 76654e63e3b235c2566e0adcd60cb34f8944b1fc
                                            <i class="bi bi-check-all fs-5"></i>
                                        </a>
                                    <?php endif; ?>

                                    <?php if ($role === 'admin'): ?>
<<<<<<< HEAD
                                        <button onclick="confirmDelLog('<?= site_url('home/tolakPinjam/' . $l['user_id'] . '/' . urlencode($l['jam_mulai'])) ?>')"
=======
                                        <button
                                            onclick="confirmDelLog('<?= $l['user_id'] ?>', '<?= urlencode($l['jam_mulai']) ?>')"
>>>>>>> 76654e63e3b235c2566e0adcd60cb34f8944b1fc
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
<<<<<<< HEAD
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <label class="form-label fw-bold small text-muted text-uppercase mb-0">Pilih Barang Tersedia</label>
                        <input type="text" id="searchBarang" class="form-control form-control-sm w-50 theme-input" placeholder="Cari nama barang..." autocomplete="off">
                    </div>
                    <div class="row g-3 overflow-auto px-1" style="max-height: 350px;" id="barangList">
                        <?php foreach ($barang as $brg): ?>
                            <div class="col-12 col-md-6 barang-item">
                                <label class="d-flex align-items-center p-2 border rounded-3 cursor-pointer theme-item-hover"
=======
                    <label class="form-label fw-bold small text-muted text-uppercase">Pilih Barang Tersedia</label>
                    <div class="row g-3 overflow-auto px-1" style="max-height: 350px;">
                        <?php foreach ($barang as $brg): ?>
                            <div class="col-md-6">
                                <label
                                    class="d-flex align-items-center p-2 border rounded-3 cursor-pointer theme-item-hover"
>>>>>>> 76654e63e3b235c2566e0adcd60cb34f8944b1fc
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
<<<<<<< HEAD
                                    <span class="small fw-bold text-main text-truncate barang-name"><?= esc($brg['nama_barang']) ?></span>
=======
                                    <span
                                        class="small fw-bold text-main text-truncate"><?= esc($brg['nama_barang']) ?></span>
>>>>>>> 76654e63e3b235c2566e0adcd60cb34f8944b1fc
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
<<<<<<< HEAD
    /* CSS CSS CSS (Sama seperti sebelumnya) */
    .nav-adaptive {
        width: 100%;
    }
    @media (min-width: 768px) {
        .nav-adaptive {
            width: fit-content;
        }
    }
    
    .hide-scrollbar::-webkit-scrollbar { display: none; }
    .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

=======
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
>>>>>>> 76654e63e3b235c2566e0adcd60cb34f8944b1fc
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

<<<<<<< HEAD
    .status-request {
        background-color: rgba(255, 255, 255, 0.1) !important;
        color: #fff !important;
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

=======
>>>>>>> 76654e63e3b235c2566e0adcd60cb34f8944b1fc
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

<<<<<<< HEAD
    .theme-card,
    .theme-modal {
        background-color: var(--bg-card) !important;
        color: var(--text-main);
    }

    .theme-table {
        color: var(--text-main) !important;
    }

    .theme-tab-bg,
    .btn-theme-action {
        background-color: rgba(255, 255, 255, 0.05);
    }

=======
    /* INPUT & HOVER SINKRONISASI TEMA */
>>>>>>> 76654e63e3b235c2566e0adcd60cb34f8944b1fc
    .theme-input {
        background-color: var(--bg-body) !important;
        color: var(--text-main) !important;
        border-color: rgba(255, 255, 255, 0.1) !important;
    }

<<<<<<< HEAD
    .bg-yellow {
        background-color: var(--primary-yellow) !important;
    }
</style>

<script>
    // Fitur Search Barang di Modal Pinjam (Real-time Filter)
    document.getElementById('searchBarang').addEventListener('keyup', function() {
        let filter = this.value.toLowerCase();
        let items = document.querySelectorAll('.barang-item');

        items.forEach(function(item) {
            let text = item.querySelector('.barang-name').textContent.toLowerCase();
            item.style.display = text.includes(filter) ? '' : 'none';
        });
    });

    // SweetAlert2 Helpers
    function confirmAction(url, message, iconType) {
        const isDark = document.documentElement.getAttribute('data-bs-theme') === 'dark';
        Swal.fire({
            title: 'Konfirmasi',
            text: message,
            icon: iconType,
            showCancelButton: true,
            confirmButtonColor: '#facc15',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Lanjutkan',
            cancelButtonText: 'Batal',
            color: isDark ? '#f8fafc' : '#1e293b',
            background: isDark ? '#1e293b' : '#fff'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    }

    function confirmDelLog(url) {
        confirmAction(url, 'Hapus log peminjaman ini secara permanen?', 'warning');
    }
</script>
=======
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
>>>>>>> 76654e63e3b235c2566e0adcd60cb34f8944b1fc
