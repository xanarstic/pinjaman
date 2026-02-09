<div class="container-fluid">
    <h3 class="fw-bold mb-4"><i class="bi bi-gear-fill me-2 text-yellow"></i>Pengaturan Sistem</h3>

    <div class="row">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm p-4">
                <form action="<?= site_url('home/updateSettings') ?>" method="post" enctype="multipart/form-data">

                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Aplikasi (Tab & Sidebar)</label>
                        <input type="text" name="app_name" class="form-control" value="<?= $setting['app_name'] ?>"
                            required>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Logo Sidebar</label>
                            <input type="file" name="logo" class="form-control mb-2"
                                onchange="preview(this, '#p-logo')">
                            <img id="p-logo" src="<?= base_url('uploads/settings/' . $setting['logo']) ?>"
                                class="img-thumbnail <?= !$setting['logo'] ? 'd-none' : '' ?>"
                                style="max-height: 80px;">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Favicon (Tab Browser)</label>
                            <input type="file" name="favicon" class="form-control mb-2"
                                onchange="preview(this, '#p-fav')">
                            <img id="p-fav" src="<?= base_url('uploads/settings/' . $setting['favicon']) ?>"
                                class="img-thumbnail <?= !$setting['favicon'] ? 'd-none' : '' ?>"
                                style="max-height: 50px;">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Tampilan Identitas Sidebar</label>
                        <select name="sidebar_type" class="form-select">
                            <option value="text" <?= $setting['sidebar_type'] == 'text' ? 'selected' : '' ?>>Gunakan Teks
                                (Nama Aplikasi)</option>
                            <option value="image" <?= $setting['sidebar_type'] == 'image' ? 'selected' : '' ?>>Gunakan Logo
                                (Gambar)</option>
                        </select>
                    </div>

                    <button class="btn btn-primary px-5 py-2">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function preview(input, target) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) { $(target).attr('src', e.target.result).removeClass('d-none'); }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>