<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold"><i class="bi bi-clock-history me-2 text-yellow"></i>Log Aktivitas</h3>
        <button class="btn btn-primary px-4 shadow-sm fw-bold" data-bs-toggle="modal" data-bs-target="#modalPinjam">
            <i class="bi bi-plus-lg me-1"></i> Pinjam Barang
        </button>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success border-0 shadow-sm mb-4"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 20px;">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-yellow text-dark">
                    <tr>
                        <th class="ps-4 py-3">PEMINJAM</th>
                        <th class="py-3">DAFTAR BARANG</th>
                        <th class="py-3 text-center">WAKTU PINJAM</th>
                        <th class="py-3 text-center">WAKTU KEMBALI</th>
                        <th class="py-3 text-center">STATUS</th>
                        <th class="pe-4 py-3 text-end">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($logs)): ?>
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-calendar-x display-4 opacity-25 d-block mb-2"></i>
                                Belum ada riwayat aktivitas peminjaman.
                            </td>
                        </tr>
                    <?php endif; ?>

                    <?php foreach ($logs as $l): ?>
                        <tr>
                            <td class="ps-4">
                                <span class="fw-bold d-block"><?= esc($l['user_nama']) ?></span>
                                <small class="text-secondary">ID: #<?= $l['user_id'] ?></small>
                            </td>
                            <td>
                                <?php 
                                $items = explode(', ', $l['barang_nama']);
                                foreach($items as $item): ?>
                                    <span class="badge bg-yellow text-dark mb-1 fw-bold shadow-sm" style="font-size: 0.75rem; border: none;">
                                        <?= esc($item) ?>
                                    </span>
                                <?php endforeach; ?>
                            </td>
                            <td class="text-center">
                                <div class="small fw-bold"><?= date('d M Y', strtotime($l['jam_mulai'])) ?></div>
                                <div class="text-secondary small"><?= date('H:i', strtotime($l['jam_mulai'])) ?> WIB</div>
                            </td>
                            <td class="text-center">
                                <?php if ($l['jam_selesai']): ?>
                                    <div class="small fw-bold"><?= date('d M Y', strtotime($l['jam_selesai'])) ?></div>
                                    <div class="text-secondary small"><?= date('H:i', strtotime($l['jam_selesai'])) ?> WIB</div>
                                <?php else: ?>
                                    <span class="text-danger small fw-bold anim-pulse">
                                        <i class="bi bi-hourglass-split"></i> Belum Kembali
                                    </span>
                                <?php endif ?>
                            </td>
                            <td class="text-center">
                                <span class="badge rounded-pill px-3 py-2 <?= $l['jam_selesai'] ? 'bg-success bg-opacity-10 text-success border border-success' : 'bg-warning bg-opacity-10 text-warning border border-warning' ?>">
                                    <?= $l['jam_selesai'] ? 'Sudah Kembali' : 'Aktif' ?>
                                </span>
                            </td>
                            <td class="pe-4 text-end">
                                <?php if (session()->get('role') === 'admin'): ?>
                                    <div class="btn-group border rounded shadow-sm overflow-hidden">
                                        <?php if (!$l['jam_selesai']): ?>
                                            <a href="<?= site_url('home/selesai/'.$l['user_id'].'/'.urlencode($l['jam_mulai'])) ?>" 
                                               class="btn btn-sm bg-dark text-success border-0 px-3 py-2" 
                                               onclick="return confirm('Konfirmasi pengembalian barang?')">
                                                <i class="bi bi-check-lg fs-5"></i>
                                            </a>
                                        <?php endif ?>
                                        <button onclick="confirmDelLog('<?= $l['user_id'] ?>', '<?= urlencode($l['jam_mulai']) ?>')" 
                                                class="btn btn-sm bg-dark text-danger border-0 px-3 py-2">
                                            <i class="bi bi-trash fs-5"></i>
                                        </button>
                                    </div>
                                <?php else: ?>
                                    <span class="badge bg-light text-muted border py-2">No Access</span>
                                <?php endif ?>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modalPinjam" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form action="<?= site_url('home/pinjamLog') ?>" method="post" class="modal-content border-0">
            <div class="modal-header bg-yellow text-dark">
                <h5 class="modal-title fw-bold">Input Peminjaman Barang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-4">
                    <label class="form-label fw-bold small text-muted">SIAPA YANG MEMINJAM?</label>
                    <select name="user_id" class="form-select border-2" required>
                        <option value="" disabled selected>-- Pilih Nama User --</option>
                        <?php foreach($users as $user): ?>
                            <option value="<?= $user['id'] ?>"><?= esc($user['nama']) ?> (<?= ucfirst($user['role']) ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-0">
                    <label class="form-label fw-bold small text-muted">PILIH BARANG (BISA LEBIH DARI SATU)</label>
                    <div class="p-3 border rounded-3 bg-light bg-opacity-10" style="max-height: 250px; overflow-y: auto;">
                        <?php foreach($barang as $brg): ?>
                            <div class="form-check custom-checkbox mb-2">
                                <input class="form-check-input" type="checkbox" name="barang_id[]" value="<?= $brg['id'] ?>" id="brg-<?= $brg['id'] ?>">
                                <label class="form-check-label" for="brg-<?= $brg['id'] ?>">
                                    <?= esc($brg['nama_barang']) ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="submit" class="btn btn-primary w-100 py-2 fw-bold shadow-sm">
                    Konfirmasi Peminjaman <i class="bi bi-arrow-right-short ms-1"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    .bg-yellow { background-color: var(--primary-yellow) !important; }
    .anim-pulse { animation: pulse-red 2s infinite; }
    @keyframes pulse-red { 0% { opacity: 1; } 50% { opacity: 0.5; } 100% { opacity: 1; } }

    .custom-checkbox .form-check-input:checked {
        background-color: var(--primary-yellow);
        border-color: var(--primary-yellow);
    }
</style>

<script>
    function confirmDelLog(uid, jam) {
        if(confirm('Hapus riwayat log ini? Barang yang bersangkutan tidak akan terpengaruh.')) {
            window.location.href = "<?= site_url('home/deleteLogBatch/') ?>" + uid + "/" + jam;
        }
    }
</script>