<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Models\CmsPage;
use App\Models\CmsTreatment;
use App\Models\SeoMetadata;
use App\StandaloneRunner;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

final class CmsApiController extends Controller
{
    /**
     * Get USDental-inspired 4-pillar navigation tree with mega-dropdowns.
     */
    public function navigation(): JsonResponse
    {
        $treatments = CmsTreatment::where('is_published', true)
            ->orderBy('display_order', 'asc')
            ->get();

        $groupedTreatments = $treatments->groupBy('category_name');

        $categories = [
            [
                'category' => 'Dental Implants & Surgery',
                'description' => 'Permanent tooth replacements & bone regeneration',
                'iconName' => 'Sparkles',
                'items' => ($groupedTreatments->get('Dental Implants & Surgery') ?? collect())->map(function ($item): array {
                    return [
                        'label' => $item->title,
                        'href' => '/treatments/' . $item->slug,
                        'description' => $item->subtitle,
                        'badge' => $item->featured_badge,
                    ];
                })->values()->all(),
            ],
            [
                'category' => 'Cosmetic Dentistry & Orthodontics',
                'description' => 'Aesthetic smile makeovers & aligners',
                'iconName' => 'Smile',
                'items' => ($groupedTreatments->get('Cosmetic Dentistry & Orthodontics') ?? collect())->map(function ($item): array {
                    return [
                        'label' => $item->title,
                        'href' => '/treatments/' . $item->slug,
                        'description' => $item->subtitle,
                        'badge' => $item->featured_badge,
                    ];
                })->values()->all(),
            ],
            [
                'category' => 'Gum Care & Periodontics',
                'description' => 'Advanced periodontal therapy & laser treatments',
                'iconName' => 'Shield',
                'items' => ($groupedTreatments->get('Gum Care & Periodontics') ?? collect())->map(function ($item): array {
                    return [
                        'label' => $item->title,
                        'href' => '/treatments/' . $item->slug,
                        'description' => $item->subtitle,
                        'badge' => $item->featured_badge,
                    ];
                })->values()->all(),
            ],
            [
                'category' => 'General & Restorative Care',
                'description' => 'Everyday dentistry, pain relief & oral health',
                'iconName' => 'Activity',
                'items' => ($groupedTreatments->get('General & Restorative Care') ?? collect())->map(function ($item): array {
                    return [
                        'label' => $item->title,
                        'href' => '/treatments/' . $item->slug,
                        'description' => $item->subtitle,
                        'badge' => $item->featured_badge,
                    ];
                })->values()->all(),
            ],
        ];

        return response()->json([
            'success' => true,
            'data' => [
                'navigation' => [
                    ['label' => 'Home', 'href' => '/'],
                    [
                        'label' => 'About Us',
                        'items' => [
                            ['label' => 'The Practice & Philosophy', 'href' => '/about-us', 'description' => 'American clinical standards & sterilization.'],
                            ['label' => 'Our Specialist Team', 'href' => '/our-team', 'description' => 'Board-certified prosthodontists & surgeons.'],
                            ['label' => 'Technology & 3D Imaging', 'href' => '/technology', 'description' => 'Low-dose CBCT & intraoral scanners.'],
                            ['label' => 'Why Choose Us & Accreditations', 'href' => '/why-choose-us', 'description' => 'Hospital-grade infection control & zero-pain.'],
                        ],
                    ],
                    [
                        'label' => 'Treatments & Procedures',
                        'href' => '/treatments',
                        'categories' => $categories,
                    ],
                    [
                        'label' => 'Patient Resources',
                        'items' => [
                            ['label' => 'First Visit Guide & Triage', 'href' => '/first-visit', 'description' => 'What to expect on your first appointment.'],
                            ['label' => 'Plans & Insurance Coverage', 'href' => '/plans-coverage', 'description' => 'In-house membership savings & insurance.'],
                            ['label' => 'Smile Gallery & Case Studies', 'href' => '/smile-gallery', 'description' => 'Verified before-and-after smile transformations.'],
                            ['label' => 'Patient FAQs & Dental Advice', 'href' => '/patient-faq', 'description' => 'Clear answers to common patient questions.'],
                        ],
                    ],
                    ['label' => 'Contact & Clinics', 'href' => '/contact'],
                ],
            ],
        ]);
    }

