<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Models\CmsPage;
use App\Models\CmsTreatment;
use App\Models\SeoMetadata;
use Illuminate\Http\JsonResponse;
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

        return response()->json([
            'success' => true,
            'data' => [
                'page' => $page,
                'seo' => $seo,
            ],
        ]);
    }
}
