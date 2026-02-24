<div class="container-fluid">
    <div class="row align-items-center mb-4 g-3">
        <div class="col-12 col-md">
            <h3 class="fw-bold text-main m-0"><i class="bi bi-people-fill me-2 text-yellow"></i>Manajemen User</h3>
        </div>
        <div class="col-12 col-md-auto">
            <button class="btn btn-primary px-4 shadow-sm fw-bold w-100" data-bs-toggle="modal" data-bs-target="#createUserModal">
                <i class="bi bi-person-plus-fill me-1"></i> Tambah User
            </button>
        </div>
    </div>

    <div class="card border-0 shadow-sm overflow-hidden theme-card" style="border-radius: 20px;">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 theme-table">
                <thead class="bg-yellow text-dark">
                    <tr>
                        <th class="ps-4 py-3 border-0">INFORMASI PENGGUNA</th>
                        <th class="py-3 border-0">USERNAME</th>
                        <th class="py-3 text-center border-0">HAK AKSES</th>
                        <th class="pe-4 py-3 text-end border-0">TINDAKAN</th>
                    </tr>
                </thead>
                <tbody class="text-main">
                    <?php foreach ($users as $u): ?>
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <?php 
                                        $avatarColor = '#6366f1'; // Default Staff
                                        if($u['role'] === 'admin') $avatarColor = '#ef4444';
                                        if($u['role'] === 'asistant') $avatarColor = '#0d6efd';
                                    ?>
                                    <div class="avatar-box me-3 text-white fw-bold d-flex align-items-center justify-content-center shadow-sm" 
                                         style="background-color: <?= $avatarColor ?>; width: 45px; height: 45px; border-radius: 12px;">
                                        <?= strtoupper(substr(esc($u['nama']), 0, 1)) ?>
                                    </div>
                                    <div>
                                        <span class="fw-bold d-block"><?= esc($u['nama']) ?></span>
                                        <small class="text-secondary small">ID: #<?= $u['id'] ?></small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="fw-medium"><i class="bi bi-person-fill me-2 opacity-50"></i><?= esc($u['username']) ?></div>
                            </td>
                            <td class="text-center">
                                <?php if ($u['role'] === 'admin'): ?>
                                    <span class="badge rounded-pill px-3 py-2 bg-danger bg-opacity-10 text-danger border border-danger">Administrator</span>
                                <?php elseif ($u['role'] === 'asistant'): ?>
                                    <span class="badge rounded-pill px-3 py-2 status-tunggu">Asistant</span>
                                <?php else: ?>
                                    <span class="badge rounded-pill px-3 py-2 bg-secondary bg-opacity-10 text-secondary border border-secondary">Staff</span>
                                <?php endif; ?>
                            </td>
                            <td class="pe-4 text-end">
                                <div class="btn-group border border-secondary border-opacity-25 rounded shadow-sm overflow-hidden">
                                    <button class="btn btn-sm btn-theme-action text-warning py-2 px-3" 
                                            data-bs-toggle="modal" data-bs-target="#editUserModal"
                                            data-id="<?= $u['id'] ?>" data-nama="<?= esc($u['nama']) ?>" 
                                            data-username="<?= esc($u['username']) ?>" data-role="<?= $u['role'] ?>">
                                        <i class="bi bi-pencil-square fs-5"></i>
                                    </button>
                                    <button class="btn btn-sm btn-theme-action text-danger py-2 px-3" 
                                            onclick="confirmDeleteUser(<?= $u['id'] ?>)">
                                        <i class="bi bi-trash fs-5"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="createUserModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form action="<?= site_url('home/createUser') ?>" method="post" class="modal-content border-0 theme-modal shadow-lg">
            <div class="modal-header bg-yellow text-dark border-0">
                <h5 class="modal-title fw-bold">Daftarkan User Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-3">
                    <label class="form-label fw-bold small text-muted">NAMA LENGKAP</label>
                    <input type="text" name="nama" class="form-control theme-input" placeholder="Masukkan nama user..." required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold small text-muted">USERNAME</label>
                    <input type="text" name="username" class="form-control theme-input" placeholder="Masukkan username unik..." required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold small text-muted">KATA SANDI</label>
                    <input type="password" name="password" class="form-control theme-input" placeholder="Minimal 6 karakter" required>
                </div>
                <div class="mb-0">
                    <label class="form-label fw-bold small text-muted">LEVEL AKSES</label>
                    <select name="role" class="form-select theme-input border-2">
                        <option value="user">Staff (Hanya Pinjam)</option>
                        <option value="asistant">Asistant (Verifikasi Barang)</option>
                        <option value="admin">Administrator (Full Akses)</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="submit" class="btn btn-primary w-100 py-3 fw-bold">SIMPAN USER</button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="editUserModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form action="<?= site_url('home/updateUser') ?>" method="post" class="modal-content border-0 theme-modal shadow-lg">
            <input type="hidden" name="id" id="edit-user-id">
            <div class="modal-header bg-warning text-dark border-0">
                <h5 class="modal-title fw-bold">Perbarui Profil User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-3">
                    <label class="form-label fw-bold small text-muted">NAMA LENGKAP</label>
                    <input type="text" name="nama" id="edit-user-nama" class="form-control theme-input" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold small text-muted">USERNAME</label>
                    <input type="text" name="username" id="edit-user-username" class="form-control theme-input" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold small text-muted">GANTI PASSWORD</label>
                    <input type="password" name="password" class="form-control theme-input" placeholder="Biarkan kosong jika tidak diganti">
                </div>
                <div class="mb-0">
                    <label class="form-label fw-bold small text-muted">LEVEL AKSES</label>
                    <select name="role" id="edit-user-role" class="form-select theme-input border-2">
                        <option value="user">Staff (Hanya Pinjam)</option>
                        <option value="asistant">Asistant (Verifikasi Barang)</option>
                        <option value="admin">Administrator (Full Akses)</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="submit" class="btn btn-warning w-100 py-3 fw-bold text-dark">UPDATE DATA USER</button>
            </div>
        </form>
    </div>
