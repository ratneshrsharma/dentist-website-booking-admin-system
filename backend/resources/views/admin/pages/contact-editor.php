<?php

use App\Core\App;

$hero = $contact['hero'] ?? [];
$sections = $contact['sections'] ?? [];
$reassurance = $contact['reassurance_card'] ?? [];
$seo = $contact['seo'] ?? [];
$entriesCount = (int) ($entriesCount ?? 0);

include __DIR__ . '/_editor-styles.php';
?>

<div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-1 small">
                <li class="breadcrumb-item"><a href="<?= App::url('/admin/pages') ?>" class="text-decoration-none">CMS Pages</a></li>
                <li class="breadcrumb-item active">Contact &amp; Location Editor</li>
            </ol>
        </nav>
        <h3 class="fw-bold mb-0 text-dark">
            <i class="bi bi-geo-alt text-success me-2"></i> Contact &amp; Location Page Editor
        </h3>
    </div>
    <div class="d-flex gap-2 flex-wrap">
        <a href="<?= App::url('/admin/contact/submissions') ?>" class="btn btn-outline-info btn-sm px-3">
            <i class="bi bi-envelope-paper me-1"></i> Form Entries <span class="badge bg-info text-dark ms-1"><?= $entriesCount ?></span>
        </a>
        <a href="<?= App::url('/admin/settings') ?>" class="btn btn-outline-secondary btn-sm px-3">
            <i class="bi bi-gear me-1"></i> Forwarding Emails
        </a>
        <a href="<?= App::url('/contact/') ?>" target="_blank" class="btn btn-outline-success btn-sm px-3">
            <i class="bi bi-box-arrow-up-right me-1"></i> View Live Page
        </a>
    </div>
</div>

