<?php

declare(strict_types=1);

use App\Core\App;

$hero = $pageData['hero'] ?? [];
$sections = $pageData['sections'] ?? [];
$blogPosts = $pageData['blog_posts'] ?? [];
$seo = $pageData['seo'] ?? [];
$isBlog = (($pageData['template'] ?? '') === 'blog_list' || $slug === 'blog');

require __DIR__ . '/_editor-styles.php';
?>

<div class="row mb-4 align-items-center">
    <div class="col-md-8">
        <div class="d-flex align-items-center gap-2 mb-1">
            <a href="<?= App::url('/admin/pages') ?>" class="text-decoration-none text-muted small">
                <i class="bi bi-arrow-left"></i> Back to Page List
            </a>
            <span class="text-muted small">/</span>
            <span class="text-success small fw-semibold"><?= htmlspecialchars($pageData['title'] ?? ucfirst($slug)) ?></span>
        </div>
        <h2 class="fw-bold text-dark mb-0">
            <i class="bi <?= $isBlog ? 'bi-journal-richtext' : 'bi-file-earmark-richtext' ?> text-success me-2"></i>
            <?= htmlspecialchars($pageData['title'] ?? ucfirst($slug)) ?> Editor
        </h2>
        <p class="text-muted small mb-0">
            Manage banner, dynamic sections, <?= $isBlog ? 'blog posts, ' : '' ?>and SEO metadata. HTML tags are supported.
        </p>
    </div>
    <div class="col-md-4 text-md-end mt-3 mt-md-0">
        <a href="<?= App::url($isBlog ? '/blog' : '/' . $slug) ?>" target="_blank" class="btn btn-outline-secondary rounded-pill shadow-sm">
            <i class="bi bi-box-arrow-up-right me-1"></i> Preview Live Page
        </a>
    </div>
</div>

