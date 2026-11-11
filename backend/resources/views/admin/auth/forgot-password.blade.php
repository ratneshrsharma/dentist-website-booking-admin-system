<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Forgot Password - Advanced Dental PRO</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-beta2/dist/css/adminlte.min.css">
    <style>
        :root {
            --app-primary: #0D9488;
            --app-primary-dark: #0F766E;
        }
        body {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            background: linear-gradient(135deg, #0F172A 0%, #1E293B 50%, #0F766E 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }
        .login-card-box {
            width: 100%;
            max-width: 460px;
            background: #ffffff;
            border-radius: 1rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.45);
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .login-header-banner {
            background: linear-gradient(135deg, #0F172A 0%, #0D9488 100%);
            padding: 2.25rem 2rem 1.75rem;
            color: #ffffff;
            text-align: center;
        }
        .brand-logo-icon {
            width: 52px;
            height: 52px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            margin-bottom: 0.75rem;
            border: 1px solid rgba(255, 255, 255, 0.25);
        }
        .btn-teal-primary {
            background-color: var(--app-primary);
            border-color: var(--app-primary);
            color: #ffffff;
            font-weight: 600;
            padding: 0.75rem 1.25rem;
            border-radius: 0.5rem;
        }
        .btn-teal-primary:hover {
            background-color: var(--app-primary-dark);
            border-color: var(--app-primary-dark);
            color: #ffffff;
        }
    </style>
</head>
<body>

<div class="login-card-box">
    <!-- Header -->
    <div class="login-header-banner">
        <div class="brand-logo-icon">
            <i class="bi bi-key-fill text-warning"></i>
        </div>
        <h4 class="fw-bold mb-1 tracking-tight">Password Recovery</h4>
        <p class="text-white-50 small mb-0">Secure Clinical Access Credential Reset</p>
    </div>

    <!-- Form Body -->
    <div class="p-4">
        <?php if (!empty($reset_sent)): ?>
            <div class="alert alert-success d-flex align-items-center small py-3 px-3 mb-3 rounded-3" role="alert">
                <i class="bi bi-check-circle-fill me-2 fs-4 text-success"></i>
                <div>
                    <strong>Reset link dispatched!</strong><br>
                    If an active clinician or staff account exists for <span class="fw-bold"><?= htmlspecialchars($email ?? '') ?></span>, secure reset instructions and a 15-minute one-time token have been transmitted.
                </div>
            </div>
            <div class="text-center mt-4">
                <a href="{{ url('/admin/login') }}" class="btn btn-teal-primary w-100">
                    <i class="bi bi-arrow-left me-2"></i>Return to Sign In
                </a>
            </div>
        <?php else: ?>
            <p class="text-muted small mb-3">
                Enter your verified practice email address below. We'll verify your clinician identity and transmit a cryptographically signed password reset token.
            </p>

            <form action="{{ url('/admin/forgot-password') }}" method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label small fw-semibold text-secondary">Registered Work Email</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-envelope"></i></span>
                        <input type="email" class="form-control border-start-0 ps-0" id="email" name="email" placeholder="doctor@advanceddental.com" required autofocus>
                    </div>
                </div>

                <button type="submit" class="btn btn-teal-primary w-100 mb-3 shadow-sm">
                    <i class="bi bi-send-check me-2"></i>Send Secure Reset Instructions
                </button>
            </form>

            <div class="text-center pt-2 border-top">
                <a href="{{ url('/admin/login') }}" class="small text-decoration-none text-muted">
                    <i class="bi bi-arrow-left me-1"></i>Back to Sign In
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
