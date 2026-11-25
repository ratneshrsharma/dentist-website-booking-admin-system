<?php

declare(strict_types=1);

use App\Core\App;

$hero = $treatments['hero'] ?? [];
$sections = $treatments['sections'] ?? [];
$feeBands = $treatments['fee_bands'] ?? [];
$pillars = $treatments['clinical_pillars'] ?? [];
$seo = $treatments['seo'] ?? [];

require __DIR__ . '/_editor-styles.php';
?>

<div class="row mb-4 align-items-center">
    <div class="col-md-8">
        <div class="d-flex align-items-center gap-2 mb-1">
            <a href="<?= App::url('/admin/pages') ?>" class="text-decoration-none text-muted small">
                <i class="bi bi-arrow-left"></i> Back to Page List
            </a>
            <span class="text-muted small">/</span>
            <span class="text-success small fw-semibold">Treatments &amp; Services Catalog Editor</span>
        </div>
        <h2 class="fw-bold text-dark mb-0">
            <i class="bi bi-grid-3x3-gap text-success me-2"></i> Treatments &amp; Services Page Editor
        </h2>
        <p class="text-muted small mb-0">
            Manage hero banner, dynamic page sections, NHS/Private fee bands, clinical pillars, and SEO metadata. HTML tags are supported.
        </p>
    </div>
    <div class="col-md-4 text-md-end mt-3 mt-md-0">
        <a href="<?= App::url('/treatments') ?>" target="_blank" class="btn btn-outline-secondary rounded-pill shadow-sm">
            <i class="bi bi-box-arrow-up-right me-1"></i> Preview Treatments Page
        </a>
    </div>
</div>