<form action="<?= App::url('/admin/pages/' . urlencode($slug) . '/edit') ?>" method="POST" enctype="multipart/form-data">
    <ul class="nav cms-editor-tabs mb-4" role="tablist">
        <li class="nav-item">
            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#sec-hero" type="button">
                <i class="bi bi-image"></i> 1. Banner &amp; CTAs
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#sec-composition" type="button">
                <i class="bi bi-layers-fill"></i> 2. Content Sections <?= $isBlog ? '&amp; Blog Posts' : '' ?>
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
                    <h5 class="fw-bold mb-0">Page Banner &amp; Headlines</h5>
                </div>
                <div class="card-body p-4">
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
                            <label class="form-label fw-semibold">Upload Banner Image</label>
                            <input type="file" name="hero_image_file" class="form-control" accept="image/*">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Or Image Path</label>
                            <input type="text" name="hero_image_manual" class="form-control font-monospace" value="<?= htmlspecialchars($hero['image'] ?? '') ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. CONTENT & BLOG POSTS -->
        <div class="tab-pane fade" id="sec-composition">
            <?php if ($isBlog): ?>
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white py-3 border-bottom">
                        <div class="d-flex justify-content-between align-items-center w-100">
                            <div>
                                <h5 class="fw-bold mb-0"><i class="bi bi-journal-richtext text-success me-2"></i> Managed Blog Posts (<?= count($blogPosts) ?>)</h5>
                                <small class="text-muted">Add, reorder, or remove articles displayed on <code>/blog</code>.</small>
                            </div>
                            <button type="button" class="btn btn-brand rounded-pill btn-sm" onclick="addBlogPostRow()">
                                <i class="bi bi-plus-circle me-1"></i> Add Blog Post
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div id="blogPostsContainer" class="row g-3">
                            <?php foreach ($blogPosts as $bIdx => $bp): ?>
                                <div class="col-md-6 blog-post-item">
                                    <div class="p-3 bg-light rounded-3 border h-100">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="badge bg-success-subtle text-success fw-bold">Article #<?= $bIdx + 1 ?></span>
                                            <div class="btn-group btn-group-sm">
                                                <button type="button" class="btn btn-outline-secondary" onclick="moveLoopItem(this, '.blog-post-item', -1)" title="Move Up"><i class="bi bi-arrow-up"></i></button>
                                                <button type="button" class="btn btn-outline-secondary" onclick="moveLoopItem(this, '.blog-post-item', 1)" title="Move Down"><i class="bi bi-arrow-down"></i></button>
                                                <button type="button" class="btn btn-outline-danger" onclick="this.closest('.blog-post-item').remove()" title="Delete Post"><i class="bi bi-trash"></i></button>
                                            </div>
                                        </div>
                                        <input type="hidden" name="blog_posts[<?= $bIdx ?>][id]" value="<?= htmlspecialchars($bp['id'] ?? ('post_' . ($bIdx + 1))) ?>">
                                        <label class="form-label small fw-bold">Title</label>
                                        <input type="text" name="blog_posts[<?= $bIdx ?>][title]" class="form-control form-control-sm fw-bold mb-2" value="<?= htmlspecialchars($bp['title'] ?? '') ?>">
                                        <div class="row g-2 mb-2">
                                            <div class="col-4">
                                                <label class="form-label small fw-bold">Category</label>
                                                <input type="text" name="blog_posts[<?= $bIdx ?>][category]" class="form-control form-control-sm" value="<?= htmlspecialchars($bp['category'] ?? '') ?>">
                                            </div>
                                            <div class="col-4">
                                                <label class="form-label small fw-bold">Author</label>
                                                <input type="text" name="blog_posts[<?= $bIdx ?>][author]" class="form-control form-control-sm" value="<?= htmlspecialchars($bp['author'] ?? '') ?>">
                                            </div>
                                            <div class="col-4">
                                                <label class="form-label small fw-bold">Date</label>
                                                <input type="date" name="blog_posts[<?= $bIdx ?>][date]" class="form-control form-control-sm" value="<?= htmlspecialchars($bp['date'] ?? date('Y-m-d')) ?>">
                                            </div>
                                        </div>
                                        <label class="form-label small fw-bold">Excerpt</label>
                                        <textarea name="blog_posts[<?= $bIdx ?>][excerpt]" class="form-control form-control-sm mb-2" rows="2"><?= htmlspecialchars($bp['excerpt'] ?? '') ?></textarea>
                                        <label class="form-label small fw-bold">Full Content (HTML supported)</label>
                                        <textarea name="blog_posts[<?= $bIdx ?>][content]" class="form-control form-control-sm mb-2" rows="3"><?= htmlspecialchars($bp['content'] ?? '') ?></textarea>
                                        <label class="form-label small fw-bold">Featured Image URL</label>
                                        <input type="text" name="blog_posts[<?= $bIdx ?>][image]" class="form-control form-control-sm font-monospace" value="<?= htmlspecialchars($bp['image'] ?? '') ?>">
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="fw-bold mb-0"><i class="bi bi-layers-fill text-success me-2"></i> Page Sections (<?= count($sections) ?>)</h5>
                </div>
                <div class="card-body p-4">
                    <div class="d-flex flex-column gap-3">
                        <?php foreach ($sections as $idx => $sec):
                            $secId = $sec['id'] ?? ('sec_' . ($idx + 1));
                        ?>
                            <div class="card border rounded-4 shadow-none bg-light section-item-card">
                                <div class="card-header section-acc-header border-bottom">
                                    <div class="section-acc-left">
                                        <span class="badge bg-dark-subtle text-dark font-monospace section-order-badge">#<?= $idx + 1 ?></span>
                                        <span class="fw-bold text-dark section-name-display"><?= htmlspecialchars($sec['name'] ?? $sec['title'] ?? 'Section') ?></span>
                                    </div>
                                    <div class="section-acc-right">
                                        <div class="form-check form-switch m-0">
                                            <input class="form-check-input" type="checkbox" name="sections[<?= $idx ?>][is_active]" value="1" id="cSecActive_<?= $idx ?>" <?= ($sec['is_active'] ?? true) ? 'checked' : '' ?>>
                                            <label class="form-check-label small fw-semibold" for="cSecActive_<?= $idx ?>">Active</label>
                                        </div>
                                        <button type="button" class="section-toggle-btn collapsed" data-bs-toggle="collapse" data-bs-target="#cSecCollapse_<?= $idx ?>" aria-expanded="false">
                                            <i class="bi bi-plus-lg"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="collapse" id="cSecCollapse_<?= $idx ?>">
                                    <div class="card-body p-4 bg-white border-top">
                                        <input type="hidden" name="sections[<?= $idx ?>][id]" value="<?= htmlspecialchars($secId) ?>">
                                        <input type="hidden" name="sections[<?= $idx ?>][type]" value="<?= htmlspecialchars($sec['type'] ?? 'custom_content') ?>">
                                        <input type="hidden" name="sections[<?= $idx ?>][category]" value="<?= htmlspecialchars($sec['category'] ?? 'custom_content') ?>">
                                        <input type="hidden" name="sections[<?= $idx ?>][name]" value="<?= htmlspecialchars($sec['name'] ?? '') ?>">
                                        <input type="hidden" name="sections[<?= $idx ?>][order]" value="<?= $idx + 1 ?>">
                                        <div class="row g-3">
                                            <div class="col-md-4">
                                                <label class="form-label small fw-semibold">Eyebrow</label>
                                                <input type="text" name="sections[<?= $idx ?>][eyebrow]" class="form-control form-control-sm" value="<?= htmlspecialchars($sec['eyebrow'] ?? '') ?>">
                                            </div>
                                            <div class="col-md-5">
                                                <label class="form-label small fw-semibold">Title (HTML supported)</label>
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
                                                <label class="form-label small fw-semibold">Summary</label>
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

        <!-- 3. SEO -->
        <div class="tab-pane fade" id="sec-seo">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-3 border-bottom">
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

    <div class="card border-0 shadow-sm rounded-4 p-3 bg-white sticky-bottom mb-4">
        <div class="d-flex align-items-center justify-content-between">
            <span class="text-muted small"><i class="bi bi-cloud-check text-success me-1"></i> Changes save immediately to <code>/api/v1/pages/<?= htmlspecialchars($slug) ?></code>.</span>
            <button type="submit" class="btn btn-brand rounded-pill px-4 shadow-sm"><i class="bi bi-check-lg me-1"></i> Save Page</button>
        </div>
    </div>
