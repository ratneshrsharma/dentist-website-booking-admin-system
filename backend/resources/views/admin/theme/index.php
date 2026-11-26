<?php

declare(strict_types=1);

use App\Core\App;
use App\Core\Auth;

$clinic = $theme['branding'] ?? [];
$colors = $theme['colors'] ?? [];
$typography = $theme['typography'] ?? [];
$headerMenu = $theme['header_menu'] ?? [];
$footerData = $theme['footer_data'] ?? [];
$sys = $theme['system_settings'] ?? [];
$canManageSystem = Auth::can('settings') || Auth::can('users');
?>

<div class="row mb-4 align-items-center">
    <div class="col-md-8">
        <h2 class="fw-bold text-dark mb-1">
            <i class="bi bi-palette text-success me-2"></i> Global Theme & Whitelabeling Studio
        </h2>
        <p class="text-muted mb-0">
            Customize practice logo, brand colors, typography, surgery contact details, and site navigation.
        </p>
    </div>
    <div class="col-md-4 text-md-end mt-3 mt-md-0">
        <a href="<?= App::url('/') ?>" target="_blank" class="btn btn-outline-secondary rounded-pill shadow-sm">
            <i class="bi bi-box-arrow-up-right me-1"></i> Preview Live Site
        </a>
    </div>
</div>

