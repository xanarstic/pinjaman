<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | Yellowface Inventory</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --primary-yellow: #facc15;
            --dark-navy: #0f172a;
            --navy-lighter: #1e293b;
<<<<<<< HEAD
            --glass-bg: rgba(255, 255, 255, 0.05);
            --glass-border: rgba(255, 255, 255, 0.1);
=======
>>>>>>> 76654e63e3b235c2566e0adcd60cb34f8944b1fc
        }

        body {
            font-family: 'Poppins', sans-serif;
<<<<<<< HEAD
            background-color: var(--dark-navy);
            min-height: 100vh;
            min-height: 100dvh;
            display: flex;
            margin: 0;
            overflow-x: hidden;
            overflow-y: auto;
            position: relative;
        }

        /* Animated Background */
        .bg-shape {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.4;
            z-index: -1;
            animation: float 10s infinite ease-in-out;
            will-change: transform;
        }

        .shape-1 {
            width: 400px; height: 400px;
            background: var(--primary-yellow);
            top: -100px; left: -100px;
            animation-delay: 0s;
        }
        .shape-2 {
            width: 300px; height: 300px;
            background: #6366f1;
            bottom: -50px; right: -50px;
            animation-delay: 2s;
        }
        .shape-3 {
            width: 200px; height: 200px;
            background: #ec4899;
            top: 40%; left: 60%;
            animation-delay: 4s;
        }

        .login-container {
            width: 100%;
            max-width: 400px;
            padding: 20px;
            margin: auto;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        .login-header {
            background: rgba(250, 204, 21, 0.9);
            padding: 45px 20px;
            text-align: center;
            position: relative;
        }

        .login-header i {
            font-size: 3.5rem;
            color: var(--dark-navy);
            filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.1));
        }

        .brand-name {
            color: var(--dark-navy);
            font-weight: 800;
            letter-spacing: 2px;
            margin-top: 10px;
            font-size: 1.5rem;
        }

        .form-label {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .input-group {
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .input-group:focus-within {
            border-color: var(--primary-yellow);
            box-shadow: 0 0 0 3px rgba(250, 204, 21, 0.2);
        }

        .input-group-text {
            background: transparent;
            border: none;
            color: rgba(255, 255, 255, 0.4);
            padding-left: 15px;
            padding-right: 10px;
        }

        .form-control {
            background: transparent;
            border: none;
            color: #fff;
            padding: 12px 15px;
        }

        .form-control:focus {
            background: transparent;
            color: #fff;
            box-shadow: none;
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.2);
        }

        .btn-login {
            background: var(--primary-yellow);
            color: var(--dark-navy);
            border: none;
            border-radius: 12px;
            padding: 14px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        .btn-login:hover {
            background: #fff;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -5px rgba(250, 204, 21, 0.4);
            color: var(--dark-navy);
        }

        .password-toggle {
            cursor: pointer;
            padding-right: 15px;
        }

        .alert {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.2);
            color: #fca5a5;
            border-radius: 12px;
            font-size: 0.9rem;
            animation: shake 0.5s ease-in-out;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(20px, -20px); }
        }
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }
    </style>
</head>

<body>

    <div class="bg-shape shape-1"></div>
    <div class="bg-shape shape-2"></div>
    <div class="bg-shape shape-3"></div>

    <div class="login-container">
        <div class="glass-card">
            <div class="login-header">
                <i class="bi bi-shield-lock-fill"></i>
                <h4 class="brand-name mb-0">YELLOWFACE</h4>
                <div class="badge bg-dark bg-opacity-10 text-dark fw-bold" style="font-size: 0.7rem;">INVENTORY SYSTEM
                </div>
            </div>

            <div class="card-body p-4 p-md-5">
                <div class="text-center mb-4">
                    <h5 class="text-white fw-bold mb-1">Akses Masuk</h5>
                    <p class="text-white-50 small">Silakan login untuk melanjutkan</p>
                </div>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert d-flex align-items-center mb-4" role="alert">
                        <i class="bi bi-exclamation-circle-fill me-2"></i>
                        <div><?= session()->getFlashdata('error') ?></div>
                    </div>
                <?php endif; ?>

                <form method="post" action="<?= site_url('home/loginProcess') ?>">
                    <div class="mb-3">
                        <label class="form-label small text-uppercase">Email</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                            <input type="email" name="email" class="form-control" placeholder="admin@email.com"
                                required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small text-uppercase">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-key-fill"></i></span>
                            <input type="password" name="password" id="passwordInput" class="form-control"
                                placeholder="••••••••" required>
                            <span class="input-group-text password-toggle" onclick="togglePassword()">
                                <i class="bi bi-eye-slash" id="toggleIcon"></i>
                            </span>
                        </div>
                    </div>

                    <!-- Human Verification -->
                    <div class="mb-4">
                        <label class="form-label small text-uppercase text-yellow">Human Verification</label>
                        <div class="input-group">
                            <span class="input-group-text text-white fw-bold bg-white bg-opacity-10" style="min-width: 80px; justify-content: center;">
                                <?= $captcha_text ?>
                            </span>
                            <input type="number" name="captcha" class="form-control text-center fw-bold" placeholder="Hasil?" required autocomplete="off">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-login w-100">
                        Masuk Sistem <i class="bi bi-arrow-right-short ms-1 fs-5"></i>
                    </button>
                </form>
            </div>
        </div>

        <p class="text-center text-white-50 mt-4 small">
            &copy; <?= date('Y') ?> <strong>Yellowface</strong><br>
            Secure Inventory Management
        </p>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('passwordInput');
            const toggleIcon = document.getElementById('toggleIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.replace('bi-eye-slash', 'bi-eye');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.replace('bi-eye', 'bi-eye-slash');
            }
        }
    </script>

</body>

</html>