<?php

use App\Core\App;

$statusFilter = $statusFilter ?? 'all';
$counts = $counts ?? ['all' => 0, 'published' => 0, 'scheduled' => 0, 'draft' => 0];
?>

<div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
    <div>
        <h3 class="fw-bold mb-1 text-dark">
            <i class="bi bi-journal-richtext text-success me-2"></i> Blog Posts
        </h3>
        <p class="text-muted small mb-0">Manage articles, publish status, scheduled posts, categories, tags, and SEO metadata.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= App::url('/admin/blog/categories') ?>" class="btn btn-outline-secondary btn-sm px-3">
            <i class="bi bi-folder2-open me-1"></i> Categories
        </a>
        <a href="<?= App::url('/admin/blog/tags') ?>" class="btn btn-outline-secondary btn-sm px-3">
            <i class="bi bi-tags me-1"></i> Tags
        </a>
        <a href="<?= App::url('/admin/blog/posts/create') ?>" class="btn btn-brand btn-sm px-3">
            <i class="bi bi-plus-lg me-1"></i> Add New Post
        </a>
    </div>
</div>

<!-- WordPress-style Status Filter Bar & Search -->
<div class="card border-0 shadow-sm mb-3">
    <div class="card-body py-2 px-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <a href="<?= App::url('/admin/blog/posts?status=all') ?>" class="btn btn-sm <?= $statusFilter === 'all' ? 'btn-dark' : 'btn-outline-secondary' ?>">
                All <span class="badge bg-secondary ms-1"><?= (int) $counts['all'] ?></span>
            </a>
            <a href="<?= App::url('/admin/blog/posts?status=published') ?>" class="btn btn-sm <?= $statusFilter === 'published' ? 'btn-success' : 'btn-outline-success' ?>">
                Published <span class="badge bg-success ms-1"><?= (int) $counts['published'] ?></span>
            </a>
            <a href="<?= App::url('/admin/blog/posts?status=scheduled') ?>" class="btn btn-sm <?= $statusFilter === 'scheduled' ? 'btn-info text-white' : 'btn-outline-info' ?>">
                Scheduled <span class="badge bg-info text-dark ms-1"><?= (int) $counts['scheduled'] ?></span>
            </a>
            <a href="<?= App::url('/admin/blog/posts?status=draft') ?>" class="btn btn-sm <?= $statusFilter === 'draft' ? 'btn-secondary' : 'btn-outline-secondary' ?>">
                Drafts <span class="badge bg-secondary ms-1"><?= (int) $counts['draft'] ?></span>
            </a>
        </div>
        <form method="GET" action="<?= App::url('/admin/blog/posts') ?>" class="d-flex gap-2">
            <input type="hidden" name="status" value="<?= htmlspecialchars($statusFilter) ?>">
            <input type="text" name="q" value="<?= htmlspecialchars($search ?? '') ?>" class="form-control form-control-sm" placeholder="Search posts..." style="width: 220px;">
            <button type="submit" class="btn btn-outline-primary btn-sm" title="Search"><i class="bi bi-search"></i></button>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th style="width: 64px;">Image</th>
                    <th>Post Title &amp; Slug</th>
                    <th>Categories &amp; Tags</th>
                    <th>Author</th>
                    <th>Status</th>
                    <th>Publish / Schedule Date</th>
                    <th class="text-end" style="width: 140px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($posts)): ?>
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="bi bi-journal-x fs-2 d-block mb-2 opacity-50"></i>
                            No blog posts found. <a href="<?= App::url('/admin/blog/posts/create') ?>">Create your first post</a>.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($posts as $post): ?>
                        <?php
                        $eff = $post['effective_status'] ?? 'draft';
                        $isLive = !empty($post['is_live']);
                        $imgSrc = !empty($post['featured_image']) ? App::url($post['featured_image']) : App::url('/uploads/home/treatment-room.jpg');
                        $liveUrl = App::url('/blog/' . ($post['slug'] ?? '') . '/');
                        ?>
                        <tr>
                            <td>
                                <img src="<?= htmlspecialchars($imgSrc) ?>" alt="<?= htmlspecialchars($post['featured_image_alt'] ?? $post['title']) ?>" class="rounded border" style="width: 52px; height: 40px; object-fit: cover;">
                            </td>
                            <td>
                                <div class="fw-bold text-dark"><?= htmlspecialchars($post['title'] ?? '') ?></div>
                                <div class="small text-muted"><code>/blog/<?= htmlspecialchars($post['slug'] ?? '') ?></code></div>
                            </td>
                            <td>
                                <div class="d-flex flex-wrap gap-1 mb-1">
                                    <?php foreach (($post['categories'] ?? []) as $cat): ?>
                                        <span class="badge bg-success-subtle text-success border border-success-subtle"><?= htmlspecialchars($cat['name']) ?></span>
                                    <?php endforeach; ?>
                                </div>
                                <div class="d-flex flex-wrap gap-1">
                                    <?php foreach (($post['tags'] ?? []) as $tag): ?>
                                        <span class="badge bg-light text-secondary border">#<?= htmlspecialchars($tag['name']) ?></span>
                                    <?php endforeach; ?>
                                </div>
                            </td>
                            <td class="small text-muted"><?= htmlspecialchars($post['author'] ?? '') ?></td>
                            <td>
                                <form method="POST" action="<?= App::url('/admin/blog/posts/' . $post['id'] . '/toggle') ?>" class="d-inline">
                                    <?php if ($eff === 'published'): ?>
                                        <button type="submit" class="btn btn-sm btn-success rounded-pill px-2 py-0" title="Click to switch to Draft" style="font-size: 11px;">
                                            <i class="bi bi-check-circle-fill me-1"></i> Published
                                        </button>
                                    <?php elseif ($eff === 'scheduled'): ?>
                                        <button type="submit" class="btn btn-sm btn-info text-dark rounded-pill px-2 py-0" title="Scheduled — click to publish now or manage" style="font-size: 11px;">
                                            <i class="bi bi-clock-fill me-1"></i> Scheduled
                                        </button>
                                    <?php else: ?>
                                        <button type="submit" class="btn btn-sm btn-secondary rounded-pill px-2 py-0" title="Draft — click to publish" style="font-size: 11px;">
                                            <i class="bi bi-pencil-fill me-1"></i> Draft
                                        </button>
                                    <?php endif; ?>
                                </form>
                            </td>
                            <td class="small text-muted">
                                <?= htmlspecialchars(str_replace('T', ' ', (string) ($post['published_at'] ?? ''))) ?>
                            </td>
                            <td class="text-end">
                                <div class="btn-group btn-group-sm" role="group">
                                    <?php if ($isLive): ?>
                                        <a href="<?= htmlspecialchars($liveUrl) ?>" target="_blank" class="btn btn-outline-secondary" title="View Live Post">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    <?php endif; ?>
                                    <a href="<?= App::url('/admin/blog/posts/' . $post['id'] . '/edit') ?>" class="btn btn-outline-primary" title="Edit Post">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form method="POST" action="<?= App::url('/admin/blog/posts/' . $post['id'] . '/delete') ?>" class="d-inline" onsubmit="return confirm('Delete this blog post permanently?');">
                                        <button type="submit" class="btn btn-outline-danger btn-sm" title="Delete Post">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
