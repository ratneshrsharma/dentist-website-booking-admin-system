<?php

declare(strict_types=1);

use App\Core\App;

$hero = $home['hero'] ?? [];
$servicesIntro = $home['services_intro'] ?? [];
$services = $home['featured_services'] ?? [];
$about = $home['about_summary'] ?? [];
$clinicians = $home['clinicians'] ?? [];
$testimonials = $home['testimonials'] ?? [];
$charter = $home['safety_charter'] ?? [];
$contact = $home['contact_section'] ?? [];
?>

<div class="row mb-4 align-items-center">
    <div class="col-md-8">
        <div class="d-flex align-items-center gap-2 mb-1">
            <a href="<?= App::url('/admin/pages') ?>" class="text-decoration-none text-muted small">
                <i class="bi bi-arrow-left"></i> Back to Page List
            </a>
            <span class="text-muted small">/</span>
            <span class="text-success small fw-semibold">Homepage Editor</span>
        </div>
        <h2 class="fw-bold text-dark mb-0">
            <i class="bi bi-pencil-square text-success me-2"></i> Homepage Content & Visual Assets Editor
        </h2>
    </div>
    <div class="col-md-4 text-md-end mt-3 mt-md-0">
        <a href="<?= App::url('/') ?>" target="_blank" class="btn btn-outline-secondary rounded-pill shadow-sm">
            <i class="bi bi-box-arrow-up-right me-1"></i> Preview Live Website
        </a>
    </div>
</div>

