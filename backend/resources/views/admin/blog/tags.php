<?php

use App\Core\App;

$editing = !empty($editTag);
?>

<div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
    <div>
        <h3 class="fw-bold mb-1 text-dark"><i class="bi bi-tags text-success me-2"></i> Blog Tags</h3>
        <p class="text-muted small mb-0">Manage topic tags for filtering and internal blog navigation.</p>
    </div>
    <a href="<?= App::url('/admin/blog/posts') ?>" class="btn btn-outline-secondary btn-sm px-3">
        <i class="bi bi-arrow-left me-1"></i> Back to All Posts
    </a>
</div>

<div class="row g-4">
    <!-- Add / Edit Tag Form -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h6 class="fw-bold mb-0"><?= $editing ? 'Edit Tag' : 'Add New Tag' ?></h6>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="<?= App::url('/admin/blog/tags/save') ?>">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($editTag['id'] ?? '') ?>">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Tag Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control form-control-sm" required value="<?= htmlspecialchars($editTag['name'] ?? '') ?>" placeholder="e.g. Airflow Polish">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Slug</label>
                        <input type="text" name="slug" class="form-control form-control-sm" value="<?= htmlspecialchars($editTag['slug'] ?? '') ?>" placeholder="auto-generated-if-blank">
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-brand btn-sm px-3">
                            <i class="bi bi-check2 me-1"></i> <?= $editing ? 'Update Tag' : 'Add Tag' ?>
                        </button>
                        <?php if ($editing): ?>
                            <a href="<?= App::url('/admin/blog/tags') ?>" class="btn btn-outline-secondary btn-sm">Cancel</a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Tags List Table -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Tag Name</th>
                            <th>Slug</th>
                            <th>Posts</th>
                            <th class="text-end" style="width: 110px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tags as $tag): ?>
                            <tr>
                                <td class="fw-bold">#<?= htmlspecialchars($tag['name']) ?></td>
                                <td><code><?= htmlspecialchars($tag['slug']) ?></code></td>
                                <td><span class="badge bg-light text-dark border"><?= (int) ($postCounts[$tag['id']] ?? 0) ?></span></td>
                                <td class="text-end">
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= App::url('/admin/blog/tags?edit=' . urlencode($tag['id'])) ?>" class="btn btn-outline-primary" title="Edit Tag">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form method="POST" action="<?= App::url('/admin/blog/tags/' . $tag['id'] . '/delete') ?>" class="d-inline" onsubmit="return confirm('Delete this tag?');">
                                            <button type="submit" class="btn btn-outline-danger btn-sm" title="Delete Tag">
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