<form action="<?= App::url('/admin/pages/treatments/edit') ?>" method="POST" enctype="multipart/form-data">
    <ul class="nav cms-editor-tabs mb-4" role="tablist">
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
        <!-- 1. BANNER -->
        <div class="tab-pane fade show active" id="sec-hero">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="fw-bold mb-0">Treatments Catalog Hero Banner</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4 align-items-center mb-4 pb-4 border-bottom">
                        <div class="col-md-3 text-center">
                            <img src="<?= htmlspecialchars($hero['image'] ?? App::url('/uploads/home/hero-patient.jpg')) ?>"
                                 alt="Treatments Hero" class="shadow-sm rounded-3 mb-2" id="trtHeroPreview" style="width: 160px; height: 110px; object-fit: cover;">
                            <small class="d-block text-muted">Saved in <code>uploads/treatments/</code></small>
                        </div>
                        <div class="col-md-9">
                            <div class="mb-2">
                                <label class="form-label fw-semibold">Upload New Hero Image</label>
                                <input type="file" name="hero_image_file" class="form-control" accept="image/*" onchange="if(this.files[0]){const r=new FileReader();r.onload=e=>document.getElementById('trtHeroPreview').src=e.target.result;r.readAsDataURL(this.files[0]);}">
                            </div>
                            <label class="form-label fw-semibold">Or Direct Image Path</label>
                            <input type="text" name="hero_image_manual" class="form-control font-monospace" value="<?= htmlspecialchars($hero['image'] ?? '') ?>">
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Eyebrow Tagline</label>
                            <input type="text" name="hero_eyebrow" class="form-control" value="<?= htmlspecialchars($hero['eyebrow'] ?? '') ?>">
                        </div>
                        <div class="col-md-8">
                            <label class="form-label fw-semibold">Headline Title (HTML supported)</label>
                            <input type="text" name="hero_headline" class="form-control fw-bold" value="<?= htmlspecialchars($hero['headline'] ?? '') ?>">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Subtitle (HTML supported)</label>
                            <textarea name="hero_subtitle" class="form-control" rows="2"><?= htmlspecialchars($hero['subtitle'] ?? '') ?></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Primary CTA Text</label>
                            <input type="text" name="hero_cta_primary" class="form-control" value="<?= htmlspecialchars($hero['cta_primary'] ?? 'Book Consultation') ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Primary CTA Link</label>
                            <input type="text" name="hero_cta_primary_link" class="form-control font-monospace" value="<?= htmlspecialchars($hero['cta_primary_link'] ?? '#quick-book') ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. CONTENT SECTIONS -->
        <div class="tab-pane fade" id="sec-composition">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <div class="d-flex justify-content-between align-items-center w-100 flex-wrap gap-2">
                        <div>
                            <h5 class="fw-bold mb-0"><i class="bi bi-layers-fill text-success me-2"></i> Treatments Page Sections Composition</h5>
                            <small class="text-muted">Reorder sections, toggle active/inactive on sections &amp; sub-elements, choose grid columns (1–6), or add new sections.</small>
                        </div>
                        <button type="button" class="btn btn-brand rounded-pill btn-sm shadow-sm" data-bs-toggle="modal" data-bs-target="#addTrtSectionModal">
                            <i class="bi bi-plus-circle me-1"></i> Add New Section
                        </button>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div id="sectionsListContainer" class="d-flex flex-column gap-3">
                        <?php foreach ($sections as $idx => $sec):
                            $secId = $sec['id'] ?? ('sec_' . ($idx + 1));
                            $secType = $sec['type'] ?? 'custom_content';
                            $secCat = $sec['category'] ?? 'prebuilt';
                        ?>
                            <div class="card border rounded-4 shadow-none bg-light section-item-card" id="sectionCard_<?= htmlspecialchars($secId) ?>">
                                <div class="card-header section-acc-header border-bottom">
                                    <div class="section-acc-left">
                                        <div class="btn-group btn-group-sm">
                                            <button type="button" class="btn btn-outline-secondary" onclick="moveLoopCard(this, '.section-item-card', -1); recalcTrtOrders();"><i class="bi bi-arrow-up"></i></button>
                                            <button type="button" class="btn btn-outline-secondary" onclick="moveLoopCard(this, '.section-item-card', 1); recalcTrtOrders();"><i class="bi bi-arrow-down"></i></button>
                                        </div>
                                        <span class="badge bg-dark-subtle text-dark font-monospace section-order-badge">#<?= $idx + 1 ?></span>
                                        <div>
                                            <span class="fw-bold text-dark section-name-display"><?= htmlspecialchars($sec['name'] ?? $sec['title'] ?? 'Section') ?></span>
                                            <span class="badge ms-2 section-cat-badge bg-primary-subtle text-primary"><?= htmlspecialchars($secType) ?></span>
                                        </div>
                                    </div>
                                    <div class="section-acc-right">
                                        <div class="form-check form-switch m-0">
                                            <input class="form-check-input" type="checkbox" name="sections[<?= $idx ?>][is_active]" value="1" id="trtSecActive_<?= $idx ?>" <?= ($sec['is_active'] ?? true) ? 'checked' : '' ?>>
                                            <label class="form-check-label small fw-semibold" for="trtSecActive_<?= $idx ?>">Active</label>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-outline-danger rounded-circle" onclick="this.closest('.section-item-card').remove(); recalcTrtOrders();" title="Remove Section"><i class="bi bi-trash"></i></button>
                                        <button type="button" class="section-toggle-btn collapsed" data-bs-toggle="collapse" data-bs-target="#trtSecCollapse_<?= $idx ?>" aria-expanded="false"><i class="bi bi-plus-lg"></i></button>
                                    </div>
                                </div>
                                <div class="collapse" id="trtSecCollapse_<?= $idx ?>">
                                    <div class="card-body p-4 bg-white border-top">
                                        <input type="hidden" name="sections[<?= $idx ?>][id]" value="<?= htmlspecialchars($secId) ?>">
                                        <input type="hidden" name="sections[<?= $idx ?>][type]" value="<?= htmlspecialchars($secType) ?>">
                                        <input type="hidden" name="sections[<?= $idx ?>][category]" value="<?= htmlspecialchars($secCat) ?>">
                                        <input type="hidden" name="sections[<?= $idx ?>][name]" value="<?= htmlspecialchars($sec['name'] ?? '') ?>">
                                        <input type="hidden" class="section-order-input" name="sections[<?= $idx ?>][order]" value="<?= $idx + 1 ?>">

                                        <div class="row g-3">
                                            <div class="col-md-4">
                                                <label class="form-label small fw-semibold">Eyebrow</label>
                                                <input type="text" name="sections[<?= $idx ?>][eyebrow]" class="form-control form-control-sm" value="<?= htmlspecialchars($sec['eyebrow'] ?? '') ?>">
                                            </div>
                                            <div class="col-md-5">
                                                <label class="form-label small fw-semibold">Section Main Title (HTML supported)</label>
                                                <input type="text" name="sections[<?= $idx ?>][title]" class="form-control form-control-sm fw-bold" value="<?= htmlspecialchars($sec['title'] ?? '') ?>">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label small fw-semibold">Grid Columns</label>
                                                <select name="sections[<?= $idx ?>][grid_cols]" class="form-select form-select-sm">
                                                    <?php for ($c = 1; $c <= 6; $c++): ?>
                                                        <option value="<?= $c ?>" <?= ((int)($sec['grid_cols'] ?? 3)) === $c ? 'selected' : '' ?>><?= $c ?> <?= $c === 1 ? 'Col' : 'Cols' ?></option>
                                                    <?php endfor; ?>
                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label small fw-semibold">Summary / Subtitle (HTML supported)</label>
                                                <textarea name="sections[<?= $idx ?>][summary]" class="form-control form-control-sm" rows="2"><?= htmlspecialchars($sec['summary'] ?? '') ?></textarea>
                                            </div>

                                            <?php if ($secType === 'custom_content' || $secType === 'page_snippet'): ?>
                                                <div class="col-md-4">
                                                    <label class="form-label small fw-semibold">Layout</label>
                                                    <select name="sections[<?= $idx ?>][column_layout]" class="form-select form-select-sm">
                                                        <option value="two_col_split" <?= ($sec['column_layout'] ?? '') === 'two_col_split' ? 'selected' : '' ?>>2-Column Split</option>
                                                        <option value="full_width" <?= ($sec['column_layout'] ?? '') === 'full_width' ? 'selected' : '' ?>>Full-Width</option>
                                                        <option value="action_bar" <?= ($sec['column_layout'] ?? '') === 'action_bar' ? 'selected' : '' ?>>Action Banner</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label small fw-semibold">CTA Text</label>
                                                    <input type="text" name="sections[<?= $idx ?>][cta_text]" class="form-control form-control-sm" value="<?= htmlspecialchars($sec['cta_text'] ?? '') ?>">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label small fw-semibold">CTA Link</label>
                                                    <input type="text" name="sections[<?= $idx ?>][cta_link]" class="form-control form-control-sm font-monospace" value="<?= htmlspecialchars($sec['cta_link'] ?? '') ?>">
                                                </div>
                                            <?php endif; ?>

                                            <?php if ($secType === 'fee_bands_block'): ?>
                                                <div class="col-12 mt-3 pt-3 border-top">
                                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                                        <h6 class="fw-bold text-success mb-0">NHS &amp; Private Fee Band Cards</h6>
                                                        <div class="d-flex align-items-center gap-2">
                                                            <?php renderColsSelector('fee_bands_cols', (int)($treatments['fee_bands_cols'] ?? 3)); ?>
                                                            <button type="button" class="btn btn-sm btn-outline-success rounded-pill" onclick="addTrtFeeBand()"><i class="bi bi-plus-circle me-1"></i> Add Fee Card</button>
                                                        </div>
                                                    </div>
                                                    <div class="row g-2" id="trtFeeBandsContainer">
                                                        <?php foreach ($feeBands as $fIdx => $fb): ?>
                                                            <div class="col-md-4 loop-fee-card">
                                                                <div class="p-3 bg-light rounded border h-100">
                                                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                                                        <div class="form-check form-switch m-0">
                                                                            <input class="form-check-input" type="checkbox" name="fee_bands[<?= $fIdx ?>][is_active]" value="1" <?= ($fb['is_active'] ?? true) ? 'checked' : '' ?>>
                                                                            <label class="form-check-label small fw-semibold">Active</label>
                                                                        </div>
                                                                        <div class="btn-group btn-group-sm">
                                                                            <button type="button" class="btn btn-outline-secondary" onclick="moveLoopCard(this, '.loop-fee-card', -1)"><i class="bi bi-arrow-left"></i></button>
                                                                            <button type="button" class="btn btn-outline-secondary" onclick="moveLoopCard(this, '.loop-fee-card', 1)"><i class="bi bi-arrow-right"></i></button>
                                                                            <button type="button" class="btn btn-outline-danger" onclick="removeLoopCard(this, '.loop-fee-card')"><i class="bi bi-trash"></i></button>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mb-2"><?php renderIconPickerInput("fee_bands[{$fIdx}][icon]", $fb['icon'] ?? 'local_hospital', 'local_hospital'); ?></div>
                                                                    <input type="text" name="fee_bands[<?= $fIdx ?>][title]" class="form-control form-control-sm fw-bold mb-1" value="<?= htmlspecialchars($fb['title'] ?? '') ?>" placeholder="Title">
                                                                    <div class="row g-1 mb-1">
                                                                        <div class="col-6"><input type="text" name="fee_bands[<?= $fIdx ?>][badge]" class="form-control form-control-sm" value="<?= htmlspecialchars($fb['badge'] ?? '') ?>" placeholder="Badge"></div>
                                                                        <div class="col-6"><input type="text" name="fee_bands[<?= $fIdx ?>][price]" class="form-control form-control-sm fw-bold" value="<?= htmlspecialchars($fb['price'] ?? '') ?>" placeholder="Price"></div>
                                                                    </div>
                                                                    <textarea name="fee_bands[<?= $fIdx ?>][desc]" class="form-control form-control-sm" rows="2"><?= htmlspecialchars($fb['desc'] ?? '') ?></textarea>
                                                                </div>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </div>
                                            <?php elseif ($secType === 'why_us_block'): ?>
                                                <div class="col-12 mt-3 pt-3 border-top">
                                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                                        <h6 class="fw-bold text-success mb-0">Clinical Pillars</h6>
                                                        <div class="d-flex align-items-center gap-2">
                                                            <?php renderColsSelector('pillars_cols', (int)($treatments['pillars_cols'] ?? 4)); ?>
                                                            <button type="button" class="btn btn-sm btn-outline-success rounded-pill" onclick="addTrtPillar()"><i class="bi bi-plus-circle me-1"></i> Add Pillar</button>
                                                        </div>
                                                    </div>
                                                    <div class="row g-2" id="trtPillarsContainer">
                                                        <?php foreach ($pillars as $pIdx => $pl): ?>
                                                            <div class="col-md-3 loop-trt-pillar">
                                                                <div class="p-3 bg-light rounded border h-100">
                                                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                                                        <div class="form-check form-switch m-0">
                                                                            <input class="form-check-input" type="checkbox" name="clinical_pillars[<?= $pIdx ?>][is_active]" value="1" <?= ($pl['is_active'] ?? true) ? 'checked' : '' ?>>
                                                                            <label class="form-check-label small fw-semibold">Active</label>
                                                                        </div>
                                                                        <div class="btn-group btn-group-sm">
                                                                            <button type="button" class="btn btn-outline-secondary" onclick="moveLoopCard(this, '.loop-trt-pillar', -1)"><i class="bi bi-arrow-left"></i></button>
                                                                            <button type="button" class="btn btn-outline-secondary" onclick="moveLoopCard(this, '.loop-trt-pillar', 1)"><i class="bi bi-arrow-right"></i></button>
                                                                            <button type="button" class="btn btn-outline-danger" onclick="removeLoopCard(this, '.loop-trt-pillar')"><i class="bi bi-trash"></i></button>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mb-2"><?php renderIconPickerInput("clinical_pillars[{$pIdx}][icon]", $pl['icon'] ?? 'biotech', 'biotech'); ?></div>
                                                                    <input type="text" name="clinical_pillars[<?= $pIdx ?>][title]" class="form-control form-control-sm fw-bold mb-1" value="<?= htmlspecialchars($pl['title'] ?? '') ?>" placeholder="Title">
                                                                    <textarea name="clinical_pillars[<?= $pIdx ?>][desc]" class="form-control form-control-sm" rows="2"><?= htmlspecialchars($pl['desc'] ?? '') ?></textarea>
                                                                </div>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3. SEO -->
        <div class="tab-pane fade" id="sec-seo">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-3 border-bottom"><h5 class="fw-bold mb-0">SEO &amp; Metadata</h5></div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-12"><label class="form-label fw-bold">Meta Title</label><input type="text" name="meta_title" class="form-control" value="<?= htmlspecialchars($seo['meta_title'] ?? '') ?>"></div>
                        <div class="col-12"><label class="form-label fw-bold">Meta Description</label><textarea name="meta_description" class="form-control" rows="3"><?= htmlspecialchars($seo['meta_description'] ?? '') ?></textarea></div>
                        <div class="col-12"><label class="form-label fw-bold">Keywords</label><input type="text" name="keywords" class="form-control" value="<?= htmlspecialchars($seo['keywords'] ?? '') ?>"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 p-3 bg-white sticky-bottom mb-4">
        <div class="d-flex align-items-center justify-content-between">
            <span class="text-muted small"><i class="bi bi-cloud-check text-success me-1"></i> Saving updates <code>/api/v1/pages/treatments</code> immediately.</span>
            <button type="submit" class="btn btn-brand rounded-pill px-4 shadow-sm"><i class="bi bi-check-lg me-1"></i> Save Treatments Page</button>
        </div>
    </div>
