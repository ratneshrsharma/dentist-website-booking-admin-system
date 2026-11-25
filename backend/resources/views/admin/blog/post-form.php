<?php

use App\Core\App;

$isEdit = !empty($isEdit) && !empty($post['id']);
$formAction = $isEdit
    ? App::url('/admin/blog/posts/' . $post['id'] . '/edit')
    : App::url('/admin/blog/posts/create');

$selectedCats = $post['category_ids'] ?? [];
$selectedTags = $post['tag_ids'] ?? [];
$faqs = $post['faqs'] ?? [];
$seo = $post['seo'] ?? [];
$imgUrl = !empty($post['featured_image']) ? App::url($post['featured_image']) : App::url('/uploads/home/treatment-room.jpg');

include dirname(__DIR__) . '/pages/_editor-styles.php';
?>

<div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-1 small">
                <li class="breadcrumb-item"><a href="<?= App::url('/admin/blog/posts') ?>" class="text-decoration-none">Blog Posts</a></li>
                <li class="breadcrumb-item active"><?= $isEdit ? 'Edit Post' : 'New Post' ?></li>
            </ol>
        </nav>
        <h3 class="fw-bold mb-0 text-dark">
            <i class="bi bi-journal-text text-success me-2"></i>
            <?= $isEdit ? 'Edit Blog Post' : 'Create New Blog Post' ?>
        </h3>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= App::url('/admin/blog/posts') ?>" class="btn btn-outline-secondary btn-sm px-3">
            <i class="bi bi-arrow-left me-1"></i> Back to Posts
        </a>
        <?php if ($isEdit && !empty($post['is_live'])): ?>
            <a href="<?= App::url('/blog/' . $post['slug'] . '/') ?>" target="_blank" class="btn btn-outline-success btn-sm px-3">
                <i class="bi bi-box-arrow-up-right me-1"></i> View Live Post
            </a>
        <?php endif; ?>
    </div>
</div>

