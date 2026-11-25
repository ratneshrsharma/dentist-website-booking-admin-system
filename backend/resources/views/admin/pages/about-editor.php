<?php

declare(strict_types=1);

use App\Core\App;

$hero = $about['hero'] ?? [];
$sections = $about['sections'] ?? [];
$whyUs = $about['why_us'] ?? [];
$pillars = $whyUs['pillars'] ?? [];
$stats = $whyUs['stats'] ?? [];
$clinics = $about['clinics'] ?? [];
$clinicFeatures = $clinics['features'] ?? [];
$charter = $about['safety_charter'] ?? [];
$charterCards = $charter['cards'] ?? [];
$emergencyBox = $charter['emergency_box'] ?? [];
$seo = $about['seo'] ?? [];

$trustBadges = $hero['trust_badges'] ?? [
    ['icon' => 'local_hospital', 'label' => 'NHS & Private'],
    ['icon' => 'verified_user', 'label' => 'CQC Regulated'],
    ['icon' => 'workspace_premium', 'label' => 'BDA Member'],
    ['icon' => 'military_tech', 'label' => 'Award-Winning'],
];

require __DIR__ . '/_editor-styles.php';
?>

<div class="row mb-4 align-items-center">
    <div class="col-md-8">
        <div class="d-flex align-items-center gap-2 mb-1">
            <a href="<?= App::url('/admin/pages') ?>" class="text-decoration-none text-muted small">
                <i class="bi bi-arrow-left"></i> Back to Page List
            </a>
            <span class="text-muted small">/</span>
            <span class="text-success small fw-semibold">About Page Editor</span>
        </div>
        <h2 class="fw-bold text-dark mb-0">
            <i class="bi bi-info-circle text-success me-2"></i> About Page Content &amp; Sections Editor
        </h2>
        <p class="text-muted small mb-0">
            Manage hero banner, trust badges, dynamic page sections (Common Components, Other Pages, Custom Content), and SEO metadata. HTML tags like <code>&lt;br /&gt;</code> and <code>&lt;strong&gt;</code> are supported.
        </p>
    </div>
    <div class="col-md-4 text-md-end mt-3 mt-md-0">
        <a href="<?= App::url('/about-us') ?>" target="_blank" class="btn btn-outline-secondary rounded-pill shadow-sm">
            <i class="bi bi-box-arrow-up-right me-1"></i> Preview Live About Page
        </a>
    </div>
</div>

