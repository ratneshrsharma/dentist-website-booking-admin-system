<?php

declare(strict_types=1);

use App\Core\App;
?>

<div class="row mb-4 align-items-center">
    <div class="col-md-8">
        <h2 class="fw-bold text-dark mb-1">
            <i class="bi bi-layout-text-window-reverse text-success me-2"></i> CMS Website Pages Manager
        </h2>
        <p class="text-muted mb-0">
            Overview of client-facing pages. Select any page to edit content and change section images.
        </p>
    </div>
    <div class="col-md-4 text-md-end mt-3 mt-md-0">
        <a href="<?= App::url('/admin/pages/home/edit') ?>" class="btn btn-brand rounded-pill shadow-sm">
            <i class="bi bi-pencil-square me-1"></i> Edit Homepage Content
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
    <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
        <h5 class="fw-bold mb-0">All Managed Website Pages</h5>
        <span class="badge bg-secondary-subtle text-secondary px-3 py-2 rounded-pill">
            <?= count($pages) ?> Total Pages
        </span>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive" style="max-height: 600px; overflow-x: auto; overflow-y: auto;">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light sticky-top" style="z-index: 10;">
                    <tr>
                        <th class="ps-4" style="width: 25%;">Page Title</th>
                        <th style="width: 20%;">Slug / Route</th>
                        <th style="width: 15%;">Status</th>
                        <th style="width: 15%;">Active Sections</th>
                        <th style="width: 15%;">Last Modified</th>
                        <th class="text-end pe-4" style="width: 10%;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pages as $p): ?>
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="p-2 rounded-3 bg-light border text-primary">
                                        <i class="bi <?= $p['slug'] === 'home' ? 'bi-house-door' : 'bi-file-text' ?> fs-5"></i>
                                    </span>
                                    <div>
                                        <span class="fw-bold text-dark d-block"><?= htmlspecialchars($p['title']) ?></span>
                                        <?php if ($p['slug'] === 'home'): ?>
                                            <span class="badge bg-success-subtle text-success" style="font-size: 10px;">Primary Landing Portal</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark font-monospace border px-2 py-1">
                                    <?= htmlspecialchars($p['route']) ?>
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-success-subtle text-success px-3 py-1 rounded-pill fw-semibold">
                                    <i class="bi bi-check-circle me-1"></i> <?= ucfirst($p['status']) ?>
                                </span>
                            </td>
                            <td>
                                <span class="fw-semibold text-secondary"><?= $p['sections_count'] ?> sections</span>
                            </td>
                            <td>
                                <small class="text-muted"><?= htmlspecialchars($p['updated_at']) ?></small>
                            </td>
                            <td class="text-end pe-4">
                                <?php if ($p['is_editable']): ?>
                                    <a href="<?= App::url('/admin/pages/home/edit') ?>" class="btn btn-brand btn-sm rounded-pill px-3 shadow-sm">
                                        <i class="bi bi-pencil-square me-1"></i> Edit Content
                                    </a>
                                <?php else: ?>
                                    <a href="<?= App::url($p['route']) ?>" target="_blank" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                                        <i class="bi bi-eye me-1"></i> View
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination & Responsive Footer Toolbar -->
        <div class="card-footer bg-white border-top py-3 d-flex flex-wrap justify-content-between align-items-center gap-2">
            <div class="d-flex align-items-center gap-3">
                <small class="text-muted fw-semibold">
                    Showing <span class="text-dark fw-bold"><?= count($pages) ?></span> of <span class="text-dark fw-bold"><?= count($pages) ?></span> managed pages
                </small>
            </div>
            <nav aria-label="Page navigation">
                <ul class="pagination pagination-sm m-0">
                    <li class="page-item disabled"><a class="page-link" href="#"><i class="bi bi-chevron-left"></i></a></li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item disabled"><a class="page-link" href="#"><i class="bi bi-chevron-right"></i></a></li>
                </ul>
            </nav>
        </div>
    </div>
</div>

<div class="alert alert-info border-0 shadow-sm rounded-4 p-4 d-flex align-items-start gap-3">
    <i class="bi bi-info-circle-fill fs-3 text-info mt-1"></i>
    <div>
        <h5 class="fw-bold mb-1">Dynamic Headless Homepage Editing</h5>
        <p class="mb-0 small text-secondary">
            Your homepage is built completely out of dynamic CMS components. Clicking <strong>"Edit Content"</strong> allows you to modify all headlines, clinical stats, services cards, doctor profiles, and upload new images for the hero banner, clinical surgeries, and team members. All modifications are served instantly via <code>/api/v1/pages/home</code>.
        </p>
    </div>
</div>
