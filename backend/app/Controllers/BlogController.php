<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\App;
use App\Core\Auth;
use App\Services\BlogService;

/**
 * WordPress-style Blog Admin Controller (Posts, Categories, Tags)
 */
class BlogController
{
    public function posts(): void
    {
        Auth::requirePermission('blog');

        $statusFilter = trim((string) ($_GET['status'] ?? 'all'));
        $search = strtolower(trim((string) ($_GET['q'] ?? '')));

        $allPosts = BlogService::getAllPosts(false);
        $counts = [
            'all' => count($allPosts),
            'published' => 0,
            'scheduled' => 0,
            'draft' => 0,
        ];
        foreach ($allPosts as $p) {
            $eff = $p['effective_status'] ?? 'draft';
            if (isset($counts[$eff])) {
                $counts[$eff]++;
            }
        }

        $filtered = array_values(array_filter($allPosts, static function ($p) use ($statusFilter, $search) {
            if ($statusFilter !== 'all' && ($p['effective_status'] ?? 'draft') !== $statusFilter) {
                return false;
            }
            if ($search !== '') {
                $hay = strtolower(($p['title'] ?? '') . ' ' . ($p['slug'] ?? '') . ' ' . ($p['author'] ?? ''));
                if (!str_contains($hay, $search)) {
                    return false;
                }
            }
            return true;
        }));

        App::render('admin/blog/posts', [
            'pageTitle' => 'Blog Posts',
            'activeNav' => 'blog-posts',
            'posts' => $filtered,
            'counts' => $counts,
            'statusFilter' => $statusFilter,
            'search' => $search,
        ]);
    }

    public function createPost(): void
    {
        Auth::requirePermission('blog');

        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
            $this->handlePostSave(null);
            return;
        }