<form action="<?= App::url('/admin/pages/about-us/edit') ?>" method="POST" enctype="multipart/form-data" id="aboutEditorForm">
    <!-- Unified 3-Tab Navigation (Banner, Content, SEO & Metadata) -->
    <ul class="nav cms-editor-tabs mb-4" id="aboutEditorTabs" role="tablist">
        <li class="nav-item">
            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#sec-hero" type="button">
                <i class="bi bi-image"></i> 1. Banner &amp; CTAs
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#sec-composition" type="button">
                <i class="bi bi-layers-fill"></i> 2. Content Sections (<?= count($sections) ?>)
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#sec-seo" type="button">
                <i class="bi bi-search"></i> 3. SEO &amp; Metadata
            </button>
        </li>
    </ul>

    <div class="tab-content">
        <!-- ============================================================== -->
        <!-- 1. BANNER & CTAs TAB -->
        <!-- ============================================================== -->
        <div class="tab-pane fade show active" id="sec-hero">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="fw-bold mb-0">Hero Banner, Team Image, Trust Badges &amp; CTAs</h5>
                </div>
                <div class="card-body p-4">
                    <!-- Hero Team Image Upload with Live Preview -->
                    <div class="row g-4 align-items-center mb-4 pb-4 border-bottom">
                        <div class="col-md-3 text-center">
                            <label class="form-label fw-bold d-block mb-2">Current Hero Image</label>
                            <img src="<?= htmlspecialchars($hero['image'] ?? App::url('/uploads/about-us/about-team.jpg')) ?>"
                                 alt="About Hero Team" class="preview-img-box shadow-sm mb-2 rounded-3" id="aboutHeroPreview" style="width: 160px; height: 110px; object-fit: cover;">
                            <small class="d-block text-muted">Saved in <code>uploads/about-us/</code></small>
                        </div>
                        <div class="col-md-9">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Upload New Team Image File</label>
                                <input type="file" name="hero_image_file" class="form-control" accept="image/*" onchange="previewAboutImg(this, 'aboutHeroPreview')">
                            </div>
                            <div class="row g-2">
                                <div class="col-md-7">
                                    <label class="form-label fw-semibold">Or Direct Image URL / Path</label>
                                    <input type="text" name="hero_image_manual" class="form-control font-monospace" value="<?= htmlspecialchars($hero['image'] ?? '') ?>">
                                </div>
                                <div class="col-md-5">
                                    <label class="form-label fw-semibold">Image Caption</label>
                                    <input type="text" name="hero_image_caption" class="form-control" value="<?= htmlspecialchars($hero['image_caption'] ?? '') ?>">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Headlines & Story -->
                    <div class="row g-3 mb-4 pb-4 border-bottom">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Eyebrow Tagline</label>
                            <input type="text" name="hero_eyebrow" class="form-control" value="<?= htmlspecialchars($hero['eyebrow'] ?? '') ?>">
                        </div>
                        <div class="col-md-8">
                            <label class="form-label fw-semibold">Headline Title (HTML tags supported)</label>
                            <input type="text" name="hero_headline" class="form-control fw-bold" value="<?= htmlspecialchars($hero['headline'] ?? '') ?>">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Practice Story &amp; Subtitle (HTML tags supported)</label>
                            <textarea name="hero_subtitle" class="form-control" rows="3"><?= htmlspecialchars($hero['subtitle'] ?? '') ?></textarea>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Primary CTA Text</label>
                            <input type="text" name="hero_cta_primary" class="form-control" value="<?= htmlspecialchars($hero['cta_primary'] ?? 'Meet Our Team') ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Primary CTA Link</label>
                            <input type="text" name="hero_cta_primary_link" class="form-control font-monospace" value="<?= htmlspecialchars($hero['cta_primary_link'] ?? '#our-team') ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Secondary CTA Text</label>
                            <input type="text" name="hero_cta_secondary" class="form-control" value="<?= htmlspecialchars($hero['cta_secondary'] ?? '0121 765 2870') ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Secondary CTA Link</label>
                            <input type="text" name="hero_cta_secondary_link" class="form-control font-monospace" value="<?= htmlspecialchars($hero['cta_secondary_link'] ?? 'tel:+441217652870') ?>">
                        </div>
                    </div>

                    <!-- 4 Hero Trust Badges -->
                    <h6 class="fw-bold text-secondary mb-3">Hero Trust Badges (4 Items)</h6>
                    <div class="row g-3">
                        <?php foreach ($trustBadges as $bIdx => $tb):
                            $tbIcon = is_array($tb) ? ($tb['icon'] ?? 'verified_user') : 'verified_user';
                            $tbLabel = is_array($tb) ? ($tb['label'] ?? '') : (string)$tb;
                        ?>
                            <div class="col-md-3">
                                <div class="p-3 bg-light rounded-3 border">
                                    <label class="form-label small fw-bold">Material Icon #<?= $bIdx + 1 ?></label>
                                    <input type="text" name="trust_badge_icons[]" class="form-control form-control-sm font-monospace mb-2" value="<?= htmlspecialchars($tbIcon) ?>">
                                    <label class="form-label small fw-bold">Badge Label</label>
                                    <input type="text" name="trust_badge_labels[]" class="form-control form-control-sm fw-semibold" value="<?= htmlspecialchars($tbLabel) ?>">
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- ============================================================== -->
        <!-- 2. CONTENT SECTIONS COMPOSITION ENGINE -->
        <!-- ============================================================== -->
        <div class="tab-pane fade" id="sec-composition">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div>
                        <h5 class="fw-bold mb-0">
                            <i class="bi bi-layers-fill text-success me-2"></i> About Page Sections Composition Engine
                        </h5>
                        <small class="text-muted">Reorder sections (▲/▼), toggle visibility, edit embedded cards/pillars/amenities, or add Common Components, Other Pages, and New Content sections.</small>
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
                                No sections added yet. Click "+ Add New Section" to build your About page layout.
                            </div>
                        <?php else: ?>
                            <?php foreach ($sections as $idx => $sec):
                                $secId = $sec['id'] ?? ('sec_' . ($idx + 1));
                                $secType = $sec['type'] ?? 'custom_content';
                                $secCat = $sec['category'] ?? 'prebuilt';
                            ?>
                                <div class="card border rounded-4 shadow-none bg-light section-item-card" id="sectionCard_<?= htmlspecialchars($secId) ?>" data-section-id="<?= htmlspecialchars($secId) ?>">
                                    <!-- Accordion Header (Left/Right aligned, +/- at far right, collapsed by default) -->
                                    <div class="card-header section-acc-header border-bottom">
                                        <div class="section-acc-left">
                                            <div class="btn-group btn-group-sm">
                                                <button type="button" class="btn btn-outline-secondary" onclick="moveSectionUp(this)" title="Move Up"><i class="bi bi-arrow-up"></i></button>
                                                <button type="button" class="btn btn-outline-secondary" onclick="moveSectionDown(this)" title="Move Down"><i class="bi bi-arrow-down"></i></button>
                                            </div>
                                            <span class="badge bg-dark-subtle text-dark font-monospace section-order-badge">#<?= $sec['order'] ?? ($idx + 1) ?></span>
                                            <div>
                                                <span class="fw-bold text-dark section-name-display"><?= htmlspecialchars($sec['name'] ?? $sec['title'] ?? 'Section') ?></span>
                                                <span class="badge ms-2 section-cat-badge <?= $secCat === 'prebuilt' ? 'bg-primary-subtle text-primary' : ($secCat === 'page_snippet' ? 'bg-info-subtle text-info' : 'bg-success-subtle text-success') ?>">
                                                    <?= ucfirst(str_replace('_', ' ', $secCat)) ?> (<?= htmlspecialchars($secType) ?>)
                                                </span>
                                            </div>
                                        </div>
                                        <div class="section-acc-right">
                                            <div class="form-check form-switch m-0">
                                                <input class="form-check-input" type="checkbox" name="sections[<?= $idx ?>][is_active]" value="1"
                                                       id="secActive_<?= htmlspecialchars($secId) ?>" <?= ($sec['is_active'] ?? true) ? 'checked' : '' ?>>
                                                <label class="form-check-label small fw-semibold" for="secActive_<?= htmlspecialchars($secId) ?>">Active</label>
                                            </div>
                                            <button type="button" class="btn btn-sm btn-outline-danger rounded-circle" onclick="removeSection(this)" title="Remove Section">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                            <button type="button" class="section-toggle-btn collapsed" data-bs-toggle="collapse" data-bs-target="#secCollapse_<?= htmlspecialchars($secId) ?>" aria-expanded="false" title="Expand / Collapse">
                                                <i class="bi bi-plus-lg"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Accordion Body (Collapsed by default) -->
                                    <div class="collapse" id="secCollapse_<?= htmlspecialchars($secId) ?>">
                                        <div class="card-body p-4 bg-white border-top">
                                            <input type="hidden" name="sections[<?= $idx ?>][id]" value="<?= htmlspecialchars($secId) ?>">
                                            <input type="hidden" name="sections[<?= $idx ?>][type]" value="<?= htmlspecialchars($secType) ?>">
                                            <input type="hidden" name="sections[<?= $idx ?>][category]" value="<?= htmlspecialchars($secCat) ?>">
                                            <input type="hidden" name="sections[<?= $idx ?>][name]" value="<?= htmlspecialchars($sec['name'] ?? '') ?>">
                                            <input type="hidden" name="sections[<?= $idx ?>][page_slug]" value="<?= htmlspecialchars($sec['page_slug'] ?? '') ?>">
                                            <input type="hidden" class="section-order-input" name="sections[<?= $idx ?>][order]" value="<?= htmlspecialchars((string)($sec['order'] ?? ($idx + 1))) ?>">

                                            <div class="row g-3">
                                                <div class="col-md-4">
                                                    <label class="form-label small fw-semibold">Eyebrow Tagline</label>
                                                    <input type="text" name="sections[<?= $idx ?>][eyebrow]" class="form-control form-control-sm" value="<?= htmlspecialchars($sec['eyebrow'] ?? '') ?>">
                                                </div>
                                                <div class="col-md-8">
                                                    <label class="form-label small fw-semibold">Section Main Title (HTML tags supported)</label>
                                                    <input type="text" name="sections[<?= $idx ?>][title]" class="form-control form-control-sm fw-bold" value="<?= htmlspecialchars($sec['title'] ?? '') ?>">
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label small fw-semibold">Section Summary / Subtitle (HTML tags supported)</label>
                                                    <textarea name="sections[<?= $idx ?>][summary]" class="form-control form-control-sm" rows="2"><?= htmlspecialchars($sec['summary'] ?? '') ?></textarea>
                                                </div>

                                                <?php if ($secType === 'custom_content' || $secType === 'page_snippet'): ?>
                                                    <div class="col-12">
                                                        <label class="form-label small fw-semibold">Full Description Body (HTML supported)</label>
                                                        <textarea name="sections[<?= $idx ?>][description]" class="form-control form-control-sm" rows="3"><?= htmlspecialchars($sec['description'] ?? '') ?></textarea>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label small fw-semibold">Column Layout</label>
                                                        <select name="sections[<?= $idx ?>][column_layout]" class="form-select form-select-sm">
                                                            <option value="two_col_split" <?= ($sec['column_layout'] ?? '') === 'two_col_split' ? 'selected' : '' ?>>2-Column Split</option>
                                                            <option value="full_width" <?= ($sec['column_layout'] ?? '') === 'full_width' ? 'selected' : '' ?>>Full-Width</option>
                                                            <option value="action_bar" <?= ($sec['column_layout'] ?? '') === 'action_bar' ? 'selected' : '' ?>>Action Banner</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label small fw-semibold">Image Position</label>
                                                        <select name="sections[<?= $idx ?>][image_position]" class="form-select form-select-sm">
                                                            <option value="left" <?= ($sec['image_position'] ?? '') === 'left' ? 'selected' : '' ?>>Image Left</option>
                                                            <option value="right" <?= ($sec['image_position'] ?? '') === 'right' ? 'selected' : '' ?>>Image Right</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label small fw-semibold">Feature Image</label>
                                                        <input type="file" name="section_image_files[<?= $idx ?>]" class="form-control form-control-sm mb-1" accept="image/*">
                                                        <input type="text" name="sections[<?= $idx ?>][feature_image]" class="form-control form-control-sm font-monospace" value="<?= htmlspecialchars($sec['feature_image'] ?? '') ?>">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label small fw-semibold">CTA Button Text</label>
                                                        <input type="text" name="sections[<?= $idx ?>][cta_text]" class="form-control form-control-sm" value="<?= htmlspecialchars($sec['cta_text'] ?? '') ?>">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label small fw-semibold">CTA Button Link</label>
                                                        <input type="text" name="sections[<?= $idx ?>][cta_link]" class="form-control form-control-sm font-monospace" value="<?= htmlspecialchars($sec['cta_link'] ?? '') ?>">
                                                    </div>
                                                <?php endif; ?>

                                                <!-- Specialized Sub-Editors Inside Accordion -->
                                                <?php if ($secType === 'why_us_block'): ?>
                                                    <div class="col-12 mt-3 pt-3 border-top">
                                                        <h6 class="fw-bold text-success mb-2"><i class="bi bi-bar-chart-fill me-1"></i> Key Practice Statistics (4 Milestones)</h6>
                                                        <div class="row g-2 mb-3">
                                                            <?php foreach ($stats as $sIdx => $st): ?>
                                                                <div class="col-md-3">
                                                                    <div class="p-2 bg-light rounded border">
                                                                        <input type="text" name="stats[<?= $sIdx ?>][value]" class="form-control form-control-sm fw-bold mb-1" value="<?= htmlspecialchars($st['value'] ?? '') ?>" placeholder="25+">
                                                                        <input type="text" name="stats[<?= $sIdx ?>][label]" class="form-control form-control-sm mb-1" value="<?= htmlspecialchars($st['label'] ?? '') ?>" placeholder="Label">
                                                                        <input type="text" name="stats[<?= $sIdx ?>][desc]" class="form-control form-control-sm" value="<?= htmlspecialchars($st['desc'] ?? '') ?>" placeholder="Sub-description">
                                                                    </div>
                                                                </div>
                                                            <?php endforeach; ?>
                                                        </div>
                                                        <h6 class="fw-bold text-success mb-2"><i class="bi bi-shield-check me-1"></i> 4 Clinical Ethos Pillars</h6>
                                                        <div class="row g-2">
                                                            <?php foreach ($pillars as $pIdx => $pl): ?>
                                                                <div class="col-md-6">
                                                                    <div class="p-3 bg-light rounded border">
                                                                        <div class="row g-2">
                                                                            <div class="col-4">
                                                                                <label class="form-label small fw-bold">Icon</label>
                                                                                <input type="text" name="pillars[<?= $pIdx ?>][icon]" class="form-control form-control-sm font-monospace" value="<?= htmlspecialchars($pl['icon'] ?? 'spa') ?>">
                                                                            </div>
                                                                            <div class="col-8">
                                                                                <label class="form-label small fw-bold">Pillar Title</label>
                                                                                <input type="text" name="pillars[<?= $pIdx ?>][title]" class="form-control form-control-sm fw-bold" value="<?= htmlspecialchars($pl['title'] ?? '') ?>">
                                                                            </div>
                                                                            <div class="col-12">
                                                                                <textarea name="pillars[<?= $pIdx ?>][desc]" class="form-control form-control-sm" rows="2"><?= htmlspecialchars($pl['desc'] ?? '') ?></textarea>
                                                                            </div>
                                                                            <div class="col-12">
                                                                                <input type="text" name="pillars[<?= $pIdx ?>][badge]" class="form-control form-control-sm" value="<?= htmlspecialchars($pl['badge'] ?? '') ?>" placeholder="Footer badge">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <?php endforeach; ?>
                                                        </div>
                                                    </div>
                                                <?php elseif ($secType === 'clinics_block'): ?>
                                                    <div class="col-12 mt-3 pt-3 border-top">
                                                        <h6 class="fw-bold text-success mb-2"><i class="bi bi-building me-1"></i> Surgery Card &amp; 5 Amenities</h6>
                                                        <div class="row g-2 mb-3 bg-light p-3 rounded border">
                                                            <div class="col-md-4">
                                                                <label class="form-label small fw-bold">Surgery Title</label>
                                                                <input type="text" name="clinics_surgery_title" class="form-control form-control-sm" value="<?= htmlspecialchars($clinics['surgery_title'] ?? 'Modern Surgery 1') ?>">
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="form-label small fw-bold">Status Badge</label>
                                                                <input type="text" name="clinics_surgery_badge" class="form-control form-control-sm" value="<?= htmlspecialchars($clinics['surgery_badge'] ?? 'Active Clinical Suite') ?>">
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="form-label small fw-bold">Upload Surgery Image</label>
                                                                <input type="file" name="clinics_image_file" class="form-control form-control-sm" accept="image/*">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label small fw-bold">Surgery Description</label>
                                                                <input type="text" name="clinics_surgery_desc" class="form-control form-control-sm" value="<?= htmlspecialchars($clinics['surgery_desc'] ?? '') ?>">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label small fw-bold">Surgery Image Path</label>
                                                                <input type="text" name="clinics_image_manual" class="form-control form-control-sm font-monospace" value="<?= htmlspecialchars($clinics['surgery_image'] ?? '') ?>">
                                                            </div>
                                                        </div>
                                                        <div class="row g-2">
                                                            <?php foreach ($clinicFeatures as $cfIdx => $cf): ?>
                                                                <div class="col-md-6">
                                                                    <div class="p-2 bg-light rounded border">
                                                                        <div class="row g-2">
                                                                            <div class="col-4">
                                                                                <input type="text" name="clinic_features[<?= $cfIdx ?>][icon]" class="form-control form-control-sm font-monospace" value="<?= htmlspecialchars($cf['icon'] ?? 'radiology') ?>">
                                                                            </div>
                                                                            <div class="col-8">
                                                                                <input type="text" name="clinic_features[<?= $cfIdx ?>][title]" class="form-control form-control-sm fw-bold" value="<?= htmlspecialchars($cf['title'] ?? '') ?>">
                                                                            </div>
                                                                            <div class="col-12">
                                                                                <textarea name="clinic_features[<?= $cfIdx ?>][desc]" class="form-control form-control-sm" rows="2"><?= htmlspecialchars($cf['desc'] ?? '') ?></textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <?php endforeach; ?>
                                                        </div>
                                                    </div>
                                                <?php elseif ($secType === 'safety_charter_cards'): ?>
                                                    <div class="col-12 mt-3 pt-3 border-top">
                                                        <h6 class="fw-bold text-success mb-2"><i class="bi bi-file-earmark-medical me-1"></i> 3 Safety Charter Cards &amp; Emergency Bar</h6>
                                                        <div class="row g-2 mb-3">
                                                            <?php foreach ($charterCards as $ccIdx => $cc): ?>
                                                                <div class="col-md-4">
                                                                    <div class="p-2 bg-light rounded border">
                                                                        <input type="text" name="charter_cards[<?= $ccIdx ?>][icon]" class="form-control form-control-sm font-monospace mb-1" value="<?= htmlspecialchars($cc['icon'] ?? 'verified') ?>" placeholder="Icon">
                                                                        <input type="text" name="charter_cards[<?= $ccIdx ?>][title]" class="form-control form-control-sm fw-bold mb-1" value="<?= htmlspecialchars($cc['title'] ?? '') ?>" placeholder="Card Title">
                                                                        <textarea name="charter_cards[<?= $ccIdx ?>][desc]" class="form-control form-control-sm mb-1" rows="3"><?= htmlspecialchars($cc['desc'] ?? '') ?></textarea>
                                                                        <input type="text" name="charter_cards[<?= $ccIdx ?>][footer_label]" class="form-control form-control-sm" value="<?= htmlspecialchars($cc['footer_label'] ?? '') ?>" placeholder="Footer Label">
                                                                    </div>
                                                                </div>
                                                            <?php endforeach; ?>
                                                        </div>
                                                        <div class="row g-2 bg-light p-3 rounded border">
                                                            <div class="col-md-4">
                                                                <label class="form-label small fw-bold">Emergency Box Title</label>
                                                                <input type="text" name="emergency_title" class="form-control form-control-sm" value="<?= htmlspecialchars($emergencyBox['title'] ?? 'Emergency & Out-of-Hours Dental Support') ?>">
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="form-label small fw-bold">Emergency Subtitle</label>
                                                                <input type="text" name="emergency_subtitle" class="form-control form-control-sm" value="<?= htmlspecialchars($emergencyBox['subtitle'] ?? '') ?>">
                                                            </div>
                                                            <div class="col-md-2">
                                                                <label class="form-label small fw-bold">Phone</label>
                                                                <input type="text" name="emergency_phone" class="form-control form-control-sm" value="<?= htmlspecialchars($emergencyBox['phone'] ?? '+44 121 765 2870') ?>">
                                                            </div>
                                                            <div class="col-md-2">
                                                                <label class="form-label small fw-bold">NHS Badge</label>
                                                                <input type="text" name="emergency_nhs111" class="form-control form-control-sm" value="<?= htmlspecialchars($emergencyBox['nhs111'] ?? '111') ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>

                                                <!-- Creative Background & Styling -->
                                                <div class="col-12 mt-3 pt-3 border-top">
                                                    <label class="form-label small fw-bold text-dark mb-2">
                                                        <i class="bi bi-palette2 text-primary me-1"></i> Section Background &amp; Creative Styling
                                                    </label>
                                                    <div class="row g-2 bg-light p-3 rounded-3 border">
                                                        <div class="col-md-3">
                                                            <label class="form-label small fw-semibold">Background Type</label>
                                                            <select name="sections[<?= $idx ?>][bg_type]" class="form-select form-select-sm fw-semibold" onchange="toggleSectionBgFields(this, '<?= htmlspecialchars($secId) ?>')">
                                                                <option value="default" <?= ($sec['bg_type'] ?? 'default') === 'default' ? 'selected' : '' ?>>Alternating (Odd/Even)</option>
                                                                <option value="solid" <?= ($sec['bg_type'] ?? '') === 'solid' ? 'selected' : '' ?>>Solid Custom Color</option>
                                                                <option value="gradient" <?= ($sec['bg_type'] ?? '') === 'gradient' ? 'selected' : '' ?>>Modern Gradient</option>
                                                                <option value="image" <?= ($sec['bg_type'] ?? '') === 'image' ? 'selected' : '' ?>>Background Image</option>
                                                                <option value="image_overlay" <?= ($sec['bg_type'] ?? '') === 'image_overlay' ? 'selected' : '' ?>>Image with Overlay</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-3 sec-bg-field sec-bg-solid-<?= htmlspecialchars($secId) ?>" style="display: <?= ($sec['bg_type'] ?? '') === 'solid' ? 'block' : 'none' ?>;">
                                                            <label class="form-label small fw-semibold">Solid Color</label>
                                                            <input type="text" name="sections[<?= $idx ?>][bg_color]" class="form-control form-control-sm font-monospace" value="<?= htmlspecialchars($sec['bg_color'] ?? '#f0fdf4') ?>">
                                                        </div>
                                                        <div class="col-md-5 sec-bg-field sec-bg-gradient-<?= htmlspecialchars($secId) ?>" style="display: <?= ($sec['bg_type'] ?? '') === 'gradient' ? 'block' : 'none' ?>;">
                                                            <label class="form-label small fw-semibold">Gradient Start / End / Angle</label>
                                                            <div class="input-group input-group-sm">
                                                                <input type="text" name="sections[<?= $idx ?>][bg_gradient_start]" class="form-control font-monospace" value="<?= htmlspecialchars($sec['bg_gradient_start'] ?? '#094713') ?>">
                                                                <input type="text" name="sections[<?= $idx ?>][bg_gradient_end]" class="form-control font-monospace" value="<?= htmlspecialchars($sec['bg_gradient_end'] ?? '#15803d') ?>">
                                                                <input type="text" name="sections[<?= $idx ?>][bg_gradient_angle]" class="form-control font-monospace" value="<?= htmlspecialchars($sec['bg_gradient_angle'] ?? '135deg') ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 sec-bg-field sec-bg-image-<?= htmlspecialchars($secId) ?>" style="display: <?= in_array($sec['bg_type'] ?? '', ['image', 'image_overlay']) ? 'block' : 'none' ?>;">
                                                            <label class="form-label small fw-semibold">Bg Image Upload / URL</label>
                                                            <input type="file" name="section_bg_files[<?= $idx ?>]" class="form-control form-control-sm mb-1" accept="image/*">
                                                            <input type="text" name="sections[<?= $idx ?>][bg_image]" class="form-control form-control-sm font-monospace" value="<?= htmlspecialchars($sec['bg_image'] ?? '') ?>">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="form-label small fw-semibold">Text Contrast</label>
                                                            <select name="sections[<?= $idx ?>][text_contrast]" class="form-select form-select-sm">
                                                                <option value="auto" <?= ($sec['text_contrast'] ?? 'auto') === 'auto' ? 'selected' : '' ?>>Auto</option>
                                                                <option value="light" <?= ($sec['text_contrast'] ?? '') === 'light' ? 'selected' : '' ?>>Light (White)</option>
                                                                <option value="dark" <?= ($sec['text_contrast'] ?? '') === 'dark' ? 'selected' : '' ?>>Dark</option>
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

        <!-- ============================================================== -->
        <!-- 3. SEO & METADATA TAB -->
        <!-- ============================================================== -->
        <div class="tab-pane fade" id="sec-seo">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="fw-bold mb-0"><i class="bi bi-search text-success me-2"></i> Search Engine Optimization &amp; Social Metadata</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Meta Title</label>
                            <input type="text" name="meta_title" class="form-control" value="<?= htmlspecialchars($seo['meta_title'] ?? '') ?>">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Meta Description</label>
                            <textarea name="meta_description" class="form-control" rows="3"><?= htmlspecialchars($seo['meta_description'] ?? '') ?></textarea>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Keywords (comma-separated)</label>
                            <input type="text" name="keywords" class="form-control" value="<?= htmlspecialchars($seo['keywords'] ?? '') ?>">
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
                <i class="bi bi-cloud-check text-success me-1"></i> Saving updates <code>/api/v1/pages/about-us</code> immediately.
            </span>
            <button type="submit" class="btn btn-brand btn-lg rounded-pill px-5 shadow">
                <i class="bi bi-check-lg me-2"></i> Save About Page Content &amp; Sections
            </button>
        </div>
    </div>