<form action="<?= App::url('/admin/pages/home/edit') ?>" method="POST" enctype="multipart/form-data">
    <!-- Section Tabs -->
    <ul class="nav nav-tabs mb-4 border-bottom-0" id="homeEditorTabs" role="tablist">
        <li class="nav-item">
            <button class="nav-link active px-3 py-2" data-bs-toggle="tab" data-bs-target="#sec-hero" type="button">
                <i class="bi bi-image me-1"></i> 1. Hero Banner
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link px-3 py-2" data-bs-toggle="tab" data-bs-target="#sec-services" type="button">
                <i class="bi bi-grid-3x3-gap me-1"></i> 2. Services Grid
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link px-3 py-2" data-bs-toggle="tab" data-bs-target="#sec-about" type="button">
                <i class="bi bi-info-circle me-1"></i> 3. About & Clinic Photos
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link px-3 py-2" data-bs-toggle="tab" data-bs-target="#sec-doctors" type="button">
                <i class="bi bi-people me-1"></i> 4. Doctors & Avatars
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link px-3 py-2" data-bs-toggle="tab" data-bs-target="#sec-testimonials" type="button">
                <i class="bi bi-star me-1"></i> 5. Testimonials
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link px-3 py-2" data-bs-toggle="tab" data-bs-target="#sec-charter" type="button">
                <i class="bi bi-shield-check me-1"></i> 6. Safety Charter
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link px-3 py-2" data-bs-toggle="tab" data-bs-target="#sec-contact" type="button">
                <i class="bi bi-geo-alt me-1"></i> 7. Hours & Map
            </button>
        </li>
    </ul>

    <div class="tab-content">
        <!-- ============================================================== -->
        <!-- 1. HERO BANNER -->
        <!-- ============================================================== -->
        <div class="tab-pane fade show active" id="sec-hero">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="fw-bold mb-0">Hero Banner Headlines, Image & Stats</h5>
                </div>
                <div class="card-body p-4">
                    <!-- Hero Image Upload with Live Preview -->
                    <div class="row g-4 align-items-center mb-4 pb-4 border-bottom">
                        <div class="col-md-3 text-center">
                            <label class="form-label fw-bold d-block mb-2">Current Hero Image</label>
                            <img src="<?= htmlspecialchars($hero['hero_image'] ?? App::url('/images/hero-patient.jpg')) ?>" 
                                 alt="Hero Image" class="preview-img-box shadow-sm mb-2" id="heroImagePreview" style="width: 140px; height: 110px;">
                            <small class="d-block text-muted">Patient Consultation Photo</small>
                        </div>
                        <div class="col-md-9">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Upload New Hero Image File</label>
                                <input type="file" name="hero_image_file" class="form-control" accept="image/*" onchange="previewImage(this, 'heroImagePreview')">
                                <small class="text-muted">Upload high-resolution dental photography (.jpg, .png, .webp). Max size: 10MB.</small>
                            </div>
                            <div class="mb-0">
                                <label class="form-label fw-semibold">Or Direct Image URL / Path</label>
                                <input type="text" name="hero_image_manual" class="form-control" value="<?= htmlspecialchars($hero['hero_image'] ?? '') ?>" placeholder="/images/hero-patient.jpg">
                            </div>
                        </div>
                    </div>

                    <!-- Headlines & Copy -->
                    <div class="row g-3 mb-4 pb-4 border-bottom">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Eyebrow Tagline</label>
                            <input type="text" name="hero_eyebrow" class="form-control" value="<?= htmlspecialchars($hero['eyebrow'] ?? 'NHS & Private Patients Welcomed') ?>" placeholder="NHS & Private Patients Welcomed">
                        </div>
                        <div class="col-md-5">
                            <label class="form-label fw-semibold">Main Headline Title</label>
                            <input type="text" name="hero_title" class="form-control" value="<?= htmlspecialchars($hero['title'] ?? $hero['headline'] ?? 'Make your Dental Experience a') ?>" placeholder="Make your Dental Experience a">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Highlighted Brand Word</label>
                            <input type="text" name="hero_highlight_word" class="form-control" value="<?= htmlspecialchars($hero['highlight_word'] ?? $hero['headline_highlight'] ?? 'Lot Brighter') ?>" placeholder="Lot Brighter">
                            <small class="text-muted">Underlined with brand primary color.</small>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Hero Subtitle Paragraph</label>
                            <textarea name="hero_subtitle" class="form-control" rows="2"><?= htmlspecialchars($hero['subtitle'] ?? 'Welcome to Acocks Green Dental Practice. Delivering gentle, high-standard dental care for patients of all ages across Birmingham B27. From preventive family appointments to transformative aesthetics, our clinical team puts your comfort first.') ?></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Primary CTA Button Text</label>
                            <input type="text" name="hero_cta_primary" class="form-control" value="<?= htmlspecialchars($hero['cta_primary'] ?? 'Book An Appointment') ?>" placeholder="Book An Appointment">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Primary CTA Link / Action Target</label>
                            <input type="text" name="hero_cta_primary_link" class="form-control" value="<?= htmlspecialchars($hero['cta_primary_link'] ?? '#quick-book') ?>" placeholder="#quick-book">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Secondary CTA Button Text</label>
                            <input type="text" name="hero_cta_secondary" class="form-control" value="<?= htmlspecialchars($hero['cta_secondary'] ?? 'Emergency Consultation') ?>" placeholder="Emergency Consultation">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Secondary CTA Link</label>
                            <input type="text" name="hero_cta_secondary_link" class="form-control" value="<?= htmlspecialchars($hero['cta_secondary_link'] ?? '/contact/#emergency') ?>" placeholder="/contact/#emergency">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Hero Emergency Contact Phone</label>
                            <input type="text" name="hero_phone" class="form-control" value="<?= htmlspecialchars($hero['phone'] ?? '+44 121 765 2870') ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Hero Emergency Label</label>
                            <input type="text" name="hero_emergency_label" class="form-control" value="<?= htmlspecialchars($hero['emergency_label'] ?? 'Emergency Triage Line') ?>">
                        </div>
                    </div>

                    <!-- Hero 3 Key Statistics -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-bold text-secondary mb-0">Hero Practice Statistics (Toggle Active / Inactive)</h6>
                    </div>
                    <div class="row g-3">
                        <?php foreach ($hero['stats'] as $idx => $st): ?>
                            <div class="col-md-4">
                                <div class="p-3 bg-light rounded-3 border">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="small fw-bold text-dark">Statistic #<?= $idx + 1 ?></span>
                                        <div class="form-check form-switch m-0">
                                            <input class="form-check-input" type="checkbox" name="stat_active[]" value="<?= $idx ?>" id="statActive<?= $idx ?>" <?= ($st['is_active'] ?? true) ? 'checked' : '' ?>>
                                            <label class="form-check-label small fw-semibold" for="statActive<?= $idx ?>">Active</label>
                                        </div>
                                    </div>
                                    <label class="form-label small fw-bold">Value</label>
                                    <input type="text" name="stat_values[]" class="form-control mb-2 fw-bold" value="<?= htmlspecialchars($st['value'] ?? '') ?>" placeholder="5,000+">
                                    <label class="form-label small fw-bold">Label</label>
                                    <input type="text" name="stat_labels[]" class="form-control" value="<?= htmlspecialchars($st['label'] ?? '') ?>" placeholder="Happy Patients">
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- ============================================================== -->
        <!-- 2. SERVICES GRID -->
        <!-- ============================================================== -->
        <div class="tab-pane fade" id="sec-services">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="fw-bold mb-0">Services Section Intro & Treatment Cards</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3 mb-4 pb-4 border-bottom">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Section Eyebrow</label>
                            <input type="text" name="services_eyebrow" class="form-control" value="<?= htmlspecialchars($servicesIntro['eyebrow'] ?? 'Our Practice Services') ?>">
                        </div>
                        <div class="col-md-8">
                            <label class="form-label fw-semibold">Section Headline Title</label>
                            <input type="text" name="services_title" class="form-control" value="<?= htmlspecialchars($servicesIntro['title'] ?? 'Discover Quality Dental Care in Acocks Green') ?>">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Section Subtitle</label>
                            <textarea name="services_subtitle" class="form-control" rows="2"><?= htmlspecialchars($servicesIntro['subtitle'] ?? '') ?></textarea>
                        </div>
                    </div>

                    <h6 class="fw-bold text-secondary mb-3">8 Featured Treatment Cards</h6>
                    <div class="row g-3">
                        <?php foreach ($services as $idx => $s): ?>
                            <div class="col-md-6">
                                <div class="card border h-100 p-3 rounded-3 shadow-none bg-light">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="badge bg-primary-subtle text-primary fw-bold">Card #<?= $idx + 1 ?></span>
                                        <span class="badge bg-secondary-subtle text-secondary"><?= htmlspecialchars($s['category'] ?? 'General') ?></span>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label small fw-semibold">Treatment Title</label>
                                        <input type="text" name="service_titles[]" class="form-control form-control-sm fw-bold" value="<?= htmlspecialchars($s['title'] ?? '') ?>" required>
                                    </div>
                                    <div class="row g-2 mb-2">
                                        <div class="col-6">
                                            <label class="form-label small fw-semibold">Badge Tag</label>
                                            <input type="text" name="service_badges[]" class="form-control form-control-sm" value="<?= htmlspecialchars($s['badge'] ?? '') ?>" placeholder="Preventive">
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label small fw-semibold">Icon Symbol</label>
                                            <input type="text" name="service_icons[]" class="form-control form-control-sm font-monospace" value="<?= htmlspecialchars($s['icon'] ?? 'dentistry') ?>">
                                        </div>
                                    </div>
                                    <div class="mb-0">
                                        <label class="form-label small fw-semibold">Short Description</label>
                                        <textarea name="service_descriptions[]" class="form-control form-control-sm" rows="2"><?= htmlspecialchars($s['description'] ?? '') ?></textarea>
                                    </div>
                                    <input type="hidden" name="service_slugs[]" value="<?= htmlspecialchars($s['slug'] ?? ('service-' . ($idx + 1))) ?>">
                                    <input type="hidden" name="service_categories[]" value="<?= htmlspecialchars($s['category'] ?? 'Dental Care') ?>">
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- ============================================================== -->
        <!-- 3. ABOUT OUR TEAM & CLINIC PHOTOS -->
        <!-- ============================================================== -->
        <div class="tab-pane fade" id="sec-about">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="fw-bold mb-0">About Practice Story & Surgery Photography</h5>
                </div>
                <div class="card-body p-4">
                    <!-- Photo 1 & Photo 2 Uploaders -->
                    <div class="row g-4 mb-4 pb-4 border-bottom">
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded-3 border h-100">
                                <h6 class="fw-bold mb-3"><i class="bi bi-camera me-1"></i> Clinic Photo 1 (Treatment Room)</h6>
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <img src="<?= htmlspecialchars($about['image_1'] ?? App::url('/images/treatment-room.jpg')) ?>" 
                                         alt="Surgery Photo 1" class="preview-img-box shadow-sm" id="aboutImg1Preview" style="width: 120px; height: 90px;">
                                    <div class="flex-grow-1">
                                        <label class="form-label small fw-semibold">Upload New Image File</label>
                                        <input type="file" name="about_image_1_file" class="form-control form-control-sm" accept="image/*" onchange="previewImage(this, 'aboutImg1Preview')">
                                    </div>
                                </div>
                                <input type="text" name="about_image_1_manual" class="form-control form-control-sm" value="<?= htmlspecialchars($about['image_1'] ?? '') ?>" placeholder="/images/treatment-room.jpg">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded-3 border h-100">
                                <h6 class="fw-bold mb-3"><i class="bi bi-camera me-1"></i> Clinic Photo 2 (Surgery Reception)</h6>
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <img src="<?= htmlspecialchars($about['image_2'] ?? App::url('/images/surgery-clinic.jpg')) ?>" 
                                         alt="Surgery Photo 2" class="preview-img-box shadow-sm" id="aboutImg2Preview" style="width: 120px; height: 90px;">
                                    <div class="flex-grow-1">
                                        <label class="form-label small fw-semibold">Upload New Image File</label>
                                        <input type="file" name="about_image_2_file" class="form-control form-control-sm" accept="image/*" onchange="previewImage(this, 'aboutImg2Preview')">
                                    </div>
                                </div>
                                <input type="text" name="about_image_2_manual" class="form-control form-control-sm" value="<?= htmlspecialchars($about['image_2'] ?? '') ?>" placeholder="/images/surgery-clinic.jpg">
                            </div>
                        </div>
                    </div>

                    <!-- Story Text -->
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Eyebrow</label>
                            <input type="text" name="about_eyebrow" class="form-control" value="<?= htmlspecialchars($about['eyebrow'] ?? 'About Acocks Green Practice') ?>">
                        </div>
                        <div class="col-md-5">
                            <label class="form-label fw-semibold">Headline Title</label>
                            <input type="text" name="about_title" class="form-control" value="<?= htmlspecialchars($about['title'] ?? 'Dedicated Dental Professionals Serving Birmingham B27') ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Experience Years Badge</label>
                            <input type="text" name="about_experience_years" class="form-control" value="<?= htmlspecialchars($about['experience_years'] ?? '20+') ?>">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Section Subtitle</label>
                            <input type="text" name="about_subtitle" class="form-control" value="<?= htmlspecialchars($about['subtitle'] ?? '') ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Story Paragraph 1</label>
                            <textarea name="about_story_p1" class="form-control" rows="3"><?= htmlspecialchars($about['story_paragraphs'][0] ?? '') ?></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Story Paragraph 2</label>
                            <textarea name="about_story_p2" class="form-control" rows="3"><?= htmlspecialchars($about['story_paragraphs'][1] ?? '') ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ============================================================== -->
        <!-- 4. DOCTORS & CLINICIANS -->
        <!-- ============================================================== -->
        <div class="tab-pane fade" id="sec-doctors">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="fw-bold mb-0">Clinicians, Dental Surgeons & Avatar Photos</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">
                        <?php foreach ($clinicians as $idx => $doc): ?>
                            <div class="col-md-6">
                                <div class="card border h-100 p-4 rounded-3 shadow-none bg-light">
                                    <div class="d-flex align-items-center gap-3 mb-3">
                                        <img src="<?= htmlspecialchars($doc['avatar'] ?? App::url('/images/doctor-das.jpg')) ?>" 
                                             alt="<?= htmlspecialchars($doc['name']) ?>" class="preview-img-box rounded-circle shadow-sm" id="doctorAvatarPreview_<?= $idx ?>">
                                        <div class="flex-grow-1">
                                            <label class="form-label small fw-bold mb-1">Doctor #<?= $idx + 1 ?> Avatar Photo</label>
                                            <input type="file" name="doctor_avatar_files[<?= $idx ?>]" class="form-control form-control-sm mb-1" accept="image/*" onchange="previewImage(this, 'doctorAvatarPreview_<?= $idx ?>')">
                                            <input type="text" name="doctor_avatars_manual[<?= $idx ?>]" class="form-control form-control-sm font-monospace" value="<?= htmlspecialchars($doc['avatar'] ?? '') ?>" placeholder="/images/doctor-das.jpg">
                                        </div>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label small fw-semibold">Doctor Full Name</label>
                                        <input type="text" name="doctor_names[<?= $idx ?>]" class="form-control form-control-sm fw-bold" value="<?= htmlspecialchars($doc['name'] ?? '') ?>" required>
                                    </div>
                                    <div class="row g-2 mb-2">
                                        <div class="col-6">
                                            <label class="form-label small fw-semibold">Degrees & Title</label>
                                            <input type="text" name="doctor_titles[<?= $idx ?>]" class="form-control form-control-sm" value="<?= htmlspecialchars($doc['title'] ?? '') ?>" placeholder="BDS Dental Surgeon">
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label small fw-semibold">Role Badge</label>
                                            <input type="text" name="doctor_badges[<?= $idx ?>]" class="form-control form-control-sm" value="<?= htmlspecialchars($doc['badge'] ?? '') ?>" placeholder="Associate Dentist">
                                        </div>
                                    </div>
                                    <div class="mb-0">
                                        <label class="form-label small fw-semibold">Doctor Bio / Focus</label>
                                        <textarea name="doctor_bios[<?= $idx ?>]" class="form-control form-control-sm" rows="2"><?= htmlspecialchars($doc['bio'] ?? '') ?></textarea>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- ============================================================== -->
        <!-- 5. TESTIMONIALS -->
        <!-- ============================================================== -->
        <div class="tab-pane fade" id="sec-testimonials">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="fw-bold mb-0">Google Reviews & Patient Rating</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Average Rating (out of 5.0)</label>
                            <input type="number" step="0.1" name="testimonial_rating" class="form-control" value="<?= htmlspecialchars((string)($testimonials['average_rating'] ?? 4.9)) ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Total Verified Reviews Count</label>
                            <input type="number" name="testimonial_count" class="form-control" value="<?= htmlspecialchars((string)($testimonials['total_reviews'] ?? 148)) ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ============================================================== -->
        <!-- 6. SAFETY CHARTER -->
        <!-- ============================================================== -->
        <div class="tab-pane fade" id="sec-charter">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="fw-bold mb-0">NHS Sexual Safety Charter Standards</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Charter Banner Title</label>
                            <input type="text" name="charter_title" class="form-control" value="<?= htmlspecialchars($charter['title'] ?? '') ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Official NHS Reference URL</label>
                            <input type="text" name="charter_link" class="form-control" value="<?= htmlspecialchars($charter['link_url'] ?? '') ?>">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Charter Summary & Commitment</label>
                            <textarea name="charter_description" class="form-control" rows="2"><?= htmlspecialchars($charter['description'] ?? '') ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ============================================================== -->
        <!-- 7. CLINIC CONTACT & MAP -->
        <!-- ============================================================== -->
        <div class="tab-pane fade" id="sec-contact">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="fw-bold mb-0">Surgery Hours & Location Map Photo</h5>
                </div>
                <div class="card-body p-4">
                    <!-- Map / Surgery Photo Upload with Live Preview -->
                    <div class="row g-4 align-items-center mb-4 pb-4 border-bottom">
                        <div class="col-md-3 text-center">
                            <label class="form-label fw-bold d-block mb-2">Location Map Photo</label>
                            <img src="<?= htmlspecialchars($contact['map_image'] ?? App::url('/images/surgery-clinic.jpg')) ?>" 
                                 alt="Map Image" class="preview-img-box shadow-sm mb-2" id="mapImagePreview" style="width: 140px; height: 110px;">
                            <small class="d-block text-muted">Surgery Location View</small>
                        </div>
                        <div class="col-md-9">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Upload New Surgery Location Photo</label>
                                <input type="file" name="map_image_file" class="form-control" accept="image/*" onchange="previewImage(this, 'mapImagePreview')">
                                <small class="text-muted">Upload surgery exterior photo or map diagram (.jpg, .png, .webp).</small>
                            </div>
                            <div class="mb-0">
                                <label class="form-label fw-semibold">Or Direct Image URL / Path</label>
                                <input type="text" name="map_image_manual" class="form-control" value="<?= htmlspecialchars($contact['map_image'] ?? '') ?>" placeholder="/images/surgery-clinic.jpg">
                            </div>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Section Title</label>
                            <input type="text" name="contact_title" class="form-control" value="<?= htmlspecialchars($contact['title'] ?? '') ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Practice Email Address</label>
                            <input type="email" name="contact_email" class="form-control" value="<?= htmlspecialchars($contact['email'] ?? '') ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Surgery Physical Address</label>
                            <input type="text" name="contact_address" class="form-control" value="<?= htmlspecialchars($contact['address'] ?? '') ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Contact Telephone</label>
                            <input type="text" name="contact_phone" class="form-control" value="<?= htmlspecialchars($contact['phone'] ?? '') ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sticky Bottom Save Bar -->
    <div class="card border-0 shadow-sm rounded-4 p-3 bg-white sticky-bottom mb-4">
        <div class="d-flex align-items-center justify-content-between">
            <span class="text-muted small">
                <i class="bi bi-cloud-check text-success me-1"></i> Saving will update the homepage payload served via <code>/api/v1/pages/home</code> immediately.
            </span>
            <button type="submit" class="btn btn-brand btn-lg rounded-pill px-5 shadow">
                <i class="bi bi-check-lg me-2"></i> Save Homepage Content & Visual Assets
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
