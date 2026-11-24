<?php

declare(strict_types=1);

use App\Core\App;

$hero = $home['hero'] ?? [];
$sections = $home['sections'] ?? [];
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
        <p class="text-muted small mb-0">
            Customize hero banner copy, visual imagery, CTA buttons, and assemble page sections dynamically with custom layouts (Thumbnails vs Sidebar, Image Left vs Right).
        </p>
    </div>
    <div class="col-md-4 text-md-end mt-3 mt-md-0">
        <a href="<?= App::url('/') ?>" target="_blank" class="btn btn-outline-secondary rounded-pill shadow-sm">
            <i class="bi bi-box-arrow-up-right me-1"></i> Preview Live Website
        </a>
    </div>
</div>

<form action="<?= App::url('/admin/pages/home/edit') ?>" method="POST" enctype="multipart/form-data" id="homeEditorForm">
    <!-- Section Tabs: Hero Banner & Dynamic Sections Composition Engine -->
    <ul class="nav nav-tabs mb-4 border-bottom-0" id="homeEditorTabs" role="tablist">
        <li class="nav-item">
            <button class="nav-link active px-4 py-2 fw-semibold" data-bs-toggle="tab" data-bs-target="#sec-hero" type="button">
                <i class="bi bi-image me-1"></i> 1. Hero Banner & CTAs
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link px-4 py-2 fw-bold text-success border-success" data-bs-toggle="tab" data-bs-target="#sec-composition" type="button">
                <i class="bi bi-layers-fill me-1"></i> 2. Page Sections Composition & Layout (<?= count($sections) ?>)
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
                                <input type="text" name="hero_image_manual" class="form-control font-monospace" value="<?= htmlspecialchars($hero['hero_image'] ?? '') ?>" placeholder="/images/hero-patient.jpg">
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
                            <input type="text" name="hero_title" class="form-control fw-bold" value="<?= htmlspecialchars($hero['title'] ?? $hero['headline'] ?? 'Make your Dental Experience a') ?>" placeholder="Make your Dental Experience a">
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
                        <?php foreach (($hero['stats'] ?? []) as $idx => $st): ?>
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
        <!-- 2. DYNAMIC PAGE SECTIONS COMPOSITION & LAYOUT ENGINE -->
        <!-- ============================================================== -->
        <div class="tab-pane fade" id="sec-composition">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div>
                        <h5 class="fw-bold mb-0">
                            <i class="bi bi-layers-fill text-success me-2"></i> Page Sections Composition Engine
                        </h5>
                        <small class="text-muted">Reorder sections (▲/▼), switch layout variants (Thumbnail Grid vs Sidebar List), toggle visibility, or add new blocks.</small>
                    </div>
                    <div>
                        <button type="button" class="btn btn-brand rounded-pill shadow-sm" data-bs-toggle="modal" data-bs-target="#addSectionModal">
                            <i class="bi bi-plus-circle me-1"></i> Add New Section
                        </button>
                    </div>
                </div>

                <div class="card-body p-4">
                    <div id="sectionsListContainer" class="d-flex flex-column gap-3">
                        <?php if (empty($sections)): ?>
                            <div class="p-5 text-center bg-light rounded-4 border text-muted">
                                <i class="bi bi-layers fs-1 d-block mb-2"></i>
                                No dynamic sections added yet. Click "+ Add New Section" to build your homepage layout.
                            </div>
                        <?php else: ?>
                            <?php foreach ($sections as $idx => $sec): ?>
                                <?php
                                $secId = $sec['id'] ?? ('sec_' . ($idx + 1));
                                $secType = $sec['type'] ?? 'custom_content';
                                $secCat = $sec['category'] ?? 'prebuilt';
                                $isServices = ($secType === 'services_block');
                                $isCustom = ($secType === 'custom_content' || $secType === 'page_snippet');
                                ?>
                                <div class="card border rounded-4 shadow-none bg-light section-item-card" id="sectionCard_<?= $secId ?>" data-section-id="<?= $secId ?>">
                                    <!-- Section Header Bar -->
                                    <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between flex-wrap gap-2 border-bottom">
                                        <div class="d-flex align-items-center gap-3">
                                            <!-- Move Up / Move Down Buttons -->
                                            <div class="btn-group btn-group-sm">
                                                <button type="button" class="btn btn-outline-secondary" onclick="moveSectionUp(this)" title="Move Up">
                                                    <i class="bi bi-arrow-up"></i>
                                                </button>
                                                <button type="button" class="btn btn-outline-secondary" onclick="moveSectionDown(this)" title="Move Down">
                                                    <i class="bi bi-arrow-down"></i>
                                                </button>
                                            </div>

                                            <span class="badge bg-dark-subtle text-dark font-monospace section-order-badge">
                                                #<?= $sec['order'] ?? ($idx + 1) ?>
                                            </span>

                                            <div>
                                                <span class="fw-bold text-dark section-name-display"><?= htmlspecialchars($sec['name'] ?? $sec['title'] ?? 'Section') ?></span>
                                                <span class="badge ms-2 <?= $secCat === 'prebuilt' ? 'bg-primary-subtle text-primary' : ($secCat === 'page_snippet' ? 'bg-info-subtle text-info' : 'bg-success-subtle text-success') ?>">
                                                    <?= ucfirst(str_replace('_', ' ', $secCat)) ?> (<?= htmlspecialchars($secType) ?>)
                                                </span>
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-center gap-3">
                                            <!-- Active Switch -->
                                            <div class="form-check form-switch m-0">
                                                <input class="form-check-input" type="checkbox" name="sections[<?= $idx ?>][is_active]" value="1" 
                                                       id="secActive_<?= $secId ?>" <?= ($sec['is_active'] ?? true) ? 'checked' : '' ?>>
                                                <label class="form-check-label small fw-semibold" for="secActive_<?= $secId ?>">Active</label>
                                            </div>

                                            <!-- Toggle Details Button -->
                                            <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill" data-bs-toggle="collapse" data-bs-target="#secCollapse_<?= $secId ?>">
                                                <i class="bi bi-sliders me-1"></i> Configure
                                            </button>

                                            <!-- Delete Section Button -->
                                            <button type="button" class="btn btn-sm btn-outline-danger rounded-circle" onclick="removeSection(this)" title="Remove Section">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Section Settings Collapse -->
                                    <div class="collapse show" id="secCollapse_<?= $secId ?>">
                                        <div class="card-body p-4 bg-white border-top">
                                            <!-- Hidden Identification Inputs -->
                                            <input type="hidden" name="sections[<?= $idx ?>][id]" value="<?= htmlspecialchars($secId) ?>">
                                            <input type="hidden" name="sections[<?= $idx ?>][type]" value="<?= htmlspecialchars($secType) ?>">
                                            <input type="hidden" name="sections[<?= $idx ?>][category]" value="<?= htmlspecialchars($secCat) ?>">
                                            <input type="hidden" name="sections[<?= $idx ?>][name]" value="<?= htmlspecialchars($sec['name'] ?? '') ?>">
                                            <input type="hidden" name="sections[<?= $idx ?>][page_slug]" value="<?= htmlspecialchars($sec['page_slug'] ?? '') ?>">
                                            <input type="hidden" class="section-order-input" name="sections[<?= $idx ?>][order]" value="<?= htmlspecialchars((string)($sec['order'] ?? ($idx + 1))) ?>">

                                            <div class="row g-3">
                                                <!-- Eyebrow & Title -->
                                                <div class="col-md-4">
                                                    <label class="form-label small fw-semibold">Eyebrow Tagline / Subtitle</label>
                                                    <input type="text" name="sections[<?= $idx ?>][eyebrow]" class="form-control form-control-sm" 
                                                           value="<?= htmlspecialchars($sec['eyebrow'] ?? '') ?>" placeholder="e.g. Our Practice Services">
                                                </div>
                                                <div class="col-md-5">
                                                    <label class="form-label small fw-semibold">Section Main Title <span class="text-danger">*</span></label>
                                                    <input type="text" name="sections[<?= $idx ?>][title]" class="form-control form-control-sm fw-bold" 
                                                           value="<?= htmlspecialchars($sec['title'] ?? '') ?>" required>
                                                </div>

                                                <!-- Layout Variant Selector -->
                                                <div class="col-md-3">
                                                    <label class="form-label small fw-semibold">Layout Presentation Style</label>
                                                    <?php if ($isServices): ?>
                                                        <select name="sections[<?= $idx ?>][layout]" class="form-select form-select-sm fw-semibold text-primary">
                                                            <option value="thumbnail" <?= ($sec['layout'] ?? 'thumbnail') === 'thumbnail' ? 'selected' : '' ?>>Thumbnail Grid (Cards)</option>
                                                            <option value="sidebar_list" <?= ($sec['layout'] ?? '') === 'sidebar_list' ? 'selected' : '' ?>>Vertical Sidebar List</option>
                                                        </select>
                                                        <small class="text-muted d-block mt-1">Render as cards or sidebar list</small>
                                                    <?php else: ?>
                                                        <select name="sections[<?= $idx ?>][layout]" class="form-select form-select-sm">
                                                            <option value="thumbnail" <?= ($sec['layout'] ?? 'thumbnail') === 'thumbnail' ? 'selected' : '' ?>>Standard Layout</option>
                                                            <option value="sidebar_list" <?= ($sec['layout'] ?? '') === 'sidebar_list' ? 'selected' : '' ?>>Sidebar Compact</option>
                                                        </select>
                                                    <?php endif; ?>
                                                </div>

                                                <!-- Summary Text -->
                                                <div class="col-md-6">
                                                    <label class="form-label small fw-semibold">Short Summary</label>
                                                    <textarea name="sections[<?= $idx ?>][summary]" class="form-control form-control-sm" rows="2" 
                                                              placeholder="Short summary of this section..."><?= htmlspecialchars($sec['summary'] ?? '') ?></textarea>
                                                </div>

                                                <!-- Little Description -->
                                                <div class="col-md-6">
                                                    <label class="form-label small fw-semibold">Description / Body Narrative</label>
                                                    <textarea name="sections[<?= $idx ?>][description]" class="form-control form-control-sm" rows="2" 
                                                              placeholder="Detailed clinical or informative description..."><?= htmlspecialchars($sec['description'] ?? '') ?></textarea>
                                                </div>

                                                <?php if ($isCustom || !empty($sec['feature_image'])): ?>
                                                    <!-- Image Alignment & Position (Left vs Right) -->
                                                    <div class="col-md-3">
                                                        <label class="form-label small fw-semibold">Feature Image Position</label>
                                                        <select name="sections[<?= $idx ?>][image_position]" class="form-select form-select-sm fw-semibold">
                                                            <option value="left" <?= ($sec['image_position'] ?? 'left') === 'left' ? 'selected' : '' ?>>Image on Left Side</option>
                                                            <option value="right" <?= ($sec['image_position'] ?? 'right') === 'right' ? 'selected' : '' ?>>Image on Right Side</option>
                                                        </select>
                                                    </div>

                                                    <!-- Column Layout Options -->
                                                    <div class="col-md-3">
                                                        <label class="form-label small fw-semibold">Column Layout Style</label>
                                                        <select name="sections[<?= $idx ?>][column_layout]" class="form-select form-select-sm">
                                                            <option value="two_col_split" <?= ($sec['column_layout'] ?? 'two_col_split') === 'two_col_split' ? 'selected' : '' ?>>2 Columns Split (50/50)</option>
                                                            <option value="action_bar" <?= ($sec['column_layout'] ?? '') === 'action_bar' ? 'selected' : '' ?>>Action Bar Banner (Callout)</option>
                                                            <option value="full_width" <?= ($sec['column_layout'] ?? '') === 'full_width' ? 'selected' : '' ?>>1 Column Full Width</option>
                                                        </select>
                                                    </div>

                                                    <!-- Feature Image Upload & Preview -->
                                                    <div class="col-md-6">
                                                        <label class="form-label small fw-semibold">Feature Image File / URL</label>
                                                        <div class="input-group input-group-sm mb-1">
                                                            <input type="file" name="section_image_files[<?= $idx ?>]" class="form-control form-control-sm" accept="image/*">
                                                        </div>
                                                        <input type="text" name="sections[<?= $idx ?>][feature_image]" class="form-control form-control-sm font-monospace" 
                                                               value="<?= htmlspecialchars($sec['feature_image'] ?? '') ?>" placeholder="/images/surgery-clinic.jpg">
                                                    </div>
                                                <?php endif; ?>

                                                <!-- CTA Button Options -->
                                                <div class="col-md-6">
                                                    <label class="form-label small fw-semibold">Action Button Text (Optional)</label>
                                                    <input type="text" name="sections[<?= $idx ?>][cta_text]" class="form-control form-control-sm" 
                                                           value="<?= htmlspecialchars($sec['cta_text'] ?? '') ?>" placeholder="e.g. Read Our Safety Standards">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label small fw-semibold">Action Target Link / URL</label>
                                                    <input type="text" name="sections[<?= $idx ?>][cta_link]" class="form-control form-control-sm font-monospace" 
                                                           value="<?= htmlspecialchars($sec['cta_link'] ?? '') ?>" placeholder="e.g. /about-us or https://...">
                                                </div>

                                                <!-- Creative Background & Section Styling -->
                                                <div class="col-12 mt-3 pt-3 border-top">
                                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                                        <label class="form-label small fw-bold text-dark mb-0">
                                                            <i class="bi bi-palette2 text-primary me-1"></i> Section Background & Creative Styling
                                                        </label>
                                                        <span class="badge bg-light text-secondary border">Design Freedom</span>
                                                    </div>

                                                    <div class="row g-2 bg-light p-3 rounded-3 border">
                                                        <!-- Background Type -->
                                                        <div class="col-md-3">
                                                            <label class="form-label small fw-semibold">Background Type</label>
                                                            <select name="sections[<?= $idx ?>][bg_type]" class="form-select form-select-sm fw-semibold" onchange="toggleSectionBgFields(this, '<?= $secId ?>')">
                                                                <option value="default" <?= ($sec['bg_type'] ?? 'default') === 'default' ? 'selected' : '' ?>>Alternating (Odd/Even Auto)</option>
                                                                <option value="solid" <?= ($sec['bg_type'] ?? '') === 'solid' ? 'selected' : '' ?>>Solid Custom Color</option>
                                                                <option value="gradient" <?= ($sec['bg_type'] ?? '') === 'gradient' ? 'selected' : '' ?>>Modern Gradient</option>
                                                                <option value="image" <?= ($sec['bg_type'] ?? '') === 'image' ? 'selected' : '' ?>>Background Image</option>
                                                                <option value="image_overlay" <?= ($sec['bg_type'] ?? '') === 'image_overlay' ? 'selected' : '' ?>>Image with Color Overlay</option>
                                                            </select>
                                                        </div>

                                                        <!-- Solid Color Field -->
                                                        <div class="col-md-3 sec-bg-field sec-bg-solid-<?= $secId ?>" style="display: <?= ($sec['bg_type'] ?? '') === 'solid' ? 'block' : 'none' ?>;">
                                                            <label class="form-label small fw-semibold">Solid Color</label>
                                                            <div class="input-group input-group-sm">
                                                                <input type="color" class="form-control form-control-color" value="<?= htmlspecialchars($sec['bg_color'] ?? '#f0fdf4') ?>" 
                                                                       oninput="this.nextElementSibling.value = this.value">
                                                                <input type="text" name="sections[<?= $idx ?>][bg_color]" class="form-control font-monospace" 
                                                                       value="<?= htmlspecialchars($sec['bg_color'] ?? '#f0fdf4') ?>" placeholder="#f0fdf4">
                                                            </div>
                                                        </div>

                                                        <!-- Gradient Fields -->
                                                        <div class="col-md-5 sec-bg-field sec-bg-gradient-<?= $secId ?>" style="display: <?= ($sec['bg_type'] ?? '') === 'gradient' ? 'block' : 'none' ?>;">
                                                            <label class="form-label small fw-semibold">Gradient Colors (Start & End)</label>
                                                            <div class="input-group input-group-sm">
                                                                <input type="color" class="form-control form-control-color" value="<?= htmlspecialchars($sec['bg_gradient_start'] ?? '#094713') ?>" 
                                                                       oninput="this.nextElementSibling.value = this.value" title="Start Color">
                                                                <input type="text" name="sections[<?= $idx ?>][bg_gradient_start]" class="form-control font-monospace" 
                                                                       value="<?= htmlspecialchars($sec['bg_gradient_start'] ?? '#094713') ?>" placeholder="#094713">
                                                                <span class="input-group-text">to</span>
                                                                <input type="color" class="form-control form-control-color" value="<?= htmlspecialchars($sec['bg_gradient_end'] ?? '#15803d') ?>" 
                                                                       oninput="this.nextElementSibling.value = this.value" title="End Color">
                                                                <input type="text" name="sections[<?= $idx ?>][bg_gradient_end]" class="form-control font-monospace" 
                                                                       value="<?= htmlspecialchars($sec['bg_gradient_end'] ?? '#15803d') ?>" placeholder="#15803d">
                                                            </div>
                                                        </div>

                                                        <!-- Background Image & Overlay Fields -->
                                                        <div class="col-md-6 sec-bg-field sec-bg-image-<?= $secId ?>" style="display: <?= in_array($sec['bg_type'] ?? '', ['image', 'image_overlay']) ? 'block' : 'none' ?>;">
                                                            <label class="form-label small fw-semibold">Background Image File / URL</label>
                                                            <div class="input-group input-group-sm mb-1">
                                                                <input type="file" name="section_bg_files[<?= $idx ?>]" class="form-control form-control-sm" accept="image/*">
                                                            </div>
                                                            <input type="text" name="sections[<?= $idx ?>][bg_image]" class="form-control form-control-sm font-monospace" 
                                                                   value="<?= htmlspecialchars($sec['bg_image'] ?? '') ?>" placeholder="/images/surgery-clinic.jpg">
                                                        </div>

                                                        <div class="col-md-3 sec-bg-field sec-bg-overlay-<?= $secId ?>" style="display: <?= ($sec['bg_type'] ?? '') === 'image_overlay' ? 'block' : 'none' ?>;">
                                                            <label class="form-label small fw-semibold">Overlay Color & Opacity</label>
                                                            <div class="input-group input-group-sm">
                                                                <input type="color" class="form-control form-control-color" value="<?= htmlspecialchars($sec['bg_overlay_color'] ?? '#000000') ?>" 
                                                                       oninput="this.nextElementSibling.value = this.value">
                                                                <input type="text" name="sections[<?= $idx ?>][bg_overlay_color]" class="form-control font-monospace" 
                                                                       value="<?= htmlspecialchars($sec['bg_overlay_color'] ?? '#000000') ?>" placeholder="#000000">
                                                                <select name="sections[<?= $idx ?>][bg_overlay_opacity]" class="form-select form-select-sm" style="max-width: 80px;">
                                                                    <option value="0.3" <?= ($sec['bg_overlay_opacity'] ?? 0.6) == 0.3 ? 'selected' : '' ?>>30%</option>
                                                                    <option value="0.5" <?= ($sec['bg_overlay_opacity'] ?? 0.6) == 0.5 ? 'selected' : '' ?>>50%</option>
                                                                    <option value="0.7" <?= ($sec['bg_overlay_opacity'] ?? 0.6) == 0.7 ? 'selected' : '' ?>>70%</option>
                                                                    <option value="0.85" <?= ($sec['bg_overlay_opacity'] ?? 0.6) == 0.85 ? 'selected' : '' ?>>85%</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <!-- Text Contrast & Spacing -->
                                                        <div class="col-md-3">
                                                            <label class="form-label small fw-semibold">Text Contrast Theme</label>
                                                            <select name="sections[<?= $idx ?>][text_contrast]" class="form-select form-select-sm">
                                                                <option value="auto" <?= ($sec['text_contrast'] ?? 'auto') === 'auto' ? 'selected' : '' ?>>Auto (Theme Default)</option>
                                                                <option value="light" <?= ($sec['text_contrast'] ?? '') === 'light' ? 'selected' : '' ?>>Light / White Text (Dark BG)</option>
                                                                <option value="dark" <?= ($sec['text_contrast'] ?? '') === 'dark' ? 'selected' : '' ?>>Dark Text (Light BG)</option>
                                                            </select>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <label class="form-label small fw-semibold">Section Vertical Spacing</label>
                                                            <select name="sections[<?= $idx ?>][padding_y]" class="form-select form-select-sm">
                                                                <option value="normal" <?= ($sec['padding_y'] ?? 'normal') === 'normal' ? 'selected' : '' ?>>Standard (5.5rem)</option>
                                                                <option value="compact" <?= ($sec['padding_y'] ?? '') === 'compact' ? 'selected' : '' ?>>Compact (3.5rem)</option>
                                                                <option value="generous" <?= ($sec['padding_y'] ?? '') === 'generous' ? 'selected' : '' ?>>Generous (7.5rem)</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
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
                <i class="bi bi-check-lg me-2"></i> Save Homepage Content & Sections
            </button>
        </div>
    </div>
