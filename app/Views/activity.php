<div class="container-fluid">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <h3 class="fw-bold"><i class="bi bi-journal-text me-2 text-yellow"></i>Activity Log (Audit Trail)</h3>
        <span class="badge bg-dark text-yellow border border-warning px-3 py-2 shadow-sm">
            <i class="bi bi-shield-lock-fill me-1"></i> Admin Audit Mode
        </span>
    </div>

    <div class="card border-0 shadow-sm mb-4"
        style="border-radius: 15px; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.1) !important;">
        <form method="get" action="<?= site_url('home/activity') ?>" class="card-body p-4">
            <div class="row g-2">
                <!-- Baris 1: Tanggal (Split 2 Kolom di HP) -->
                <div class="col-6 col-md-3">
                    <label class="small fw-bold text-muted mb-1 text-uppercase">Dari Tanggal</label>
                    <input type="date" name="start_date" class="form-control form-control-sm" value="<?= $filter['start_date'] ?? '' ?>">
                </div>
                <div class="col-6 col-md-3">
                    <label class="small fw-bold text-muted mb-1 text-uppercase">Sampai Tanggal</label>
                    <input type="date" name="end_date" class="form-control form-control-sm" value="<?= $filter['end_date'] ?? '' ?>">
                </div>

                <!-- Baris 2: User & Aksi -->
                <div class="col-6 col-md-2">
                    <label class="small fw-bold text-muted mb-1 text-uppercase">User</label>
                    <select name="user_id" class="form-select form-select-sm">
                        <option value="">Semua User</option>
                        <?php foreach ($users as $u): ?>
                            <option value="<?= $u['id'] ?>" <?= ($filter['user_id'] ?? '') == $u['id'] ? 'selected' : '' ?>>
                                <?= esc($u['nama']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-6 col-md-3">
                    <label class="small fw-bold text-muted mb-1 text-uppercase">Cari Tindakan / Aksi</label>
                    <input type="text" name="action" class="form-control form-control-sm"
                        placeholder="Contoh: Hapus, Login, Update..." value="<?= $filter['action'] ?? '' ?>">
                </div>

                <!-- Baris 3: Jam (Split 2 Kolom di HP) -->
                <div class="col-6 col-md-1">
                    <label class="small fw-bold text-muted mb-1 text-uppercase">Jam Mulai</label>
                    <input type="time" name="start_time" class="form-control form-control-sm" value="<?= $filter['start_time'] ?? '' ?>">
                </div>
                <div class="col-6 col-md-1">
                    <label class="small fw-bold text-muted mb-1 text-uppercase">Jam Akhir</label>
                    <input type="time" name="end_time" class="form-control form-control-sm" value="<?= $filter['end_time'] ?? '' ?>">
                </div>

                <!-- Tombol -->
                <div class="col-12 col-md-2 d-flex align-items-end gap-1">
                    <button type="submit" class="btn btn-warning btn-sm w-100 fw-bold me-1 text-dark shadow-sm">
                        <i class="bi bi-funnel-fill"></i>
                    </button>
                    <a href="<?= site_url('home/activity') ?>" class="btn btn-secondary btn-sm shadow-sm">
                        <i class="bi bi-arrow-counterclockwise"></i>
                    </a>
                </div>
            </div>
        </form>
    </div>

    <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 20px;">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-yellow text-dark">
                    <tr>
                        <th class="ps-4 py-3">PENGGUNA</th>
                        <th class="py-3">AKSI / TINDAKAN</th>
                        <th class="py-3">URL TUJUAN</th>
                        <th class="py-3 text-center">ALAMAT IP</th>
                        <th class="pe-4 py-3 text-end">WAKTU</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($activities)): ?>
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted small">Tidak ada aktivitas ditemukan.</td>
                        </tr>
                    <?php endif; ?>

                    <?php foreach ($activities as $a): ?>
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-mini me-2 bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold"
                                        style="width: 32px; height: 32px; font-size: 0.75rem;">
                                        <?= strtoupper(substr(esc($a['user_nama'] ?? '??'), 0, 1)) ?>
                                    </div>
                                    <span class="fw-bold"><?= esc($a['user_nama'] ?? 'Unknown User') ?></span>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-yellow text-dark border-0 fw-bold shadow-sm"
                                    style="font-size: 0.7rem;">
                                    <?= esc($a['action']) ?>
                                </span>
                            </td>
                            <td><code class="small text-secondary"><?= esc($a['url']) ?></code></td>
                            <td class="text-center small text-muted"><?= esc($a['ip_address']) ?></td>
                            <td class="pe-4 text-end">
                                <small class="fw-bold d-block"><?= date('d/m/Y', strtotime($a['created_at'])) ?></small>
                                <small class="text-muted"
                                    style="font-size: 0.75rem;"><?= date('H:i:s', strtotime($a['created_at'])) ?>
                                    WIB</small>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .bg-yellow {
        background-color: var(--primary-yellow) !important;
    }

    .text-yellow {
        color: var(--primary-yellow) !important;
    }
</style>