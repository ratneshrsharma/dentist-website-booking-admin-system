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
    <ul class="nav nav-tabs cms-tabs mb-4" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-banner" type="button" role="tab">
                <i class="bi bi-image me-1"></i> 1. Banner &amp; CTAs
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-sections" type="button" role="tab">
                <i class="bi bi-layers me-1"></i> 2. Content Sections (<?= count($sections) ?>)
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-seo" type="button" role="tab">
                <i class="bi bi-search me-1"></i> 3. SEO &amp; Metadata
            </button>
        </li>
    </ul>

    <div class="tab-content">
        <!-- TAB 1: BANNER & HERO -->
        <div class="tab-pane fade show active" id="tab-banner" role="tabpanel">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="fw-bold mb-0">Contact Hero Banner &amp; Reception Card</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Hero Eyebrow</label>
                            <input type="text" name="hero_eyebrow" class="form-control" value="<?= htmlspecialchars($hero['eyebrow'] ?? '') ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Hero Headline</label>
                            <input type="text" name="hero_headline" class="form-control" value="<?= htmlspecialchars($hero['headline'] ?? '') ?>">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">Hero Subtitle</label>
                            <textarea name="hero_subtitle" class="form-control" rows="2"><?= htmlspecialchars($hero['subtitle'] ?? '') ?></textarea>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Triage Badge Label</label>
                            <input type="text" name="hero_triage_label" class="form-control" value="<?= htmlspecialchars($hero['triage_label'] ?? 'Direct Clinical Triage') ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Triage Phone Number</label>
                            <input type="text" name="hero_triage_phone" class="form-control" value="<?= htmlspecialchars($hero['triage_phone'] ?? '0121 765 2870') ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Upload Hero Reception Image</label>
                            <input type="file" name="hero_image_file" class="form-control" accept="image/*">
                            <input type="hidden" name="hero_image" value="<?= htmlspecialchars($hero['image'] ?? '/uploads/home/surgery-clinic.jpg') ?>">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="fw-bold mb-0">Nervous / Dental Phobic Reassurance Card</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-5">
                            <label class="form-label fw-bold">Card Title</label>
                            <input type="text" name="reassurance_title" class="form-control" value="<?= htmlspecialchars($reassurance['title'] ?? '') ?>">
                        </div>
                        <div class="col-md-7">
                            <label class="form-label fw-bold">Card Description</label>
                            <textarea name="reassurance_desc" class="form-control" rows="2"><?= htmlspecialchars($reassurance['desc'] ?? '') ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 2: CONTENT SECTIONS -->
        <div class="tab-pane fade" id="tab-sections" role="tabpanel">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <small class="text-muted">Reorder sections, toggle Active/Inactive, edit copy, or add custom sections.</small>
                <button type="button" class="btn btn-outline-success btn-sm" onclick="addContactSection()">
                    <i class="bi bi-plus-lg me-1"></i> Add Custom Section
                </button>
            </div>

            <div class="accordion cms-accordion" id="contactSectionsAccordion">
                <?php foreach ($sections as $idx => $sec): ?>
                    <?php $isActive = !isset($sec['is_active']) || !empty($sec['is_active']); ?>
                    <div class="accordion-item contact-sec-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#csec_<?= $idx ?>">
                                <div class="d-flex justify-content-between align-items-center w-100 pe-2">
                                    <span>
                                        <span class="badge bg-light text-dark border me-2 sec-num">#<?= $idx + 1 ?></span>
                                        <strong><?= htmlspecialchars($sec['name'] ?? ($sec['title'] ?? 'Section')) ?></strong>
                                        <span class="badge bg-success-subtle text-success ms-2"><?= htmlspecialchars($sec['type'] ?? 'custom') ?></span>
                                    </span>
                                    <div class="d-flex align-items-center gap-2" onclick="event.stopPropagation();">
                                        <input type="hidden" name="sections[<?= $idx ?>][is_active]" value="<?= $isActive ? '1' : '0' ?>" class="sec-active-hidden">
                                        <div class="form-check form-switch mb-0">
                                            <input class="form-check-input" type="checkbox" <?= $isActive ? 'checked' : '' ?> onchange="this.closest('.contact-sec-item').querySelector('.sec-active-hidden').value = this.checked ? '1' : '0';">
                                            <label class="form-check-label small">Active</label>
                                        </div>
                                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="moveContactSec(this, -1)" title="Move Up"><i class="bi bi-arrow-up"></i></button>
                                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="moveContactSec(this, 1)" title="Move Down"><i class="bi bi-arrow-down"></i></button>
                                        <button type="button" class="btn btn-outline-danger btn-sm" onclick="this.closest('.contact-sec-item').remove()" title="Remove Section"><i class="bi bi-trash3"></i></button>
                                    </div>
                                </div>
                            </button>
                        </h2>
                        <div id="csec_<?= $idx ?>" class="accordion-collapse collapse" data-bs-parent="#contactSectionsAccordion">
                            <div class="accordion-body">
                                <input type="hidden" name="sections[<?= $idx ?>][id]" value="<?= htmlspecialchars($sec['id'] ?? '') ?>">
                                <input type="hidden" name="sections[<?= $idx ?>][type]" value="<?= htmlspecialchars($sec['type'] ?? 'custom_content') ?>">
                                <input type="hidden" name="sections[<?= $idx ?>][category]" value="<?= htmlspecialchars($sec['category'] ?? 'custom') ?>">
                                <input type="hidden" name="sections[<?= $idx ?>][name]" value="<?= htmlspecialchars($sec['name'] ?? '') ?>">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold">Eyebrow</label>
                                        <input type="text" name="sections[<?= $idx ?>][eyebrow]" class="form-control form-control-sm" value="<?= htmlspecialchars($sec['eyebrow'] ?? '') ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold">Section Title</label>
                                        <input type="text" name="sections[<?= $idx ?>][title]" class="form-control form-control-sm" value="<?= htmlspecialchars($sec['title'] ?? '') ?>">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label small fw-bold">Summary / Description (HTML supported)</label>
                                        <textarea name="sections[<?= $idx ?>][summary]" class="form-control form-control-sm" rows="2"><?= htmlspecialchars($sec['summary'] ?? '') ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- TAB 3: SEO & METADATA -->
        <div class="tab-pane fade" id="tab-seo" role="tabpanel">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="fw-bold mb-0">SEO &amp; Metadata</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-bold">Meta Title</label>
                            <input type="text" name="meta_title" class="form-control" value="<?= htmlspecialchars($seo['meta_title'] ?? '') ?>">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">Meta Description</label>
                            <textarea name="meta_description" class="form-control" rows="3"><?= htmlspecialchars($seo['meta_description'] ?? '') ?></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">Keywords</label>
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
function moveContactSec(btn, dir) {
    var item = btn.closest('.contact-sec-item');
    var parent = document.getElementById('contactSectionsAccordion');
    if (dir === -1 && item.previousElementSibling) {
        parent.insertBefore(item, item.previousElementSibling);
    } else if (dir === 1 && item.nextElementSibling) {
        parent.insertBefore(item.nextElementSibling, item);
    }
}