</form>

<!-- ============================================================== -->
<!-- MODAL: ADD NEW SECTION (3 CHOICES) -->
<!-- ============================================================== -->
<div class="modal fade" id="addSectionModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header bg-light py-3 border-bottom">
                <h5 class="modal-title fw-bold text-dark">
                    <i class="bi bi-plus-circle text-success me-2"></i> Add New Section to Homepage
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <!-- 3 Category Navigation Pills -->
                <ul class="nav nav-pills nav-fill mb-4 p-1 bg-light rounded-pill" id="addSectionTabs" role="tablist">
                    <li class="nav-item">
                        <button class="nav-link active rounded-pill fw-semibold" id="pill-prebuilt-tab" data-bs-toggle="pill" data-bs-target="#pill-prebuilt" type="button">
                            1. Pre-built Component
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link rounded-pill fw-semibold" id="pill-snippet-tab" data-bs-toggle="pill" data-bs-target="#pill-snippet" type="button">
                            2. Other Page Snippet
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link rounded-pill fw-semibold" id="pill-custom-tab" data-bs-toggle="pill" data-bs-target="#pill-custom" type="button">
                            3. Add New Content Block
                        </button>
                    </li>
                </ul>

                <div class="tab-content" id="addSectionTabsContent">
                    <!-- CHOICE 1: PRE-BUILT COMPONENT -->
                    <div class="tab-pane fade show active" id="pill-prebuilt">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label fw-bold">Select Pre-Built Component Type</label>
                                <select id="prebuiltTypeSelect" class="form-select fw-semibold" onchange="onPrebuiltTypeChange(this.value)">
                                    <option value="services_block">Practice Services Catalog (Thumbnail Grid or Sidebar List)</option>
                                    <option value="team_block">Doctors & Dental Surgeons Grid</option>
                                    <option value="testimonials_block">Patient Reviews & Testimonials Slider</option>
                                    <option value="charter_block">NHS Sexual Safety Charter Action Banner</option>
                                    <option value="contact_block">Surgery Operating Hours & Location Map</option>
                                    <option value="blog_block">Practice News & Blog Posts</option>
                                </select>
                            </div>

                            <div class="col-md-6" id="prebuiltLayoutRow">
                                <label class="form-label fw-semibold">Services Presentation Layout</label>
                                <select id="prebuiltLayoutSelect" class="form-select fw-semibold text-primary">
                                    <option value="thumbnail">Thumbnail Grid (Cards)</option>
                                    <option value="sidebar_list">Vertical Sidebar List</option>
                                </select>
                                <small class="text-muted">Choose whether to display treatments as cards or a compact sidebar list.</small>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Section Eyebrow Text</label>
                                <input type="text" id="prebuiltEyebrow" class="form-control" value="Our Practice Services">
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">Section Main Title</label>
                                <input type="text" id="prebuiltTitle" class="form-control fw-bold" value="Discover Quality Dental Care in Acocks Green">
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">Short Summary</label>
                                <textarea id="prebuiltSummary" class="form-control" rows="2">Personalized clinical dental solutions delivered in modern surgeries with low radiation digital radiography and compassionate pacing.</textarea>
                            </div>

                            <div class="col-12 text-end mt-4">
                                <button type="button" class="btn btn-brand rounded-pill px-4" onclick="insertPrebuiltSection()">
                                    <i class="bi bi-check2-circle me-1"></i> Insert Pre-Built Section
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- CHOICE 2: OTHER PAGE SNIPPET -->
                    <div class="tab-pane fade" id="pill-snippet">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Select Source Page</label>
                                <select id="snippetPageSlug" class="form-select fw-semibold" onchange="onSnippetPageChange(this.value)">
                                    <option value="about-us">About Our Practice & Surgery (/about-us)</option>
                                    <option value="contact">Contact & Emergency Location (/contact)</option>
                                    <option value="treatments">Treatments & Services (/treatments)</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Feature Image Position</label>
                                <select id="snippetImagePos" class="form-select fw-semibold text-primary">
                                    <option value="left">Put Image on Left Side</option>
                                    <option value="right" selected>Put Image on Right Side</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Subtitle as Eyebrow Text</label>
                                <input type="text" id="snippetEyebrow" class="form-control" value="About Acocks Green Practice">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Section Title</label>
                                <input type="text" id="snippetTitle" class="form-control fw-bold" value="Dedicated Dental Professionals Serving Birmingham B27">
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">Short Summary</label>
                                <textarea id="snippetSummary" class="form-control" rows="2">Our clinic was established with a clear mission: provide accessible, respectful, and clinically excellent dentistry.</textarea>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">Little Description / Narrative</label>
                                <textarea id="snippetDescription" class="form-control" rows="3">At Acocks Green Dental Practice, we believe that visiting the dentist should be a calm, reassuring experience. Our clinic has been trusted by families across South Birmingham for over two decades.</textarea>
                            </div>

                            <div class="col-md-8">
                                <label class="form-label fw-semibold">Feature Image URL / Path</label>
                                <input type="text" id="snippetImage" class="form-control font-monospace" value="<?= App::url('/images/surgery-clinic.jpg') ?>">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Button Action Text</label>
                                <input type="text" id="snippetCtaText" class="form-control" value="Read Full Story">
                            </div>

                            <div class="col-12 text-end mt-4">
                                <button type="button" class="btn btn-brand rounded-pill px-4" onclick="insertPageSnippetSection()">
                                    <i class="bi bi-check2-circle me-1"></i> Insert Page Snippet Section
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- CHOICE 3: CUSTOM CONTENT BLOCK / ACTION BAR -->
                    <div class="tab-pane fade" id="pill-custom">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Column Layout Option</label>
                                <select id="customColLayout" class="form-select fw-semibold text-primary">
                                    <option value="two_col_split">2 Columns Split (50/50)</option>
                                    <option value="action_bar">Action Bar Banner (Callout)</option>
                                    <option value="full_width">1 Column Full Width</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold">Image Position Option</label>
                                <select id="customImagePos" class="form-select fw-semibold text-primary">
                                    <option value="left">Put Image on Left Side</option>
                                    <option value="right" selected>Put Image on Right Side</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Eyebrow Subtitle</label>
                                <input type="text" id="customEyebrow" class="form-control" placeholder="e.g. Clinical Safety">
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">Main Section Title <span class="text-danger">*</span></label>
                                <input type="text" id="customTitle" class="form-control fw-bold" placeholder="e.g. NHS Sexual Safety Charter Signatory">
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">Short Summary</label>
                                <textarea id="customSummary" class="form-control" rows="2" placeholder="Brief summary statement..."></textarea>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">Little Description / Content Body</label>
                                <textarea id="customDescription" class="form-control" rows="3" placeholder="Provide description text, clinical protocols, or callout content..."></textarea>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Feature Image URL / Path (Optional)</label>
                                <input type="text" id="customImage" class="form-control font-monospace" placeholder="/images/hero-patient.jpg">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Action Button Text</label>
                                <input type="text" id="customCtaText" class="form-control" placeholder="e.g. Read Our Charter">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Action Link / URL</label>
                                <input type="text" id="customCtaLink" class="form-control font-monospace" placeholder="e.g. /about-us#charter">
                            </div>

                            <div class="col-12 text-end mt-4">
                                <button type="button" class="btn btn-brand rounded-pill px-4" onclick="insertCustomContentSection()">
                                    <i class="bi bi-check2-circle me-1"></i> Insert Content Block
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function previewImage(input, previewId) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById(previewId).src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// Section Reordering (Move Up / Down)
function moveSectionUp(btn) {
    const card = btn.closest('.section-item-card');
    const prev = card.previousElementSibling;
    if (prev && prev.classList.contains('section-item-card')) {
        card.parentNode.insertBefore(card, prev);
        recalculateSectionOrders();
    }
}