<form action="<?= App::url('/admin/theme') ?>" method="POST" enctype="multipart/form-data">
    <!-- Tabs Navigation -->
    <ul class="nav nav-tabs mb-4 border-bottom-0" id="themeTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active px-4 py-2" id="branding-tab" data-bs-toggle="tab" data-bs-target="#tab-branding" type="button" role="tab">
                <i class="bi bi-image me-1"></i> 1. Clinic Branding & Logo
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link px-4 py-2" id="colors-tab" data-bs-toggle="tab" data-bs-target="#tab-colors" type="button" role="tab">
                <i class="bi bi-droplet-half me-1"></i> 2. Brand Colors & Fonts
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link px-4 py-2" id="navigation-tab" data-bs-toggle="tab" data-bs-target="#tab-navigation" type="button" role="tab">
                <i class="bi bi-menu-button-wide me-1"></i> 3. Header & Footer Menus
            </button>
        </li>
        <?php if ($canManageSystem): ?>
        <li class="nav-item" role="presentation">
            <button class="nav-link px-4 py-2" id="system-tab" data-bs-toggle="tab" data-bs-target="#tab-system" type="button" role="tab">
                <i class="bi bi-sliders me-1"></i> 4. System &amp; Contact Settings
            </button>
        </li>
        <?php endif; ?>
    </ul>

    <!-- Tab Contents -->
    <div class="tab-content">
        <!-- ============================================================== -->
        <!-- TAB 1: CLINIC BRANDING & LOGO -->
        <!-- ============================================================== -->
        <div class="tab-pane fade show active" id="tab-branding" role="tabpanel">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="fw-bold mb-0">Clinic Identity & Logo Asset</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4 align-items-center mb-4 pb-4 border-bottom">
                        <div class="col-md-3 text-center">
                            <label class="form-label fw-bold d-block mb-2">Current Active Logo</label>
                            <img src="<?= htmlspecialchars($clinic['logo_url'] ?? App::url('/images/acocks-green-logo.png')) ?>" 
                                 alt="Active Logo" class="preview-img-box shadow-sm p-2 mb-2" id="logoPreview">
                            <small class="d-block text-muted">Recommended: 200x200 PNG or SVG</small>
                        </div>
                        <div class="col-md-9">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Upload New Logo File</label>
                                <input type="file" name="logo_file" class="form-control" accept="image/*" onchange="previewImage(this, 'logoPreview')">
                                <small class="text-muted">Upload an image file (.png, .jpg, .svg, .webp) to update the practice logo across header, footer & preloader.</small>
                            </div>
                            <div class="mb-0">
                                <label class="form-label fw-semibold">Or Direct Logo URL / Path</label>
                                <input type="text" name="logo_url_manual" class="form-control" value="<?= htmlspecialchars($clinic['logo_url'] ?? '') ?>" placeholder="/images/acocks-green-logo.png">
                            </div>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Clinic / Practice Name</label>
                            <input type="text" name="clinic_name" class="form-control" value="<?= htmlspecialchars($clinic['clinic_name'] ?? 'Acocks Green') ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Practice Tagline</label>
                            <input type="text" name="tagline" class="form-control" value="<?= htmlspecialchars($clinic['tagline'] ?? 'Dental Practice') ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Primary Reception Phone</label>
                            <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($clinic['phone'] ?? '+44 121 765 2870') ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Emergency Triage Hotline</label>
                            <input type="text" name="emergency_phone" class="form-control" value="<?= htmlspecialchars($clinic['emergency_phone'] ?? '+44 121 765 2870') ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">WhatsApp Number (e.g. +441217652870)</label>
                            <input type="text" name="whatsapp" class="form-control" value="<?= htmlspecialchars($clinic['whatsapp'] ?? '+441217652870') ?>">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Surgery Physical Address</label>
                            <input type="text" name="address" class="form-control" value="<?= htmlspecialchars($clinic['address'] ?? '1078 Warwick Road, Acocks Green, Birmingham B27 6BH') ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ============================================================== -->
        <!-- TAB 2: BRAND COLORS & FONTS -->
        <!-- ============================================================== -->
        <div class="tab-pane fade" id="tab-colors" role="tabpanel">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="fw-bold mb-0">Brand Design Tokens & Typography</h5>
                </div>
                <div class="card-body p-4">
                    <h6 class="fw-bold text-secondary mb-3">Color Scheme</h6>
                    <div class="row g-4 mb-4 pb-4 border-bottom">
                        <!-- Primary Color -->
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Primary Color (Buttons & Headers)</label>
                            <div class="d-flex align-items-center gap-2">
                                <input type="color" class="form-control form-control-color" id="primaryColorPicker" value="<?= htmlspecialchars($colors['primary'] ?? '#0d631b') ?>" onchange="document.getElementById('primaryColorInput').value = this.value">
                                <input type="text" name="primary_color" id="primaryColorInput" class="form-control font-monospace" value="<?= htmlspecialchars($colors['primary'] ?? '#0d631b') ?>" oninput="document.getElementById('primaryColorPicker').value = this.value">
                            </div>
                        </div>

                        <!-- Primary Hover Color -->
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Primary Hover Color</label>
                            <div class="d-flex align-items-center gap-2">
                                <input type="color" class="form-control form-control-color" id="hoverColorPicker" value="<?= htmlspecialchars($colors['primary_hover'] ?? '#0a4f15') ?>" onchange="document.getElementById('hoverColorInput').value = this.value">
                                <input type="text" name="primary_hover_color" id="hoverColorInput" class="form-control font-monospace" value="<?= htmlspecialchars($colors['primary_hover'] ?? '#0a4f15') ?>" oninput="document.getElementById('hoverColorPicker').value = this.value">
                            </div>
                        </div>

                        <!-- Secondary Color -->
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Secondary Accent Color</label>
                            <div class="d-flex align-items-center gap-2">
                                <input type="color" class="form-control form-control-color" id="secColorPicker" value="<?= htmlspecialchars($colors['secondary'] ?? '#45664e') ?>" onchange="document.getElementById('secColorInput').value = this.value">
                                <input type="text" name="secondary_color" id="secColorInput" class="form-control font-monospace" value="<?= htmlspecialchars($colors['secondary'] ?? '#45664e') ?>" oninput="document.getElementById('secColorPicker').value = this.value">
                            </div>
                        </div>

                        <!-- Surface Muted Color -->
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Surface Background Color</label>
                            <div class="d-flex align-items-center gap-2">
                                <input type="color" class="form-control form-control-color" id="surfColorPicker" value="<?= htmlspecialchars($colors['surface'] ?? '#f2fcf5') ?>" onchange="document.getElementById('surfColorInput').value = this.value">
                                <input type="text" name="surface_color" id="surfColorInput" class="form-control font-monospace" value="<?= htmlspecialchars($colors['surface'] ?? '#f2fcf5') ?>" oninput="document.getElementById('surfColorPicker').value = this.value">
                            </div>
                        </div>
                    </div>

                    <h6 class="fw-bold text-secondary mb-3">Typography & Fonts</h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Primary Font Family</label>
                            <select name="font_family" class="form-select">
                                <?php
                                $fonts = ['Plus Jakarta Sans', 'Inter', 'Roboto', 'Montserrat', 'Poppins', 'Work Sans'];
                                $selectedFont = $typography['font_family'] ?? 'Plus Jakarta Sans';
                                foreach ($fonts as $f):
                                ?>
                                    <option value="<?= $f ?>" <?= $selectedFont === $f ? 'selected' : '' ?>><?= $f ?></option>
                                <?php endforeach; ?>
                            </select>
                            <small class="text-muted">Font is loaded automatically from Google Fonts on the frontend.</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ============================================================== -->
        <!-- TAB 3: HEADER & FOOTER MENUS -->
        <!-- ============================================================== -->
        <div class="tab-pane fade" id="tab-navigation" role="tabpanel">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="fw-bold mb-0">Header Navigation Menu</h5>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive mb-3">
                        <table class="table table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 45%;">Menu Label / Title</th>
                                    <th style="width: 45%;">Destination Route / URL</th>
                                    <th style="width: 10%; text-align: center;">Order</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($headerMenu as $idx => $item): ?>
                                    <tr>
                                        <td>
                                            <input type="text" name="header_menu_titles[]" class="form-control" value="<?= htmlspecialchars($item['title'] ?? '') ?>" required>
                                        </td>
                                        <td>
                                            <input type="text" name="header_menu_paths[]" class="form-control font-monospace" value="<?= htmlspecialchars($item['path'] ?? '/') ?>" required>
                                        </td>
                                        <td class="text-center text-muted fw-bold"><?= $idx + 1 ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="fw-bold mb-0">Footer Content & Copyright Bar</h5>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Footer Copyright Text</label>
                        <input type="text" name="copyright_text" class="form-control" value="<?= htmlspecialchars($footerData['copyright_text'] ?? '') ?>">
                        <small class="text-muted">Displayed at the bottom-most bar of every patient page.</small>
                    </div>
                </div>
            </div>
        </div>

        <?php if ($canManageSystem): ?>
        <!-- ============================================================== -->
        <!-- TAB 4: SYSTEM & CONTACT SETTINGS (SUPER ADMIN & ADMIN) -->
        <!-- ============================================================== -->
        <div class="tab-pane fade" id="tab-system" role="tabpanel">
            <input type="hidden" name="sys_settings_submitted" value="1">
            <div class="row g-4 mb-4">
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-header bg-white py-3 border-bottom">
                            <h5 class="fw-bold mb-0"><i class="bi bi-shield-lock text-success me-2"></i> Session, Logs &amp; Security</h5>
                        </div>
                        <div class="card-body p-4 d-flex flex-column gap-3">
                            <div>
                                <label class="form-label fw-semibold">Admin Session Timeout (Hours)</label>
                                <input type="number" name="session_timeout_hours" min="1" max="720" class="form-control" value="<?= (int) ($sys['session_timeout_hours'] ?? 10) ?>">
                                <small class="text-muted">Default: 10 hours of inactivity before automatic logout.</small>
                            </div>
                            <div>
                                <label class="form-label fw-semibold">Delete Audit Logs Older Than (Months)</label>
                                <input type="number" name="log_retention_months" min="1" max="60" class="form-control" value="<?= (int) ($sys['log_retention_months'] ?? 2) ?>">
                                <small class="text-muted">Default: 2 months. Used by the Purge Old Logs button in Activity Logs.</small>
                            </div>
                            <div>
                                <label class="form-label fw-semibold">Default Appointment Slot Duration (Minutes)</label>
                                <select name="default_slot_duration" class="form-select">
                                    <?php $dur = (int) ($sys['default_slot_duration'] ?? 30); ?>
                                    <?php foreach ([15, 20, 30, 45, 60] as $m): ?>
                                        <option value="<?= $m ?>" <?= $dur === $m ? 'selected' : '' ?>><?= $m ?> minutes</option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-check form-switch mt-1">
                                <input class="form-check-input" type="checkbox" name="require_2fa" value="1" id="sysRequire2fa" <?= !isset($sys['require_2fa']) || !empty($sys['require_2fa']) ? 'checked' : '' ?>>
                                <label class="form-check-label fw-semibold" for="sysRequire2fa">Require 2FA Code on Staff Login</label>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="maintenance_mode" value="1" id="sysMaintMode" <?= !empty($sys['maintenance_mode']) ? 'checked' : '' ?>>
                                <label class="form-check-label fw-semibold text-danger" for="sysMaintMode">Frontend Maintenance Mode</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-header bg-white py-3 border-bottom">
                            <h5 class="fw-bold mb-0"><i class="bi bi-whatsapp text-success me-2"></i> Global Website WhatsApp &amp; Email</h5>
                        </div>
                        <div class="card-body p-4 d-flex flex-column gap-3">
                            <div>
                                <label class="form-label fw-semibold">Website WhatsApp Number (Global)</label>
                                <input type="text" name="sys_whatsapp" class="form-control" value="<?= htmlspecialchars($clinic['whatsapp'] ?? '+441217652870') ?>" placeholder="+441217652870">
                                <small class="text-muted">Updates WhatsApp links across the Floating Menu, Mobile Nav, Smart Dental Assistant, and Booking Modal.</small>
                            </div>
                            <div>
                                <label class="form-label fw-semibold">Website Public Email (Global)</label>
                                <input type="email" name="sys_email" class="form-control" value="<?= htmlspecialchars($clinic['email'] ?? 'reception@acocksgreendental.co.uk') ?>" placeholder="reception@acocksgreendental.co.uk">
                                <small class="text-muted">Updates public email displayed in Header Top Bar, Footer, and Contact Page.</small>
                            </div>
                            <div>
                                <label class="form-label fw-semibold">Contact Form Forwarding Emails (Comma-Separated)</label>
                                <input type="text" name="sys_contact_forward_emails" class="form-control" value="<?= htmlspecialchars($clinic['contact_forward_emails'] ?? ($clinic['form_email'] ?? '')) ?>" placeholder="bookings@..., reception@...">
                            </div>
                            <div class="row g-2">
                                <div class="col-6">
                                    <label class="form-label fw-semibold">Main Phone Line</label>
                                    <input type="text" name="sys_phone" class="form-control" value="<?= htmlspecialchars($clinic['phone'] ?? '+44 121 765 2870') ?>">
                                </div>
                                <div class="col-6">
                                    <label class="form-label fw-semibold">Emergency Triage Line</label>
                                    <input type="text" name="sys_emergency_phone" class="form-control" value="<?= htmlspecialchars($clinic['emergency_phone'] ?? '+44 121 765 2870') ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Sticky Bottom Save Bar -->
    <div class="card border-0 shadow-sm rounded-4 p-3 bg-white sticky-bottom mb-4">
        <div class="d-flex align-items-center justify-content-between">
            <span class="text-muted small">
                <i class="bi bi-info-circle me-1"></i> Saving will automatically update the live Next.js patient website.
            </span>
            <button type="submit" class="btn btn-brand btn-lg rounded-pill px-5 shadow">
                <i class="bi bi-check-lg me-2"></i> Save Whitelabel & Theme Settings
            </button>
        </div>
    </div>
</form>

<script>
function previewImage(input, previewId) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById(previewId).src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
