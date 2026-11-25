<?php

use App\Core\App;

$isEdit = isset($service) && !empty($service['id']);
$formAction = $isEdit 
    ? App::url('/admin/components/services/' . $service['id'] . '/edit') 
    : App::url('/admin/components/services/create');

$includedItems = $service['included_items'] ?? [];
$journeySteps = $service['journey_steps'] ?? [];
$pricingOptions = $service['pricing_options'] ?? [];
$faqs = $service['faqs'] ?? [];

require dirname(__DIR__) . '/pages/_editor-styles.php';
?>

<div class="row mb-4 align-items-center">
    <div class="col-md-8">
        <div class="d-flex align-items-center gap-2 mb-1">
            <a href="<?= App::url('/admin/components/services') ?>" class="text-decoration-none text-muted small">
                <i class="bi bi-arrow-left"></i> Back to Services List
            </a>
            <span class="text-muted small">/</span>
            <span class="text-success small fw-semibold"><?= $isEdit ? 'Edit Service' : 'Create New Service' ?></span>
        </div>
        <h2 class="fw-bold text-dark mb-0">
            <i class="bi <?= $isEdit ? 'bi-pencil-square' : 'bi-plus-circle' ?> text-success me-2"></i>
            <?= $isEdit ? 'Edit Clinical Service: ' . htmlspecialchars($service['title'] ?? '') : 'Add New Dental Service' ?>
        </h2>
        <p class="text-muted small mb-0">
            Manage treatment parameters, inner page clinical content, feature imagery, pricing, and thumbnail display.
        </p>
    </div>
    <div class="col-md-4 text-md-end mt-3 mt-md-0">
        <a href="<?= App::url('/admin/components/services') ?>" class="btn btn-outline-secondary rounded-pill shadow-sm">
            <i class="bi bi-list me-1"></i> All Services
        </a>
    </div>
</div>