function moveSectionDown(btn) {
    const card = btn.closest('.section-item-card');
    const next = card.nextElementSibling;
    if (next && next.classList.contains('section-item-card')) {
        card.parentNode.insertBefore(next, card);
        recalculateSectionOrders();
    }
}

function removeSection(btn) {
    if (confirm('Are you sure you want to remove this section from the homepage?')) {
        const card = btn.closest('.section-item-card');
        card.remove();
        recalculateSectionOrders();
    }
}

function recalculateSectionOrders() {
    const cards = document.querySelectorAll('#sectionsListContainer .section-item-card');
    cards.forEach((card, idx) => {
        const orderNum = idx + 1;
        const badge = card.querySelector('.section-order-badge');
        if (badge) badge.textContent = '#' + orderNum;
        const input = card.querySelector('.section-order-input');
        if (input) input.value = orderNum;
    });
}

function onPrebuiltTypeChange(val) {
    const layoutRow = document.getElementById('prebuiltLayoutRow');
    if (val === 'services_block') {
        layoutRow.style.display = 'block';
        document.getElementById('prebuiltEyebrow').value = 'Our Practice Services';
        document.getElementById('prebuiltTitle').value = 'Discover Quality Dental Care in Acocks Green';
        document.getElementById('prebuiltSummary').value = 'Personalized clinical dental solutions delivered in modern surgeries with low radiation digital radiography and compassionate pacing.';
    } else if (val === 'team_block') {
        layoutRow.style.display = 'none';
        document.getElementById('prebuiltEyebrow').value = 'Clinical Team';
        document.getElementById('prebuiltTitle').value = 'Meet Our Experienced Dental Team';
        document.getElementById('prebuiltSummary').value = 'Compassionate care delivered by fully registered dental professionals with decades of combined clinical expertise.';
    } else if (val === 'testimonials_block') {
        layoutRow.style.display = 'none';
        document.getElementById('prebuiltEyebrow').value = 'Patient Feedback';
        document.getElementById('prebuiltTitle').value = 'What Our Patients Say About Us';
        document.getElementById('prebuiltSummary').value = 'Real stories from patients treated at our Birmingham surgery.';
    } else if (val === 'charter_block') {
        layoutRow.style.display = 'none';
        document.getElementById('prebuiltEyebrow').value = 'Official NHS Charter';
        document.getElementById('prebuiltTitle').value = 'NHS Sexual Safety Charter Signatory';
        document.getElementById('prebuiltSummary').value = 'Championing zero tolerance for harassment and fostering a safe, respectful clinical environment.';
    } else if (val === 'contact_block') {
        layoutRow.style.display = 'none';
        document.getElementById('prebuiltEyebrow').value = 'Practice Location';
        document.getElementById('prebuiltTitle').value = 'Visit Our Modern Surgery in Birmingham B27';
        document.getElementById('prebuiltSummary').value = 'Find surgery opening hours, parking information, and telephone reception.';
    } else if (val === 'blog_block') {
        layoutRow.style.display = 'block';
        document.getElementById('prebuiltEyebrow').value = 'Practice Blog';
        document.getElementById('prebuiltTitle').value = 'Latest Dental & Oral Health Articles';
        document.getElementById('prebuiltSummary').value = 'Clinical insights, preventive brushing advice, and community health updates.';
    }
}