</form>

<!-- Add Section Modal -->
<div class="modal fade" id="addTrtSectionModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow-lg">
            <div class="modal-header bg-light border-bottom py-3">
                <h5 class="modal-title fw-bold"><i class="bi bi-plus-circle text-success me-2"></i> Add Section to Treatments Page</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Section Type</label>
                    <select id="newTrtSecType" class="form-select">
                        <option value="custom_content">New Content Section (Custom Block)</option>
                        <option value="testimonials_block">Common Component: Patient Reviews</option>
                        <option value="contact_block">Common Component: Hours &amp; Surgery Map</option>
                        <option value="page_snippet">Other Page Snippet</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Section Title *</label>
                    <input type="text" id="newTrtSecTitle" class="form-control" placeholder="e.g. Flexible 0% Finance Plans">
                </div>
                <div class="mb-0">
                    <label class="form-label fw-semibold">Summary Copy</label>
                    <textarea id="newTrtSecSummary" class="form-control" rows="2"></textarea>
                </div>
            </div>
            <div class="modal-footer bg-light border-top py-3">
                <button type="button" class="btn btn-outline-secondary rounded-pill" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-brand rounded-pill px-4" onclick="addTrtDynamicSection()">+ Add Section</button>
            </div>
        </div>
    </div>
