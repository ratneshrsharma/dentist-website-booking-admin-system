<?php

use App\Core\App;

$editing = !empty($editCategory);
?>

<div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
    <div>
        <h3 class="fw-bold mb-1 text-dark"><i class="bi bi-folder2-open text-success me-2"></i> Blog Categories</h3>
        <p class="text-muted small mb-0">Organize clinical articles and patient guides into structured categories.</p>
    </div>
    <a href="<?= App::url('/admin/blog/posts') ?>" class="btn btn-outline-secondary btn-sm px-3">
        <i class="bi bi-arrow-left me-1"></i> Back to All Posts
    </a>
</div>

<div class="row g-4">
    <!-- Add / Edit Category Form -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h6 class="fw-bold mb-0"><?= $editing ? 'Edit Category' : 'Add New Category' ?></h6>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="<?= App::url('/admin/blog/categories/save') ?>">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($editCategory['id'] ?? '') ?>">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control form-control-sm" required value="<?= htmlspecialchars($editCategory['name'] ?? '') ?>" placeholder="e.g. Preventive Care">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Slug</label>
                        <input type="text" name="slug" class="form-control form-control-sm" value="<?= htmlspecialchars($editCategory['slug'] ?? '') ?>" placeholder="auto-generated-if-blank">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Description</label>
                        <textarea name="description" class="form-control form-control-sm" rows="3" placeholder="Optional category description..."><?= htmlspecialchars($editCategory['description'] ?? '') ?></textarea>
                    </div>
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1" id="catActive" <?= !$editing || !empty($editCategory['is_active']) ? 'checked' : '' ?>>
                        <label class="form-check-label small fw-semibold" for="catActive">Active on Frontend</label>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-brand btn-sm px-3">
                            <i class="bi bi-check2 me-1"></i> <?= $editing ? 'Update Category' : 'Add Category' ?>
                        </button>
                        <?php if ($editing): ?>
                            <a href="<?= App::url('/admin/blog/categories') ?>" class="btn btn-outline-secondary btn-sm">Cancel</a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Categories List Table -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Posts</th>
                            <th>Status</th>
                            <th class="text-end" style="width: 110px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categories as $cat): ?>
                            <tr>
                                <td>
                                    <div class="fw-bold"><?= htmlspecialchars($cat['name']) ?></div>
                                    <?php if (!empty($cat['description'])): ?>
                                        <div class="small text-muted"><?= htmlspecialchars($cat['description']) ?></div>
                                    <?php endif; ?>
                                </td>
                                <td><code><?= htmlspecialchars($cat['slug']) ?></code></td>
                                <td><span class="badge bg-light text-dark border"><?= (int) ($postCounts[$cat['id']] ?? 0) ?></span></td>
                                <td>
                                    <?php if (!empty($cat['is_active'])): ?>
                                        <span class="badge bg-success-subtle text-success">Active</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary-subtle text-secondary">Inactive</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end">
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= App::url('/admin/blog/categories?edit=' . urlencode($cat['id'])) ?>" class="btn btn-outline-primary" title="Edit Category">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form method="POST" action="<?= App::url('/admin/blog/categories/' . $cat['id'] . '/delete') ?>" class="d-inline" onsubmit="return confirm('Delete this category?');">
                                            <button type="submit" class="btn btn-outline-danger btn-sm" title="Delete Category">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