</form>

<script>
function moveLoopItem(btn, selector, dir) {
    const item = btn.closest(selector);
    if (!item) return;
    if (dir < 0 && item.previousElementSibling) {
        item.parentNode.insertBefore(item, item.previousElementSibling);
    } else if (dir > 0 && item.nextElementSibling) {
        item.parentNode.insertBefore(item.nextElementSibling, item);
    }
}

function addBlogPostRow() {
    const container = document.getElementById('blogPostsContainer');
    const idx = Date.now();
    const html = `
    <div class="col-md-6 blog-post-item">
        <div class="p-3 bg-light rounded-3 border h-100">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="badge bg-success-subtle text-success fw-bold">New Article</span>
                <div class="btn-group btn-group-sm">
                    <button type="button" class="btn btn-outline-secondary" onclick="moveLoopItem(this, '.blog-post-item', -1)"><i class="bi bi-arrow-up"></i></button>
                    <button type="button" class="btn btn-outline-secondary" onclick="moveLoopItem(this, '.blog-post-item', 1)"><i class="bi bi-arrow-down"></i></button>
                    <button type="button" class="btn btn-outline-danger" onclick="this.closest('.blog-post-item').remove()"><i class="bi bi-trash"></i></button>
                </div>
            </div>
            <input type="hidden" name="blog_posts[${idx}][id]" value="post_${idx}">
            <label class="form-label small fw-bold">Title</label>
            <input type="text" name="blog_posts[${idx}][title]" class="form-control form-control-sm fw-bold mb-2" placeholder="Article Headline">
            <div class="row g-2 mb-2">
                <div class="col-4"><label class="form-label small fw-bold">Category</label><input type="text" name="blog_posts[${idx}][category]" class="form-control form-control-sm" value="Dental Care"></div>
                <div class="col-4"><label class="form-label small fw-bold">Author</label><input type="text" name="blog_posts[${idx}][author]" class="form-control form-control-sm" value="Clinical Team"></div>
                <div class="col-4"><label class="form-label small fw-bold">Date</label><input type="date" name="blog_posts[${idx}][date]" class="form-control form-control-sm" value="<?= date('Y-m-d') ?>"></div>
            </div>
            <label class="form-label small fw-bold">Excerpt</label>
            <textarea name="blog_posts[${idx}][excerpt]" class="form-control form-control-sm mb-2" rows="2"></textarea>
            <label class="form-label small fw-bold">Full Content (HTML supported)</label>
            <textarea name="blog_posts[${idx}][content]" class="form-control form-control-sm mb-2" rows="3"></textarea>
            <label class="form-label small fw-bold">Featured Image URL</label>
            <input type="text" name="blog_posts[${idx}][image]" class="form-control form-control-sm font-monospace" value="<?= App::url('/uploads/home/treatment-room.jpg') ?>">
        </div>
    </div>`;
    container.insertAdjacentHTML('beforeend', html);
}
</script>