function onSnippetPageChange(slug) {
    if (slug === 'about-us') {
        document.getElementById('snippetEyebrow').value = 'About Acocks Green Practice';
        document.getElementById('snippetTitle').value = 'Dedicated Dental Professionals Serving Birmingham B27';
        document.getElementById('snippetSummary').value = 'Our clinic was established with a clear mission: provide accessible, respectful, and clinically excellent dentistry.';
        document.getElementById('snippetDescription').value = 'At Acocks Green Dental Practice, we believe that visiting the dentist should be a calm, reassuring experience.';
        document.getElementById('snippetImage').value = '<?= App::url('/images/surgery-clinic.jpg') ?>';
    } else if (slug === 'contact') {
        document.getElementById('snippetEyebrow').value = 'Emergency & Location';
        document.getElementById('snippetTitle').value = 'Centrally Located Dental Care in Acocks Green';
        document.getElementById('snippetSummary').value = 'Easy access by train or bus, with dedicated patient parking facilities.';
        document.getElementById('snippetDescription').value = 'Visit us at 1078 Warwick Road, Birmingham B27 6BH. Call our emergency triage for urgent dental relief.';
        document.getElementById('snippetImage').value = '<?= App::url('/images/treatment-room.jpg') ?>';
    }
}

// 1. Insert Pre-built Section
function insertPrebuiltSection() {
    const type = document.getElementById('prebuiltTypeSelect').value;
    const layout = document.getElementById('prebuiltLayoutSelect').value;
    const eyebrow = document.getElementById('prebuiltEyebrow').value;
    const title = document.getElementById('prebuiltTitle').value;
    const summary = document.getElementById('prebuiltSummary').value;

    const secId = 'sec_' + type + '_' + Date.now();
    createAndAppendSectionCard({
        id: secId,
        type: type,
        category: 'prebuilt',
        name: title || 'Prebuilt Section',
        eyebrow: eyebrow,
        title: title,
        summary: summary,
        description: '',
        layout: layout,
        image_position: 'right',
        column_layout: 'full_width',
        feature_image: '',
        cta_text: type === 'services_block' ? 'View All Treatments' : '',
        cta_link: type === 'services_block' ? '/treatments' : '',
        is_active: true
    });

    bootstrap.Modal.getInstance(document.getElementById('addSectionModal')).hide();
}

