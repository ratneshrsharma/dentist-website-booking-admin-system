<?php

declare(strict_types=1);

use App\Core\App;

$clinicName = $theme['branding']['clinic_name'] ?? 'Dental SaaS';
$clinicTagline = $theme['branding']['tagline'] ?? 'Practice Management';
$clinicLogo = $theme['branding']['logo_url'] ?? App::url('/images/acocks-green-logo.png');
$primaryColor = $theme['colors']['primary'] ?? '#0d631b';
$is2FAPending = !empty($is2FAPending);
$twoFactorCode = $twoFactorCode ?? '';
$pendingEmail = $pendingEmail ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $is2FAPending ? 'Two-Factor Verification (2FA)' : 'Staff Sign In' ?> — <?= htmlspecialchars($clinicName) ?></title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@600;700&display=swap" rel="stylesheet">
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
            padding: 20px;
        }
        .login-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.12), 0 8px 16px -6px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            width: 100%;
            max-width: 460px;
        }
        .login-card-header {
            background-color: #ffffff;
            border-bottom: 1px solid #f1f5f9;
            text-align: center;
            padding: 2.2rem 2rem 1.4rem;
        }
        .clinic-logo-circle {
            width: 72px;
            height: 72px;
            margin: 0 auto 0.9rem;
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
        .two-factor-code-box {
            background: #f0fdf4;
            border: 2px dashed #86efac;
            border-radius: 12px;
            padding: 14px 16px;
            text-align: center;
        }
        .otp-display-badge {
            font-family: 'JetBrains Mono', monospace;
            font-size: 28px;
            font-weight: 800;
            letter-spacing: 0.25em;
            color: #094713;
            background: #ffffff;
            padding: 6px 16px;
            border-radius: 8px;
            border: 1px solid #bbf7d0;
            display: inline-block;
            margin: 8px 0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.04);
        }
        .otp-input-field {
            font-family: 'JetBrains Mono', monospace;
            font-size: 24px;
            font-weight: 700;
            letter-spacing: 0.35em;
            text-align: center;
            padding: 10px 14px;
            border-radius: 12px;
            border: 2px solid #cbd5e1;
            background-color: #f8fafc;
        }
        .otp-input-field:focus {
            border-color: <?= htmlspecialchars($primaryColor) ?>;
            background-color: #ffffff;
            box-shadow: 0 0 0 4px rgba(13, 99, 27, 0.15);
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
            <!-- Flash Notifications -->
            <?php if (!empty($flashError)): ?>
                <div class="alert alert-danger py-2 px-3 small d-flex align-items-center mb-3 rounded-3 shadow-sm border-0">
                    <i class="bi bi-exclamation-circle-fill me-2 fs-6"></i>
                    <div><?= htmlspecialchars($flashError) ?></div>
                </div>
            <?php endif; ?>

            <?php if (!empty($flashSuccess)): ?>
                <div class="alert alert-success py-2 px-3 small d-flex align-items-center mb-3 rounded-3 shadow-sm border-0">
                    <i class="bi bi-check-circle-fill me-2 fs-6"></i>
                    <div><?= htmlspecialchars($flashSuccess) ?></div>
                </div>
            <?php endif; ?>

            <!-- ============================================================== -->
            <!-- STEP 2: TWO-FACTOR AUTHENTICATION (2FA) CODE VERIFICATION      -->
            <!-- ============================================================== -->
            <?php if ($is2FAPending): ?>
                <div class="text-center mb-3">
                    <span class="badge bg-success-subtle text-success px-3 py-1 rounded-pill fw-semibold">
                        <i class="bi bi-shield-lock-fill me-1"></i> Two-Factor Security Check
                    </span>
                    <h5 class="fw-bold mt-2 mb-1">Enter 6-Digit 2FA Code</h5>
                    <p class="text-muted small mb-0">
                        Verifying staff access for <strong class="text-dark"><?= htmlspecialchars($pendingEmail) ?></strong>
                    </p>
                </div>

                <!-- Temporary 2FA Code Surface (Copy-Paste Helper) -->
                <div class="two-factor-code-box mb-3">
                    <div class="small text-success fw-bold text-uppercase" style="letter-spacing: 0.05em; font-size: 11px;">
                        <i class="bi bi-key-fill me-1"></i> Your Temporary 2FA Security Code
                    </div>
                    <div class="otp-display-badge" id="otpValue"><?= htmlspecialchars($twoFactorCode) ?></div>
                    <div class="d-flex justify-content-center gap-2 mt-1">
                        <button type="button" class="btn btn-xs btn-outline-success rounded-pill px-3 py-1 small fw-bold" onclick="copyAndPasteOtp('<?= htmlspecialchars($twoFactorCode) ?>')">
                            <i class="bi bi-clipboard-check me-1"></i> Copy &amp; Paste Code
                        </button>
                    </div>
                    <p class="text-muted mt-2 mb-0" style="font-size: 11px; line-height: 1.35;">
                        <i class="bi bi-info-circle me-1"></i> In live production, this 6-digit OTP code is dispatched directly to your registered work email address.
                    </p>
                </div>

                <!-- 2FA Submission Form -->
                <form action="<?= App::url('/admin/login') ?>" method="POST" id="twoFactorForm">
                    <input type="hidden" name="action" value="verify_2fa">

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary d-flex justify-content-between">
                            <span>6-Digit Verification Code</span>
                            <span class="text-muted small">Valid for 10 minutes</span>
                        </label>
                        <input type="text" 
                               name="code" 
                               id="codeInput" 
                               class="form-control otp-input-field" 
                               maxlength="6" 
                               pattern="[0-9]{6}" 
                               inputmode="numeric" 
                               autocomplete="one-time-code" 
                               placeholder="••••••" 
                               required 
                               autofocus>
                    </div>

                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-brand rounded-pill shadow-sm py-2">
                            <i class="bi bi-shield-check me-2"></i> Verify Code &amp; Complete Sign In
                        </button>
                    </div>

                    <div class="text-center">
                        <a href="<?= App::url('/admin/login/cancel-2fa') ?>" class="text-decoration-none small text-muted">
                            <i class="bi bi-arrow-left me-1"></i> Cancel &amp; Sign in with different credentials
                        </a>
                    </div>
                </form>

            <!-- ============================================================== -->
            <!-- STEP 1: CREDENTIALS INPUT (NO DIRECT AUTO-FILL)                -->
            <!-- ============================================================== -->
            <?php else: ?>
                <div class="text-center mb-3">
                    <span class="badge bg-secondary-subtle text-secondary px-3 py-1 rounded-pill fw-semibold">
                        <i class="bi bi-person-badge me-1"></i> Clinical Staff Access
                    </span>
                    <h5 class="fw-bold mt-2 mb-1">Sign In to Clinic Workspace</h5>
                    <p class="text-muted small mb-0">Please enter your verified practice credentials</p>
                </div>

                <form action="<?= App::url('/admin/login') ?>" method="POST" id="credentialsForm">
                    <input type="hidden" name="action" value="credentials">

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Work Email Address</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted"><i class="bi bi-envelope"></i></span>
                            <input type="email" 
                                   name="email" 
                                   id="emailInput" 
                                   class="form-control" 
                                   placeholder="e.g. admin@example.com" 
                                   value="" 
                                   required 
                                   autofocus>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Secure Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted"><i class="bi bi-lock"></i></span>
                            <input type="password" 
                                   name="password" 
                                   id="passwordInput" 
                                   class="form-control" 
                                   placeholder="Enter your password" 
                                   value="" 
                                   required>
                        </div>
                    </div>

                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-brand rounded-pill shadow-sm py-2">
                            <span>Proceed to 2FA Verification</span>
                            <i class="bi bi-arrow-right ms-2"></i>
                        </button>
                    </div>
                </form>

                <!-- Helper Card for Local Testing / Demonstration (Manual Click Only) -->
                <div class="border-top pt-3 text-center">
                    <div class="p-2 rounded-3 bg-light border text-start small">
                        <div class="text-muted d-flex align-items-center justify-content-between mb-1">
                            <span class="fw-bold text-dark"><i class="bi bi-key-fill text-warning me-1"></i>Demo Account</span>
                            <button type="button" class="btn btn-link btn-sm p-0 text-decoration-none text-success fw-bold" onclick="fillDemoCredentials()">
                                Auto-Fill Credentials
                            </button>
                        </div>
                        <div class="font-monospace text-secondary" style="font-size: 11px;">
                            Email: <strong>admin@example.com</strong><br>
                            Pass: <strong>Admin@DemoPass2026!</strong>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <div class="card-footer bg-light text-center py-3 border-0">
            <a href="<?= App::url('/') ?>" class="text-decoration-none small text-muted">
                <i class="bi bi-arrow-left me-1"></i> Back to Public Patient Website
            </a>
        </div>
    </div>

    <!-- Scripts for 2FA Copy-Paste and Demo Helper -->
    <script>
        function copyAndPasteOtp(code) {
            const input = document.getElementById('codeInput');
            if (input) {
                input.value = code;
                input.focus();
            }
            if (navigator.clipboard) {
                navigator.clipboard.writeText(code).then(() => {
                    const btn = event?.currentTarget;
                    if (btn) {
                        const original = btn.innerHTML;
                        btn.innerHTML = '<i class="bi bi-check2 me-1"></i> Copied & Pasted!';
                        setTimeout(() => { btn.innerHTML = original; }, 2000);
                    }
                }).catch(() => {});
            }
        }

        function fillDemoCredentials() {
            const email = document.getElementById('emailInput');
            const pass = document.getElementById('passwordInput');
            if (email) email.value = 'admin@example.com';
            if (pass) pass.value = 'Admin@DemoPass2026!';
            if (email) email.focus();
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