</div>

<script>
function recalcTrtOrders() {
    document.querySelectorAll('#sectionsListContainer .section-item-card').forEach((card, i) => {
        const b = card.querySelector('.section-order-badge');
        const inp = card.querySelector('.section-order-input');
        if (b) b.textContent = '#' + (i + 1);
        if (inp) inp.value = i + 1;
    });
}

function addTrtFeeBand() {
    const idx = Date.now();
    document.getElementById('trtFeeBandsContainer').insertAdjacentHTML('beforeend', `
    <div class="col-md-4 loop-fee-card">
        <div class="p-3 bg-light rounded border h-100">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div class="form-check form-switch m-0">
                    <input class="form-check-input" type="checkbox" name="fee_bands[${idx}][is_active]" value="1" checked>
                    <label class="form-check-label small fw-semibold">Active</label>
                </div>
                <div class="btn-group btn-group-sm">
                    <button type="button" class="btn btn-outline-secondary" onclick="moveLoopCard(this, '.loop-fee-card', -1)"><i class="bi bi-arrow-left"></i></button>
                    <button type="button" class="btn btn-outline-secondary" onclick="moveLoopCard(this, '.loop-fee-card', 1)"><i class="bi bi-arrow-right"></i></button>
                    <button type="button" class="btn btn-outline-danger" onclick="removeLoopCard(this, '.loop-fee-card')"><i class="bi bi-trash"></i></button>
                </div>
            </div>
            <div class="mb-2">
                <div class="input-group input-group-sm icon-picker-group">
                    <span class="input-group-text bg-white"><span class="material-symbols-outlined icon-picker-preview" style="font-size:18px; color:#0d631b;">payments</span></span>
                    <input type="text" name="fee_bands[${idx}][icon]" class="form-control font-monospace icon-picker-input" value="payments">
                    <button type="button" class="btn btn-outline-secondary" onclick="openIconPicker(this)"><i class="bi bi-grid-3x3-gap"></i></button>
                </div>
            </div>
            <input type="text" name="fee_bands[${idx}][title]" class="form-control form-control-sm fw-bold mb-1" placeholder="Title">
            <div class="row g-1 mb-1">
                <div class="col-6"><input type="text" name="fee_bands[${idx}][badge]" class="form-control form-control-sm" placeholder="Badge"></div>
                <div class="col-6"><input type="text" name="fee_bands[${idx}][price]" class="form-control form-control-sm fw-bold" placeholder="Price"></div>
            </div>
            <textarea name="fee_bands[${idx}][desc]" class="form-control form-control-sm" rows="2" placeholder="Description"></textarea>
        </div>
    </div>`);
}

