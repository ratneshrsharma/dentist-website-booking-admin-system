<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>403 Access Forbidden - Advanced Dental PRO</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-beta2/dist/css/adminlte.min.css">
    <style>
        :root {
            --app-primary: #0D9488;
        }
        body {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            background: #F8FAFC;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }
        .error-card {
            max-width: 540px;
            background: #ffffff;
            border-radius: 1rem;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            border: 1px solid #E2E8F0;
            overflow: hidden;
            text-align: center;
        }
        .error-icon-box {
            width: 80px;
            height: 80px;
            background: #FEE2E2;
            color: #DC2626;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            margin-bottom: 1.25rem;
        }
    </style>
</head>
<body>

<div class="error-card p-5">
    <div class="error-icon-box">
        <i class="bi bi-shield-x"></i>
    </div>
    <span class="badge bg-danger-subtle text-danger px-3 py-1 rounded-pill mb-2 fw-semibold">
        HTTP 403 Forbidden Access
    </span>
    <h3 class="fw-bold text-dark mb-2">Insufficient Role Privileges</h3>
    <p class="text-secondary small mb-4">
        Your current session role (<strong class="text-dark"><?= htmlspecialchars($user_role_label ?? 'Restricted Staff') ?></strong>) does not possess authorization to inspect or modify this clinical/financial module (<strong><?= htmlspecialchars($module_name ?? 'Protected Resource') ?></strong>).
    </p>

    <div class="alert alert-warning text-start small mb-4 py-2 px-3 border-start border-4 border-warning">
        <i class="bi bi-lock-fill me-1 text-warning"></i>
        <strong>Clinical Data Protection Policy:</strong> Patient health records (EHR), surgical odontograms, and financial transaction ledgers are shielded in strict compliance with HIPAA / GDPR healthcare privacy protocols. No confidential data was disclosed.
    </div>

    <div class="d-flex justify-content-center gap-2">
        <a href="{{ url('/admin/dashboard') }}" class="btn btn-primary px-4" style="background-color: var(--app-primary); border-color: var(--app-primary);">
            <i class="bi bi-speedometer2 me-1"></i>Return to My Dashboard
        </a>
        <a href="{{ url('/admin/logout') }}" class="btn btn-outline-secondary px-3">
            <i class="bi bi-box-arrow-right me-1"></i>Switch User
        </a>
    </div>
</div>

</body>
</html>
