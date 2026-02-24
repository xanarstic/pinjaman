<div class="container-fluid">
    <div class="row align-items-center mb-4 g-3">
        <div class="col-12 col-md">
            <h3 class="fw-bold text-main m-0">
                <i class="bi bi-box-seam me-2 text-yellow"></i>Data Barang
            </h3>
        </div>
        <?php if (session()->get('role') === 'admin'): ?>
            <div class="col-12 col-md-auto">
                <button class="btn btn-primary px-4 shadow-sm fw-bold w-100" data-bs-toggle="modal" data-bs-target="#createModal">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Barang
                </button>
            </div>
        <?php endif; ?>
    </div>

    <!-- Search Bar Section -->
    <div class="card border-0 shadow-sm mb-4 theme-card p-3">
        <form action="" method="get" class="row g-2">
            <?php if(($filter ?? 'all') !== 'all'): ?>
                <input type="hidden" name="filter" value="<?= esc($filter) ?>">
            <?php endif; ?>
            <div class="col-12 col-md">
                <input type="text" name="keyword" value="<?= esc($keyword ?? '') ?>" class="form-control theme-input border-0" placeholder="Cari nama barang..." autocomplete="off">
            </div>
            <div class="col-12 col-md-auto">
                <button type="submit" class="btn btn-primary px-4 fw-bold w-100"><i class="bi bi-search"></i></button>
            </div>
            <?php if (!empty($keyword)): ?>
                <div class="col-12 col-md-auto">
                    <a href="<?= site_url('home/barang') ?>" class="btn btn-secondary px-3 w-100" title="Reset"><i class="bi bi-x-lg"></i></a>
                </div>
            <?php endif; ?>
        </form>
    </div>

    <div class="row g-4">
        <?php if (empty($barang)): ?>
            <div class="col-12 text-center py-5">
                <i class="bi bi-box-fill display-1 text-muted opacity-25"></i>
                <p class="text-muted mt-3">Data barang tidak ditemukan.</p>
            </div>
        <?php endif; ?>

        <?php foreach ($barang as $b): ?>
            <div class="col-6 col-md-4 col-lg-3">
                <div class="card h-100 shadow-sm position-relative overflow-hidden theme-card card-barang <?= ($b['status'] === 'dipakai' || $b['status'] === 'menunggu_konfirmasi') ? 'item-dipakai' : '' ?>">
                    
                    <?php
                        $badgeClass = 'bg-success';
                        if ($b['status'] === 'dipakai') $badgeClass = 'bg-danger';
                        if ($b['status'] === 'menunggu_konfirmasi') $badgeClass = 'bg-warning text-dark';
                        
                        $statusText = str_replace('_', ' ', $b['status'] ?? 'tersedia');
                    ?>
                    <span class="badge position-absolute top-0 end-0 m-3 <?= $badgeClass ?>" style="z-index: 2; font-size: 0.7rem;">
                        <?= strtoupper($statusText) ?>
                    </span>
                    
                    <div class="image-box theme-img-bg text-center">
                        <?php if ($b['foto']): ?>
                            <img src="<?= base_url('uploads/barang/'.$b['foto']) ?>" class="card-img-top img-barang-responsive" style="object-fit: cover;">
                        <?php else: ?>
                            <div class="d-flex align-items-center justify-content-center img-barang-responsive">
                                <i class="bi bi-image text-muted fs-1 opacity-50"></i>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="card-body d-flex flex-column">
                        <h6 class="fw-bold mb-1 text-truncate text-main"><?= esc($b['nama_barang']) ?></h6>
                        
                        <div class="small mb-2 mb-md-3 flex-grow-1" style="font-size: 0.75rem;">
                            <?php if ($b['status'] === 'dipakai' || $b['status'] === 'menunggu_konfirmasi'): ?>
                                <div class="p-2 rounded mt-2 <?= $b['status'] === 'dipakai' ? 'status-pinjam-box' : 'status-tunggu-box' ?>">
                                    <i class="bi bi-person-fill me-1"></i> 
                                    <span class="d-none d-md-inline"><?= $b['status'] === 'dipakai' ? 'Dipakai:' : 'Oleh:' ?></span> 
                                    <strong class="text-main"><?= esc($b['user_nama']) ?></strong>
                                </div>
                            <?php else: ?>
                                <span class="text-secondary small"><i class="bi bi-check-circle-fill text-success me-1"></i> Tersedia di gudang</span>
                            <?php endif; ?>
                        </div>

                        <div class="d-flex gap-1 gap-md-2 flex-column flex-md-row">
                            <?php if (session()->get('role') === 'admin'): ?>
                                <button class="btn btn-sm btn-outline-warning w-100 fw-bold" data-bs-toggle="modal" data-bs-target="#editModal" 
                                        data-id="<?= $b['id'] ?>" data-nama="<?= esc($b['nama_barang']) ?>" data-foto="<?= $b['foto'] ?>">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </button>
                                <button class="btn btn-sm btn-outline-danger px-3" onclick="confirmDelete(<?= $b['id'] ?>)">
                                    <i class="bi bi-trash"></i>
                                </button>
                            <?php else: ?>
                                <button class="btn btn-sm btn-theme-disabled w-100 disabled text-muted border border-secondary border-opacity-25">
                                    <i class="bi bi-lock-fill me-1"></i> View Only
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<div class="modal fade" id="createModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form method="post" enctype="multipart/form-data" action="<?= site_url('home/createBarang') ?>" class="modal-content border-0 theme-modal">
            <div class="modal-header bg-yellow text-dark border-0">
                <h5 class="fw-bold mb-0">Tambah Barang Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="text-center mb-3">
                    <img id="preview-add" class="img-thumbnail d-none theme-img-preview" style="max-height: 200px;">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold small text-muted">NAMA BARANG</label>
                    <input name="nama_barang" class="form-control theme-input" placeholder="Contoh: Kamera Sony A7III" required>
                </div>
                <div class="mb-0">
                    <label class="form-label fw-bold small text-muted">UNGGAH FOTO</label>
                    <input type="file" name="foto" class="form-control theme-input" onchange="previewImg(this, '#preview-add')">
                </div>
            </div>
            <div class="modal-footer border-0">
                <button class="btn btn-primary w-100 py-2 fw-bold shadow-sm">Simpan Data</button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form method="post" enctype="multipart/form-data" action="<?= site_url('home/updateBarang') ?>" class="modal-content border-0 theme-modal">
            <input type="hidden" name="id" id="edit-id">
            <div class="modal-header bg-warning text-dark border-0">
                <h5 class="fw-bold mb-0">Edit Data Barang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="text-center mb-3">
                    <img id="preview-edit" class="img-thumbnail theme-img-preview" style="max-height: 200px;">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold small text-muted">NAMA BARANG</label>
                    <input name="nama_barang" id="edit-nama" class="form-control theme-input" required>
                </div>
                <div class="mb-0">
                    <label class="form-label fw-bold small text-muted">GANTI FOTO (OPSIONAL)</label>
                    <input type="file" name="foto" class="form-control theme-input" onchange="previewImg(this, '#preview-edit')">
                </div>
            </div>
            <div class="modal-footer border-0">
                <button class="btn btn-warning w-100 py-2 fw-bold text-dark shadow-sm">Update Perubahan</button>
            </div>
        </form>
    </div>