// 2. Insert Page Snippet Section
function insertPageSnippetSection() {
    const slug = document.getElementById('snippetPageSlug').value;
    const imgPos = document.getElementById('snippetImagePos').value;
    const eyebrow = document.getElementById('snippetEyebrow').value;
    const title = document.getElementById('snippetTitle').value;
    const summary = document.getElementById('snippetSummary').value;
    const desc = document.getElementById('snippetDescription').value;
    const img = document.getElementById('snippetImage').value;
    const ctaText = document.getElementById('snippetCtaText').value;

    const secId = 'sec_snippet_' + slug + '_' + Date.now();
    createAndAppendSectionCard({
        id: secId,
        type: 'page_snippet',
        category: 'page_snippet',
        page_slug: slug,
        name: title || 'Page Snippet',
        eyebrow: eyebrow,
        title: title,
        summary: summary,
        description: desc,
        layout: 'thumbnail',
        image_position: imgPos,
        column_layout: 'two_col_split',
        feature_image: img,
        cta_text: ctaText,
        cta_link: '/' + slug,
        is_active: true
    });

    bootstrap.Modal.getInstance(document.getElementById('addSectionModal')).hide();
}

// 3. Insert Custom Content Section
function insertCustomContentSection() {
    const colLayout = document.getElementById('customColLayout').value;
    const imgPos = document.getElementById('customImagePos').value;
    const eyebrow = document.getElementById('customEyebrow').value;
    const title = document.getElementById('customTitle').value;
    const summary = document.getElementById('customSummary').value;
    const desc = document.getElementById('customDescription').value;
    const img = document.getElementById('customImage').value;
    const ctaText = document.getElementById('customCtaText').value;
    const ctaLink = document.getElementById('customCtaLink').value;

    if (!title) {
        alert('Please enter a section title.');
        return;
    }

    const secId = 'sec_custom_' + Date.now();
    createAndAppendSectionCard({
        id: secId,
        type: 'custom_content',
        category: 'custom_content',
        name: title,
        eyebrow: eyebrow,
        title: title,
        summary: summary,
        description: desc,
        layout: 'thumbnail',
        image_position: imgPos,
        column_layout: colLayout,
        feature_image: img,
        cta_text: ctaText,
        cta_link: ctaLink,
        is_active: true
    });

    bootstrap.Modal.getInstance(document.getElementById('addSectionModal')).hide();
}

