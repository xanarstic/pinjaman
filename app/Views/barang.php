<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">
            <i class="bi bi-box-seam me-2 text-yellow"></i>Data Barang
        </h3>
        <?php if (session()->get('role') === 'admin'): ?>
            <button class="btn btn-primary px-4 shadow-sm fw-bold" data-bs-toggle="modal" data-bs-target="#createModal">
                <i class="bi bi-plus-lg me-1"></i> Tambah Barang
            </button>
        <?php endif; ?>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success border-0 shadow-sm mb-4"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <div class="row g-4">
        <?php if (empty($barang)): ?>
            <div class="col-12 text-center py-5">
                <i class="bi bi-box-fill display-1 text-muted opacity-25"></i>
                <p class="text-muted mt-3">Belum ada data barang tersedia.</p>
            </div>
        <?php endif; ?>

        <?php foreach ($barang as $b): ?>
            <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                <div class="card h-100 shadow-sm position-relative overflow-hidden card-barang <?= ($b['status'] === 'dipakai') ? 'item-dipakai' : '' ?>">
                    
                    <span class="badge position-absolute top-0 end-0 m-3 <?= $b['status'] === 'dipakai' ? 'bg-danger' : 'bg-success' ?>" style="z-index: 2;">
                        <?= strtoupper($b['status']) ?>
                    </span>
                    
                    <div class="image-box bg-light text-center">
                        <?php if ($b['foto']): ?>
                            <img src="<?= base_url('uploads/barang/'.$b['foto']) ?>" class="card-img-top" style="height: 200px; object-fit: cover;">
                        <?php else: ?>
                            <div class="d-flex align-items-center justify-content-center" style="height: 200px;">
                                <i class="bi bi-image text-muted fs-1"></i>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="card-body d-flex flex-column">
                        <h6 class="fw-bold mb-1 text-truncate"><?= esc($b['nama_barang']) ?></h6>
                        
                        <div class="small mb-3 flex-grow-1">
                            <?php if ($b['status'] === 'dipakai'): ?>
                                <div class="p-2 rounded bg-danger bg-opacity-10 text-danger border border-danger border-opacity-10 mt-2">
                                    <i class="bi bi-person-fill me-1"></i> Dipakai: <strong><?= esc($b['user_nama']) ?></strong>
                                </div>
                            <?php else: ?>
                                <span class="text-secondary"><i class="bi bi-check-circle-fill text-success me-1"></i> Tersedia di gudang</span>
                            <?php endif; ?>
                        </div>

                        <div class="d-flex gap-2">
                            <?php if (session()->get('role') === 'admin'): ?>
                                <button class="btn btn-sm btn-outline-warning w-100 fw-bold" data-bs-toggle="modal" data-bs-target="#editModal" 
                                        data-id="<?= $b['id'] ?>" data-nama="<?= esc($b['nama_barang']) ?>" data-foto="<?= $b['foto'] ?>">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </button>
                                <button class="btn btn-sm btn-outline-danger px-3" onclick="confirmDelete(<?= $b['id'] ?>)">
                                    <i class="bi bi-trash"></i>
                                </button>
                            <?php else: ?>
                                <button class="btn btn-sm btn-light w-100 disabled text-muted border">
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
        <form method="post" enctype="multipart/form-data" action="<?= site_url('home/createBarang') ?>" class="modal-content border-0">
            <div class="modal-header bg-yellow">
                <h5 class="fw-bold mb-0 text-dark">Tambah Barang Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="text-center mb-3">
                    <img id="preview-add" class="img-thumbnail d-none" style="max-height: 200px;">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold small text-muted">NAMA BARANG</label>
                    <input name="nama_barang" class="form-control" placeholder="Contoh: Kamera Sony A7III" required>
                </div>
                <div class="mb-0">
                    <label class="form-label fw-bold small text-muted">FOTO BARANG</label>
                    <input type="file" name="foto" class="form-control" onchange="previewImg(this, '#preview-add')">
                </div>
            </div>
            <div class="modal-footer border-0">
                <button class="btn btn-primary w-100 py-2 fw-bold shadow-sm">Simpan Data Barang</button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form method="post" enctype="multipart/form-data" action="<?= site_url('home/updateBarang') ?>" class="modal-content border-0">
            <input type="hidden" name="id" id="edit-id">
            <div class="modal-header bg-warning">
                <h5 class="fw-bold mb-0 text-dark">Edit Data Barang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="text-center mb-3">
                    <img id="preview-edit" class="img-thumbnail" style="max-height: 200px;">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold small text-muted">NAMA BARANG</label>
                    <input name="nama_barang" id="edit-nama" class="form-control" required>
                </div>
                <div class="mb-0">
                    <label class="form-label fw-bold small text-muted">GANTI FOTO (OPSIONAL)</label>
                    <input type="file" name="foto" class="form-control" onchange="previewImg(this, '#preview-edit')">
                </div>
            </div>
            <div class="modal-footer border-0">
                <button class="btn btn-warning w-100 py-2 fw-bold text-dark shadow-sm">Update Perubahan</button>
            </div>
        </form>
    </div>
</div>

<style>
    /* Styling Visual Barang */
    .card-barang { border-radius: 20px; transition: transform 0.3s ease; border: none; }
    .card-barang:hover { transform: translateY(-8px); }

    /* Efek Greyed Out untuk barang yang dipinjam */
    .item-dipakai {
        background-color: var(--bg-body) !important;
        opacity: 0.7;
        filter: grayscale(1); /* Full abu-abu */
    }
    .item-dipakai .image-box img { filter: brightness(0.6); }

    .bg-yellow { background-color: var(--primary-yellow) !important; }
</style>

<script>
    // Fungsi Preview Gambar
    function previewImg(input, target) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) { 
                $(target).attr('src', e.target.result).removeClass('d-none'); 
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Mengisi data modal edit
    const editModal = document.getElementById('editModal');
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

    function confirmDelete(id) {
        if(confirm('Hapus barang ini secara permanen?')) {
            window.location.href="<?= site_url('home/deleteBarang/') ?>"+id;
        }
    }
</script>