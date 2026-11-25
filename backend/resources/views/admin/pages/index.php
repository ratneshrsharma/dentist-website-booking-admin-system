<?php

declare(strict_types=1);

use App\Core\App;
?>

<div class="row mb-4 align-items-center">
    <div class="col-md-7">
        <h2 class="fw-bold text-dark mb-1">
            <i class="bi bi-layout-text-window-reverse text-success me-2"></i> CMS Website Pages Manager
        </h2>
        <p class="text-muted mb-0">
            Create, activate/deactivate, delete, and set any page as your Primary Homepage (WordPress-style) or Blog List.
        </p>
    </div>
    <div class="col-md-5 text-md-end mt-3 mt-md-0 d-flex justify-content-md-end gap-2">
        <button type="button" class="btn btn-brand rounded-pill shadow-sm" data-bs-toggle="modal" data-bs-target="#addPageModal">
            <i class="bi bi-plus-circle me-1"></i> Add New Page
        </button>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
    <div class="card-header bg-white py-3 border-bottom">
        <div class="d-flex align-items-center justify-content-between w-100">
            <h5 class="fw-bold mb-0">All Managed Website Pages</h5>
            <span class="badge bg-secondary-subtle text-secondary px-3 py-2 rounded-pill">
                <?= count($pages) ?> Total Pages
            </span>
        </div>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive" style="max-height: 600px; overflow-x: auto; overflow-y: auto;">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light sticky-top" style="z-index: 10;">
                    <tr>
                        <th class="ps-4" style="width: 28%;">Page Title</th>
                        <th style="width: 18%;">Slug / Route</th>
                        <th style="width: 14%;">Status</th>
                        <th style="width: 12%;">Sections</th>
                        <th style="width: 14%;">Last Modified</th>
                        <th class="text-end pe-4" style="width: 14%;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pages as $p):
                        $isPrimary = !empty($p['is_primary']);
                        $isPublished = ($p['status'] ?? 'published') === 'published';
                        $slug = $p['slug'] ?? '';
                        $editUrl = $slug === 'home'
                            ? '/admin/pages/home/edit'
                            : ($slug === 'about-us' ? '/admin/pages/about-us/edit' : '/admin/pages/' . urlencode($slug) . '/edit');
                    ?>
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="p-2 rounded-3 bg-light border <?= $isPrimary ? 'text-success' : 'text-primary' ?>">
                                        <i class="bi <?= $isPrimary ? 'bi-house-door-fill' : (($p['template'] ?? '') === 'blog_list' ? 'bi-journal-richtext' : 'bi-file-text') ?> fs-5"></i>
                                    </span>
                                    <div>
                                        <span class="fw-bold text-dark d-block"><?= htmlspecialchars($p['title']) ?></span>
                                        <div class="d-flex gap-1 flex-wrap mt-1">
                                            <?php if ($isPrimary): ?>
                                                <span class="badge bg-success-subtle text-success" style="font-size: 10px;">Primary Homepage</span>
                                            <?php endif; ?>
                                            <?php if (($p['template'] ?? '') === 'blog_list'): ?>
                                                <span class="badge bg-info-subtle text-info" style="font-size: 10px;">Blog List</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark font-monospace border px-2 py-1">
                                    <?= htmlspecialchars($p['route']) ?>
                                </span>
                            </td>
                            <td>
                                <form action="<?= App::url('/admin/pages/' . urlencode($slug) . '/toggle') ?>" method="POST" class="d-inline">
                                    <button type="submit"
                                            class="btn btn-sm rounded-pill px-3 fw-semibold <?= $isPublished ? 'btn-success' : 'btn-danger' ?>"
                                            title="Click to <?= $isPublished ? 'Deactivate' : 'Activate' ?> Page">
                                        <i class="bi <?= $isPublished ? 'bi-check-circle' : 'bi-x-circle' ?> me-1"></i>
                                        <?= $isPublished ? 'Active' : 'Inactive' ?>
                                    </button>
                                </form>
                            </td>
                            <td>
                                <span class="fw-semibold text-secondary"><?= (int)($p['sections_count'] ?? 0) ?> sections</span>
                            </td>
                            <td>
                                <small class="text-muted"><?= htmlspecialchars($p['updated_at'] ?? '') ?></small>
                            </td>
                            <td class="text-end pe-4">
                                <div class="btn-group btn-group-sm" role="group" aria-label="Page Actions">
                                    <a href="<?= App::url($p['route']) ?>" target="_blank" class="btn btn-outline-secondary" title="Preview Live Page">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <?php if (!empty($p['is_editable'])): ?>
                                        <a href="<?= App::url($editUrl) ?>" class="btn btn-outline-primary" title="Edit Page Content">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                    <?php endif; ?>
                                    <?php if (!$isPrimary): ?>
                                        <form action="<?= App::url('/admin/pages/' . urlencode($slug) . '/primary') ?>" method="POST" class="d-inline" onsubmit="return confirm('Set \'<?= htmlspecialchars($p['title'], ENT_QUOTES) ?>\' as Primary Homepage?');">
                                            <button type="submit" class="btn btn-outline-success" title="Set as Primary Homepage" style="border-radius: 0;">
                                                <i class="bi bi-house-check"></i>
                                            </button>
                                        </form>
                                        <form action="<?= App::url('/admin/pages/' . urlencode($slug) . '/delete') ?>" method="POST" class="d-inline" onsubmit="return confirm('Delete page \'<?= htmlspecialchars($p['title'], ENT_QUOTES) ?>\'?');">
                                            <button type="submit" class="btn btn-outline-danger" title="Delete Page" style="border-top-left-radius: 0; border-bottom-left-radius: 0;">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination & Responsive Footer Toolbar -->
        <div class="card-footer bg-white border-top py-3">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 w-100">
                <small class="text-muted fw-semibold">
                    Showing <span class="text-dark fw-bold"><?= count($pages) ?></span> of <span class="text-dark fw-bold"><?= count($pages) ?></span> managed pages
                </small>
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
</div>

<!-- Add New Page Modal -->
<div class="modal fade" id="addPageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="<?= App::url('/admin/pages/create') ?>" method="POST" class="modal-content border-0 rounded-4 shadow-lg">
            <div class="modal-header bg-light border-bottom py-3">
                <h5 class="modal-title fw-bold"><i class="bi bi-file-earmark-plus text-success me-2"></i> Add New CMS Page</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Page Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control" required placeholder="e.g. Invisalign Clinic Guide" oninput="autoFillPageSlug(this.value)">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">URL Slug</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light">/</span>
                        <input type="text" name="slug" id="newPageSlugInput" class="form-control font-monospace" placeholder="invisalign-guide">
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Page Template</label>
                        <select name="template" class="form-select">
                            <option value="standard">Standard Content Page</option>
                            <option value="blog_list">Blog List Page</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Initial Status</label>
                        <select name="status" class="form-select">
                            <option value="published">Active (Published)</option>
                            <option value="inactive">Inactive (Draft)</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light border-top py-3">
                <button type="button" class="btn btn-outline-secondary rounded-pill" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-brand rounded-pill px-4">Create Page</button>
            </div>
        </form>
    </div>
</div>

<script>
function autoFillPageSlug(title) {
    const slugEl = document.getElementById('newPageSlugInput');
    if (slugEl && !slugEl.dataset.manual) {
        slugEl.value = title.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
    }
}
document.getElementById('newPageSlugInput')?.addEventListener('input', function () {
    this.dataset.manual = '1';
});
</script>
