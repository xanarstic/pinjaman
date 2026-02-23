<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Link Tidak Nyata | Yellowface</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --yellow: #facc15;
            --dark: #0f172a;
        }

        body {
            background-color: var(--dark);
            color: white;
            font-family: 'Poppins', sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            overflow: hidden;
        }

        .error-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 30px;
            padding: 50px;
            max-width: 500px;
            width: 90%;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        .logo-img {
            max-height: 120px;
            filter: drop-shadow(0 0 10px rgba(250, 204, 21, 0.3));
        }

        .text-yellow {
            color: var(--yellow) !important;
        }

        .btn-yellow {
            background-color: var(--yellow);
            color: var(--dark);
            font-weight: bold;
            border: none;
            padding: 12px 30px;
            border-radius: 50px;
            transition: 0.3s;
        }

        .btn-yellow:hover {
            background-color: white;
            transform: scale(1.05);
        }

        .glitch-text {
            font-size: 5rem;
            font-weight: 800;
            margin: 0;
            line-height: 1;
            letter-spacing: -2px;
        }
    </style>
</head>

<body>

    <div class="error-card text-center">
        <div class="mb-4">
            <?php if (!empty($setting['logo'])): ?>
                <img src="<?= base_url('uploads/settings/' . $setting['logo']) ?>" class="logo-img mb-3">
            <?php else: ?>
                <h2 class="fw-bold text-yellow">YELLOWFACE</h2>
            <?php endif; ?>
        </div>

        <p class="glitch-text text-yellow opacity-25">404</p>
        <h4 class="fw-bold mb-3 mt-n3">LINK INI TIDAK NYATA</h4>

        <p class="text-white-50 small mb-4">
            Waduh! Sepertinya Anda tersesat di dimensi lain. <br>
            Halaman ini tidak tersedia di sistem inventaris.
        </p>

        <?php if ($logged): ?>
            <a href="<?= site_url('home/dashboard') ?>" class="btn btn-yellow">
                <i class="bi bi-speedometer2 me-2"></i> Ke Dashboard
            </a>
        <?php else: ?>
            <a href="<?= site_url('home/login') ?>" class="btn btn-yellow">
                <i class="bi bi-door-open-fill me-2"></i> Ke Halaman Login
            </a>
        <?php endif; ?>
    </div>

</body>

</html>