</div>

<style>
    /* VARIABEL ADAPTIF TEMA */
    .theme-card { background-color: var(--bg-card) !important; color: var(--text-main); border: 1px solid rgba(255,255,255, 0.05); }
    .theme-modal { background-color: var(--bg-card) !important; color: var(--text-main); }
    .theme-img-bg { background-color: rgba(255,255,255, 0.03) !important; border-bottom: 1px solid rgba(255,255,255, 0.05); }
    .theme-input { background-color: rgba(255,255,255, 0.05) !important; color: var(--text-main) !important; border: 1px solid rgba(255,255,255, 0.1) !important; }
/* Baris 139 di barang.php */
.theme-input:focus {            
    border-color: var(--primary-yellow) !important; 
    box-shadow: 0 0 0 0.25rem rgba(250, 204, 21, 0.25); 
    outline: none;
}
    .theme-img-preview { background-color: var(--bg-body); border-color: rgba(255,255,255, 0.1); }
    .theme-btn-disabled { background-color: rgba(255,255,255, 0.02) !important; }

    /* Info Box Peminjam */
    .status-pinjam-box { background-color: rgba(239, 68, 68, 0.08); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.15); }
    .status-tunggu-box { background-color: rgba(250, 204, 21, 0.1); color: #eab308; border: 1px solid rgba(250, 204, 21, 0.2); }

    /* Animasi & Hover */
    .card-barang { border-radius: 20px; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
    .card-barang:hover { transform: translateY(-8px); box-shadow: 0 12px 24px -10px rgba(0,0,0,0.5) !important; }

    .item-dipakai { opacity: 0.75; filter: grayscale(0.8); }
    .item-dipakai .image-box img { filter: brightness(0.5); }

    .bg-yellow { background-color: var(--primary-yellow) !important; }

    /* Responsive Image Height */
    .img-barang-responsive { height: 140px; width: 100%; }
    @media (min-width: 768px) {
        .img-barang-responsive { height: 200px; }
    }
</style>

<script>
    // Preview Gambar saat upload
    function previewImg(input, target) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) { 
                $(target).attr('src', e.target.result).removeClass('d-none'); 
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Passing data ke modal edit
    const editModal = document.getElementById('editModal');
    if (editModal) {
        editModal.addEventListener('show.bs.modal', function (e) {
            const b = e.relatedTarget;
            document.getElementById('edit-id').value = b.dataset.id;
            document.getElementById('edit-nama').value = b.dataset.nama;
            const img = document.getElementById('preview-edit');
            if(b.dataset.foto) {
                img.src = "<?= base_url('uploads/barang/') ?>/" + b.dataset.foto;
                img.classList.remove('d-none');
            } else {
                img.classList.add('d-none');
            }
        });
    }

    function confirmDelete(id) {
        const isDark = document.documentElement.getAttribute('data-bs-theme') === 'dark';
        Swal.fire({
            title: 'Hapus Barang?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
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
                window.location.href = "<?= site_url('home/deleteBarang/') ?>" + id;
            }
        });
    }
</script>