function addContactSection() {
    var acc = document.getElementById('contactSectionsAccordion');
    var idx = acc.querySelectorAll('.contact-sec-item').length;
    var cid = 'csec_new_' + Date.now();
    var html = `
    <div class="accordion-item contact-sec-item">
        <h2 class="accordion-header">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#${cid}">
                <div class="d-flex justify-content-between align-items-center w-100 pe-2">
                    <span><span class="badge bg-light text-dark border me-2">#${idx + 1}</span> <strong>New Custom Section</strong></span>
                    <div class="d-flex align-items-center gap-2" onclick="event.stopPropagation();">
                        <input type="hidden" name="sections[${idx}][is_active]" value="1" class="sec-active-hidden">
                        <div class="form-check form-switch mb-0">
                            <input class="form-check-input" type="checkbox" checked onchange="this.closest('.contact-sec-item').querySelector('.sec-active-hidden').value = this.checked ? '1' : '0';">
                            <label class="form-check-label small">Active</label>
                        </div>
                        <button type="button" class="btn btn-outline-danger btn-sm" onclick="this.closest('.contact-sec-item').remove()"><i class="bi bi-trash3"></i></button>
                    </div>
                </div>
            </button>
        </h2>
        <div id="${cid}" class="accordion-collapse collapse show" data-bs-parent="#contactSectionsAccordion">
            <div class="accordion-body">
                <input type="hidden" name="sections[${idx}][id]" value="sec_contact_${Date.now()}">
                <input type="hidden" name="sections[${idx}][type]" value="custom_content">
                <input type="hidden" name="sections[${idx}][category]" value="custom">
                <input type="hidden" name="sections[${idx}][name]" value="Custom Section">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Eyebrow</label>
                        <input type="text" name="sections[${idx}][eyebrow]" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Section Title</label>
                        <input type="text" name="sections[${idx}][title]" class="form-control form-control-sm" value="New Section">
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-bold">Summary / Description (HTML supported)</label>
                        <textarea name="sections[${idx}][summary]" class="form-control form-control-sm" rows="2"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>`;
    acc.insertAdjacentHTML('beforeend', html);
}
</script>
