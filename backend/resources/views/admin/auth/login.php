<?php

declare(strict_types=1);

use App\Core\App;

$clinicName = $theme['branding']['clinic_name'] ?? 'Dental SaaS';
$clinicTagline = $theme['branding']['tagline'] ?? 'Practice Management';
$clinicLogo = $theme['branding']['logo_url'] ?? App::url('/images/acocks-green-logo.png');
$primaryColor = $theme['colors']['primary'] ?? '#0d631b';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Staff Sign In — <?= htmlspecialchars($clinicName) ?></title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-beta2/dist/css/adminlte.min.css">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
            background: linear-gradient(135deg, #f0fdf4 0%, #e2e8f0 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 100%;
            max-width: 440px;
        }
        .login-card-header {
            background-color: #ffffff;
            border-bottom: 1px solid #f1f5f9;
            text-align: center;
            padding: 2.5rem 2rem 1.5rem;
        }
        .clinic-logo-circle {
            width: 72px;
            height: 72px;
            margin: 0 auto 1rem;
            border-radius: 50%;
            padding: 8px;
            background: #ffffff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .clinic-logo-circle img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }
        .btn-brand {
            background-color: <?= htmlspecialchars($primaryColor) ?>;
            border-color: <?= htmlspecialchars($primaryColor) ?>;
            color: #ffffff;
            font-weight: 600;
            padding: 0.75rem 1.25rem;
        }
        .btn-brand:hover {
            filter: brightness(0.9);
            color: #ffffff;
        }
    </style>
</head>
<body>
    <div class="card login-card">
        <div class="login-card-header">
            <div class="clinic-logo-circle">
                <img src="<?= htmlspecialchars($clinicLogo) ?>" alt="Logo">
            </div>
            <h4 class="fw-bold mb-1" style="color: <?= htmlspecialchars($primaryColor) ?>;">
                <?= htmlspecialchars($clinicName) ?>
            </h4>
            <p class="text-muted small mb-0"><?= htmlspecialchars($clinicTagline) ?></p>
        </div>

        <div class="card-body p-4 bg-white">
            <?php if (!empty($flashError)): ?>
                <div class="alert alert-danger py-2 small d-flex align-items-center mb-3">
                    <i class="bi bi-exclamation-circle-fill me-2 fs-6"></i>
                    <div><?= htmlspecialchars($flashError) ?></div>
                </div>
            <?php endif; ?>

            <?php if (!empty($flashSuccess)): ?>
                <div class="alert alert-success py-2 small d-flex align-items-center mb-3">
                    <i class="bi bi-check-circle-fill me-2 fs-6"></i>
                    <div><?= htmlspecialchars($flashSuccess) ?></div>
                </div>
            <?php endif; ?>

            <form action="<?= App::url('/admin/login') ?>" method="POST">
                <div class="mb-3">
                    <label class="form-label small fw-semibold text-secondary">Work Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted"><i class="bi bi-envelope"></i></span>
                        <input type="email" name="email" class="form-control" placeholder="admin@example.com" value="admin@example.com" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-semibold text-secondary">Secure Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted"><i class="bi bi-lock"></i></span>
                        <input type="password" name="password" class="form-control" placeholder="••••••••" value="Admin@DemoPass2026!" required>
                    </div>
                </div>

                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-brand rounded-pill shadow-sm">
                        <i class="bi bi-box-arrow-in-right me-2"></i> Sign In to Clinic Portal
                    </button>
                </div>
            </form>

            <div class="border-top pt-3 text-center">
                <form action="<?= App::url('/admin/login') ?>" method="POST">
                    <input type="hidden" name="demo_login" value="1">
                    <button type="submit" class="btn btn-outline-secondary btn-sm rounded-pill w-100">
                        <i class="bi bi-lightning-charge-fill text-warning me-1"></i> Quick 1-Click Demo Sign-in
                    </button>
                </form>
            </div>
        </div>

        <div class="card-footer bg-light text-center py-3 border-0">
            <a href="<?= App::url('/') ?>" class="text-decoration-none small text-muted">
                <i class="bi bi-arrow-left me-1"></i> Back to Public Patient Website
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
