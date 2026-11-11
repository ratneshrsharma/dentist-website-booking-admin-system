<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Login - Advanced Dental PRO Clinical Management</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Google Font: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- AdminLTE 4 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-beta2/dist/css/adminlte.min.css">
    <style>
        :root {
            --app-primary: #0D9488;
            --app-primary-dark: #0F766E;
            --app-surface: #0F172A;
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
            max-width: 480px;
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
            transition: all 0.2s ease;
        }
        .btn-teal-primary:hover {
            background-color: var(--app-primary-dark);
            border-color: var(--app-primary-dark);
            color: #ffffff;
            transform: translateY(-1px);
        }
        .role-chip {
            cursor: pointer;
            border: 1px solid #E2E8F0;
            border-radius: 0.5rem;
            padding: 0.5rem 0.65rem;
            background: #F8FAFC;
            transition: all 0.15s ease;
            font-size: 0.75rem;
            text-align: left;
        }
        .role-chip:hover {
            background: #F0FDFA;
            border-color: #0D9488;
            transform: translateY(-1px);
        }
    </style>
</head>
<body>

<div class="login-card-box">
    <!-- Header -->
    <div class="login-header-banner">
        <div class="brand-logo-icon">
            <i class="bi bi-hospital"></i>
        </div>
        <h4 class="fw-bold mb-1 tracking-tight">Advanced Dental <span class="badge bg-warning text-dark fs-6 ms-1">PRO</span></h4>
        <p class="text-white-50 small mb-0">Clinical EMR, Logistics & Multi-Branch Portal</p>
    </div>

    <!-- Form Body -->
    <div class="p-4 p-md-4">
        <!-- Error / Status Alerts -->
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger d-flex align-items-center small py-2 px-3 mb-3 rounded-3" role="alert">
                <i class="bi bi-exclamation-octagon-fill me-2 fs-5"></i>
                <div><?= htmlspecialchars($error) ?></div>
            </div>
        <?php endif; ?>

        <?php if (!empty($message)): ?>
            <div class="alert alert-success d-flex align-items-center small py-2 px-3 mb-3 rounded-3" role="alert">
                <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                <div><?= htmlspecialchars($message) ?></div>
            </div>
        <?php endif; ?>

        <form action="{{ url('/admin/login') }}" method="POST" id="loginForm">
            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label small fw-semibold text-secondary">Work Email Address</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-envelope"></i></span>
                    <input type="email" class="form-control border-start-0 ps-0" id="email" name="email" value="<?= htmlspecialchars($email ?? 'admin@example.com') ?>" placeholder="doctor@advanceddental.com" required autofocus>
                </div>
            </div>

            <!-- Password -->
            <div class="mb-3">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <label for="password" class="form-label small fw-semibold text-secondary mb-0">Password</label>
                    <a href="{{ url('/admin/forgot-password') }}" class="small text-decoration-none text-muted">Forgot password?</a>
                </div>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-shield-lock"></i></span>
                    <input type="password" class="form-control border-start-0 border-end-0 ps-0" id="password" name="password" value="Admin@DemoPass2026!" placeholder="••••••••••••" required>
                    <button class="btn btn-outline-secondary border-start-0" type="button" id="togglePassword">
                        <i class="bi bi-eye text-muted" id="eyeIcon"></i>
                    </button>
                </div>
            </div>

            <!-- Remember Me & Branch -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="rememberMe" name="remember" checked>
                    <label class="form-check-label small text-muted" for="rememberMe">Remember me</label>
                </div>
                <span class="badge bg-light text-muted border small"><i class="bi bi-shield-check text-success me-1"></i>256-bit Encrypted</span>
            </div>

            <!-- Submit -->
            <button type="submit" class="btn btn-teal-primary w-100 mb-3 shadow-sm">
                <i class="bi bi-box-arrow-in-right me-2"></i>Sign In to Clinical Workspace
            </button>
        </form>

        <!-- Quick Role Switcher for Testing (User-Friendly Demo) -->
        <div class="mt-4 pt-3 border-top">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="text-uppercase fw-bold text-muted small" style="font-size: 0.7rem; letter-spacing: 0.05em;">
                    <i class="bi bi-key-fill text-warning me-1"></i>Quick Role Switcher (Demo / Testing)
                </span>
                <span class="badge bg-secondary-subtle text-secondary small">Click to Auto-Fill</span>
            </div>

            <div class="row g-2">
                <!-- 1. Super Admin -->
                <div class="col-6">
                    <div class="role-chip" onclick="fillCreds('admin@example.com', 'Admin@DemoPass2026!', 'super_admin')">
                        <div class="fw-bold text-dark"><i class="bi bi-crown-fill text-warning me-1"></i>Super Admin</div>
                        <div class="text-muted text-truncate">Full System & RBAC</div>
                    </div>
                </div>

                <!-- 2. Clinic Admin -->
                <div class="col-6">
                    <div class="role-chip" onclick="fillCreds('clinic.admin@example.com', 'Admin@DemoPass2026!', 'admin')">
                        <div class="fw-bold text-dark"><i class="bi bi-hospital-fill text-primary me-1"></i>Clinic Admin</div>
                        <div class="text-muted text-truncate">Branch & Operations</div>
                    </div>
                </div>

                <!-- 3. Doctor -->
                <div class="col-6">
                    <div class="role-chip" onclick="fillCreds('dr.caldwell@example.com', 'Doctor@DemoPass2026!', 'doctor')">
                        <div class="fw-bold text-dark"><i class="bi bi-heart-pulse-fill text-danger me-1"></i>Doctor (EMR)</div>
                        <div class="text-muted text-truncate">Patients & Odontogram</div>
                    </div>
                </div>

                <!-- 4. Appointment Manager -->
                <div class="col-6">
                    <div class="role-chip" onclick="fillCreds('reception@example.com', 'Staff@DemoPass2026!', 'receptionist')">
                        <div class="fw-bold text-dark"><i class="bi bi-calendar-check-fill text-info me-1"></i>Appt. Manager</div>
                        <div class="text-muted text-truncate">Scheduler & Intake</div>
                    </div>
                </div>

                <!-- 5. Website Manager -->
                <div class="col-6">
                    <div class="role-chip" onclick="fillCreds('webmaster@example.com', 'Webmaster@DemoPass2026!', 'website_manager')">
                        <div class="fw-bold text-dark"><i class="bi bi-globe2 text-success me-1"></i>Website Mgr</div>
                        <div class="text-muted text-truncate">CMS, SEO & Theme</div>
                    </div>
                </div>

                <!-- 6. Billing Officer -->
                <div class="col-6">
                    <div class="role-chip" onclick="fillCreds('billing@example.com', 'Billing@DemoPass2026!', 'billing')">
                        <div class="fw-bold text-dark"><i class="bi bi-receipt-cutoff text-dark me-1"></i>Billing Officer</div>
                        <div class="text-muted text-truncate">POS, Invoices & Claims</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-3">
            <a href="{{ url('/') }}" class="text-muted small text-decoration-none">
                <i class="bi bi-arrow-left me-1"></i>Back to Patient Website
            </a>
        </div>
    </div>
</div>

<script>
    // Toggle password visibility
    const toggleBtn = document.getElementById('togglePassword');
    const pwdInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');
    if (toggleBtn && pwdInput) {
        toggleBtn.addEventListener('click', function() {
            const isPassword = pwdInput.type === 'password';
            pwdInput.type = isPassword ? 'text' : 'password';
            eyeIcon.className = isPassword ? 'bi bi-eye-slash text-teal' : 'bi bi-eye text-muted';
        });
    }

    // Role Auto-Filler
    function fillCreds(email, password, role) {
        document.getElementById('email').value = email;
        document.getElementById('password').value = password;

        // Highlight effect
        document.getElementById('email').classList.add('border-primary');
        document.getElementById('password').classList.add('border-primary');
        setTimeout(() => {
            document.getElementById('email').classList.remove('border-primary');
            document.getElementById('password').classList.remove('border-primary');
        }, 600);
    }
</script>
</body>
</html>
