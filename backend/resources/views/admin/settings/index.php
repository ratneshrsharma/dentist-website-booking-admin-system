<?php

declare(strict_types=1);

use App\Core\App;

$pageTitle = 'Practice & Communication Settings';
?>

<div class="row align-items-center mb-4">
    <div class="col-md-7">
        <h3 class="fw-bold mb-1 text-dark">
            <i class="bi bi-gear-fill text-success me-2"></i> Practice & Communication Settings
        </h3>
        <p class="text-muted small mb-0">
            Configure clinic contact emails for patient form notifications, WhatsApp business numbers for instant booking passes, telephone triage lines, and surgery address.
        </p>
    </div>
    <div class="col-md-5 text-md-end mt-3 mt-md-0">
        <a href="<?= App::url('/') ?>" target="_blank" class="btn btn-outline-secondary rounded-pill shadow-sm">
            <i class="bi bi-box-arrow-up-right me-1"></i> Preview Live Website
        </a>
    </div>
</div>

<form action="<?= App::url('/admin/settings') ?>" method="POST" enctype="multipart/form-data">
    <div class="row g-4 mb-4">
        <!-- Communication & Messaging Credentials -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-chat-dots-fill text-success me-2"></i> Communication Channels & Forms
                    </h5>
                </div>
                <div class="card-body p-4 d-flex flex-column gap-3">
                    <!-- Form Submission Alerts Email -->
                    <div>
                        <label class="form-label fw-bold small text-secondary">
                            Notification Email Address for Forms & Bookings <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted"><i class="bi bi-envelope-at"></i></span>
                            <input type="email" name="form_email" class="form-control" 
                                   value="<?= htmlspecialchars($branding['form_email'] ?? 'bookings@acocksgreendental.co.uk') ?>" required>
                        </div>
                        <small class="text-muted" style="font-size: 11px;">
                            All new online appointment booking alerts and patient inquiries are routed to this inbox.
                        </small>
                    </div>

                    <!-- Contact Form Forwarding Emails (Comma-Separated) -->
                    <div>
                        <label class="form-label fw-bold small text-secondary">
                            Contact Form Forwarding Emails (Comma-Separated)
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted"><i class="bi bi-envelope-paper"></i></span>
                            <input type="text" name="contact_forward_emails" class="form-control"
                                   placeholder="bookings@acocksgreendental.co.uk, reception@acocksgreendental.co.uk"
                                   value="<?= htmlspecialchars($branding['contact_forward_emails'] ?? ($branding['form_email'] ?? 'bookings@acocksgreendental.co.uk')) ?>">
                        </div>
                        <small class="text-muted" style="font-size: 11px;">
                            Enter one or more email addresses separated by commas. Every Contact Form submission is saved in CMS and forwarded to these addresses.
                        </small>
                    </div>

                    <!-- General Reception Email -->
                    <div>
                        <label class="form-label fw-bold small text-secondary">
                            Public Reception & Patient Support Email
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted"><i class="bi bi-envelope"></i></span>
                            <input type="email" name="email" class="form-control" 
                                   value="<?= htmlspecialchars($branding['email'] ?? 'reception@acocksgreendental.co.uk') ?>">
                        </div>
                        <small class="text-muted" style="font-size: 11px;">
                            Displayed in website top bar, footer, and patient appointment reminders.
                        </small>
                    </div>

                    <!-- WhatsApp Number for Website -->
                    <div>
                        <label class="form-label fw-bold small text-secondary">
                            Clinic WhatsApp Number (International format) <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-success-subtle text-success"><i class="bi bi-whatsapp"></i></span>
                            <input type="text" name="whatsapp" class="form-control" 
                                   placeholder="+441217652870" 
                                   value="<?= htmlspecialchars($branding['whatsapp'] ?? '+441217652870') ?>" required>
                        </div>
                        <small class="text-muted" style="font-size: 11px;">
                            Powers the floating bottom navigation WhatsApp button, Calendly instant confirmation pass, and admin chat triggers.
                        </small>
                    </div>

                    <!-- Clinic Main Phone Line -->
                    <div>
                        <label class="form-label fw-bold small text-secondary">
                            Main Surgery Telephone Line
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted"><i class="bi bi-telephone"></i></span>
                            <input type="text" name="phone" class="form-control" 
                                   value="<?= htmlspecialchars($branding['phone'] ?? '+44 121 765 2870') ?>">
                        </div>
                    </div>

                    <!-- Same-Day Emergency Phone Line -->
                    <div>
                        <label class="form-label fw-bold small text-secondary">
                            Same-Day Emergency Priority Line
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-danger-subtle text-danger"><i class="bi bi-telephone-plus"></i></span>
                            <input type="text" name="emergency_phone" class="form-control" 
                                   value="<?= htmlspecialchars($branding['emergency_phone'] ?? '+44 121 765 2870') ?>">
                        </div>
                        <small class="text-muted" style="font-size: 11px;">
                            Displayed prominently in emergency banner triage boxes and after-hours callouts.
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Practice Identity & Location -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-hospital text-success me-2"></i> Practice Identity & Address
                    </h5>
                </div>
                <div class="card-body p-4 d-flex flex-column gap-3">
                    <!-- Clinic Name -->
                    <div>
                        <label class="form-label fw-bold small text-secondary">
                            Practice / Clinic Name
                        </label>
                        <input type="text" name="clinic_name" class="form-control" 
                               value="<?= htmlspecialchars($branding['clinic_name'] ?? 'Acocks Green') ?>" required>
                    </div>

                    <!-- Tagline -->
                    <div>
                        <label class="form-label fw-bold small text-secondary">
                            Tagline / Practice Subtitle
                        </label>
                        <input type="text" name="tagline" class="form-control" 
                               value="<?= htmlspecialchars($branding['tagline'] ?? 'Dental Practice') ?>">
                    </div>

                    <!-- Physical Surgery Address -->
                    <div>
                        <label class="form-label fw-bold small text-secondary">
                            Full Practice Physical Address & Postcode
                        </label>
                        <textarea name="address" class="form-control" rows="3"><?= htmlspecialchars($branding['address'] ?? '1078 Warwick Road, Acocks Green, Birmingham B27 6BH') ?></textarea>
                        <small class="text-muted" style="font-size: 11px;">
                            Included in Google Maps directions, patient appointment confirmations, and website footer.
                        </small>
                    </div>

                    <!-- CQC Status & NHS Registration -->
                    <div class="row g-3">
                        <div class="col-md-7">
                            <label class="form-label fw-bold small text-secondary">CQC Inspection Status</label>
                            <input type="text" name="cqc_status" class="form-control" 
                                   value="<?= htmlspecialchars($branding['cqc_status'] ?? 'CQC Regulated Standards') ?>">
                        </div>
                        <div class="col-md-5 d-flex align-items-center mt-4">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="nhs_registered" value="1" 
                                       <?= !empty($branding['nhs_registered']) ? 'checked' : '' ?> id="nhsCheck">
                                <label class="form-check-label fw-semibold small text-dark" for="nhsCheck">
                                    NHS Registered Clinic
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Logo Upload -->
                    <div>
                        <label class="form-label fw-bold small text-secondary">Clinic Logo</label>
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-3 border p-1 bg-light" style="width: 50px; height: 50px; overflow: hidden;">
                                <img src="<?= htmlspecialchars($branding['logo_url'] ?? App::url('/images/acocks-green-logo.png')) ?>" 
                                     alt="Logo" style="width: 100%; height: 100%; object-fit: contain;">
                            </div>
                            <div class="flex-grow-1">
                                <input type="file" name="logo_file" class="form-control form-control-sm" accept="image/*">
                                <input type="hidden" name="logo_url" value="<?= htmlspecialchars($branding['logo_url'] ?? '') ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sticky Bottom Bar -->
    <div class="card border-0 shadow-sm rounded-4 bg-white p-3 text-end">
        <button type="submit" class="btn btn-success rounded-pill px-5 shadow-sm">
            <i class="bi bi-check2-circle me-1"></i> Save Practice & Communication Settings
        </button>
    </div>
</form>
