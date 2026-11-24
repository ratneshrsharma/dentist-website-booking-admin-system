<?php

declare(strict_types=1);

use App\Core\App;

$clinic = $theme['branding'] ?? [];
$colors = $theme['colors'] ?? [];
?>

<div class="row mb-4 align-items-center">
    <div class="col-md-8">
        <h2 class="fw-bold text-dark mb-1">
            <i class="bi bi-speedometer2 text-success me-2"></i> Clinical Practice Dashboard
        </h2>
        <p class="text-muted mb-0">
            Manage your clinic's brand identity, live homepage content, and white-label theme settings.
        </p>
    </div>
    <div class="col-md-4 text-md-end mt-3 mt-md-0">
        <a href="<?= App::url('/admin/pages/home/edit') ?>" class="btn btn-brand rounded-pill shadow-sm me-2">
            <i class="bi bi-pencil-square me-1"></i> Edit Homepage
        </a>
        <a href="<?= App::url('/') ?>" target="_blank" class="btn btn-outline-secondary rounded-pill shadow-sm">
            <i class="bi bi-box-arrow-up-right me-1"></i> Live Site
        </a>
    </div>
</div>

<!-- Key Metric & Overview Cards -->
<div class="row g-3 mb-4">
    <!-- Card 1: Whitelabel Identity -->
    <div class="col-md-4">
        <div class="card h-100 border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill fw-semibold">
                        <i class="bi bi-shield-check me-1"></i> Active Whitelabel
                    </span>
                    <span class="p-2 rounded-circle bg-light">
                        <i class="bi bi-palette fs-4 text-success"></i>
                    </span>
                </div>
                <h5 class="fw-bold mb-1"><?= htmlspecialchars($clinic['clinic_name'] ?? 'Acocks Green') ?></h5>
                <p class="text-muted small mb-3"><?= htmlspecialchars($clinic['tagline'] ?? 'Dental Practice') ?></p>
                <div class="d-flex align-items-center gap-2 pt-2 border-top">
                    <span class="small text-secondary">Primary Color:</span>
                    <span class="badge" style="background-color: <?= htmlspecialchars($colors['primary'] ?? '#0d631b') ?>; color: #fff;">
                        <?= htmlspecialchars($colors['primary'] ?? '#0d631b') ?>
                    </span>
                    <a href="<?= App::url('/admin/theme') ?>" class="ms-auto small text-decoration-none fw-semibold">
                        Change <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 2: Homepage CMS Status -->
    <div class="col-md-4">
        <div class="card h-100 border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill fw-semibold">
                        <i class="bi bi-file-earmark-check me-1"></i> Published
                    </span>
                    <span class="p-2 rounded-circle bg-light">
                        <i class="bi bi-layout-text-window-reverse fs-4 text-primary"></i>
                    </span>
                </div>
                <h5 class="fw-bold mb-1">Dynamic Homepage</h5>
                <p class="text-muted small mb-3">7 Reusable atomic UI sections bound to CMS API</p>
                <div class="d-flex align-items-center gap-2 pt-2 border-top">
                    <span class="small text-secondary">Updated: <?= htmlspecialchars($homeData['_updated_at'] ?? 'Today') ?></span>
                    <a href="<?= App::url('/admin/pages/home/edit') ?>" class="ms-auto small text-decoration-none fw-semibold">
                        Edit Sections <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 3: Total Managed Pages -->
    <div class="col-md-4">
        <div class="card h-100 border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span class="badge bg-info-subtle text-info px-3 py-2 rounded-pill fw-semibold">
                        <i class="bi bi-collection me-1"></i> Multi-Page Architecture
                    </span>
                    <span class="p-2 rounded-circle bg-light">
                        <i class="bi bi-layers fs-4 text-info"></i>
                    </span>
                </div>
                <h5 class="fw-bold mb-1"><?= count($pages) ?> Managed Pages</h5>
                <p class="text-muted small mb-3">Home, Treatments, About Us, Contact & Location</p>
                <div class="d-flex align-items-center gap-2 pt-2 border-top">
                    <span class="small text-secondary">Headless API v1 Active</span>
                    <a href="<?= App::url('/admin/pages') ?>" class="ms-auto small text-decoration-none fw-semibold">
                        View List <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Management Section -->
