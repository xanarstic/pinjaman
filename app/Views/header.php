<!DOCTYPE html>
<html lang="id" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?= $setting['app_name'] ?? 'Yellowface' ?> | Management</title>
    <?php if (!empty($setting['favicon'])): ?>
        <link rel="icon" type="image/any" href="<?= base_url('uploads/settings/' . $setting['favicon']) ?>">
    <?php endif; ?>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<<<<<<< HEAD
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
=======
>>>>>>> 76654e63e3b235c2566e0adcd60cb34f8944b1fc

    <style>
        :root {
            --primary-yellow: #facc15;
            --yellow-hover: #eab308;
        }

        [data-bs-theme="light"] {
            --bg-body: #f8fafc;
            --bg-card: #ffffff;
            --text-main: #1e293b;
            --sidebar-bg: #0f172a;
        }

        [data-bs-theme="dark"] {
            --bg-body: #020617;
            --bg-card: #1e293b;
            --text-main: #f8fafc;
            --sidebar-bg: #000000;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-main);
            transition: 0.3s;
        }

        .main-wrapper {
            display: flex;
            min-height: 100vh;
            width: 100%;
        }

        /* FIX: Content Wrapper dikunci biar gak 'Melejit' ke atas */
        #content-wrapper {
            flex: 1;
            min-width: 0;
            background-color: var(--bg-body);
            padding: 25px 20px;
            /* Jarak di HP */
        }

        @media (min-width: 992px) {
            #content-wrapper {
                /* Jarak atas ditambah jadi 80px agar konten turun dan rapi */
                padding-top: 80px !important;
                padding-left: 45px;
                padding-right: 45px;
            }
        }

        /* Sidebar Link Active: Kuning Background, Hitam Text */
        .nav-pills .nav-link.active {
            background-color: var(--primary-yellow) !important;
            color: #000000 !important;
            font-weight: 700 !important;
            box-shadow: 0 4px 12px rgba(250, 204, 21, 0.3);
        }

        .nav-link:hover:not(.active) {
            background-color: rgba(250, 204, 21, 0.1) !important;
            color: var(--primary-yellow) !important;
        }

        .card {
            background-color: var(--bg-card);
            color: var(--text-main);
            border: none;
            border-radius: 20px;
        }

        .text-yellow {
            color: var(--primary-yellow) !important;
        }

        .mobile-nav {
            display: none;
            background: var(--sidebar-bg);
            color: white;
            padding: 15px 20px;
            position: sticky;
            top: 0;
            z-index: 1050;
        }

        @media (max-width: 992px) {
            .mobile-nav {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
        }
<<<<<<< HEAD

        /* Mobile Optimization for Nav Pills */
        .nav-pills::-webkit-scrollbar {
            display: none; /* Hide scrollbar for Chrome, Safari and Opera */
        }
        .nav-pills { -ms-overflow-style: none; scrollbar-width: none; }
=======
>>>>>>> 76654e63e3b235c2566e0adcd60cb34f8944b1fc
    </style>

    <script>
        const savedTheme = localStorage.getItem('theme') || 'light';
        document.documentElement.setAttribute('data-bs-theme', savedTheme);
    </script>
</head>

<body>
<<<<<<< HEAD
    <header class="mobile-nav shadow-sm position-relative">
        <div class="position-absolute start-50 translate-middle-x fw-bold d-flex align-items-center text-nowrap" style="font-size: 1.5rem; height: 100%;">
            <?php if (!empty($setting['logo'])): ?>
                <img src="<?= base_url('uploads/settings/' . $setting['logo']) ?>" style="max-height: 45px;">
            <?php else: ?>
                <span class="text-yellow">YELLOW</span>FACE
            <?php endif; ?>
        </div>
        <button class="btn text-white border-0 ms-auto" type="button" data-bs-toggle="offcanvas"
            data-bs-target="#sidebarOffcanvas">
            <i class="bi bi-list" style="font-size: 2.2rem;"></i>
=======
    <header class="mobile-nav shadow-sm">
        <span class="fw-bold">
            <?php if (!empty($setting['logo'])): ?>
                <img src="<?= base_url('uploads/settings/' . $setting['logo']) ?>" style="max-height: 30px;">
            <?php else: ?>
                <span class="text-yellow">YELLOW</span>FACE
            <?php endif; ?>
        </span>
        <button class="btn text-white border-0" type="button" data-bs-toggle="offcanvas"
            data-bs-target="#sidebarOffcanvas">
            <i class="bi bi-list fs-2"></i>
>>>>>>> 76654e63e3b235c2566e0adcd60cb34f8944b1fc
        </button>
    </header>
    <div class="main-wrapper">