<form method="POST" action="<?= $formAction ?>" enctype="multipart/form-data" id="blogPostForm">
    <!-- Tabs Navigation -->
    <ul class="nav nav-tabs cms-tabs mb-4" id="blogPostTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="tab-content-btn" data-bs-toggle="tab" data-bs-target="#tab-content" type="button" role="tab">
                <i class="bi bi-file-earmark-richtext me-1"></i> 1. Post Content, Media &amp; FAQs
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="tab-seo-btn" data-bs-toggle="tab" data-bs-target="#tab-seo" type="button" role="tab">
                <i class="bi bi-search me-1"></i> 2. SEO &amp; Social Metadata
            </button>
        </li>
    </ul>

    <div class="tab-content">
        <!-- TAB 1: POST CONTENT + WORDPRESS SIDEBAR -->
        <div class="tab-pane fade show active" id="tab-content" role="tabpanel">
            <div class="row g-4">
                <!-- MAIN LEFT COLUMN (8 COLS) -->
                <div class="col-lg-8">
                    <!-- Title & Slug -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Post Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" id="postTitleInput" class="form-control form-control-lg fw-semibold" required
                                       value="<?= htmlspecialchars($post['title'] ?? '') ?>"
                                       placeholder="e.g. How Often Should You Book a Dental Hygiene Appointment?">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold small text-muted">Unique URL Slug (Permalink)</label>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text bg-light text-muted">/blog/</span>
                                    <input type="text" name="slug" id="postSlugInput" class="form-control"
                                           value="<?= htmlspecialchars($post['slug'] ?? '') ?>"
                                           placeholder="auto-generated-from-title">
                                    <span class="input-group-text bg-light text-muted">/</span>
                                </div>
                                <div class="form-text">Each post has its own dedicated page URL (no pop-ups).</div>
                            </div>
                            <div class="mb-0">
                                <label class="form-label fw-bold small">Excerpt / Short Summary</label>
                                <textarea name="excerpt" class="form-control" rows="2" placeholder="Concise summary shown on the /blog listing card..."><?= htmlspecialchars($post['excerpt'] ?? '') ?></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Rich HTML Content Editor -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <h6 class="fw-bold mb-0"><i class="bi bi-code-square text-success me-1"></i> Rich Content (HTML Supported)</h6>
                            <div class="btn-group btn-group-sm" role="group">
                                <button type="button" class="btn btn-outline-secondary" onclick="wrapHtml('h2')" title="Heading 2">H2</button>
                                <button type="button" class="btn btn-outline-secondary" onclick="wrapHtml('h3')" title="Heading 3">H3</button>
                                <button type="button" class="btn btn-outline-secondary" onclick="wrapHtml('p')" title="Paragraph">P</button>
                                <button type="button" class="btn btn-outline-secondary fw-bold" onclick="wrapHtml('strong')" title="Bold">B</button>
                                <button type="button" class="btn btn-outline-secondary fst-italic" onclick="wrapHtml('em')" title="Italic">I</button>
                                <button type="button" class="btn btn-outline-secondary" onclick="insertSnippet('<ul>\n  <li>List item</li>\n</ul>')" title="Bullet List"><i class="bi bi-list-ul"></i></button>
                                <button type="button" class="btn btn-outline-secondary" onclick="insertSnippet('<a href=&quot;https://&quot;>Link text</a>')" title="Link"><i class="bi bi-link-45deg"></i></button>
                                <button type="button" class="btn btn-outline-secondary" onclick="insertSnippet('<blockquote>Quote text</blockquote>')" title="Blockquote"><i class="bi bi-quote"></i></button>
                                <button type="button" class="btn btn-outline-primary" id="togglePreviewBtn" onclick="toggleHtmlPreview()"><i class="bi bi-eye me-1"></i> Preview</button>
                            </div>
                        </div>
                        <div class="card-body p-3">
                            <textarea name="content" id="postContentArea" class="form-control font-monospace" rows="14"
                                      placeholder="<p>Write your clinical article here. Standard HTML tags (&lt;h2&gt;, &lt;p&gt;, &lt;ul&gt;, &lt;strong&gt;, &lt;a&gt;, &lt;img&gt;) are fully supported...</p>"><?= htmlspecialchars($post['content'] ?? '') ?></textarea>
                            <div id="postContentPreview" class="border rounded p-3 bg-light d-none" style="min-height: 280px;"></div>
                        </div>
                    </div>

                    <!-- Post FAQs Section (Collapsible Accordion) -->
                    <div class="accordion cms-accordion mb-4" id="postFaqAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePostFaqs">
                                    <div class="d-flex justify-content-between align-items-center w-100 pe-2">
                                        <span><i class="bi bi-question-circle me-2"></i> Post FAQs Section (<?= count($faqs) ?>)</span>
                                        <div class="d-flex align-items-center gap-2" onclick="event.stopPropagation();">
                                            <div class="form-check form-switch mb-0">
                                                <input class="form-check-input" type="checkbox" name="show_faqs" value="1" id="showPostFaqs" <?= !empty($post['show_faqs']) ? 'checked' : '' ?>>
                                                <label class="form-check-label small fw-semibold" for="showPostFaqs">Active</label>
                                            </div>
                                        </div>
                                    </div>
                                </button>
                            </h2>
                            <div id="collapsePostFaqs" class="accordion-collapse collapse" data-bs-parent="#postFaqAccordion">
                                <div class="accordion-body">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <small class="text-muted">Add, reorder, toggle active/inactive, or remove FAQ items displayed at the bottom of this article.</small>
                                        <button type="button" class="btn btn-outline-success btn-sm" onclick="addFaqItem()">
                                            <i class="bi bi-plus-lg me-1"></i> Add FAQ
                                        </button>
                                    </div>
                                    <div id="faqItemsContainer" class="d-flex flex-column gap-3">
                                        <?php foreach ($faqs as $idx => $faq): ?>
                                            <?php $faqIsActive = !isset($faq['is_active']) || !empty($faq['is_active']); ?>
                                            <div class="card border faq-item-card">
                                                <div class="card-header bg-light py-2 d-flex justify-content-between align-items-center">
                                                    <span class="small fw-bold text-secondary faq-index-label">FAQ #<?= $idx + 1 ?></span>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <input type="hidden" name="faq_active[]" value="<?= $faqIsActive ? '1' : '0' ?>" class="faq-active-hidden">
                                                        <div class="form-check form-switch mb-0">
                                                            <input class="form-check-input faq-active-toggle" type="checkbox" <?= $faqIsActive ? 'checked' : '' ?> onchange="this.closest('.faq-item-card').querySelector('.faq-active-hidden').value = this.checked ? '1' : '0';">
                                                            <label class="form-check-label small">Active</label>
                                                        </div>
                                                        <div class="btn-group btn-group-sm">
                                                            <button type="button" class="btn btn-outline-secondary" onclick="moveFaq(this, -1)" title="Move Up"><i class="bi bi-arrow-up"></i></button>
                                                            <button type="button" class="btn btn-outline-secondary" onclick="moveFaq(this, 1)" title="Move Down"><i class="bi bi-arrow-down"></i></button>
                                                            <button type="button" class="btn btn-outline-danger" onclick="removeFaq(this)" title="Remove FAQ"><i class="bi bi-trash3"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-body p-3">
                                                    <div class="mb-2">
                                                        <label class="form-label small fw-semibold mb-1">Question</label>
                                                        <input type="text" name="faq_question[]" class="form-control form-control-sm" value="<?= htmlspecialchars($faq['question'] ?? '') ?>" placeholder="Enter question...">
                                                    </div>
                                                    <div>
                                                        <label class="form-label small fw-semibold mb-1">Answer (HTML supported)</label>
                                                        <textarea name="faq_answer[]" class="form-control form-control-sm" rows="2" placeholder="Enter answer..."><?= htmlspecialchars($faq['answer'] ?? '') ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- WORDPRESS-STYLE RIGHT SIDEBAR (4 COLS) -->
                <div class="col-lg-4">
                    <!-- Publish & Schedule Box -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <h6 class="fw-bold mb-0"><i class="bi bi-send-check text-success me-1"></i> Publish &amp; Schedule</h6>
                        </div>
                        <div class="card-body p-3">
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Post Status</label>
                                <select name="status" id="postStatusSelect" class="form-select form-select-sm">
                                    <option value="published" <?= ($post['status'] ?? '') === 'published' ? 'selected' : '' ?>>Published (Live Immediately)</option>
                                    <option value="scheduled" <?= ($post['status'] ?? '') === 'scheduled' ? 'selected' : '' ?>>Scheduled (Auto-Publish at Date/Time)</option>
                                    <option value="draft" <?= ($post['status'] ?? '') === 'draft' ? 'selected' : '' ?>>Draft (Hidden from Public)</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Publish / Schedule Date &amp; Time</label>
                                <input type="datetime-local" name="published_at" class="form-control form-control-sm"
                                       value="<?= htmlspecialchars(substr((string) ($post['published_at'] ?? date('Y-m-d\TH:i')), 0, 16)) ?>">
                                <div class="form-text">When Status is <strong>Scheduled</strong>, the post goes live automatically once this date/time is reached.</div>
                            </div>
                            <div class="row g-2 mb-3">
                                <div class="col-7">
                                    <label class="form-label small fw-bold">Author</label>
                                    <input type="text" name="author" class="form-control form-control-sm" value="<?= htmlspecialchars($post['author'] ?? 'Dr. Atandrilla Das') ?>">
                                </div>
                                <div class="col-5">
                                    <label class="form-label small fw-bold">Read Time</label>
                                    <input type="text" name="read_time" class="form-control form-control-sm" value="<?= htmlspecialchars($post['read_time'] ?? '4 min read') ?>">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-brand w-100 btn-sm py-2">
                                <i class="bi bi-check2-circle me-1"></i> <?= $isEdit ? 'Update Post' : 'Save & Publish Post' ?>
                            </button>
                        </div>
                    </div>

                    <!-- Categories Box -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white py-2 d-flex justify-content-between align-items-center">
                            <h6 class="fw-bold mb-0 small"><i class="bi bi-folder2-open text-success me-1"></i> Categories</h6>
                            <a href="<?= App::url('/admin/blog/categories') ?>" class="small text-decoration-none">+ Manage</a>
                        </div>
                        <div class="card-body p-3" style="max-height: 200px; overflow-y: auto;">
                            <?php foreach ($categories as $cat): ?>
                                <div class="form-check mb-1">
                                    <input class="form-check-input" type="checkbox" name="category_ids[]" value="<?= htmlspecialchars($cat['id']) ?>" id="cat_<?= htmlspecialchars($cat['id']) ?>"
                                        <?= in_array($cat['id'], $selectedCats, true) ? 'checked' : '' ?>>
                                    <label class="form-check-label small" for="cat_<?= htmlspecialchars($cat['id']) ?>">
                                        <?= htmlspecialchars($cat['name']) ?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Tags Box -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white py-2 d-flex justify-content-between align-items-center">
                            <h6 class="fw-bold mb-0 small"><i class="bi bi-tags text-success me-1"></i> Tags</h6>
                            <a href="<?= App::url('/admin/blog/tags') ?>" class="small text-decoration-none">+ Manage</a>
                        </div>
                        <div class="card-body p-3">
                            <div class="d-flex flex-wrap gap-2 mb-3" style="max-height: 140px; overflow-y: auto;">
                                <?php foreach ($tags as $tag): ?>
                                    <div class="form-check form-check-inline m-0">
                                        <input class="form-check-input" type="checkbox" name="tag_ids[]" value="<?= htmlspecialchars($tag['id']) ?>" id="tag_<?= htmlspecialchars($tag['id']) ?>"
                                            <?= in_array($tag['id'], $selectedTags, true) ? 'checked' : '' ?>>
                                        <label class="form-check-label small" for="tag_<?= htmlspecialchars($tag['id']) ?>">
                                            #<?= htmlspecialchars($tag['name']) ?>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <label class="form-label small fw-bold mb-1">Quick Add New Tags (comma-separated)</label>
                            <input type="text" name="new_tags" class="form-control form-control-sm" placeholder="e.g. Invisalign, Teeth Whitening">
                        </div>
                    </div>

                    <!-- Featured Image Box -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white py-2">
                            <h6 class="fw-bold mb-0 small"><i class="bi bi-image text-success me-1"></i> Featured Image &amp; Alt Tag</h6>
                        </div>
                        <div class="card-body p-3">
                            <div class="mb-2 text-center">
                                <img src="<?= htmlspecialchars($imgUrl) ?>" id="featuredImgPreview" alt="Preview" class="img-fluid rounded border" style="max-height: 160px; width: 100%; object-fit: cover;">
                            </div>
                            <div class="mb-2">
                                <label class="form-label small fw-bold mb-1">Upload Featured Image</label>
                                <input type="file" name="featured_image_file" class="form-control form-control-sm" accept="image/*" onchange="previewFeaturedFile(this)">
                            </div>
                            <div class="mb-2">
                                <label class="form-label small fw-bold mb-1">Or Image Path / URL</label>
                                <input type="text" name="featured_image" id="featuredImgPath" class="form-control form-control-sm" value="<?= htmlspecialchars($post['featured_image'] ?? '/uploads/home/treatment-room.jpg') ?>">
                            </div>
                            <div>
                                <label class="form-label small fw-bold mb-1">Image Alt Tag (Accessibility &amp; SEO)</label>
                                <input type="text" name="featured_image_alt" class="form-control form-control-sm" value="<?= htmlspecialchars($post['featured_image_alt'] ?? '') ?>" placeholder="Describe the image for screen readers &amp; Google">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 2: SEO & METADATA -->
        <div class="tab-pane fade" id="tab-seo" role="tabpanel">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="fw-bold mb-0">SEO &amp; Social Metadata</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label fw-bold">Meta Title</label>
                            <input type="text" name="seo_meta_title" id="seoMetaTitle" class="form-control" value="<?= htmlspecialchars($seo['meta_title'] ?? '') ?>" placeholder="Recommended 50–60 characters">
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" name="seo_no_index" value="1" id="seoNoIndex" <?= !empty($seo['no_index']) ? 'checked' : '' ?>>
                                <label class="form-check-label fw-semibold" for="seoNoIndex">No-Index (Hide from Search Engines)</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">Meta Description</label>
                            <textarea name="seo_meta_description" id="seoMetaDesc" class="form-control" rows="3" placeholder="Recommended 140–160 characters..."><?= htmlspecialchars($seo['meta_description'] ?? '') ?></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Meta Keywords</label>
                            <input type="text" name="seo_meta_keywords" class="form-control" value="<?= htmlspecialchars($seo['meta_keywords'] ?? '') ?>" placeholder="dental hygiene, birmingham dentist, nhs">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Custom OG Social Image URL (Optional)</label>
                            <input type="text" name="seo_og_image" class="form-control" value="<?= htmlspecialchars($seo['og_image'] ?? '') ?>" placeholder="Defaults to Featured Image if blank">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="sticky-save-bar d-flex justify-content-between align-items-center mt-4">
        <span class="small text-muted"><i class="bi bi-info-circle me-1"></i> Scheduled posts automatically publish when their scheduled date/time is reached.</span>
        <button type="submit" class="btn btn-brand btn-sm px-4">
            <i class="bi bi-check2-circle me-1"></i> <?= $isEdit ? 'Update Blog Post' : 'Save Blog Post' ?>
        </button>
    </div>
