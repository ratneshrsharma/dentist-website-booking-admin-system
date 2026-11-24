<?php

declare(strict_types=1);

use App\Core\App;

$hero = $about['hero'] ?? [];
$whyUs = $about['why_us'] ?? [];
$pillars = $whyUs['pillars'] ?? [];
$stats = $whyUs['stats'] ?? [];
$clinics = $about['clinics'] ?? [];
$charter = $about['safety_charter'] ?? [];
$seo = $about['seo'] ?? [];
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
            <i class="bi bi-info-circle text-success me-2"></i> About Page Content & Practice Standards Editor
        </h2>
        <p class="text-muted small mb-0">
            Manage practice heritage copy, clinical ethos, 4 key trust pillars, surgeries & amenities, and regulatory safety charter protocols.
        </p>
    </div>
    <div class="col-md-4 text-md-end mt-3 mt-md-0">
        <a href="<?= App::url('/about-us') ?>" target="_blank" class="btn btn-outline-secondary rounded-pill shadow-sm">
            <i class="bi bi-box-arrow-up-right me-1"></i> Preview Live About Page
        </a>
    </div>
</div>

<form action="<?= App::url('/admin/pages/about-us/edit') ?>" method="POST" enctype="multipart/form-data" id="aboutEditorForm">
    <ul class="nav nav-tabs mb-4 border-bottom-0" id="aboutEditorTabs" role="tablist">
        <li class="nav-item">
            <button class="nav-link active px-4 py-2 fw-semibold" data-bs-toggle="tab" data-bs-target="#tab-hero" type="button">
                <i class="bi bi-card-heading me-1"></i> 1. Hero & Team Image
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link px-4 py-2 fw-semibold" data-bs-toggle="tab" data-bs-target="#tab-why-us" type="button">
                <i class="bi bi-shield-check me-1"></i> 2. Why Us & Ethos Pillars
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link px-4 py-2 fw-semibold" data-bs-toggle="tab" data-bs-target="#tab-clinics" type="button">
                <i class="bi bi-building me-1"></i> 3. Our Clinics & Amenities
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link px-4 py-2 fw-semibold" data-bs-toggle="tab" data-bs-target="#tab-charter" type="button">
                <i class="bi bi-file-earmark-medical me-1"></i> 4. NHS Safety Charter
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link px-4 py-2 fw-semibold" data-bs-toggle="tab" data-bs-target="#tab-seo" type="button">
                <i class="bi bi-search me-1"></i> 5. SEO & Metadata
            </button>
        </li>
    </ul>

    <div class="tab-content">
        <!-- 1. HERO TAB -->
        <div class="tab-pane fade show active" id="tab-hero">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="fw-bold mb-0">Hero Banner & Clinical Heritage</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Eyebrow Tagline</label>
                            <input type="text" name="hero_eyebrow" class="form-control" value="<?= htmlspecialchars($hero['eyebrow'] ?? '') ?>" placeholder="e.g. Caring for Birmingham Smiles Since 1998">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Headline Title</label>
                            <input type="text" name="hero_headline" class="form-control" value="<?= htmlspecialchars($hero['headline'] ?? '') ?>">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Practice Story & Subtitle</label>
                            <textarea name="hero_subtitle" class="form-control" rows="3"><?= htmlspecialchars($hero['subtitle'] ?? '') ?></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Hero Team Image</label>
                            <input type="file" name="hero_image_file" class="form-control mb-2" accept="image/*">
                            <input type="text" name="hero_image_manual" class="form-control" value="<?= htmlspecialchars($hero['image'] ?? '') ?>" placeholder="Manual image URL">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Image Caption</label>
                            <input type="text" name="hero_image_caption" class="form-control" value="<?= htmlspecialchars($hero['image_caption'] ?? '') ?>" placeholder="e.g. Principal Clinicians & Care Team — Warwick Road">
                            <?php if (!empty($hero['image'])): ?>
                                <div class="mt-2 text-muted small">
                                    Current Image: <code><?= htmlspecialchars($hero['image']) ?></code>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. WHY US TAB -->
        <div class="tab-pane fade" id="tab-why-us">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="fw-bold mb-0">Practice Ethos & 4 Key Trust Pillars</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Section Eyebrow</label>
                            <input type="text" name="why_us_eyebrow" class="form-control" value="<?= htmlspecialchars($whyUs['eyebrow'] ?? '') ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Section Headline</label>
                            <input type="text" name="why_us_headline" class="form-control" value="<?= htmlspecialchars($whyUs['headline'] ?? '') ?>">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Section Narrative / Subtitle</label>
                            <textarea name="why_us_subtitle" class="form-control" rows="2"><?= htmlspecialchars($whyUs['subtitle'] ?? '') ?></textarea>
                        </div>
                    </div>

                    <h6 class="fw-bold text-success border-bottom pb-2 mb-3">Key Practice Statistics (4 Milestones)</h6>
                    <div class="row g-3">
                        <?php foreach ($stats as $idx => $st): ?>
                            <div class="col-md-3">
                                <div class="card p-3 border bg-light rounded-3">
                                    <label class="form-label small fw-bold">Stat Value (e.g. <?= htmlspecialchars($st['value']) ?>)</label>
                                    <input type="text" name="stats[<?= $idx ?>][value]" class="form-control mb-2" value="<?= htmlspecialchars($st['value'] ?? '') ?>">
                                    <label class="form-label small fw-bold">Label</label>
                                    <input type="text" name="stats[<?= $idx ?>][label]" class="form-control mb-2" value="<?= htmlspecialchars($st['label'] ?? '') ?>">
                                    <label class="form-label small fw-bold">Sub-Description</label>
                                    <input type="text" name="stats[<?= $idx ?>][desc]" class="form-control" value="<?= htmlspecialchars($st['desc'] ?? '') ?>">
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3. CLINICS TAB -->
        <div class="tab-pane fade" id="tab-clinics">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="fw-bold mb-0">Our Clinics & Accessible Amenities</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Eyebrow</label>
                            <input type="text" name="clinics_eyebrow" class="form-control" value="<?= htmlspecialchars($clinics['eyebrow'] ?? '') ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Headline</label>
                            <input type="text" name="clinics_headline" class="form-control" value="<?= htmlspecialchars($clinics['headline'] ?? '') ?>">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Subtitle</label>
                            <textarea name="clinics_subtitle" class="form-control" rows="2"><?= htmlspecialchars($clinics['subtitle'] ?? '') ?></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Surgery Image</label>
                            <input type="file" name="clinics_image_file" class="form-control mb-2" accept="image/*">
                            <input type="text" name="clinics_image_manual" class="form-control" value="<?= htmlspecialchars($clinics['surgery_image'] ?? '') ?>" placeholder="Manual image URL">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Surgery Badge Title & Description</label>
                            <input type="text" name="clinics_surgery_title" class="form-control mb-2" value="<?= htmlspecialchars($clinics['surgery_title'] ?? '') ?>" placeholder="Surgery 1">
                            <input type="text" name="clinics_surgery_desc" class="form-control" value="<?= htmlspecialchars($clinics['surgery_desc'] ?? '') ?>" placeholder="A-dec 500 ergonomic chair...">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 4. SAFETY CHARTER TAB -->
        <div class="tab-pane fade" id="tab-charter">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="fw-bold mb-0">NHS Safety Charter & Regulatory Safeguards</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Charter Eyebrow</label>
                            <input type="text" name="charter_eyebrow" class="form-control" value="<?= htmlspecialchars($charter['eyebrow'] ?? '') ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Charter Headline</label>
                            <input type="text" name="charter_headline" class="form-control" value="<?= htmlspecialchars($charter['headline'] ?? '') ?>">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Charter Summary / Subtitle</label>
                            <textarea name="charter_subtitle" class="form-control" rows="2"><?= htmlspecialchars($charter['subtitle'] ?? '') ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 5. SEO TAB -->
        <div class="tab-pane fade" id="tab-seo">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="fw-bold mb-0">Search Engine Optimization (SEO) & Metadata</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Meta Title Tag</label>
                            <input type="text" name="meta_title" class="form-control" value="<?= htmlspecialchars($seo['meta_title'] ?? '') ?>">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Meta Description</label>
                            <textarea name="meta_description" class="form-control" rows="2"><?= htmlspecialchars($seo['meta_description'] ?? '') ?></textarea>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Target Keywords (Comma Separated)</label>
                            <input type="text" name="keywords" class="form-control" value="<?= htmlspecialchars($seo['keywords'] ?? '') ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sticky Save Action Bar -->
    <div class="card border-0 shadow-lg rounded-4 p-3 bg-white sticky-bottom mt-4" style="z-index: 100;">
        <div class="d-flex align-items-center justify-content-between">
            <span class="text-muted small">
                <i class="bi bi-clock-history me-1"></i> Last modified: <?= htmlspecialchars($about['_updated_at'] ?? '2026-11-24') ?>
            </span>
            <button type="submit" class="btn btn-brand rounded-pill px-5 py-2 shadow-sm fw-bold">
                <i class="bi bi-check-circle-fill me-1"></i> Save About Page Content
            </button>
        </div>
    </div>
</form>