function addTrtPillar() {
    const idx = Date.now();
    document.getElementById('trtPillarsContainer').insertAdjacentHTML('beforeend', `
    <div class="col-md-3 loop-trt-pillar">
        <div class="p-3 bg-light rounded border h-100">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div class="form-check form-switch m-0">
                    <input class="form-check-input" type="checkbox" name="clinical_pillars[${idx}][is_active]" value="1" checked>
                    <label class="form-check-label small fw-semibold">Active</label>
                </div>
                <div class="btn-group btn-group-sm">
                    <button type="button" class="btn btn-outline-secondary" onclick="moveLoopCard(this, '.loop-trt-pillar', -1)"><i class="bi bi-arrow-left"></i></button>
                    <button type="button" class="btn btn-outline-secondary" onclick="moveLoopCard(this, '.loop-trt-pillar', 1)"><i class="bi bi-arrow-right"></i></button>
                    <button type="button" class="btn btn-outline-danger" onclick="removeLoopCard(this, '.loop-trt-pillar')"><i class="bi bi-trash"></i></button>
                </div>
            </div>
            <div class="mb-2">
                <div class="input-group input-group-sm icon-picker-group">
                    <span class="input-group-text bg-white"><span class="material-symbols-outlined icon-picker-preview" style="font-size:18px; color:#0d631b;">verified_user</span></span>
                    <input type="text" name="clinical_pillars[${idx}][icon]" class="form-control font-monospace icon-picker-input" value="verified_user">
                    <button type="button" class="btn btn-outline-secondary" onclick="openIconPicker(this)"><i class="bi bi-grid-3x3-gap"></i></button>
                </div>
            </div>
            <input type="text" name="clinical_pillars[${idx}][title]" class="form-control form-control-sm fw-bold mb-1" placeholder="Title">
            <textarea name="clinical_pillars[${idx}][desc]" class="form-control form-control-sm" rows="2" placeholder="Description"></textarea>
        </div>
    </div>`);
}