</form>

<script>
(function() {
    var titleEl = document.getElementById('postTitleInput');
    var slugEl = document.getElementById('postSlugInput');
    var isEdit = <?= $isEdit ? 'true' : 'false' ?>;
    var slugEdited = isEdit && slugEl.value.trim() !== '';

    slugEl.addEventListener('input', function() { slugEdited = true; });
    titleEl.addEventListener('input', function() {
        if (!slugEdited) {
            slugEl.value = titleEl.value.toLowerCase().trim()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-');
        }
    });
})();

function wrapHtml(tag) {
    var ta = document.getElementById('postContentArea');
    var start = ta.selectionStart, end = ta.selectionEnd;
    var selected = ta.value.substring(start, end) || 'Text here';
    var replacement = '<' + tag + '>' + selected + '</' + tag + '>';
    ta.value = ta.value.substring(0, start) + replacement + ta.value.substring(end);
    ta.focus();
}

function insertSnippet(snippet) {
    var ta = document.getElementById('postContentArea');
    var start = ta.selectionStart;
    ta.value = ta.value.substring(0, start) + snippet + ta.value.substring(start);
    ta.focus();
}

function toggleHtmlPreview() {
    var ta = document.getElementById('postContentArea');
    var prev = document.getElementById('postContentPreview');
    var btn = document.getElementById('togglePreviewBtn');
    if (prev.classList.contains('d-none')) {
        prev.innerHTML = ta.value || '<p class="text-muted">Nothing to preview yet.</p>';
        prev.classList.remove('d-none');
        ta.classList.add('d-none');
        btn.innerHTML = '<i class="bi bi-code me-1"></i> Edit HTML';
    } else {
        prev.classList.add('d-none');
        ta.classList.remove('d-none');
        btn.innerHTML = '<i class="bi bi-eye me-1"></i> Preview';
    }
}

