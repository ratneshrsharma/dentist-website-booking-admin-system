<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\App;

/**
 * WordPress-style Blog Management Service (Posts, Categories, Tags, Scheduling, SEO, FAQs)
 */
class BlogService
{
    private static function getPostsFile(): string
    {
        return dirname(__DIR__, 2) . '/storage/app/blog_posts.json';
    }

    private static function getCategoriesFile(): string
    {
        return dirname(__DIR__, 2) . '/storage/app/blog_categories.json';
    }

    private static function getTagsFile(): string
    {
        return dirname(__DIR__, 2) . '/storage/app/blog_tags.json';
    }

    public static function slugify(string $text): string
    {
        $slug = strtolower(trim($text));
        $slug = preg_replace('/[^a-z0-9-]+/', '-', $slug) ?? '';
        $slug = trim($slug, '-');
        return $slug !== '' ? $slug : 'post-' . time();
    }

    // =========================================================================
    // CATEGORIES
    // =========================================================================

    public static function getCategories(): array
    {
        $file = self::getCategoriesFile();
        if (file_exists($file)) {
            $data = json_decode((string) file_get_contents($file), true);
            if (is_array($data)) {
                return $data;
            }
        }
        $defaults = self::getDefaultCategories();
        self::saveCategories($defaults);
        return $defaults;
    }