<form method="POST" action="<?= App::url('/admin/pages/contact/edit') ?>" enctype="multipart/form-data">
    <ul class="nav cms-editor-tabs mb-4" role="tablist">
        <li class="nav-item">
            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-banner" type="button">
                <i class="bi bi-image"></i> 1. Banner &amp; CTAs
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-sections" type="button">
                <i class="bi bi-layers-fill"></i> 2. Content Sections (<?= count($sections) ?>)
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-seo" type="button">
                <i class="bi bi-search"></i> 3. SEO &amp; Metadata
            </button>
        </li>
    </ul>

    <div class="tab-content">
        <!-- TAB 1: BANNER & HERO -->
        <div class="tab-pane fade show active" id="tab-banner">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="fw-bold mb-0">Contact Hero Banner &amp; Reception Card</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Hero Eyebrow</label>
                            <input type="text" name="hero_eyebrow" class="form-control" value="<?= htmlspecialchars($hero['eyebrow'] ?? '') ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Hero Headline (HTML supported)</label>
                            <input type="text" name="hero_headline" class="form-control fw-bold" value="<?= htmlspecialchars($hero['headline'] ?? '') ?>">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Hero Subtitle</label>
                            <textarea name="hero_subtitle" class="form-control" rows="2"><?= htmlspecialchars($hero['subtitle'] ?? '') ?></textarea>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Triage Badge Label</label>
                            <input type="text" name="hero_triage_label" class="form-control" value="<?= htmlspecialchars($hero['triage_label'] ?? 'Direct Clinical Triage') ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Triage Phone Number</label>
                            <input type="text" name="hero_triage_phone" class="form-control" value="<?= htmlspecialchars($hero['triage_phone'] ?? '0121 765 2870') ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Upload Hero Reception Image</label>
                            <input type="file" name="hero_image_file" class="form-control" accept="image/*">
                            <input type="hidden" name="hero_image" value="<?= htmlspecialchars($hero['image'] ?? '/uploads/home/surgery-clinic.jpg') ?>">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="fw-bold mb-0">Nervous / Dental Phobic Reassurance Card</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-5">
                            <label class="form-label fw-semibold">Card Title</label>
                            <input type="text" name="reassurance_title" class="form-control" value="<?= htmlspecialchars($reassurance['title'] ?? '') ?>">
                        </div>
                        <div class="col-md-7">
                            <label class="form-label fw-semibold">Card Description</label>
                            <textarea name="reassurance_desc" class="form-control" rows="2"><?= htmlspecialchars($reassurance['desc'] ?? '') ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 2: CONTENT SECTIONS -->
        <div class="tab-pane fade" id="tab-sections">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div>
                        <h5 class="fw-bold mb-0">Contact Page Sections</h5>
                        <small class="text-muted">Reorder sections, toggle Active/Inactive, edit copy, or add custom sections.</small>
                    </div>
                    <button type="button" class="btn btn-outline-success btn-sm" onclick="addContactSection()">
                        <i class="bi bi-plus-lg me-1"></i> Add Custom Section
                    </button>
                </div>
                <div class="card-body p-4">
                    <div id="contactSectionsContainer" class="d-flex flex-column gap-3">
                        <?php foreach ($sections as $idx => $sec):
                            $isActive = !isset($sec['is_active']) || !empty($sec['is_active']);
                            $secType = $sec['type'] ?? 'custom_content';
                        ?>
                            <div class="card border rounded-4 shadow-none bg-light section-item-card">
                                <div class="card-header section-acc-header border-bottom">
                                    <div class="section-acc-left">
                                        <div class="btn-group btn-group-sm">
                                            <button type="button" class="btn btn-outline-secondary" onclick="moveContactSec(this, -1)" title="Move Up"><i class="bi bi-arrow-up"></i></button>
                                            <button type="button" class="btn btn-outline-secondary" onclick="moveContactSec(this, 1)" title="Move Down"><i class="bi bi-arrow-down"></i></button>
                                        </div>
                                        <span class="badge bg-dark-subtle text-dark font-monospace section-order-badge">#<?= $idx + 1 ?></span>
                                        <div>
                                            <span class="fw-bold text-dark"><?= htmlspecialchars($sec['name'] ?? ($sec['title'] ?? 'Section')) ?></span>
                                            <span class="badge ms-2 bg-primary-subtle text-primary"><?= htmlspecialchars($secType) ?></span>
                                        </div>
                                    </div>
                                    <div class="section-acc-right">
                                        <div class="form-check form-switch m-0">
                                            <input class="form-check-input" type="checkbox" name="sections[<?= $idx ?>][is_active]" value="1" id="cSecActive_<?= $idx ?>" <?= $isActive ? 'checked' : '' ?>>
                                            <label class="form-check-label small fw-semibold" for="cSecActive_<?= $idx ?>">Active</label>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-outline-danger rounded-circle" onclick="this.closest('.section-item-card').remove(); recalcContactOrders();" title="Remove Section"><i class="bi bi-trash"></i></button>
                                        <button type="button" class="section-toggle-btn collapsed" data-bs-toggle="collapse" data-bs-target="#cSecCollapse_<?= $idx ?>" aria-expanded="false"><i class="bi bi-plus-lg"></i></button>
                                    </div>
                                </div>
                                <div class="collapse" id="cSecCollapse_<?= $idx ?>">
                                    <div class="card-body p-4 bg-white border-top">
                                        <input type="hidden" name="sections[<?= $idx ?>][id]" value="<?= htmlspecialchars($sec['id'] ?? '') ?>">
                                        <input type="hidden" name="sections[<?= $idx ?>][type]" value="<?= htmlspecialchars($secType) ?>">
                                        <input type="hidden" name="sections[<?= $idx ?>][category]" value="<?= htmlspecialchars($sec['category'] ?? 'custom') ?>">
                                        <input type="hidden" name="sections[<?= $idx ?>][name]" value="<?= htmlspecialchars($sec['name'] ?? '') ?>">
                                        <div class="row g-3">
                                            <div class="col-md-5">
                                                <label class="form-label small fw-semibold">Eyebrow</label>
                                                <input type="text" name="sections[<?= $idx ?>][eyebrow]" class="form-control form-control-sm" value="<?= htmlspecialchars($sec['eyebrow'] ?? '') ?>">
                                            </div>
                                            <div class="col-md-7">
                                                <label class="form-label small fw-semibold">Section Title (HTML supported)</label>
                                                <input type="text" name="sections[<?= $idx ?>][title]" class="form-control form-control-sm fw-bold" value="<?= htmlspecialchars($sec['title'] ?? '') ?>">
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label small fw-semibold">Summary / Description (HTML supported)</label>
                                                <textarea name="sections[<?= $idx ?>][summary]" class="form-control form-control-sm" rows="2"><?= htmlspecialchars($sec['summary'] ?? '') ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 3: SEO & METADATA -->
        <div class="tab-pane fade" id="tab-seo">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="fw-bold mb-0">SEO &amp; Metadata</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">Meta Title</label>
                            <input type="text" name="meta_title" class="form-control" value="<?= htmlspecialchars($seo['meta_title'] ?? '') ?>">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Meta Description</label>
                            <textarea name="meta_description" class="form-control" rows="3"><?= htmlspecialchars($seo['meta_description'] ?? '') ?></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Keywords</label>
                            <input type="text" name="keywords" class="form-control" value="<?= htmlspecialchars($seo['keywords'] ?? '') ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="sticky-save-bar d-flex justify-content-between align-items-center mt-4">
        <span class="small text-muted"><i class="bi bi-info-circle me-1"></i> Changes apply live to <code>/contact/</code>.</span>
        <button type="submit" class="btn btn-brand btn-sm px-4">
            <i class="bi bi-check2-circle me-1"></i> Save Contact Page
        </button>
    </div>