<form action="<?= $formAction ?>" method="POST" enctype="multipart/form-data">
    <div class="row g-4">
        <!-- Main Service Content Column (Left) -->
        <div class="col-lg-8">
            <!-- 1. Basic Details Card -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="fw-bold mb-0">1. Service Identity & Titles</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label fw-semibold">Service Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" id="serviceTitle" class="form-control fw-bold" 
                                   value="<?= htmlspecialchars($service['title'] ?? '') ?>" 
                                   placeholder="e.g. Routine Dental Examinations" required
                                   onkeyup="autoGenerateSlug(this.value)">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Slug (URL Route) <span class="text-danger">*</span></label>
                            <input type="text" name="slug" id="serviceSlug" class="form-control font-monospace" 
                                   value="<?= htmlspecialchars($service['slug'] ?? '') ?>" 
                                   placeholder="routine-examinations" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Clinical Category</label>
                            <select name="category" class="form-select">
                                <?php
                                $categories = [
                                    'General Dentistry', 'Hygiene', 'Restorations', 
                                    'Endodontics', 'Prosthetics', 'Orthodontics', 
                                    'Oral Surgery', 'Cosmetic Dentistry', 'Emergency'
                                ];
                                $currCat = $service['category'] ?? 'General Dentistry';
                                foreach ($categories as $cat): ?>
                                    <option value="<?= $cat ?>" <?= $currCat === $cat ? 'selected' : '' ?>><?= $cat ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Badge Tag</label>
                            <input type="text" name="badge" class="form-control" 
                                   value="<?= htmlspecialchars($service['badge'] ?? '') ?>" 
                                   placeholder="e.g. Preventive, Airflow Polish, Same-Day">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Short Summary / Description (for Cards & Thumbnails) <span class="text-danger">*</span></label>
                            <textarea name="summary" class="form-control" rows="2" required 
                                      placeholder="Brief summary appearing on homepage cards and search results..."><?= htmlspecialchars($service['summary'] ?? $service['description'] ?? '') ?></textarea>
                            <small class="text-muted">Recommended: 100 - 160 characters for optimal card layouts.</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. Inner Page Full Clinical Content Card -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="fw-bold mb-0">2. Inner Page Clinical Narrative & Patient Info</h5>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Full Inner Page Body Content</label>
                        <textarea name="content" class="form-control" rows="8" 
                                  placeholder="Provide detailed clinical information about this procedure, what patients can expect during the appointment, aftercare instructions, and benefits..."><?= htmlspecialchars($service['content'] ?? '') ?></textarea>
                        <small class="text-muted">Displayed on the dedicated service inner page (e.g. <code>/treatments/<?= htmlspecialchars($service['slug'] ?? 'service-slug') ?></code>).</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Meta Column (Right) -->
        <div class="col-lg-4">
            <!-- Status & Order Card -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="fw-bold mb-0">Publishing & Order</h5>
                </div>
                <div class="card-body p-4">
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" name="is_active" id="serviceActive" 
                               <?= ($service['is_active'] ?? true) ? 'checked' : '' ?>>
                        <label class="form-check-label fw-bold" for="serviceActive">Active on Website</label>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Display Sort Order</label>
                        <input type="number" name="display_order" class="form-control fw-bold" 
                               value="<?= htmlspecialchars((string)($service['display_order'] ?? 1)) ?>" min="1">
                        <small class="text-muted">Controls card order on homepage and inner service listings.</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold d-flex justify-content-between align-items-center">
                            <span>Icon Symbol (Material Symbols)</span>
                            <span class="badge bg-light text-success border">Material Symbol</span>
                        </label>
                        <div class="input-group mb-2">
                            <span class="input-group-text bg-success-subtle text-success border-success">
                                <span class="material-symbols-outlined fs-4" id="iconDisplay">
                                    <?= htmlspecialchars($service['icon'] ?? 'dentistry') ?>
                                </span>
                            </span>
                            <input type="text" name="icon" id="iconInput" class="form-control font-monospace fw-bold" 
                                   value="<?= htmlspecialchars($service['icon'] ?? 'dentistry') ?>" 
                                   placeholder="e.g. dentistry"
                                   oninput="updateIconDisplay(this.value)">
                        </div>

                        <!-- Clickable Icon Preset Selector Grid -->
                        <div class="border rounded-3 p-3 bg-light">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <small class="fw-bold text-dark">Click to Choose Clinical Icon:</small>
                                <small class="text-muted" style="font-size: 11px;">24 Clinical Presets</small>
                            </div>
                            <div class="d-flex flex-wrap gap-2" id="iconPickerGrid" style="max-height: 180px; overflow-y: auto;">
                                <?php 
                                $popularIcons = [
                                    ['name' => 'dentistry', 'label' => 'Tooth / Dentistry'],
                                    ['name' => 'clean_hands', 'label' => 'Hygiene & Clean'],
                                    ['name' => 'healing', 'label' => 'Fillings & Healing'],
                                    ['name' => 'vital_signs', 'label' => 'Root Canal'],
                                    ['name' => 'crown', 'label' => 'Crown & Bridge'],
                                    ['name' => 'auto_fix_high', 'label' => 'Aligners & Cosmetic'],
                                    ['name' => 'medical_services', 'label' => 'Surgery / Extraction'],
                                    ['name' => 'e911_emergency', 'label' => 'Emergency 911'],
                                    ['name' => 'sentiment_satisfied', 'label' => 'Gentle / Phobic'],
                                    ['name' => 'health_and_safety', 'label' => 'Health & Safety'],
                                    ['name' => 'local_hospital', 'label' => 'Surgery Clinic'],
                                    ['name' => 'medication', 'label' => 'Sedation / Meds'],
                                    ['name' => 'biotech', 'label' => 'Digital 3D Diagnostics'],
                                    ['name' => 'masks', 'label' => 'Sterilization'],
                                    ['name' => 'radiology', 'label' => 'Digital Radiography'],
                                    ['name' => 'monitor_heart', 'label' => 'Sedation Monitoring'],
                                    ['name' => 'emergency', 'label' => 'Acute Relief'],
                                    ['name' => 'star', 'label' => 'Boutique Whitening'],
                                    ['name' => 'verified', 'label' => 'CQC Regulated'],
                                    ['name' => 'schedule', 'label' => 'Routine Checkup'],
                                    ['name' => 'favorite', 'label' => 'Comfort Care'],
                                    ['name' => 'shield', 'label' => 'Patient Protection'],
                                    ['name' => 'child_care', 'label' => 'Pediatric Care'],
                                    ['name' => 'personal_injury', 'label' => 'Dental Trauma'],
                                ];
                                $curIcon = $service['icon'] ?? 'dentistry';
                                foreach ($popularIcons as $ico):
                                    $isSelected = ($ico['name'] === $curIcon);
                                ?>
                                    <button type="button" 
                                            class="btn btn-sm <?= $isSelected ? 'btn-success text-white' : 'btn-outline-secondary bg-white' ?> d-inline-flex align-items-center gap-1 icon-select-btn" 
                                            data-icon="<?= $ico['name'] ?>"
                                            onclick="selectPresetIcon('<?= $ico['name'] ?>')"
                                            title="<?= $ico['label'] ?>" 
                                            style="padding: 4px 8px; font-size: 12px; border-radius: 8px;">
                                        <span class="material-symbols-outlined" style="font-size: 18px;"><?= $ico['name'] ?></span>
                                        <span><?= $ico['name'] ?></span>
                                    </button>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Feature Image Upload Card -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="fw-bold mb-0">Feature Photography</h5>
                </div>
                <div class="card-body p-4 text-center">
                    <div class="mb-3">
                        <img src="<?= htmlspecialchars(!empty($service['feature_image']) ? $service['feature_image'] : App::url('/images/hero-patient.jpg')) ?>" 
                             alt="Feature Preview" class="preview-img-box w-100" style="height: 160px; object-fit: cover;" id="serviceFeaturePrev">
                    </div>
                    <div class="mb-3 text-start">
                        <label class="form-label small fw-bold">Upload Feature Image File</label>
                        <input type="file" name="feature_image_file" class="form-control form-control-sm" accept="image/*" 
                               onchange="previewImage(this, 'serviceFeaturePrev')">
                    </div>
                    <div class="text-start">
                        <label class="form-label small fw-bold">Or Direct Image URL / Path</label>
                        <input type="text" name="feature_image" class="form-control form-control-sm font-monospace" 
                               value="<?= htmlspecialchars($service['feature_image'] ?? '') ?>" 
                               placeholder="/images/hero-patient.jpg">
                    </div>
                </div>
            </div>

            <!-- Pricing & Duration Card -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="fw-bold mb-0">Pricing & Time</h5>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Starting Price / Tariff</label>
                        <input type="text" name="starting_price" class="form-control" 
                               value="<?= htmlspecialchars($service['starting_price'] ?? '') ?>" 
                               placeholder="e.g. From Â£65.00 or NHS Band 1 (Â£26.80)">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Estimated Duration</label>
                        <input type="text" name="duration" class="form-control" 
                               value="<?= htmlspecialchars($service['duration'] ?? '') ?>" 
                               placeholder="e.g. 30 mins or 45 mins">
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-semibold">CDT / Dental Code</label>
                        <input type="text" name="cdt_code" class="form-control font-monospace" 
                               value="<?= htmlspecialchars($service['cdt_code'] ?? '') ?>" 
                               placeholder="e.g. D0120">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Treatment Inner Page Sections (Matching HTML Inner Page Template) -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-white py-3 border-bottom">
            <h5 class="fw-bold mb-0"><i class="bi bi-file-earmark-richtext text-success me-2"></i> Treatment Inner Page Content (<code>/treatments/<?= htmlspecialchars($service['slug'] ?? 'slug') ?></code>)</h5>
        </div>
        <div class="card-body p-4 d-flex flex-column gap-3">
            <!-- Eyebrow -->
            <div>
                <label class="form-label small fw-bold">Hero Eyebrow Tagline</label>
                <input type="text" name="eyebrow" class="form-control form-control-sm" value="<?= htmlspecialchars($service['eyebrow'] ?? '') ?>" placeholder="e.g. GENERAL DENTISTRY â€¢ ACOCKS GREEN SURGERY">
            </div>

            <?php $flags = $service['section_flags'] ?? ['show_included' => true, 'show_journey' => true, 'show_pricing' => true, 'show_faqs' => true]; ?>

            <!-- 1. What's Included -->
            <div class="card border rounded-4 shadow-none bg-light section-item-card">
                <div class="card-header section-acc-header border-bottom">
                    <div class="section-acc-left">
                        <span class="badge bg-dark-subtle text-dark font-monospace section-order-badge">#1</span>
                        <span class="fw-bold text-dark section-name-display">What&apos;s Included / Clinical Overview (<?= count($includedItems) ?>)</span>
                    </div>
                    <div class="section-acc-right">
                        <div class="form-check form-switch m-0">
                            <input class="form-check-input" type="checkbox" name="section_flags[show_included]" value="1" id="flagInc" <?= ($flags['show_included'] ?? true) ? 'checked' : '' ?>>
                            <label class="form-check-label small fw-semibold" for="flagInc">Active</label>
                        </div>
                        <button type="button" class="section-toggle-btn collapsed" data-bs-toggle="collapse" data-bs-target="#svcIncCollapse" aria-expanded="false">
                            <i class="bi bi-plus-lg"></i>
                        </button>
                    </div>
                </div>
                <div class="collapse" id="svcIncCollapse">
                    <div class="card-body p-4 bg-white border-top">
                        <div class="d-flex justify-content-end mb-3">
                            <button type="button" class="btn btn-sm btn-outline-success rounded-pill" onclick="addSvcIncluded()"><i class="bi bi-plus-circle me-1"></i> Add Included Item</button>
                        </div>
                        <div class="row g-3" id="svcIncludedContainer">
                            <?php foreach ($includedItems as $iIdx => $inc): ?>
                                <div class="col-md-4 loop-svc-inc">
                                    <div class="p-3 bg-light rounded border h-100">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <div class="form-check form-switch m-0">
                                                <input class="form-check-input" type="checkbox" name="included_items[<?= $iIdx ?>][is_active]" value="1" <?= ($inc['is_active'] ?? true) ? 'checked' : '' ?>>
                                                <label class="form-check-label small fw-semibold">Active</label>
                                            </div>
                                            <div class="btn-group btn-group-sm">
                                                <button type="button" class="btn btn-outline-secondary" onclick="moveLoopCard(this, '.loop-svc-inc', -1)"><i class="bi bi-arrow-left"></i></button>
                                                <button type="button" class="btn btn-outline-secondary" onclick="moveLoopCard(this, '.loop-svc-inc', 1)"><i class="bi bi-arrow-right"></i></button>
                                                <button type="button" class="btn btn-outline-danger" onclick="removeLoopCard(this, '.loop-svc-inc')"><i class="bi bi-trash"></i></button>
                                            </div>
                                        </div>
                                        <label class="form-label small fw-bold">Icon</label>
                                        <div class="mb-2"><?php renderIconPickerInput("included_items[{$iIdx}][icon]", $inc['icon'] ?? 'clinical_notes', 'clinical_notes'); ?></div>
                                        <label class="form-label small fw-bold">Title</label>
                                        <input type="text" name="included_items[<?= $iIdx ?>][title]" class="form-control form-control-sm fw-bold mb-2" value="<?= htmlspecialchars($inc['title'] ?? '') ?>">
                                        <label class="form-label small fw-bold">Description</label>
                                        <textarea name="included_items[<?= $iIdx ?>][desc]" class="form-control form-control-sm" rows="3"><?= htmlspecialchars($inc['desc'] ?? '') ?></textarea>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. Patient Journey -->
            <div class="card border rounded-4 shadow-none bg-light section-item-card">
                <div class="card-header section-acc-header border-bottom">
                    <div class="section-acc-left">
                        <span class="badge bg-dark-subtle text-dark font-monospace section-order-badge">#2</span>
                        <span class="fw-bold text-dark section-name-display">Patient Step-by-Step Journey (<?= count($journeySteps) ?>)</span>
                    </div>
                    <div class="section-acc-right">
                        <div class="form-check form-switch m-0">
                            <input class="form-check-input" type="checkbox" name="section_flags[show_journey]" value="1" id="flagJrn" <?= ($flags['show_journey'] ?? true) ? 'checked' : '' ?>>
                            <label class="form-check-label small fw-semibold" for="flagJrn">Active</label>
                        </div>
                        <button type="button" class="section-toggle-btn collapsed" data-bs-toggle="collapse" data-bs-target="#svcJourneyCollapse" aria-expanded="false">
                            <i class="bi bi-plus-lg"></i>
                        </button>
                    </div>
                </div>
                <div class="collapse" id="svcJourneyCollapse">
                    <div class="card-body p-4 bg-white border-top">
                        <div class="d-flex justify-content-end mb-3">
                            <button type="button" class="btn btn-sm btn-outline-success rounded-pill" onclick="addSvcJourney()"><i class="bi bi-plus-circle me-1"></i> Add Journey Step</button>
                        </div>
                        <div class="row g-3" id="svcJourneyContainer">
                            <?php foreach ($journeySteps as $jIdx => $js): ?>
                                <div class="col-md-3 loop-svc-jrn">
                                    <div class="p-3 bg-light rounded border h-100">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <div class="form-check form-switch m-0">
                                                <input class="form-check-input" type="checkbox" name="journey_steps[<?= $jIdx ?>][is_active]" value="1" <?= ($js['is_active'] ?? true) ? 'checked' : '' ?>>
                                                <label class="form-check-label small fw-semibold">Active</label>
                                            </div>
                                            <div class="btn-group btn-group-sm">
                                                <button type="button" class="btn btn-outline-secondary" onclick="moveLoopCard(this, '.loop-svc-jrn', -1)"><i class="bi bi-arrow-left"></i></button>
                                                <button type="button" class="btn btn-outline-secondary" onclick="moveLoopCard(this, '.loop-svc-jrn', 1)"><i class="bi bi-arrow-right"></i></button>
                                                <button type="button" class="btn btn-outline-danger" onclick="removeLoopCard(this, '.loop-svc-jrn')"><i class="bi bi-trash"></i></button>
                                            </div>
                                        </div>
                                        <label class="form-label small fw-bold">Step #</label>
                                        <input type="text" name="journey_steps[<?= $jIdx ?>][step]" class="form-control form-control-sm font-monospace mb-2" value="<?= htmlspecialchars($js['step'] ?? sprintf('%02d', $jIdx + 1)) ?>">
                                        <label class="form-label small fw-bold">Step Title</label>
                                        <input type="text" name="journey_steps[<?= $jIdx ?>][title]" class="form-control form-control-sm fw-bold mb-2" value="<?= htmlspecialchars($js['title'] ?? '') ?>">
                                        <label class="form-label small fw-bold">Description</label>
                                        <textarea name="journey_steps[<?= $jIdx ?>][desc]" class="form-control form-control-sm" rows="3"><?= htmlspecialchars($js['desc'] ?? '') ?></textarea>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3. Pricing Options -->
            <div class="card border rounded-4 shadow-none bg-light section-item-card">
                <div class="card-header section-acc-header border-bottom">
                    <div class="section-acc-left">
                        <span class="badge bg-dark-subtle text-dark font-monospace section-order-badge">#3</span>
                        <span class="fw-bold text-dark section-name-display">Transparent Pricing Tiers (<?= count($pricingOptions) ?>)</span>
                    </div>
                    <div class="section-acc-right">
                        <div class="form-check form-switch m-0">
                            <input class="form-check-input" type="checkbox" name="section_flags[show_pricing]" value="1" id="flagPrc" <?= ($flags['show_pricing'] ?? true) ? 'checked' : '' ?>>
                            <label class="form-check-label small fw-semibold" for="flagPrc">Active</label>
                        </div>
                        <button type="button" class="section-toggle-btn collapsed" data-bs-toggle="collapse" data-bs-target="#svcPricingCollapse" aria-expanded="false">
                            <i class="bi bi-plus-lg"></i>
                        </button>
                    </div>
                </div>
                <div class="collapse" id="svcPricingCollapse">
                    <div class="card-body p-4 bg-white border-top">
                        <div class="d-flex justify-content-end mb-3">
                            <button type="button" class="btn btn-sm btn-outline-success rounded-pill" onclick="addSvcPricing()"><i class="bi bi-plus-circle me-1"></i> Add Pricing Tier</button>
                        </div>
                        <div class="row g-3" id="svcPricingContainer">
                            <?php foreach ($pricingOptions as $pIdx => $po): ?>
                                <div class="col-md-4 loop-svc-prc">
                                    <div class="p-3 bg-light rounded border h-100">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <div class="form-check form-switch m-0">
                                                <input class="form-check-input" type="checkbox" name="pricing_options[<?= $pIdx ?>][is_active]" value="1" <?= ($po['is_active'] ?? true) ? 'checked' : '' ?>>
                                                <label class="form-check-label small fw-semibold">Active</label>
                                            </div>
                                            <div class="btn-group btn-group-sm">
                                                <button type="button" class="btn btn-outline-secondary" onclick="moveLoopCard(this, '.loop-svc-prc', -1)"><i class="bi bi-arrow-left"></i></button>
                                                <button type="button" class="btn btn-outline-secondary" onclick="moveLoopCard(this, '.loop-svc-prc', 1)"><i class="bi bi-arrow-right"></i></button>
                                                <button type="button" class="btn btn-outline-danger" onclick="removeLoopCard(this, '.loop-svc-prc')"><i class="bi bi-trash"></i></button>
                                            </div>
                                        </div>
                                        <input type="text" name="pricing_options[<?= $pIdx ?>][title]" class="form-control form-control-sm fw-bold mb-2" value="<?= htmlspecialchars($po['title'] ?? '') ?>" placeholder="Tier Title">
                                        <div class="row g-2 mb-2">
                                            <div class="col-6"><input type="text" name="pricing_options[<?= $pIdx ?>][badge]" class="form-control form-control-sm" value="<?= htmlspecialchars($po['badge'] ?? '') ?>" placeholder="Badge"></div>
                                            <div class="col-6"><input type="text" name="pricing_options[<?= $pIdx ?>][price]" class="form-control form-control-sm fw-bold" value="<?= htmlspecialchars($po['price'] ?? '') ?>" placeholder="Price"></div>
                                        </div>
                                        <label class="form-label small fw-bold">Features (one per line)</label>
                                        <textarea name="pricing_options[<?= $pIdx ?>][features_text]" class="form-control form-control-sm mb-2" rows="3"><?= htmlspecialchars(implode("\n", $po['features'] ?? [])) ?></textarea>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="pricing_options[<?= $pIdx ?>][is_featured]" value="1" id="poFeat<?= $pIdx ?>" <?= !empty($po['is_featured']) ? 'checked' : '' ?>>
                                            <label class="form-check-label small fw-semibold" for="poFeat<?= $pIdx ?>">Highlight as Popular</label>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 4. FAQs -->
            <div class="card border rounded-4 shadow-none bg-light section-item-card">
                <div class="card-header section-acc-header border-bottom">
                    <div class="section-acc-left">
                        <span class="badge bg-dark-subtle text-dark font-monospace section-order-badge">#4</span>
                        <span class="fw-bold text-dark section-name-display">Treatment FAQs (<?= count($faqs) ?>)</span>
                    </div>
                    <div class="section-acc-right">
                        <div class="form-check form-switch m-0">
                            <input class="form-check-input" type="checkbox" name="section_flags[show_faqs]" value="1" id="flagFaq" <?= ($flags['show_faqs'] ?? true) ? 'checked' : '' ?>>
                            <label class="form-check-label small fw-semibold" for="flagFaq">Active</label>
                        </div>
                        <button type="button" class="section-toggle-btn collapsed" data-bs-toggle="collapse" data-bs-target="#svcFaqCollapse" aria-expanded="false">
                            <i class="bi bi-plus-lg"></i>
                        </button>
                    </div>
                </div>
                <div class="collapse" id="svcFaqCollapse">
                    <div class="card-body p-4 bg-white border-top">
                        <div class="d-flex justify-content-end mb-3">
                            <button type="button" class="btn btn-sm btn-outline-success rounded-pill" onclick="addSvcFaq()"><i class="bi bi-plus-circle me-1"></i> Add FAQ</button>
                        </div>
                        <div class="row g-3" id="svcFaqContainer">
                            <?php foreach ($faqs as $fIdx => $fq): ?>
                                <div class="col-md-4 loop-svc-faq">
                                    <div class="p-3 bg-light rounded border h-100">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <div class="form-check form-switch m-0">
                                                <input class="form-check-input" type="checkbox" name="faqs[<?= $fIdx ?>][is_active]" value="1" <?= ($fq['is_active'] ?? true) ? 'checked' : '' ?>>
                                                <label class="form-check-label small fw-semibold">Active</label>
                                            </div>
                                            <div class="btn-group btn-group-sm">
                                                <button type="button" class="btn btn-outline-secondary" onclick="moveLoopCard(this, '.loop-svc-faq', -1)"><i class="bi bi-arrow-left"></i></button>
                                                <button type="button" class="btn btn-outline-secondary" onclick="moveLoopCard(this, '.loop-svc-faq', 1)"><i class="bi bi-arrow-right"></i></button>
                                                <button type="button" class="btn btn-outline-danger" onclick="removeLoopCard(this, '.loop-svc-faq')"><i class="bi bi-trash"></i></button>
                                            </div>
                                        </div>
                                        <label class="form-label small fw-bold">Question</label>
                                        <input type="text" name="faqs[<?= $fIdx ?>][question]" class="form-control form-control-sm fw-bold mb-2" value="<?= htmlspecialchars($fq['question'] ?? '') ?>">
                                        <label class="form-label small fw-bold">Answer</label>
                                        <textarea name="faqs[<?= $fIdx ?>][answer]" class="form-control form-control-sm" rows="3"><?= htmlspecialchars($fq['answer'] ?? '') ?></textarea>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script>