<div class="row g-4">
    <!-- Homepage Sections Status Summary -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                <h5 class="fw-bold mb-0">
                    <i class="bi bi-columns-gap text-primary me-2"></i> Homepage Managed Sections
                </h5>
                <a href="<?= App::url('/admin/pages/home/edit') ?>" class="btn btn-sm btn-outline-primary rounded-pill">
                    <i class="bi bi-pencil-square me-1"></i> Open Visual Editor
                </a>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush rounded-bottom-4">
                    <div class="list-group-item d-flex align-items-center justify-content-between py-3 px-4">
                        <div class="d-flex align-items-center gap-3">
                            <span class="badge bg-light text-dark p-2 rounded-3 border"><i class="bi bi-card-heading fs-6"></i></span>
                            <div>
                                <h6 class="mb-0 fw-bold">Hero Banner & Appointment Quick Bar</h6>
                                <small class="text-muted"><?= htmlspecialchars($homeData['hero']['title'] ?? '') ?></small>
                            </div>
                        </div>
                        <span class="badge bg-success-subtle text-success px-3 py-1 rounded-pill">Live</span>
                    </div>

                    <div class="list-group-item d-flex align-items-center justify-content-between py-3 px-4">
                        <div class="d-flex align-items-center gap-3">
                            <span class="badge bg-light text-dark p-2 rounded-3 border"><i class="bi bi-grid-3x3-gap fs-6"></i></span>
                            <div>
                                <h6 class="mb-0 fw-bold">Categorized Practice Services Grid</h6>
                                <small class="text-muted"><?= count($homeData['featured_services'] ?? []) ?> treatment items with icons & badges</small>
                            </div>
                        </div>
                        <span class="badge bg-success-subtle text-success px-3 py-1 rounded-pill">Live</span>
                    </div>

                    <div class="list-group-item d-flex align-items-center justify-content-between py-3 px-4">
                        <div class="d-flex align-items-center gap-3">
                            <span class="badge bg-light text-dark p-2 rounded-3 border"><i class="bi bi-people fs-6"></i></span>
                            <div>
                                <h6 class="mb-0 fw-bold">About Our Surgery & Clinicians Grid</h6>
                                <small class="text-muted"><?= count($homeData['clinicians'] ?? []) ?> Dental Surgeons & Specialists</small>
                            </div>
                        </div>
                        <span class="badge bg-success-subtle text-success px-3 py-1 rounded-pill">Live</span>
                    </div>

                    <div class="list-group-item d-flex align-items-center justify-content-between py-3 px-4">
                        <div class="d-flex align-items-center gap-3">
                            <span class="badge bg-light text-dark p-2 rounded-3 border"><i class="bi bi-geo-alt fs-6"></i></span>
                            <div>
                                <h6 class="mb-0 fw-bold">Clinic Hours, Location & NHS Sexual Safety Charter</h6>
                                <small class="text-muted"><?= htmlspecialchars($clinic['address'] ?? '') ?></small>
                            </div>
                        </div>
                        <span class="badge bg-success-subtle text-success px-3 py-1 rounded-pill">Live</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Whitelabel Preview Card -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-white py-3 border-bottom">
                <h5 class="fw-bold mb-0">
                    <i class="bi bi-brush text-success me-2"></i> Whitelabeling Snapshot
                </h5>
            </div>
            <div class="card-body p-4 text-center">
                <div class="mb-3">
                    <img src="<?= htmlspecialchars($clinic['logo_url'] ?? App::url('/images/acocks-green-logo.png')) ?>" 
                         alt="Logo" class="rounded-circle shadow-sm p-2 border bg-white" style="width: 80px; height: 80px; object-fit: contain;">
                </div>
                <h5 class="fw-bold mb-1"><?= htmlspecialchars($clinic['clinic_name'] ?? 'Acocks Green') ?></h5>
                <p class="text-muted small mb-3"><?= htmlspecialchars($clinic['tagline'] ?? 'Dental Practice') ?></p>

                <div class="text-start bg-light p-3 rounded-3 mb-3 small">
                    <div class="mb-1"><strong>Phone:</strong> <?= htmlspecialchars($clinic['phone'] ?? '') ?></div>
                    <div class="mb-1"><strong>Emergency:</strong> <?= htmlspecialchars($clinic['emergency_phone'] ?? '') ?></div>
                    <div><strong>Font:</strong> <?= htmlspecialchars($theme['typography']['font_family'] ?? 'Plus Jakarta Sans') ?></div>
                </div>

                <a href="<?= App::url('/admin/theme') ?>" class="btn btn-outline-success w-100 rounded-pill fw-semibold">
                    <i class="bi bi-sliders me-1"></i> Open Theme Studio
                </a>
            </div>
        </div>
    </div>
</div>
