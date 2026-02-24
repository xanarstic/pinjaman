<div class="container-fluid">
    <h3 class="fw-bold mb-4"><i class="bi bi-person-circle me-2 text-yellow"></i>Profil Saya</h3>

    <div class="row g-4">
        <!-- Form Edit Profil -->
        <div class="col-md-8">
            <div class="card border-0 shadow-sm p-4 theme-card h-100">
                <form action="<?= site_url('home/updateProfile') ?>" method="post">
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">NAMA LENGKAP</label>
                        <input type="text" name="nama" class="form-control theme-input" value="<?= esc($user['nama']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">USERNAME</label>
                        <input type="text" name="username" class="form-control theme-input" value="<?= esc($user['username']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">ROLE / JABATAN</label>
                        <input type="text" class="form-control theme-input" value="<?= strtoupper($user['role']) ?>" disabled readonly>
                        <small class="text-muted d-block mt-1" style="font-size: 0.75rem;">*Hubungi Administrator jika ingin mengubah hak akses.</small>
                    </div>

                    <hr class="opacity-10 my-4">

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">GANTI PASSWORD BARU (OPSIONAL)</label>
                        <input type="password" name="password" class="form-control theme-input" placeholder="Kosongkan jika tidak ingin mengganti password">
                    </div>

                    <!-- KOLOM KEAMANAN BARU -->
                    <div class="mb-4 p-3 rounded border border-warning border-opacity-25" style="background: rgba(250, 204, 21, 0.05);">
                        <label class="form-label fw-bold small text-warning"><i class="bi bi-shield-lock-fill me-1"></i> KONFIRMASI PASSWORD SAAT INI (WAJIB)</label>
                        <input type="password" name="current_password" class="form-control theme-input border-warning" placeholder="Masukkan password anda saat ini untuk menyimpan..." required>
                    </div>

                    <button type="submit" class="btn btn-primary px-5 py-3 fw-bold w-100 shadow-sm">SIMPAN PERUBAHAN</button>
                </form>
            </div>
        </div>
        
        <!-- Kartu Info Profil -->
        <div class="col-md-4">
             <div class="card border-0 shadow-sm p-4 theme-card text-center h-100 d-flex flex-column justify-content-center align-items-center">
                <div class="mb-3 position-relative">
                    <div class="avatar-box mx-auto text-white fw-bold d-flex align-items-center justify-content-center shadow-sm" 
                         style="background-color: var(--primary-yellow); width: 100px; height: 100px; border-radius: 50%; font-size: 2.5rem;">
                        <?= strtoupper(substr(esc($user['nama']), 0, 1)) ?>
                    </div>
                    <div class="position-absolute bottom-0 end-0 bg-dark text-yellow rounded-circle p-2 border border-2 border-white shadow-sm" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-check-lg fw-bold"></i>
                    </div>
                </div>
                <h4 class="fw-bold mb-1 text-main"><?= esc($user['nama']) ?></h4>
                <p class="text-muted small mb-3">@<?= esc($user['username']) ?></p>
                <span class="badge bg-dark text-yellow py-2 px-4 rounded-pill border border-warning border-opacity-25">
                    <?= strtoupper($user['role']) ?>
                </span>
                
                <div class="mt-4 w-100 pt-3 border-top border-secondary border-opacity-10">
                    <div class="row text-center">
                        <div class="col">
                            <small class="d-block text-muted small text-uppercase fw-bold">Terdaftar Sejak</small>
                            <span class="fw-bold text-main">
                                <?= !empty($user['created_at']) ? date('d M Y', strtotime($user['created_at'])) : '-' ?>
                            </span>
                        </div>
                    </div>
                </div>
             </div>
        </div>
    </div>
</div>

<style>
    .theme-card { background-color: var(--bg-card) !important; color: var(--text-main); }
    .theme-input { background-color: var(--bg-body) !important; color: var(--text-main) !important; border-color: rgba(255, 255, 255, 0.1) !important; }
    .theme-input:focus { border-color: var(--primary-yellow) !important; box-shadow: 0 0 0 0.25rem rgba(250, 204, 21, 0.25); }
    .text-yellow { color: var(--primary-yellow) !important; }
    .text-main { color: var(--text-main) !important; }
</style>