function createAndAppendSectionCard(data) {
    const container = document.getElementById('sectionsListContainer');
    const existingCards = container.querySelectorAll('.section-item-card');
    const newOrder = existingCards.length + 1;
    const newIdx = 'new_' + Date.now();

    const isServices = (data.type === 'services_block');
    const isCustom = (data.category === 'custom_content' || data.category === 'page_snippet');

    const html = `
    <div class="card border rounded-4 shadow-none bg-light section-item-card" id="sectionCard_${data.id}" data-section-id="${data.id}">
        <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between flex-wrap gap-2 border-bottom">
            <div class="d-flex align-items-center gap-3">
                <div class="btn-group btn-group-sm">
                    <button type="button" class="btn btn-outline-secondary" onclick="moveSectionUp(this)" title="Move Up"><i class="bi bi-arrow-up"></i></button>
                    <button type="button" class="btn btn-outline-secondary" onclick="moveSectionDown(this)" title="Move Down"><i class="bi bi-arrow-down"></i></button>
                </div>
                <span class="badge bg-dark-subtle text-dark font-monospace section-order-badge">#${newOrder}</span>
                <div>
                    <span class="fw-bold text-dark section-name-display">${escapeHtml(data.name)}</span>
                    <span class="badge ms-2 bg-success-subtle text-success">${escapeHtml(data.category)} (${escapeHtml(data.type)})</span>
                </div>
            </div>
            <div class="d-flex align-items-center gap-3">
                <div class="form-check form-switch m-0">
                    <input class="form-check-input" type="checkbox" name="sections[${newIdx}][is_active]" value="1" id="secActive_${data.id}" checked>
                    <label class="form-check-label small fw-semibold" for="secActive_${data.id}">Active</label>
                </div>
                <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill" data-bs-toggle="collapse" data-bs-target="#secCollapse_${data.id}">
                    <i class="bi bi-sliders me-1"></i> Configure
                </button>
                <button type="button" class="btn btn-sm btn-outline-danger rounded-circle" onclick="removeSection(this)" title="Remove Section">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        </div>
        <div class="collapse show" id="secCollapse_${data.id}">
            <div class="card-body p-4 bg-white border-top">
                <input type="hidden" name="sections[${newIdx}][id]" value="${escapeHtml(data.id)}">
                <input type="hidden" name="sections[${newIdx}][type]" value="${escapeHtml(data.type)}">
                <input type="hidden" name="sections[${newIdx}][category]" value="${escapeHtml(data.category)}">
                <input type="hidden" name="sections[${newIdx}][name]" value="${escapeHtml(data.name)}">
                <input type="hidden" name="sections[${newIdx}][page_slug]" value="${escapeHtml(data.page_slug || '')}">
                <input type="hidden" class="section-order-input" name="sections[${newIdx}][order]" value="${newOrder}">

                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label small fw-semibold">Eyebrow Tagline / Subtitle</label>
                        <input type="text" name="sections[${newIdx}][eyebrow]" class="form-control form-control-sm" value="${escapeHtml(data.eyebrow || '')}">
                    </div>
                    <div class="col-md-5">
                        <label class="form-label small fw-semibold">Section Main Title <span class="text-danger">*</span></label>
                        <input type="text" name="sections[${newIdx}][title]" class="form-control form-control-sm fw-bold" value="${escapeHtml(data.title || '')}" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-semibold">Layout Presentation Style</label>
                        ${isServices ? `
                            <select name="sections[${newIdx}][layout]" class="form-select form-select-sm fw-semibold text-primary">
                                <option value="thumbnail" ${data.layout === 'thumbnail' ? 'selected' : ''}>Thumbnail Grid (Cards)</option>
                                <option value="sidebar_list" ${data.layout === 'sidebar_list' ? 'selected' : ''}>Vertical Sidebar List</option>
                            </select>
                        ` : `
                            <select name="sections[${newIdx}][layout]" class="form-select form-select-sm">
                                <option value="thumbnail" selected>Standard Layout</option>
                                <option value="sidebar_list">Sidebar Compact</option>
                            </select>
                        `}
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold">Short Summary</label>
                        <textarea name="sections[${newIdx}][summary]" class="form-control form-control-sm" rows="2">${escapeHtml(data.summary || '')}</textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold">Description / Body Narrative</label>
                        <textarea name="sections[${newIdx}][description]" class="form-control form-control-sm" rows="2">${escapeHtml(data.description || '')}</textarea>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-semibold">Feature Image Position</label>
                        <select name="sections[${newIdx}][image_position]" class="form-select form-select-sm fw-semibold">
                            <option value="left" ${data.image_position === 'left' ? 'selected' : ''}>Image on Left Side</option>
                            <option value="right" ${data.image_position === 'right' ? 'selected' : ''}>Image on Right Side</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-semibold">Column Layout Style</label>
                        <select name="sections[${newIdx}][column_layout]" class="form-select form-select-sm">
                            <option value="two_col_split" ${data.column_layout === 'two_col_split' ? 'selected' : ''}>2 Columns Split (50/50)</option>
                            <option value="action_bar" ${data.column_layout === 'action_bar' ? 'selected' : ''}>Action Bar Banner (Callout)</option>
                            <option value="full_width" ${data.column_layout === 'full_width' ? 'selected' : ''}>1 Column Full Width</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold">Feature Image URL / Path</label>
                        <input type="text" name="sections[${newIdx}][feature_image]" class="form-control form-control-sm font-monospace" value="${escapeHtml(data.feature_image || '')}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold">Action Button Text</label>
                        <input type="text" name="sections[${newIdx}][cta_text]" class="form-control form-control-sm" value="${escapeHtml(data.cta_text || '')}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold">Action Target Link / URL</label>
                        <input type="text" name="sections[${newIdx}][cta_link]" class="form-control form-control-sm font-monospace" value="${escapeHtml(data.cta_link || '')}">
                    </div>

                    <!-- Creative Background & Styling -->
                    <div class="col-12 mt-3 pt-3 border-top">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <label class="form-label small fw-bold text-dark mb-0">
                                <i class="bi bi-palette2 text-primary me-1"></i> Section Background & Creative Styling
                            </label>
                            <span class="badge bg-light text-secondary border">Design Freedom</span>
                        </div>
                        <div class="row g-2 bg-light p-3 rounded-3 border">
                            <div class="col-md-3">
                                <label class="form-label small fw-semibold">Background Type</label>
                                <select name="sections[${newIdx}][bg_type]" class="form-select form-select-sm fw-semibold" onchange="toggleSectionBgFields(this, '${data.id}')">
                                    <option value="default" selected>Alternating (Odd/Even Auto)</option>
                                    <option value="solid">Solid Custom Color</option>
                                    <option value="gradient">Modern Gradient</option>
                                    <option value="image">Background Image</option>
                                    <option value="image_overlay">Image with Color Overlay</option>
                                </select>
                            </div>
                            <div class="col-md-3 sec-bg-field sec-bg-solid-${data.id}" style="display: none;">
                                <label class="form-label small fw-semibold">Solid Color</label>
                                <div class="input-group input-group-sm">
                                    <input type="color" class="form-control form-control-color" value="#f0fdf4" oninput="this.nextElementSibling.value = this.value">
                                    <input type="text" name="sections[${newIdx}][bg_color]" class="form-control font-monospace" value="#f0fdf4" placeholder="#f0fdf4">
                                </div>
                            </div>
                            <div class="col-md-5 sec-bg-field sec-bg-gradient-${data.id}" style="display: none;">
                                <label class="form-label small fw-semibold">Gradient Colors (Start & End)</label>
                                <div class="input-group input-group-sm">
                                    <input type="color" class="form-control form-control-color" value="#094713" oninput="this.nextElementSibling.value = this.value" title="Start">
                                    <input type="text" name="sections[${newIdx}][bg_gradient_start]" class="form-control font-monospace" value="#094713">
                                    <span class="input-group-text">to</span>
                                    <input type="color" class="form-control form-control-color" value="#15803d" oninput="this.nextElementSibling.value = this.value" title="End">
                                    <input type="text" name="sections[${newIdx}][bg_gradient_end]" class="form-control font-monospace" value="#15803d">
                                </div>
                            </div>
                            <div class="col-md-6 sec-bg-field sec-bg-image-${data.id}" style="display: none;">
                                <label class="form-label small fw-semibold">Background Image File / URL</label>
                                <input type="text" name="sections[${newIdx}][bg_image]" class="form-control form-control-sm font-monospace" placeholder="/images/surgery-clinic.jpg">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small fw-semibold">Text Contrast Theme</label>
                                <select name="sections[${newIdx}][text_contrast]" class="form-select form-select-sm">
                                    <option value="auto" selected>Auto (Theme Default)</option>
                                    <option value="light">Light / White Text (Dark BG)</option>
                                    <option value="dark">Dark Text (Light BG)</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small fw-semibold">Section Vertical Spacing</label>
                                <select name="sections[${newIdx}][padding_y]" class="form-select form-select-sm">
                                    <option value="normal" selected>Standard (5.5rem)</option>
                                    <option value="compact">Compact (3.5rem)</option>
                                    <option value="generous">Generous (7.5rem)</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    `;

    const div = document.createElement('div');
    div.innerHTML = html.trim();
    container.appendChild(div.firstChild);
    recalculateSectionOrders();
}

function toggleSectionBgFields(select, secId) {
    const val = select.value;
    const parent = select.closest('.row');
    const solidField = parent.querySelector('.sec-bg-solid-' + secId);
    const gradientField = parent.querySelector('.sec-bg-gradient-' + secId);
    const imageField = parent.querySelector('.sec-bg-image-' + secId);
    const overlayField = parent.querySelector('.sec-bg-overlay-' + secId);

    if (solidField) solidField.style.display = (val === 'solid') ? 'block' : 'none';
    if (gradientField) gradientField.style.display = (val === 'gradient') ? 'block' : 'none';
    if (imageField) imageField.style.display = (val === 'image' || val === 'image_overlay') ? 'block' : 'none';
    if (overlayField) overlayField.style.display = (val === 'image_overlay') ? 'block' : 'none';
}

function escapeHtml(text) {
    if (!text) return '';
    return String(text)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
}
</script>
