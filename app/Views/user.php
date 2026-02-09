<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold"><i class="bi bi-people-fill me-2 text-yellow"></i>Manajemen User</h3>
        <button class="btn btn-primary px-4 shadow-sm fw-bold" data-bs-toggle="modal" data-bs-target="#createUserModal">
            <i class="bi bi-person-plus-fill me-1"></i> Tambah User
        </button>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success border-0 shadow-sm mb-4"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger border-0 shadow-sm mb-4"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 20px;">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-yellow text-dark">
                    <tr>
                        <th class="ps-4 py-3">INFORMASI PENGGUNA</th>
                        <th class="py-3">KONTAK / EMAIL</th>
                        <th class="py-3 text-center">HAK AKSES</th>
                        <th class="pe-4 py-3 text-end">TINDAKAN</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $u): ?>
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-box me-3 text-white fw-bold d-flex align-items-center justify-content-center shadow-sm" 
                                         style="background-color: <?= $u['role'] === 'admin' ? '#ef4444' : '#6366f1' ?>; width: 45px; height: 45px; border-radius: 12px;">
                                        <?= strtoupper(substr(esc($u['nama']), 0, 1)) ?>
                                    </div>
                                    <div>
                                        <span class="fw-bold d-block text-main"><?= esc($u['nama']) ?></span>
                                        <small class="text-secondary small">ID Pengguna: #<?= $u['id'] ?></small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="text-main fw-medium"><i class="bi bi-envelope-fill me-2 opacity-50"></i><?= esc($u['email']) ?></div>
                            </td>
                            <td class="text-center">
                                <span class="badge rounded-pill px-3 py-2 <?= $u['role'] === 'admin' ? 'bg-danger bg-opacity-10 text-danger border border-danger' : 'bg-secondary bg-opacity-10 text-secondary border border-secondary' ?>">
                                    <?= ucfirst($u['role']) ?>
                                </span>
                            </td>
                            <td class="pe-4 text-end">
                                <div class="btn-group border rounded shadow-sm overflow-hidden">
                                    <button class="btn btn-sm bg-card-theme text-warning py-2 border-0 px-3" 
                                            data-bs-toggle="modal" data-bs-target="#editUserModal"
                                            data-id="<?= $u['id'] ?>" data-nama="<?= esc($u['nama']) ?>"
                                            data-email="<?= esc($u['email']) ?>" data-role="<?= $u['role'] ?>">
                                        <i class="bi bi-pencil-square fs-5"></i>
                                    </button>
                                    <button class="btn btn-sm bg-card-theme text-danger py-2 border-0 px-3" 
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
        <form action="<?= site_url('home/createUser') ?>" method="post" class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-yellow text-dark">
                <h5 class="modal-title fw-bold">Daftarkan User Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-3">
                    <label class="form-label fw-bold small text-muted">NAMA LENGKAP</label>
                    <input type="text" name="nama" class="form-control" placeholder="Masukkan nama user..." required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold small text-muted">ALAMAT EMAIL</label>
                    <input type="email" name="email" class="form-control" placeholder="user@yellowface.com" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold small text-muted">KATA SANDI</label>
                    <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter" required>
                </div>
                <div class="mb-0">
                    <label class="form-label fw-bold small text-muted">LEVEL AKSES</label>
                    <select name="role" class="form-select border-2">
                        <option value="staff">Staff (Hanya Pinjam)</option>
                        <option value="admin">Administrator (Full Akses)</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">Simpan User</button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="editUserModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form action="<?= site_url('home/updateUser') ?>" method="post" class="modal-content border-0 shadow-lg">
            <input type="hidden" name="id" id="edit-user-id">
            <div class="modal-header bg-warning">
                <h5 class="modal-title fw-bold text-dark">Perbarui Profil User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-3">
                    <label class="form-label fw-bold small text-muted">NAMA LENGKAP</label>
                    <input type="text" name="nama" id="edit-user-nama" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold small text-muted">ALAMAT EMAIL</label>
                    <input type="email" name="email" id="edit-user-email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold small text-muted">GANTI PASSWORD</label>
                    <input type="password" name="password" class="form-control" placeholder="Biarkan kosong jika tidak diganti">
                </div>
               <div class="mb-0">
    <label class="form-label fw-bold small text-muted">LEVEL AKSES</label>
    <select name="role" id="edit-user-role" class="form-select border-2">
        <option value="user">Staff (Hanya Pinjam)</option>
        <option value="admin">Administrator (Full Akses)</option>
    </select>
</div>
            </div>
            <div class="modal-footer border-0">
                <button type="submit" class="btn btn-warning w-100 py-2 fw-bold text-dark">Update Data User</button>
            </div>
        </form>
    </div>
</div>

<style>
    .bg-yellow { background-color: var(--primary-yellow) !important; }
    .bg-card-theme { background-color: var(--bg-card) !important; }
    .text-main { color: var(--text-main); }
</style>

<script>
    // Skrip untuk mengisi data modal edit secara otomatis
    const editUserModal = document.getElementById('editUserModal');
    if (editUserModal) {
        editUserModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            document.getElementById('edit-user-id').value = button.dataset.id;
            document.getElementById('edit-user-nama').value = button.dataset.nama;
            document.getElementById('edit-user-email').value = button.dataset.email;
            document.getElementById('edit-user-role').value = button.dataset.role;
        });
    }

    function confirmDeleteUser(id) {
        if (confirm('Apakah Anda yakin ingin menghapus user ini? Semua riwayat log user ini akan tetap tersimpan.')) {
            window.location.href = "<?= site_url('home/deleteUser/') ?>" + id;
        }
    }
</script>