</form>

<!-- MODAL: ADD NEW SECTION (Common Components, Other Pages, Custom Content) -->
<div class="modal fade" id="addSectionModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 rounded-4 shadow-lg">
            <div class="modal-header bg-light border-bottom py-3">
                <h5 class="modal-title fw-bold"><i class="bi bi-plus-circle-fill text-success me-2"></i> Add Section to About Page</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <ul class="nav cms-editor-tabs mb-4" role="tablist">
                    <li class="nav-item">
                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-common" type="button">Common Components</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-other" type="button">Other Pages</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-custom" type="button">New Content Section</button>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="tab-common">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="p-3 border rounded-3 bg-light h-100 d-flex flex-column justify-content-between">
                                    <div>
                                        <h6 class="fw-bold"><i class="bi bi-grid-3x3-gap text-primary me-1"></i> Clinical Services Grid</h6>
                                        <p class="small text-muted mb-2">Embeds the active clinical treatments grid.</p>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-primary rounded-pill" onclick="addAboutCommonSection('services_block', 'Clinical Services Grid', 'Our Treatments', 'Discover Our Dental Services')">+ Add Services Grid</button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 border rounded-3 bg-light h-100 d-flex flex-column justify-content-between">
                                    <div>
                                        <h6 class="fw-bold"><i class="bi bi-people-fill text-success me-1"></i> Doctors &amp; Clinicians Team</h6>
                                        <p class="small text-muted mb-2">Displays GDC-registered doctors and hygienists.</p>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-success rounded-pill" onclick="addAboutCommonSection('team_block', 'Our Clinical Team', 'Meet Our Clinicians', 'GDC-Registered Dentists & Nurses')">+ Add Team Grid</button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 border rounded-3 bg-light h-100 d-flex flex-column justify-content-between">
                                    <div>
                                        <h6 class="fw-bold"><i class="bi bi-star-fill text-warning me-1"></i> Patient Reviews Slider</h6>
                                        <p class="small text-muted mb-2">Verified Google &amp; patient testimonials.</p>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-warning text-dark rounded-pill" onclick="addAboutCommonSection('testimonials_block', 'Patient Reviews', 'Patient Voices', 'What Our Patients Say')">+ Add Reviews</button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 border rounded-3 bg-light h-100 d-flex flex-column justify-content-between">
                                    <div>
                                        <h6 class="fw-bold"><i class="bi bi-geo-alt-fill text-danger me-1"></i> Hours &amp; Surgery Map</h6>
                                        <p class="small text-muted mb-2">Opening hours, address, and location map.</p>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-danger rounded-pill" onclick="addAboutCommonSection('contact_block', 'Hours & Surgery Map', 'Visit Us', 'Acocks Green Surgery Hours & Map')">+ Add Hours &amp; Map</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="tab-other">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Select Page</label>
                                <select id="otherPageSlug" class="form-select">
                                    <option value="home">Homepage</option>
                                    <option value="treatments">Treatments Overview</option>
                                    <option value="contact">Contact &amp; Emergency</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Headline (HTML supported)</label>
                                <input type="text" id="otherPageTitle" class="form-control" placeholder="e.g. Explore Our Treatments">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Summary Copy</label>
                                <textarea id="otherPageSummary" class="form-control" rows="2"></textarea>
                            </div>
                            <div class="col-12 text-end">
                                <button type="button" class="btn btn-brand rounded-pill px-4" onclick="addAboutOtherPageSection()">+ Add Page Section</button>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="tab-custom">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Eyebrow</label>
                                <input type="text" id="customEyebrow" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Section Title (HTML supported) *</label>
                                <input type="text" id="customTitle" class="form-control">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Summary</label>
                                <textarea id="customSummary" class="form-control" rows="2"></textarea>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Description (HTML supported)</label>
                                <textarea id="customDescription" class="form-control" rows="2"></textarea>
                            </div>
                            <div class="col-12 text-end">
                                <button type="button" class="btn btn-brand rounded-pill px-4" onclick="addAboutCustomSection()">+ Add Custom Section</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function previewAboutImg(input, imgId) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function (e) {
            document.getElementById(imgId).src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}

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
    if (confirm('Remove this section from the About page?')) {
        btn.closest('.section-item-card').remove();
        recalculateSectionOrders();
    }
}

