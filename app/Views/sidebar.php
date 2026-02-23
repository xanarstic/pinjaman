<nav id="sidebar-wrapper" class="p-3 text-white d-none d-lg-flex flex-column shadow"
    style="background: var(--sidebar-bg); width: 280px; position: sticky; top: 0; height: 100vh; z-index: 1000;">

    <div class="text-center mb-4">
        <?php if (($setting['sidebar_type'] ?? 'text') == 'image' && !empty($setting['logo'] ?? '')): ?>
            <img src="<?= base_url('uploads/settings/' . $setting['logo']) ?>" alt="Logo" class="img-fluid mb-2"
                style="max-height: 180px; width: auto; max-width: 90%; object-fit: contain;">
        <?php else: ?>
            <h4 class="fw-bold mb-0 text-white mt-3">
                <span class="text-yellow"><?= strtoupper($setting['app_name'] ?? 'YELLOWFACE') ?></span>
            </h4>
        <?php endif; ?>
        <small class="text-white-50 d-block mt-1 fw-bold" style="font-size: 0.6rem; letter-spacing: 2px;">
            INVENTORY MANAGEMENT SYSTEM
        </small>
    </div>

    <hr style="opacity: 0.1; margin-top: 0;">

    <div class="nav nav-pills flex-column mb-auto px-2">
        <?php
        $role = session()->get('role'); // Ambil role dari session
        
        /** * Urutan Menu Sesuai Permintaan:
         * 1. Dashboard, 2. Barang, 3. Log Peminjaman (Semua Role)
         * 4. Activity Log, 5. Setting, 6. Users (Hanya Admin)
         */
        $menu_items = [
            ['dashboard', 'speedometer2', 'Dashboard'],
            ['barang', 'box-seam', 'Data Barang'],
            ['log', 'clock-history', 'Log Peminjaman'],
        ];

        // Tambahkan menu khusus Admin
        if ($role === 'admin') {
            $menu_items[] = ['activity', 'journal-text', 'Activity Log'];
            $menu_items[] = ['setting', 'gear-fill', 'Setting'];
            $menu_items[] = ['user', 'people', 'Users'];
        }

        foreach ($menu_items as $m): ?>
            <a href="<?= site_url('home/' . $m[0]) ?>"
                class="nav-link py-2 px-3 mb-2 <?= ($active === $m[0]) ? 'active' : 'text-white-50' ?>"
                style="border-radius: 12px; transition: 0.3s;">
                <i class="bi bi-<?= $m[1] ?> me-2"></i> <?= $m[2] ?>
            </a>
        <?php endforeach; ?>
    </div>

    <div class="px-2 mb-3">
        <div class="d-flex align-items-center justify-content-between p-2 rounded-3 bg-white bg-opacity-10 shadow-sm"
            style="cursor: pointer;" onclick="toggleTheme()">
            <span class="small ps-2 text-white-50">
                <i class="bi bi-sun-fill text-yellow me-2 theme-icon-class"></i> Mode
            </span>
            <div class="form-check form-switch m-0">
                <input class="form-check-input theme-toggle-class" type="checkbox" style="cursor: pointer;">
            </div>
        </div>
    </div>

    <hr style="opacity: 0.1;">

    <div class="px-2">
        <a href="<?= site_url('home/logout') ?>" class="nav-link text-danger fw-bold d-flex align-items-center p-3"
<<<<<<< HEAD
            style="border-radius: 12px;" onclick="event.preventDefault(); confirmLogout(this.href)">
=======
            style="border-radius: 12px;" onclick="return confirm('Keluar dari sistem?')">
>>>>>>> 76654e63e3b235c2566e0adcd60cb34f8944b1fc
            <i class="bi bi-box-arrow-left me-2"></i> LOGOUT
        </a>
    </div>
</nav>

<div class="offcanvas offcanvas-start bg-dark text-white d-lg-none" tabindex="-1" id="sidebarOffcanvas"
    style="width: 280px;">
    <div class="offcanvas-header border-bottom border-secondary">
        <h5 class="offcanvas-title fw-bold text-yellow">
            <?= strtoupper($setting['app_name'] ?? 'YELLOWFACE') ?>
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body d-flex flex-column">
        <div class="nav nav-pills flex-column mb-auto">
            <?php foreach ($menu_items as $m): ?>
                <a href="<?= site_url('home/' . $m[0]) ?>"
                    class="nav-link py-3 <?= ($active === $m[0]) ? 'active' : 'text-white' ?>">
                    <i class="bi bi-<?= $m[1] ?> me-2"></i> <?= $m[2] ?>
                </a>
            <?php endforeach; ?>
        </div>

        <div class="px-0 mb-3">
            <div class="d-flex align-items-center justify-content-between p-3 rounded-3 bg-white bg-opacity-10"
                onclick="toggleTheme()" style="cursor: pointer;">
                <span class="small text-white-50">
                    <i class="bi bi-sun-fill text-yellow me-2 theme-icon-class"></i> Mode Tampilan
                </span>
                <div class="form-check form-switch m-0">
                    <input class="form-check-input theme-toggle-class" type="checkbox">
                </div>
            </div>
        </div>

        <hr>
        <a href="<?= site_url('home/logout') ?>" class="nav-link text-danger py-3 fw-bold"
<<<<<<< HEAD
            onclick="event.preventDefault(); confirmLogout(this.href)">
=======
            onclick="return confirm('Keluar?')">
>>>>>>> 76654e63e3b235c2566e0adcd60cb34f8944b1fc
            <i class="bi bi-box-arrow-left me-2"></i> LOGOUT
        </a>
    </div>
</div>

<main id="content-wrapper" class="flex-grow-1 p-4">