</div>

<style>
    /* VARIABEL ADAPTIF */
    .theme-card { background-color: var(--bg-card) !important; color: var(--text-main); }
    .theme-table { color: var(--text-main) !important; }
    .theme-modal { background-color: var(--bg-card) !important; color: var(--text-main); }
    .theme-input { background-color: var(--bg-body) !important; color: var(--text-main) !important; border-color: rgba(255, 255, 255, 0.1) !important; }
    .btn-theme-action { background-color: rgba(255, 255, 255, 0.05); transition: 0.2s; }
    .btn-theme-action:hover { background-color: rgba(255, 255, 255, 0.15); }
    
    /* Warna Asistant Sinkron dengan Workflow */
    .status-tunggu { background-color: rgba(13, 110, 253, 0.1) !important; color: #0d6efd !important; border: 1px solid rgba(13, 110, 253, 0.2); }
    .bg-yellow { background-color: var(--primary-yellow) !important; }
</style>

<script>
    const editUserModal = document.getElementById('editUserModal');
    if (editUserModal) {
        editUserModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            document.getElementById('edit-user-id').value = button.dataset.id;
            document.getElementById('edit-user-nama').value = button.dataset.nama;
            document.getElementById('edit-user-username').value = button.dataset.username;
            document.getElementById('edit-user-role').value = button.dataset.role;
        });
    }

    function confirmDeleteUser(id) {
        const isDark = document.documentElement.getAttribute('data-bs-theme') === 'dark';
        Swal.fire({
            title: 'Hapus User?',
            text: "Akses user ini akan dicabut permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            background: isDark ? '#1e293b' : '#fff',
            color: isDark ? '#f8fafc' : '#1e293b'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "<?= site_url('home/deleteUser/') ?>" + id;
            }
        });
    }
</script>