function recalculateSectionOrders() {
    document.querySelectorAll('#sectionsListContainer .section-item-card').forEach(function (card, idx) {
        const order = idx + 1;
        const badge = card.querySelector('.section-order-badge');
        const input = card.querySelector('.section-order-input');
        if (badge) badge.textContent = '#' + order;
        if (input) input.value = order;
    });
}

function toggleSectionBgFields(select, secId) {
    const val = select.value;
    const parent = select.closest('.row');
    const solidField = parent.querySelector('.sec-bg-solid-' + secId);
    const gradientField = parent.querySelector('.sec-bg-gradient-' + secId);
    const imageField = parent.querySelector('.sec-bg-image-' + secId);
    if (solidField) solidField.style.display = (val === 'solid') ? 'block' : 'none';
    if (gradientField) gradientField.style.display = (val === 'gradient') ? 'block' : 'none';
    if (imageField) imageField.style.display = (val === 'image' || val === 'image_overlay') ? 'block' : 'none';
}

function addAboutCommonSection(type, name, eyebrow, title) {
    appendAboutSectionCard({ id: 'sec_' + type + '_' + Date.now(), type, category: 'prebuilt', name, eyebrow, title, summary: '' });
    bootstrap.Modal.getInstance(document.getElementById('addSectionModal')).hide();
}