function previewFeaturedFile(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('featuredImgPreview').src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function renumberFaqs() {
    document.querySelectorAll('#faqItemsContainer .faq-item-card').forEach(function(card, i) {
        var lbl = card.querySelector('.faq-index-label');
        if (lbl) lbl.textContent = 'FAQ #' + (i + 1);
    });
}

function addFaqItem() {
    var container = document.getElementById('faqItemsContainer');
    var count = container.querySelectorAll('.faq-item-card').length + 1;
    var html = `
    <div class="card border faq-item-card">
        <div class="card-header bg-light py-2 d-flex justify-content-between align-items-center">
            <span class="small fw-bold text-secondary faq-index-label">FAQ #${count}</span>
            <div class="d-flex align-items-center gap-2">
                <input type="hidden" name="faq_active[]" value="1" class="faq-active-hidden">
                <div class="form-check form-switch mb-0">
                    <input class="form-check-input faq-active-toggle" type="checkbox" checked onchange="this.closest('.faq-item-card').querySelector('.faq-active-hidden').value = this.checked ? '1' : '0';">
                    <label class="form-check-label small">Active</label>
                </div>
                <div class="btn-group btn-group-sm">
                    <button type="button" class="btn btn-outline-secondary" onclick="moveFaq(this, -1)" title="Move Up"><i class="bi bi-arrow-up"></i></button>
                    <button type="button" class="btn btn-outline-secondary" onclick="moveFaq(this, 1)" title="Move Down"><i class="bi bi-arrow-down"></i></button>
                    <button type="button" class="btn btn-outline-danger" onclick="removeFaq(this)" title="Remove FAQ"><i class="bi bi-trash3"></i></button>
                </div>
            </div>
        </div>
        <div class="card-body p-3">
            <div class="mb-2">
                <label class="form-label small fw-semibold mb-1">Question</label>
                <input type="text" name="faq_question[]" class="form-control form-control-sm" placeholder="Enter question...">
            </div>
            <div>
                <label class="form-label small fw-semibold mb-1">Answer (HTML supported)</label>
                <textarea name="faq_answer[]" class="form-control form-control-sm" rows="2" placeholder="Enter answer..."></textarea>
            </div>
        </div>
    </div>`;
    container.insertAdjacentHTML('beforeend', html);
}

function moveFaq(btn, dir) {
    var card = btn.closest('.faq-item-card');
    var container = document.getElementById('faqItemsContainer');
    if (dir === -1 && card.previousElementSibling) {
        container.insertBefore(card, card.previousElementSibling);
    } else if (dir === 1 && card.nextElementSibling) {
        container.insertBefore(card.nextElementSibling, card);
    }
    renumberFaqs();
}

function removeFaq(btn) {
    btn.closest('.faq-item-card').remove();
    renumberFaqs();
}
</script>