</form>

<script>
function recalcContactOrders() {
    document.querySelectorAll('#contactSectionsContainer .section-item-card').forEach(function(card, i) {
        var badge = card.querySelector('.section-order-badge');
        if (badge) badge.textContent = '#' + (i + 1);
    });
}

function moveContactSec(btn, dir) {
    var card = btn.closest('.section-item-card');
    var container = document.getElementById('contactSectionsContainer');
    if (dir === -1 && card.previousElementSibling) {
        container.insertBefore(card, card.previousElementSibling);
    } else if (dir === 1 && card.nextElementSibling) {
        container.insertBefore(card.nextElementSibling, card);
    }
    recalcContactOrders();
}

function addContactSection() {
    var container = document.getElementById('contactSectionsContainer');
    var idx = container.querySelectorAll('.section-item-card').length;
    var cid = 'cSecCollapse_new_' + Date.now();
    var html = `
    <div class="card border rounded-4 shadow-none bg-light section-item-card">
        <div class="card-header section-acc-header border-bottom">
            <div class="section-acc-left">
                <div class="btn-group btn-group-sm">
                    <button type="button" class="btn btn-outline-secondary" onclick="moveContactSec(this, -1)" title="Move Up"><i class="bi bi-arrow-up"></i></button>
                    <button type="button" class="btn btn-outline-secondary" onclick="moveContactSec(this, 1)" title="Move Down"><i class="bi bi-arrow-down"></i></button>
                </div>
                <span class="badge bg-dark-subtle text-dark font-monospace section-order-badge">#${idx + 1}</span>
                <div>
                    <span class="fw-bold text-dark">New Custom Section</span>
                    <span class="badge ms-2 bg-primary-subtle text-primary">custom_content</span>
                </div>
            </div>
            <div class="section-acc-right">
                <div class="form-check form-switch m-0">
                    <input class="form-check-input" type="checkbox" name="sections[${idx}][is_active]" value="1" checked>
                    <label class="form-check-label small fw-semibold">Active</label>
                </div>
                <button type="button" class="btn btn-sm btn-outline-danger rounded-circle" onclick="this.closest('.section-item-card').remove(); recalcContactOrders();" title="Remove Section"><i class="bi bi-trash"></i></button>
                <button type="button" class="section-toggle-btn" data-bs-toggle="collapse" data-bs-target="#${cid}" aria-expanded="true"><i class="bi bi-plus-lg"></i></button>
            </div>
        </div>
        <div class="collapse show" id="${cid}">
            <div class="card-body p-4 bg-white border-top">
                <input type="hidden" name="sections[${idx}][id]" value="sec_contact_${Date.now()}">
                <input type="hidden" name="sections[${idx}][type]" value="custom_content">
                <input type="hidden" name="sections[${idx}][category]" value="custom">
                <input type="hidden" name="sections[${idx}][name]" value="Custom Section">
                <div class="row g-3">
                    <div class="col-md-5">
                        <label class="form-label small fw-semibold">Eyebrow</label>
                        <input type="text" name="sections[${idx}][eyebrow]" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-7">
                        <label class="form-label small fw-semibold">Section Title (HTML supported)</label>
                        <input type="text" name="sections[${idx}][title]" class="form-control form-control-sm fw-bold" value="New Section">
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-semibold">Summary / Description (HTML supported)</label>
                        <textarea name="sections[${idx}][summary]" class="form-control form-control-sm" rows="2"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>`;
    container.insertAdjacentHTML('beforeend', html);
}
</script>