function addAboutOtherPageSection() {
    const slug = document.getElementById('otherPageSlug').value;
    const title = document.getElementById('otherPageTitle').value || 'Featured Page';
    const summary = document.getElementById('otherPageSummary').value || '';
    appendAboutSectionCard({ id: 'sec_page_' + Date.now(), type: 'page_snippet', category: 'page_snippet', page_slug: slug, name: title, eyebrow: 'From ' + slug, title, summary });
    bootstrap.Modal.getInstance(document.getElementById('addSectionModal')).hide();
}

function addAboutCustomSection() {
    const title = document.getElementById('customTitle').value;
    if (!title) { alert('Please enter a section title.'); return; }
    appendAboutSectionCard({
        id: 'sec_custom_' + Date.now(),
        type: 'custom_content',
        category: 'custom_content',
        name: title,
        eyebrow: document.getElementById('customEyebrow').value,
        title: title,
        summary: document.getElementById('customSummary').value,
        description: document.getElementById('customDescription').value
    });
    bootstrap.Modal.getInstance(document.getElementById('addSectionModal')).hide();
}

function appendAboutSectionCard(data) {
    const container = document.getElementById('sectionsListContainer');
    const order = container.querySelectorAll('.section-item-card').length + 1;
    const idx = 'new_' + Date.now();
    const esc = (s) => String(s || '').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
    const html = `
    <div class="card border rounded-4 shadow-none bg-light section-item-card is-open" id="sectionCard_${data.id}" data-section-id="${data.id}">
        <div class="card-header section-acc-header border-bottom">
            <div class="section-acc-left">
                <div class="btn-group btn-group-sm">
                    <button type="button" class="btn btn-outline-secondary" onclick="moveSectionUp(this)"><i class="bi bi-arrow-up"></i></button>
                    <button type="button" class="btn btn-outline-secondary" onclick="moveSectionDown(this)"><i class="bi bi-arrow-down"></i></button>
                </div>
                <span class="badge bg-dark-subtle text-dark font-monospace section-order-badge">#${order}</span>
                <div>
                    <span class="fw-bold text-dark section-name-display">${esc(data.name)}</span>
                    <span class="badge ms-2 section-cat-badge bg-success-subtle text-success">${esc(data.category)} (${esc(data.type)})</span>
                </div>
            </div>
            <div class="section-acc-right">
                <div class="form-check form-switch m-0">
                    <input class="form-check-input" type="checkbox" name="sections[${idx}][is_active]" value="1" id="secActive_${data.id}" checked>
                    <label class="form-check-label small fw-semibold" for="secActive_${data.id}">Active</label>
                </div>
                <button type="button" class="btn btn-sm btn-outline-danger rounded-circle" onclick="removeSection(this)"><i class="bi bi-trash"></i></button>
                <button type="button" class="section-toggle-btn" data-bs-toggle="collapse" data-bs-target="#secCollapse_${data.id}" aria-expanded="true"><i class="bi bi-dash-lg"></i></button>
            </div>
        </div>
        <div class="collapse show" id="secCollapse_${data.id}">
            <div class="card-body p-4 bg-white border-top">
                <input type="hidden" name="sections[${idx}][id]" value="${esc(data.id)}">
                <input type="hidden" name="sections[${idx}][type]" value="${esc(data.type)}">
                <input type="hidden" name="sections[${idx}][category]" value="${esc(data.category)}">
                <input type="hidden" name="sections[${idx}][name]" value="${esc(data.name)}">
                <input type="hidden" name="sections[${idx}][page_slug]" value="${esc(data.page_slug || '')}">
                <input type="hidden" class="section-order-input" name="sections[${idx}][order]" value="${order}">
                <div class="row g-3">
                    <div class="col-md-4"><label class="form-label small fw-semibold">Eyebrow</label><input type="text" name="sections[${idx}][eyebrow]" class="form-control form-control-sm" value="${esc(data.eyebrow)}"></div>
                    <div class="col-md-8"><label class="form-label small fw-semibold">Main Title (HTML supported)</label><input type="text" name="sections[${idx}][title]" class="form-control form-control-sm fw-bold" value="${esc(data.title)}"></div>
                    <div class="col-12"><label class="form-label small fw-semibold">Summary</label><textarea name="sections[${idx}][summary]" class="form-control form-control-sm" rows="2">${esc(data.summary)}</textarea></div>
                    ${(data.type === 'custom_content' || data.type === 'page_snippet') ? `
                    <div class="col-12"><label class="form-label small fw-semibold">Description (HTML supported)</label><textarea name="sections[${idx}][description]" class="form-control form-control-sm" rows="3">${esc(data.description)}</textarea></div>
                    <div class="col-md-6"><label class="form-label small fw-semibold">CTA Text</label><input type="text" name="sections[${idx}][cta_text]" class="form-control form-control-sm"></div>
                    <div class="col-md-6"><label class="form-label small fw-semibold">CTA Link</label><input type="text" name="sections[${idx}][cta_link]" class="form-control form-control-sm font-monospace"></div>
                    ` : ''}
                </div>
            </div>
        </div>
    </div>`;
    const div = document.createElement('div');
    div.innerHTML = html.trim();
    container.appendChild(div.firstChild);
    recalculateSectionOrders();
    bindAccordionStateListeners(container);
}
</script>