function addTrtDynamicSection() {
    const type = document.getElementById('newTrtSecType').value;
    const title = document.getElementById('newTrtSecTitle').value.trim();
    if (!title) { alert('Please enter a section title.'); return; }
    const summary = document.getElementById('newTrtSecSummary').value.trim();
    const idx = 'new_' + Date.now();
    const container = document.getElementById('sectionsListContainer');
    const order = container.querySelectorAll('.section-item-card').length + 1;
    container.insertAdjacentHTML('beforeend', `
    <div class="card border rounded-4 shadow-none bg-light section-item-card is-open">
        <div class="card-header section-acc-header border-bottom">
            <div class="section-acc-left">
                <div class="btn-group btn-group-sm">
                    <button type="button" class="btn btn-outline-secondary" onclick="moveLoopCard(this, '.section-item-card', -1); recalcTrtOrders();"><i class="bi bi-arrow-up"></i></button>
                    <button type="button" class="btn btn-outline-secondary" onclick="moveLoopCard(this, '.section-item-card', 1); recalcTrtOrders();"><i class="bi bi-arrow-down"></i></button>
                </div>
                <span class="badge bg-dark-subtle text-dark font-monospace section-order-badge">#${order}</span>
                <div><span class="fw-bold text-dark section-name-display">${title}</span><span class="badge ms-2 section-cat-badge bg-primary-subtle text-primary">${type}</span></div>
            </div>
            <div class="section-acc-right">
                <div class="form-check form-switch m-0">
                    <input class="form-check-input" type="checkbox" name="sections[${idx}][is_active]" value="1" checked>
                    <label class="form-check-label small fw-semibold">Active</label>
                </div>
                <button type="button" class="btn btn-sm btn-outline-danger rounded-circle" onclick="this.closest('.section-item-card').remove(); recalcTrtOrders();"><i class="bi bi-trash"></i></button>
                <button type="button" class="section-toggle-btn" data-bs-toggle="collapse" data-bs-target="#trtSecCollapse_${idx}" aria-expanded="true"><i class="bi bi-dash-lg"></i></button>
            </div>
        </div>
        <div class="collapse show" id="trtSecCollapse_${idx}">
            <div class="card-body p-4 bg-white border-top">
                <input type="hidden" name="sections[${idx}][id]" value="sec_${idx}">
                <input type="hidden" name="sections[${idx}][type]" value="${type}">
                <input type="hidden" name="sections[${idx}][category]" value="${type === 'custom_content' ? 'custom_content' : 'prebuilt'}">
                <input type="hidden" name="sections[${idx}][name]" value="${title}">
                <input type="hidden" class="section-order-input" name="sections[${idx}][order]" value="${order}">
                <div class="row g-3">
                    <div class="col-md-4"><label class="form-label small fw-semibold">Eyebrow</label><input type="text" name="sections[${idx}][eyebrow]" class="form-control form-control-sm"></div>
                    <div class="col-md-8"><label class="form-label small fw-semibold">Main Title</label><input type="text" name="sections[${idx}][title]" class="form-control form-control-sm fw-bold" value="${title}"></div>
                    <div class="col-12"><label class="form-label small fw-semibold">Summary</label><textarea name="sections[${idx}][summary]" class="form-control form-control-sm" rows="2">${summary}</textarea></div>
                </div>
            </div>
        </div>
    </div>`);
    bindAccordionStateListeners(container);
    bootstrap.Modal.getInstance(document.getElementById('addTrtSectionModal')).hide();
}
</script>