    public static function saveCategories(array $categories): void
    {
        $file = self::getCategoriesFile();
        $dir = dirname($file);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        file_put_contents($file, json_encode(array_values($categories), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public static function getCategoryById(string $id): ?array
    {
        foreach (self::getCategories() as $cat) {
            if (($cat['id'] ?? '') === $id) {
                return $cat;
            }
        }
        return null;
    }

    public static function saveCategory(array $input): array
    {
        $categories = self::getCategories();
        $id = trim((string) ($input['id'] ?? ''));
        $name = trim((string) ($input['name'] ?? ''));
        $slug = trim((string) ($input['slug'] ?? ''));
        $slug = $slug !== '' ? self::slugify($slug) : self::slugify($name);
        $description = trim((string) ($input['description'] ?? ''));
        $isActive = !empty($input['is_active']);

        // Ensure unique slug
        $baseSlug = $slug;
        $counter = 1;
        while (true) {
            $conflict = false;
            foreach ($categories as $cat) {
                if (($cat['slug'] ?? '') === $slug && ($cat['id'] ?? '') !== $id) {
                    $conflict = true;
                    break;
                }
            }
            if (!$conflict) {
                break;
            }
            $slug = $baseSlug . '-' . (++$counter);
        }

        if ($id !== '') {
            foreach ($categories as &$cat) {
                if (($cat['id'] ?? '') === $id) {
                    $cat['name'] = $name;
                    $cat['slug'] = $slug;
                    $cat['description'] = $description;
                    $cat['is_active'] = $isActive;
                    self::saveCategories($categories);
                    return $cat;
                }
            }
            unset($cat);
        }

        $newCat = [
            'id' => 'cat_' . uniqid(),
            'name' => $name,
            'slug' => $slug,
            'description' => $description,
            'is_active' => $isActive,
        ];
        $categories[] = $newCat;
        self::saveCategories($categories);
        return $newCat;
    }

    public static function deleteCategory(string $id): void
    {
        $categories = array_values(array_filter(
            self::getCategories(),
            static fn($c) => ($c['id'] ?? '') !== $id
        ));
        self::saveCategories($categories);

        // Detach from posts
        $posts = self::getAllPosts(false);
        $changed = false;
        foreach ($posts as &$p) {
            $orig = $p['category_ids'] ?? [];
            $filtered = array_values(array_filter($orig, static fn($cid) => $cid !== $id));
            if (count($filtered) !== count($orig)) {
                $p['category_ids'] = $filtered;
                $changed = true;
            }
        }
        unset($p);
        if ($changed) {
            self::savePosts($posts);
        }
    }

    private static function getDefaultCategories(): array
    {
        return [
            ['id' => 'cat_preventive', 'name' => 'Preventive Care', 'slug' => 'preventive-care', 'description' => 'Oral hygiene, check-ups, and preventive dental guidance.', 'is_active' => true],
            ['id' => 'cat_guides', 'name' => 'Patient Guides', 'slug' => 'patient-guides', 'description' => 'NHS vs private pathways, fees, and treatment explanations.', 'is_active' => true],
            ['id' => 'cat_emergency', 'name' => 'Emergency Care', 'slug' => 'emergency-care', 'description' => 'Same-day urgent dental triage and pain relief advice.', 'is_active' => true],
            ['id' => 'cat_cosmetic', 'name' => 'Cosmetic Dentistry', 'slug' => 'cosmetic-dentistry', 'description' => 'Invisalign aligners, whitening, and smile aesthetics.', 'is_active' => true],
        ];
    }

    // =========================================================================
    // TAGS
    // =========================================================================

    public static function getTags(): array
    {
        $file = self::getTagsFile();
        if (file_exists($file)) {
            $data = json_decode((string) file_get_contents($file), true);
            if (is_array($data)) {
                return $data;
            }
        }
        $defaults = self::getDefaultTags();
        self::saveTags($defaults);
        return $defaults;
    }

    public static function saveTags(array $tags): void
    {
        $file = self::getTagsFile();
        $dir = dirname($file);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        file_put_contents($file, json_encode(array_values($tags), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public static function getTagById(string $id): ?array
    {
        foreach (self::getTags() as $tag) {
            if (($tag['id'] ?? '') === $id) {
                return $tag;
            }
        }
        return null;
    }

    public static function saveTag(array $input): array
    {
        $tags = self::getTags();
        $id = trim((string) ($input['id'] ?? ''));
        $name = trim((string) ($input['name'] ?? ''));
        $slug = trim((string) ($input['slug'] ?? ''));
        $slug = $slug !== '' ? self::slugify($slug) : self::slugify($name);

        $baseSlug = $slug;
        $counter = 1;
        while (true) {
            $conflict = false;
            foreach ($tags as $t) {
                if (($t['slug'] ?? '') === $slug && ($t['id'] ?? '') !== $id) {
                    $conflict = true;
                    break;
                }
            }
            if (!$conflict) {
                break;
            }
            $slug = $baseSlug . '-' . (++$counter);
        }

        if ($id !== '') {
            foreach ($tags as &$t) {
                if (($t['id'] ?? '') === $id) {
                    $t['name'] = $name;
                    $t['slug'] = $slug;
                    self::saveTags($tags);
                    return $t;
                }
            }
            unset($t);
        }

        $newTag = [
            'id' => 'tag_' . uniqid(),
            'name' => $name,
            'slug' => $slug,
        ];
        $tags[] = $newTag;
        self::saveTags($tags);
        return $newTag;
    }

    public static function ensureTagByName(string $name): ?array
    {
        $name = trim($name);
        if ($name === '') {
            return null;
        }
        $slug = self::slugify($name);
        foreach (self::getTags() as $t) {
            if (strcasecmp($t['name'] ?? '', $name) === 0 || ($t['slug'] ?? '') === $slug) {
                return $t;
            }
        }
        return self::saveTag(['name' => $name, 'slug' => $slug]);
    }

    public static function deleteTag(string $id): void
    {
        $tags = array_values(array_filter(
            self::getTags(),
            static fn($t) => ($t['id'] ?? '') !== $id
        ));
        self::saveTags($tags);

        $posts = self::getAllPosts(false);
        $changed = false;
        foreach ($posts as &$p) {
            $orig = $p['tag_ids'] ?? [];
            $filtered = array_values(array_filter($orig, static fn($tid) => $tid !== $id));
            if (count($filtered) !== count($orig)) {
                $p['tag_ids'] = $filtered;
                $changed = true;
            }
        }
        unset($p);
        if ($changed) {
            self::savePosts($posts);
        }
    }

    private static function getDefaultTags(): array
    {
        return [
            ['id' => 'tag_airflow', 'name' => 'Airflow Polish', 'slug' => 'airflow-polish'],
            ['id' => 'tag_hygiene', 'name' => 'Dental Hygiene', 'slug' => 'dental-hygiene'],
            ['id' => 'tag_nhs', 'name' => 'NHS Dentistry', 'slug' => 'nhs-dentistry'],
            ['id' => 'tag_private', 'name' => 'Private Care', 'slug' => 'private-care'],
            ['id' => 'tag_emergency', 'name' => 'Same-Day Triage', 'slug' => 'same-day-triage'],
            ['id' => 'tag_birmingham', 'name' => 'Birmingham B27', 'slug' => 'birmingham-b27'],
        ];
    }

    // =========================================================================
    // POSTS
    // =========================================================================

    public static function isPostLive(array $post): bool
    {
        $status = $post['status'] ?? 'draft';
        if ($status === 'published') {
            return true;
        }
        if ($status === 'scheduled') {
            $pub = trim((string) ($post['published_at'] ?? ''));
            if ($pub === '') {
                return false;
            }
            $ts = strtotime($pub);
            return $ts !== false && $ts <= time();
        }
        return false;
    }

    public static function getEffectiveStatus(array $post): string
    {
        $status = $post['status'] ?? 'draft';
        if ($status === 'scheduled') {
            $pub = trim((string) ($post['published_at'] ?? ''));
            $ts = $pub !== '' ? strtotime($pub) : false;
            if ($ts !== false && $ts <= time()) {
                return 'published';
            }
            return 'scheduled';
        }
        return $status;
    }

    public static function getAllPosts(bool $onlyLive = false): array
    {
        $file = self::getPostsFile();
        if (file_exists($file)) {
            $data = json_decode((string) file_get_contents($file), true);
            $posts = is_array($data) ? $data : self::getDefaultPosts();
        } else {
            $posts = self::getDefaultPosts();
            self::savePosts($posts);
        }

        $categoriesById = [];
        foreach (self::getCategories() as $c) {
            $categoriesById[$c['id']] = $c;
        }
        $tagsById = [];
        foreach (self::getTags() as $t) {
            $tagsById[$t['id']] = $t;
        }

        $enriched = [];
        foreach ($posts as $post) {
            if ($onlyLive && !self::isPostLive($post)) {
                continue;
            }
            $enriched[] = self::enrichPost($post, $categoriesById, $tagsById);
        }

        // Sort newest published_at / created_at first
        usort($enriched, static function ($a, $b) {
            $ta = strtotime((string) ($a['published_at'] ?? $a['created_at'] ?? '')) ?: 0;
            $tb = strtotime((string) ($b['published_at'] ?? $b['created_at'] ?? '')) ?: 0;
            return $tb <=> $ta;
        });

        return $enriched;
    }

    private static function enrichPost(array $post, array $categoriesById, array $tagsById): array
    {
        $catObjs = [];
        foreach (($post['category_ids'] ?? []) as $cid) {
            if (isset($categoriesById[$cid])) {
                $catObjs[] = $categoriesById[$cid];
            }
        }
        $tagObjs = [];
        foreach (($post['tag_ids'] ?? []) as $tid) {
            if (isset($tagsById[$tid])) {
                $tagObjs[] = $tagsById[$tid];
            }
        }

        $post['categories'] = $catObjs;
        $post['tags'] = $tagObjs;
        $post['category'] = $catObjs[0]['name'] ?? ($post['category'] ?? 'Clinical Guide');
        $post['effective_status'] = self::getEffectiveStatus($post);
        $post['is_live'] = self::isPostLive($post);

        $pubRaw = (string) ($post['published_at'] ?? '');
        $ts = $pubRaw !== '' ? strtotime($pubRaw) : false;
        $post['date'] = $ts ? date('Y-m-d', $ts) : date('Y-m-d');
        $post['date_formatted'] = $ts ? date('j M Y', $ts) : date('j M Y');

        return $post;
    }

    public static function savePosts(array $posts): void
    {
        $file = self::getPostsFile();
        $dir = dirname($file);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        // Strip derived fields before persisting
        $clean = array_map(static function ($p) {
            unset($p['categories'], $p['tags'], $p['category'], $p['effective_status'], $p['is_live'], $p['date'], $p['date_formatted']);
            return $p;
        }, array_values($posts));
        file_put_contents($file, json_encode($clean, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public static function getPostById(string $id): ?array
    {
        foreach (self::getAllPosts(false) as $p) {
            if (($p['id'] ?? '') === $id) {
                return $p;
            }
        }
        return null;
    }

    public static function getPostBySlug(string $slug, bool $onlyLive = true): ?array
    {
        $slug = trim($slug, '/');
        foreach (self::getAllPosts($onlyLive) as $p) {
            if (($p['slug'] ?? '') === $slug) {
                return $p;
            }
        }
        return null;
    }

    public static function savePost(array $input, ?string $id = null): array
    {
        $posts = self::getAllPosts(false);
        $title = trim((string) ($input['title'] ?? 'Untitled Post'));
        $rawSlug = trim((string) ($input['slug'] ?? ''));
        $slug = $rawSlug !== '' ? self::slugify($rawSlug) : self::slugify($title);

        // Guarantee unique slug
        $baseSlug = $slug;
        $counter = 1;
        while (true) {
            $conflict = false;
            foreach ($posts as $p) {
                if (($p['slug'] ?? '') === $slug && ($p['id'] ?? '') !== ($id ?? '')) {
                    $conflict = true;
                    break;
                }
            }
            if (!$conflict) {
                break;
            }
            $slug = $baseSlug . '-' . (++$counter);
        }

        $status = (string) ($input['status'] ?? 'draft');
        if (!in_array($status, ['published', 'draft', 'scheduled'], true)) {
            $status = 'draft';
        }
        $publishedAt = trim((string) ($input['published_at'] ?? ''));
        if ($publishedAt === '') {
            $publishedAt = date('Y-m-d\TH:i');
        }

        $tagIds = array_values(array_filter((array) ($input['tag_ids'] ?? [])));
        // Support quick-adding comma-separated new tags
        $newTagsRaw = trim((string) ($input['new_tags'] ?? ''));
        if ($newTagsRaw !== '') {
            foreach (explode(',', $newTagsRaw) as $tName) {
                $tObj = self::ensureTagByName($tName);
                if ($tObj && !in_array($tObj['id'], $tagIds, true)) {
                    $tagIds[] = $tObj['id'];
                }
            }
        }

        $now = date('c');
        $payload = [
            'id' => $id ?: ('post_' . uniqid()),
            'title' => $title,
            'slug' => $slug,
            'status' => $status,
            'published_at' => $publishedAt,
            'author' => trim((string) ($input['author'] ?? 'Acocks Green Clinical Team')),
            'read_time' => trim((string) ($input['read_time'] ?? '4 min read')),
            'category_ids' => array_values(array_filter((array) ($input['category_ids'] ?? []))),
            'tag_ids' => $tagIds,
            'featured_image' => trim((string) ($input['featured_image'] ?? '/uploads/home/treatment-room.jpg')),
            'featured_image_alt' => trim((string) ($input['featured_image_alt'] ?? $title)),
            'excerpt' => trim((string) ($input['excerpt'] ?? '')),
            'content' => (string) ($input['content'] ?? ''),
            'show_faqs' => !empty($input['show_faqs']),
            'faqs' => array_values((array) ($input['faqs'] ?? [])),
            'seo' => [
                'meta_title' => trim((string) ($input['seo']['meta_title'] ?? '')),
                'meta_description' => trim((string) ($input['seo']['meta_description'] ?? '')),
                'meta_keywords' => trim((string) ($input['seo']['meta_keywords'] ?? '')),
                'og_image' => trim((string) ($input['seo']['og_image'] ?? '')),
                'no_index' => !empty($input['seo']['no_index']),
            ],
            'updated_at' => $now,
        ];

        $found = false;
        foreach ($posts as &$p) {
            if (($p['id'] ?? '') === $payload['id']) {
                $payload['created_at'] = $p['created_at'] ?? $now;
                $p = $payload;
                $found = true;
                break;
            }
        }
        unset($p);

        if (!$found) {
            $payload['created_at'] = $now;
            array_unshift($posts, $payload);
        }

        self::savePosts($posts);
        return self::getPostById($payload['id']) ?? $payload;
    }

    public static function togglePostStatus(string $id): ?array
    {
        $posts = self::getAllPosts(false);
        foreach ($posts as &$p) {
            if (($p['id'] ?? '') === $id) {
                $current = $p['status'] ?? 'draft';
                $p['status'] = ($current === 'published') ? 'draft' : 'published';
                if ($p['status'] === 'published' && empty($p['published_at'])) {
                    $p['published_at'] = date('Y-m-d\TH:i');
                }
                $p['updated_at'] = date('c');
                self::savePosts($posts);
                return $p;
            }
        }
        unset($p);
        return null;
    }

    public static function deletePost(string $id): void
    {
        $posts = array_values(array_filter(
            self::getAllPosts(false),
            static fn($p) => ($p['id'] ?? '') !== $id
        ));
        self::savePosts($posts);
    }

    private static function getDefaultPosts(): array
    {
        return [
            [
                'id' => 'post_1',
                'title' => 'How Often Should You Book a Dental Hygiene & Airflow Polish?',
                'slug' => 'how-often-dental-hygiene-airflow',
                'status' => 'published',
                'published_at' => '2026-11-18T09:00',
                'author' => 'Claire, Dental Hygienist',
                'read_time' => '4 min read',
                'category_ids' => ['cat_preventive'],
                'tag_ids' => ['tag_airflow', 'tag_hygiene', 'tag_birmingham'],
                'featured_image' => '/uploads/home/treatment-room.jpg',
                'featured_image_alt' => 'Dental hygienist performing Airflow polish in Birmingham clinic',
                'excerpt' => 'Learn how Airflow warm-water polishing removes stubborn tea, coffee, and plaque biofilm gently without scraping sensitive enamel.',
                'content' => '<p>Regular dental hygiene appointments every <strong>3 to 6 months</strong> are essential for preventing gum disease, halitosis, and preserving natural enamel.</p><h2>Why Airflow Warm-Water Polishing?</h2><p>Unlike traditional abrasive scaling pastes, our Swiss-engineered Airflow system uses a gentle stream of warm water, air, and fine erythritol powder to lift surface stains and bacterial biofilm painlessly—even around dental implants, veneers, and sensitive root surfaces.</p><ul><li><strong>Zero scraping sensitivity:</strong> Warm water reduces thermal shock for sensitive teeth.</li><li><strong>Deep stain removal:</strong> Clears tea, coffee, red wine, and smoking stains in one visit.</li><li><strong>Gum health protection:</strong> Disrupts sub-gingival plaque biofilm safely.</li></ul>',
                'show_faqs' => true,
                'faqs' => [
                    ['question' => 'Does Airflow polishing hurt sensitive teeth?', 'answer' => 'No. Because Airflow uses body-temperature warm water and ultra-fine erythritol powder rather than metal scraping alone, most patients find it remarkably comfortable.', 'is_active' => true],
                    ['question' => 'How long does an Airflow hygiene appointment take?', 'answer' => 'A standard hygiene & Airflow session lasts 30 to 45 minutes depending on plaque and stain build-up.', 'is_active' => true],
                ],
                'seo' => [
                    'meta_title' => 'How Often Should You Book Dental Hygiene & Airflow Polish? | Acocks Green Dental',
                    'meta_description' => 'Discover how often to book dental hygiene appointments and why Airflow warm-water polishing is ideal for sensitive teeth in Birmingham B27.',
                    'meta_keywords' => 'dental hygiene birmingham, airflow polish, plaque removal, acocks green dentist',
                    'og_image' => '',
                    'no_index' => false,
                ],
                'created_at' => '2026-11-18T09:00:00+00:00',
                'updated_at' => '2026-11-18T09:00:00+00:00',
            ],
            [
                'id' => 'post_2',
                'title' => 'NHS vs Private Dental Care in Birmingham: What Is Included?',
                'slug' => 'nhs-vs-private-dental-care-birmingham',
                'status' => 'published',
                'published_at' => '2026-11-10T10:30',
                'author' => 'Dr. Atandrilla Das',
                'read_time' => '5 min read',
                'category_ids' => ['cat_guides'],
                'tag_ids' => ['tag_nhs', 'tag_private', 'tag_birmingham'],
                'featured_image' => '/uploads/home/hero-patient.jpg',
                'featured_image_alt' => 'Dentist explaining NHS and private treatment options to a smiling patient',
                'excerpt' => 'A transparent breakdown of NHS Band 1, Band 2, and Band 3 treatments alongside private cosmetic options like white fillings and Invisalign.',
                'content' => '<p>Understanding your dental treatment options should always be clear and stress-free. At Acocks Green Dental Practice, we explain both <strong>NHS and private pathways</strong> upfront so you can choose what suits your clinical needs and budget.</p><h2>NHS Dental Charge Bands Explained</h2><ul><li><strong>Band 1 (£26.80):</strong> Clinical examination, diagnosis, X-rays, and preventive oral health advice.</li><li><strong>Band 2 (£73.50):</strong> Everything in Band 1 plus fillings, root canal treatment, and extractions.</li><li><strong>Band 3 (£319.10):</strong> Complex laboratory work including crowns, bridges, and dentures.</li></ul><h2>When Patients Choose Private Care</h2><p>Private options allow longer unhurried appointments, tooth-coloured composite fillings on back molars, Airflow stain polishing, and discreet Invisalign aligner orthodontics.</p>',
                'show_faqs' => true,
                'faqs' => [
                    ['question' => 'Can I mix NHS and private dental treatments?', 'answer' => 'Yes. Many patients have their routine NHS check-up and choose private cosmetic upgrades such as white composite fillings or teeth whitening.', 'is_active' => true],
                ],
                'seo' => [
                    'meta_title' => 'NHS vs Private Dental Care in Birmingham B27 | Patient Guide',
                    'meta_description' => 'Compare NHS Dental Bands 1, 2, and 3 with private dental treatments at Acocks Green Dental Practice in Birmingham.',
                    'meta_keywords' => 'nhs dentist birmingham, nhs dental bands, private dentist acocks green',
                    'og_image' => '',
                    'no_index' => false,
                ],
                'created_at' => '2026-11-10T10:30:00+00:00',
                'updated_at' => '2026-11-10T10:30:00+00:00',
            ],
            [
                'id' => 'post_3',
                'title' => 'Same-Day Emergency Dental Triage: What Counts as Urgent?',
                'slug' => 'same-day-emergency-dental-triage',
                'status' => 'published',
                'published_at' => '2026-11-02T08:30',
                'author' => 'Dr. Nadeem Sohail',
                'read_time' => '3 min read',
                'category_ids' => ['cat_emergency'],
                'tag_ids' => ['tag_emergency', 'tag_birmingham'],
                'featured_image' => '/uploads/home/surgery-clinic.jpg',
                'featured_image_alt' => 'Modern emergency dental treatment suite at Acocks Green Dental',
                'excerpt' => 'Severe toothache, facial swelling, or a knocked-out tooth? Here is how our Birmingham B27 triage line gets you seen the very same day.',
                'content' => '<p>Dental emergencies can happen without warning. If you experience severe throbbing pain, facial swelling, or dental trauma, call our reception on <strong>+44 121 765 2870</strong> before 10:00 AM for priority same-day clinical triage.</p><h2>Symptoms Requiring Urgent Same-Day Care</h2><ul><li>Uncontrolled toothache disrupting sleep despite painkillers</li><li>Facial or gum swelling, abscess, or fever</li><li>Knocked-out, loosened, or fractured adult tooth</li><li>Lost crown or filling causing acute nerve sensitivity</li></ul>',
                'show_faqs' => true,
                'faqs' => [
                    ['question' => 'Do I need to be a registered patient for emergency triage?', 'answer' => 'No. We reserve daily emergency triage slots for both registered and unregistered patients in Birmingham B27.', 'is_active' => true],
                ],
                'seo' => [
                    'meta_title' => 'Same-Day Emergency Dentist Birmingham B27 | Urgent Triage',
                    'meta_description' => 'Need an emergency dentist in Acocks Green, Birmingham? Learn what counts as urgent and how to book same-day triage.',
                    'meta_keywords' => 'emergency dentist birmingham, same day dental triage, toothache relief b27',
                    'og_image' => '',
                    'no_index' => false,
                ],
                'created_at' => '2026-11-02T08:30:00+00:00',
                'updated_at' => '2026-11-02T08:30:00+00:00',
            ],
        ];
    }
}