function addSvcIncluded() {
    const idx = Date.now();
    document.getElementById('svcIncludedContainer').insertAdjacentHTML('beforeend', `
    <div class="col-md-4 loop-svc-inc">
        <div class="p-3 bg-light rounded border h-100">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div class="form-check form-switch m-0"><input class="form-check-input" type="checkbox" name="included_items[${idx}][is_active]" value="1" checked><label class="form-check-label small fw-semibold">Active</label></div>
                <div class="btn-group btn-group-sm">
                    <button type="button" class="btn btn-outline-secondary" onclick="moveLoopCard(this, '.loop-svc-inc', -1)"><i class="bi bi-arrow-left"></i></button>
                    <button type="button" class="btn btn-outline-secondary" onclick="moveLoopCard(this, '.loop-svc-inc', 1)"><i class="bi bi-arrow-right"></i></button>
                    <button type="button" class="btn btn-outline-danger" onclick="removeLoopCard(this, '.loop-svc-inc')"><i class="bi bi-trash"></i></button>
                </div>
            </div>
            <label class="form-label small fw-bold">Icon</label>
            <div class="mb-2"><div class="input-group input-group-sm icon-picker-group"><span class="input-group-text bg-white"><span class="material-symbols-outlined icon-picker-preview" style="font-size:18px; color:#0d631b;">clinical_notes</span></span><input type="text" name="included_items[${idx}][icon]" class="form-control font-monospace icon-picker-input" value="clinical_notes"><button type="button" class="btn btn-outline-secondary" onclick="openIconPicker(this)"><i class="bi bi-grid-3x3-gap"></i></button></div></div>
            <label class="form-label small fw-bold">Title</label>
            <input type="text" name="included_items[${idx}][title]" class="form-control form-control-sm fw-bold mb-2" placeholder="Item Title">
            <label class="form-label small fw-bold">Description</label>
            <textarea name="included_items[${idx}][desc]" class="form-control form-control-sm" rows="3" placeholder="Description"></textarea>
        </div>
    </div>`);
}
function addSvcJourney() {
    const idx = Date.now();
    document.getElementById('svcJourneyContainer').insertAdjacentHTML('beforeend', `
    <div class="col-md-3 loop-svc-jrn">
        <div class="p-3 bg-light rounded border h-100">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div class="form-check form-switch m-0"><input class="form-check-input" type="checkbox" name="journey_steps[${idx}][is_active]" value="1" checked><label class="form-check-label small fw-semibold">Active</label></div>
                <div class="btn-group btn-group-sm">
                    <button type="button" class="btn btn-outline-secondary" onclick="moveLoopCard(this, '.loop-svc-jrn', -1)"><i class="bi bi-arrow-left"></i></button>
                    <button type="button" class="btn btn-outline-secondary" onclick="moveLoopCard(this, '.loop-svc-jrn', 1)"><i class="bi bi-arrow-right"></i></button>
                    <button type="button" class="btn btn-outline-danger" onclick="removeLoopCard(this, '.loop-svc-jrn')"><i class="bi bi-trash"></i></button>
                </div>
            </div>
            <label class="form-label small fw-bold">Step #</label>
            <input type="text" name="journey_steps[${idx}][step]" class="form-control form-control-sm font-monospace mb-2" value="05">
            <label class="form-label small fw-bold">Step Title</label>
            <input type="text" name="journey_steps[${idx}][title]" class="form-control form-control-sm fw-bold mb-2" placeholder="Step Title">
            <label class="form-label small fw-bold">Description</label>
            <textarea name="journey_steps[${idx}][desc]" class="form-control form-control-sm" rows="3" placeholder="Description"></textarea>
        </div>
    </div>`);
}
function addSvcPricing() {
    const idx = Date.now();
    document.getElementById('svcPricingContainer').insertAdjacentHTML('beforeend', `
    <div class="col-md-4 loop-svc-prc">
        <div class="p-3 bg-light rounded border h-100">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div class="form-check form-switch m-0"><input class="form-check-input" type="checkbox" name="pricing_options[${idx}][is_active]" value="1" checked><label class="form-check-label small fw-semibold">Active</label></div>
                <div class="btn-group btn-group-sm">
                    <button type="button" class="btn btn-outline-secondary" onclick="moveLoopCard(this, '.loop-svc-prc', -1)"><i class="bi bi-arrow-left"></i></button>
                    <button type="button" class="btn btn-outline-secondary" onclick="moveLoopCard(this, '.loop-svc-prc', 1)"><i class="bi bi-arrow-right"></i></button>
                    <button type="button" class="btn btn-outline-danger" onclick="removeLoopCard(this, '.loop-svc-prc')"><i class="bi bi-trash"></i></button>
                </div>
            </div>
            <input type="text" name="pricing_options[${idx}][title]" class="form-control form-control-sm fw-bold mb-2" placeholder="Tier Title">
            <div class="row g-2 mb-2">
                <div class="col-6"><input type="text" name="pricing_options[${idx}][badge]" class="form-control form-control-sm" placeholder="Badge"></div>
                <div class="col-6"><input type="text" name="pricing_options[${idx}][price]" class="form-control form-control-sm fw-bold" placeholder="Price"></div>
            </div>
            <label class="form-label small fw-bold">Features (one per line)</label>
            <textarea name="pricing_options[${idx}][features_text]" class="form-control form-control-sm mb-2" rows="3" placeholder="Feature 1&#10;Feature 2"></textarea>
            <div class="form-check"><input class="form-check-input" type="checkbox" name="pricing_options[${idx}][is_featured]" value="1"><label class="form-check-label small fw-semibold">Highlight as Popular</label></div>
        </div>
    </div>`);
}
function addSvcFaq() {
    const idx = Date.now();
    document.getElementById('svcFaqContainer').insertAdjacentHTML('beforeend', `
    <div class="col-md-4 loop-svc-faq">
        <div class="p-3 bg-light rounded border h-100">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div class="form-check form-switch m-0"><input class="form-check-input" type="checkbox" name="faqs[${idx}][is_active]" value="1" checked><label class="form-check-label small fw-semibold">Active</label></div>
                <div class="btn-group btn-group-sm">
                    <button type="button" class="btn btn-outline-secondary" onclick="moveLoopCard(this, '.loop-svc-faq', -1)"><i class="bi bi-arrow-left"></i></button>
                    <button type="button" class="btn btn-outline-secondary" onclick="moveLoopCard(this, '.loop-svc-faq', 1)"><i class="bi bi-arrow-right"></i></button>
                    <button type="button" class="btn btn-outline-danger" onclick="removeLoopCard(this, '.loop-svc-faq')"><i class="bi bi-trash"></i></button>
                </div>
            </div>
            <label class="form-label small fw-bold">Question</label>
            <input type="text" name="faqs[${idx}][question]" class="form-control form-control-sm fw-bold mb-2" placeholder="Question?">
            <label class="form-label small fw-bold">Answer</label>
            <textarea name="faqs[${idx}][answer]" class="form-control form-control-sm" rows="3" placeholder="Answer..."></textarea>
        </div>
    </div>`);
}
</script>
    <!-- Sticky Action Footer -->
    <div class="sticky-bottom bg-white p-3 rounded-4 shadow-lg border d-flex justify-content-between align-items-center mb-4">
        <a href="<?= App::url('/admin/components/services') ?>" class="btn btn-outline-secondary px-4 py-2 rounded-pill">
            Cancel
        </a>
        <button type="submit" class="btn btn-brand px-5 py-2 rounded-pill shadow">
            <i class="bi bi-check2-circle me-1"></i> <?= $isEdit ? 'Update Service' : 'Save New Service' ?>
        </button>
    </div>
</form>

<script>
function autoGenerateSlug(title) {
    <?php if (!$isEdit): ?>
    const slug = title.toLowerCase()
        .replace(/[^a-z0-9 -]/g, '')
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-');
    document.getElementById('serviceSlug').value = slug;
    <?php endif; ?>
}

function previewImage(input, previewId) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById(previewId).src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function updateIconDisplay(val) {
    const icon = val.trim() || 'dentistry';
    document.getElementById('iconDisplay').textContent = icon;
    // Highlight matching button if any
    document.querySelectorAll('.icon-select-btn').forEach(btn => {
        if (btn.getAttribute('data-icon') === icon) {
            btn.className = 'btn btn-sm btn-success text-white d-inline-flex align-items-center gap-1 icon-select-btn';
        } else {
            btn.className = 'btn btn-sm btn-outline-secondary bg-white d-inline-flex align-items-center gap-1 icon-select-btn';
        }
    });
}

function selectPresetIcon(iconName) {
    document.getElementById('iconInput').value = iconName;
    updateIconDisplay(iconName);
}
</script>