    /**
     * Get all published treatments.
     */
    public function treatments(): JsonResponse
    {
        $treatments = CmsTreatment::with('seo')
            ->where('is_published', true)
            ->orderBy('display_order', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $treatments,
        ]);
    }

    /**
     * Get single treatment procedure by slug with SEO.
     */
    public function treatmentBySlug(string $slug): JsonResponse
    {
        $treatment = CmsTreatment::with('seo')
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        return response()->json([
            'success' => true,
            'data' => $treatment,
        ]);
    }

    /**
     * Get page content and attached Yoast-style SEO by key/slug.
     */
    public function pageByKey(string $slug): JsonResponse
    {
        $page = CmsPage::where('page_key', $slug)
            ->where('is_published', true)
            ->first();

        $seo = SeoMetadata::where('entity_slug', $slug)->first();

        $storage = class_exists(StandaloneRunner::class) ? StandaloneRunner::getCmsStorageData() : [];
        if (isset($storage['pages'][$slug])) {
            return response()->json([
                'success' => true,
                'data' => $storage['pages'][$slug],
            ]);
        }

        if ($slug === 'treatments' && !$page) {
            $default = class_exists(StandaloneRunner::class)
                ? StandaloneRunner::getDefaultTreatmentsContent()
                : [
                    'slug' => 'treatments',
                    'title' => 'Treatments & Services',
                    'eyebrow' => 'Evidence-Based Dental Excellence',
                    'subtitle' => 'From routine NHS prevention to advanced private smile rehabilitation, explore our comprehensive range of clinical dental treatments in Acocks Green, Birmingham.',
                    'badge' => 'B27 6BH Dental Surgery',
                    'breadcrumbs' => ['Home', 'Treatments & Services'],
                ];
            return response()->json([
                'success' => true,
                'data' => $default,
            ]);
        }

        if (($slug === 'general-dentistry' || $slug === 'treatments/general-dentistry' || str_starts_with($slug, 'treatments/')) && !$page) {
            $default = class_exists(StandaloneRunner::class)
                ? StandaloneRunner::getDefaultTreatmentDetailContent($slug)
                : [
                    'slug' => $slug,
                    'title' => 'General Dentistry & Routine Dental Check-ups in Birmingham',
                ];
            return response()->json([
                'success' => true,
                'data' => $default,
            ]);
        }

        if (($slug === 'home' || $slug === 'index' || $slug === '') && !$page) {
            $default = class_exists(StandaloneRunner::class)
                ? StandaloneRunner::getDefaultHomeContent()
                : [
                    'slug' => 'home',
                    'title' => 'Home',
                ];
            return response()->json([
                'success' => true,
                'data' => $default,
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'page' => $page,
                'seo' => $seo,
            ],
        ]);
    }

    /**
     * Dedicated SEO Endpoint (Endpoint 2).
     */
    public function seo(string $slug): JsonResponse
    {
        $cleanSlug = trim($slug, '/');
        if ($cleanSlug === '' || $cleanSlug === 'index') {
            $cleanSlug = 'home';
        }

        $storage = class_exists(StandaloneRunner::class) ? StandaloneRunner::getCmsStorageData() : [];
        if (isset($storage['pages'][$cleanSlug]['seo'])) {
            return response()->json([
                'success' => true,
                'data' => $storage['pages'][$cleanSlug]['seo'],
            ]);
        }

        $defaultSeo = class_exists(StandaloneRunner::class)
            ? StandaloneRunner::getDefaultSeoData($cleanSlug)
            : [];

        return response()->json([
            'success' => true,
            'data' => $defaultSeo,
        ]);
    }

    /**
     * Dual-Scope Custom Code Injection API (Endpoint 4).
     */
    public function codeInjection(string $slug): JsonResponse
    {
        $cleanSlug = trim($slug, '/');
        if ($cleanSlug === '' || $cleanSlug === 'index') {
            $cleanSlug = 'home';
        }

        $storage = class_exists(StandaloneRunner::class) ? StandaloneRunner::getCmsStorageData() : [];
        $defaultCode = class_exists(StandaloneRunner::class)
            ? StandaloneRunner::getDefaultCodeInjection($cleanSlug)
            : ['common' => [], 'page' => [], 'merged' => []];

        $common = $storage['common_code'] ?? $defaultCode['common'];
        $pageCode = $storage['pages'][$cleanSlug]['code_injection'] ?? $defaultCode['page'];
        $merged = [
            'custom_css' => trim(($common['custom_css'] ?? '') . "\n\n" . ($pageCode['custom_css'] ?? '')),
            'head_scripts' => trim(($common['head_scripts'] ?? '') . "\n\n" . ($pageCode['head_scripts'] ?? '')),
            'body_scripts' => trim(($common['body_scripts'] ?? '') . "\n\n" . ($pageCode['body_scripts'] ?? '')),
        ];

        return response()->json([
            'success' => true,
            'data' => [
                'slug' => $cleanSlug,
                'common' => $common,
                'page' => $pageCode,
                'merged' => $merged,
            ],
        ]);
    }

    /**
     * Save CMS page content, SEO, and Custom Code Injection.
     */
    public function savePage(Request $request): JsonResponse
    {
        $payload = $request->all();
        $slug = trim($payload['slug'] ?? 'home', '/');
        if ($slug === '' || $slug === 'index') {
            $slug = 'home';
        }

        $storage = class_exists(StandaloneRunner::class) ? StandaloneRunner::getCmsStorageData() : [];
        if (!isset($storage['pages'])) {
            $storage['pages'] = [];
        }

        if (isset($payload['common_code']) && is_array($payload['common_code'])) {
            $storage['common_code'] = [
                'custom_css' => $payload['common_code']['custom_css'] ?? '',
                'head_scripts' => $payload['common_code']['head_scripts'] ?? '',
                'body_scripts' => $payload['common_code']['body_scripts'] ?? '',
            ];
        }

        $existing = $storage['pages'][$slug] ?? ($slug === 'treatments' && class_exists(StandaloneRunner::class)
            ? StandaloneRunner::getDefaultTreatmentsContent()
            : ($slug === 'home' && class_exists(StandaloneRunner::class)
                ? StandaloneRunner::getDefaultHomeContent()
                : [
                    'slug' => $slug,
                    'title' => ucwords(str_replace(['-', '/'], ' ', $slug)),
                    'seo' => class_exists(StandaloneRunner::class) ? StandaloneRunner::getDefaultSeoData($slug) : [],
                ]));

        $updated = array_merge($existing, $payload);
        $updated['slug'] = $slug;
        $updated['updated_at'] = date('Y-m-d H:i:s');

        $storage['pages'][$slug] = $updated;

        if (class_exists(StandaloneRunner::class)) {
            StandaloneRunner::saveCmsStorageData($storage);
        }

        return response()->json([
            'success' => true,
            'message' => "Page '{$slug}' and Code Injection configurations saved successfully.",
            'data' => $updated,
        ]);
    }
}