        App::render('admin/blog/post-form', [
            'pageTitle' => 'Add New Blog Post',
            'activeNav' => 'blog-new',
            'post' => [
                'id' => '',
                'title' => '',
                'slug' => '',
                'status' => 'published',
                'published_at' => date('Y-m-d\TH:i'),
                'author' => 'Dr. Atandrilla Das',
                'read_time' => '4 min read',
                'category_ids' => [],
                'tag_ids' => [],
                'featured_image' => '/uploads/home/treatment-room.jpg',
                'featured_image_alt' => '',
                'excerpt' => '',
                'content' => '',
                'show_faqs' => true,
                'faqs' => [],
                'seo' => [
                    'meta_title' => '',
                    'meta_description' => '',
                    'meta_keywords' => '',
                    'og_image' => '',
                    'no_index' => false,
                ],
            ],
            'categories' => BlogService::getCategories(),
            'tags' => BlogService::getTags(),
            'isEdit' => false,
        ]);
    }

    public function editPost(string $id): void
    {
        Auth::requirePermission('blog');

        $post = BlogService::getPostById($id);
        if (!$post) {
            App::flash('error', 'Blog post not found.');
            App::redirect('/admin/blog/posts');
        }

        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
            $this->handlePostSave($id);
            return;
        }

        App::render('admin/blog/post-form', [
            'pageTitle' => 'Edit Post: ' . ($post['title'] ?? ''),
            'activeNav' => 'blog-posts',
            'post' => $post,
            'categories' => BlogService::getCategories(),
            'tags' => BlogService::getTags(),
            'isEdit' => true,
        ]);
    }

    private function handlePostSave(?string $id): void
    {
        $existing = $id ? BlogService::getPostById($id) : null;
        $featuredImage = trim((string) ($_POST['featured_image'] ?? ($existing['featured_image'] ?? '/uploads/home/treatment-room.jpg')));

        // Handle featured image upload to uploads/blog/
        if (!empty($_FILES['featured_image_file']['tmp_name']) && is_uploaded_file($_FILES['featured_image_file']['tmp_name'])) {
            $ext = strtolower(pathinfo($_FILES['featured_image_file']['name'], PATHINFO_EXTENSION));
            $allowed = ['jpg', 'jpeg', 'png', 'webp', 'gif', 'svg'];
            if (in_array($ext, $allowed, true)) {
                $uploadDir = dirname(__DIR__, 2) . '/public/uploads/blog';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                $filename = 'blog-' . time() . '-' . mt_rand(100, 999) . '.' . $ext;
                if (move_uploaded_file($_FILES['featured_image_file']['tmp_name'], $uploadDir . DIRECTORY_SEPARATOR . $filename)) {
                    $featuredImage = '/uploads/blog/' . $filename;
                }
            }
        }

        // Parse FAQs
        $faqs = [];
        $faqQ = $_POST['faq_question'] ?? [];
        $faqA = $_POST['faq_answer'] ?? [];
        $faqActive = $_POST['faq_active'] ?? [];
        if (is_array($faqQ)) {
            foreach ($faqQ as $idx => $q) {
                $qText = trim((string) $q);
                $aText = trim((string) ($faqA[$idx] ?? ''));
                if ($qText !== '' || $aText !== '') {
                    $faqs[] = [
                        'question' => $qText,
                        'answer' => $aText,
                        'is_active' => isset($faqActive[$idx]) && (string) $faqActive[$idx] === '1',
                    ];
                }
            }
        }

        $saved = BlogService::savePost([
            'title' => $_POST['title'] ?? '',
            'slug' => $_POST['slug'] ?? '',
            'status' => $_POST['status'] ?? 'draft',
            'published_at' => $_POST['published_at'] ?? date('Y-m-d\TH:i'),
            'author' => $_POST['author'] ?? 'Acocks Green Clinical Team',
            'read_time' => $_POST['read_time'] ?? '4 min read',
            'category_ids' => $_POST['category_ids'] ?? [],
            'tag_ids' => $_POST['tag_ids'] ?? [],
            'new_tags' => $_POST['new_tags'] ?? '',
            'featured_image' => $featuredImage,
            'featured_image_alt' => $_POST['featured_image_alt'] ?? '',
            'excerpt' => $_POST['excerpt'] ?? '',
            'content' => $_POST['content'] ?? '',
            'show_faqs' => !empty($_POST['show_faqs']),
            'faqs' => $faqs,
            'seo' => [
                'meta_title' => $_POST['seo_meta_title'] ?? '',
                'meta_description' => $_POST['seo_meta_description'] ?? '',
                'meta_keywords' => $_POST['seo_meta_keywords'] ?? '',
                'og_image' => $_POST['seo_og_image'] ?? '',
                'no_index' => !empty($_POST['seo_no_index']),
            ],
        ], $id);

        App::flash('success', $id ? 'Blog post updated successfully!' : 'Blog post created successfully!');
        App::redirect('/admin/blog/posts/' . $saved['id'] . '/edit');
    }

    public function togglePostStatus(string $id): void
    {
        Auth::requirePermission('blog');
        BlogService::togglePostStatus($id);
        App::flash('success', 'Post status updated.');
        App::redirect('/admin/blog/posts');
    }

    public function deletePost(string $id): void
    {
        Auth::requirePermission('blog');
        BlogService::deletePost($id);
        App::flash('success', 'Blog post deleted.');
        App::redirect('/admin/blog/posts');
    }

    // =========================================================================
    // CATEGORIES
    // =========================================================================

    public function categories(): void
    {
        Auth::requirePermission('blog');
        $editId = trim((string) ($_GET['edit'] ?? ''));
        $editCategory = $editId !== '' ? BlogService::getCategoryById($editId) : null;

        $posts = BlogService::getAllPosts(false);
        $counts = [];
        foreach ($posts as $p) {
            foreach (($p['category_ids'] ?? []) as $cid) {
                $counts[$cid] = ($counts[$cid] ?? 0) + 1;
            }
        }

        App::render('admin/blog/categories', [
            'pageTitle' => 'Blog Categories',
            'activeNav' => 'blog-categories',
            'categories' => BlogService::getCategories(),
            'editCategory' => $editCategory,
            'postCounts' => $counts,
        ]);
    }

    public function saveCategory(): void
    {
        Auth::requirePermission('blog');
        $name = trim((string) ($_POST['name'] ?? ''));
        if ($name === '') {
            App::flash('error', 'Category name is required.');
            App::redirect('/admin/blog/categories');
        }
        BlogService::saveCategory([
            'id' => $_POST['id'] ?? '',
            'name' => $name,
            'slug' => $_POST['slug'] ?? '',
            'description' => $_POST['description'] ?? '',
            'is_active' => !empty($_POST['is_active']),
        ]);
        App::flash('success', 'Category saved successfully.');
        App::redirect('/admin/blog/categories');
    }

    public function deleteCategory(string $id): void
    {
        Auth::requirePermission('blog');
        BlogService::deleteCategory($id);
        App::flash('success', 'Category deleted.');
        App::redirect('/admin/blog/categories');
    }

    // =========================================================================
    // TAGS
    // =========================================================================

    public function tags(): void
    {
        Auth::requirePermission('blog');
        $editId = trim((string) ($_GET['edit'] ?? ''));
        $editTag = $editId !== '' ? BlogService::getTagById($editId) : null;

        $posts = BlogService::getAllPosts(false);
        $counts = [];
        foreach ($posts as $p) {
            foreach (($p['tag_ids'] ?? []) as $tid) {
                $counts[$tid] = ($counts[$tid] ?? 0) + 1;
            }
        }

        App::render('admin/blog/tags', [
            'pageTitle' => 'Blog Tags',
            'activeNav' => 'blog-tags',
            'tags' => BlogService::getTags(),
            'editTag' => $editTag,
            'postCounts' => $counts,
        ]);
    }

    public function saveTag(): void
    {
        Auth::requirePermission('blog');
        $name = trim((string) ($_POST['name'] ?? ''));
        if ($name === '') {
            App::flash('error', 'Tag name is required.');
            App::redirect('/admin/blog/tags');
        }
        BlogService::saveTag([
            'id' => $_POST['id'] ?? '',
            'name' => $name,
            'slug' => $_POST['slug'] ?? '',
        ]);
        App::flash('success', 'Tag saved successfully.');
        App::redirect('/admin/blog/tags');
    }

    public function deleteTag(string $id): void
    {
        Auth::requirePermission('blog');
        BlogService::deleteTag($id);
        App::flash('success', 'Tag deleted.');
        App::redirect('/admin/blog/tags');
    }
}

