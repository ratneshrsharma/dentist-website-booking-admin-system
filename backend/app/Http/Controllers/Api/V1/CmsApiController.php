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

        if ($slug === 'treatments' && !$page) {
            return response()->json([
                'success' => true,
                'data' => [
                    'slug' => 'treatments',
                    'title' => 'Treatments & Services',
                    'eyebrow' => 'Evidence-Based Dental Excellence',
                    'subtitle' => 'From routine NHS prevention to advanced private smile rehabilitation, explore our comprehensive range of clinical dental treatments in Acocks Green, Birmingham.',
                    'badge' => 'B27 6BH Dental Surgery',
                    'breadcrumbs' => ['Home', 'Treatments & Services'],
                    'doctor' => [
                        'name' => 'Dr. Richard C. Williams',
                        'title' => 'Clinical Director & Lead Implant Surgeon',
                        'credentials' => 'BDS (Birm), MJDF RCS (Eng), PgCert Implantology',
                        'gdc_number' => 'GDC No: 178924',
                        'avatar' => 'https://images.unsplash.com/photo-1622253692010-333f2da6031d?auto=format&fit=crop&q=80&w=300',
                    ],
                    'categories' => [
                        ['id' => 'all', 'label' => 'All Services', 'icon' => 'dentistry'],
                        ['id' => 'general', 'label' => 'General Dentistry', 'icon' => 'medical_services'],
                        ['id' => 'hygiene', 'label' => 'Hygiene & Prevention', 'icon' => 'clean_hands'],
                        ['id' => 'restorative', 'label' => 'Restorative Care', 'icon' => 'healing'],
                        ['id' => 'aesthetic', 'label' => 'Aesthetic & Cosmetic', 'icon' => 'auto_awesome'],
                        ['id' => 'emergency', 'label' => 'Emergency & Surgery', 'icon' => 'emergency'],
                    ],
                    'services' => [
                        [
                            'id' => 1,
                            'slug' => 'routine-examinations',
                            'category' => 'general',
                            'category_label' => 'General Dentistry',
                            'title' => 'Routine Examinations & Check-ups',
                            'badge' => 'NHS & Private',
                            'excerpt' => 'Comprehensive oral health assessments, low-dose digital radiographs, periodontal screening, and early cancer detection for patients of all ages.',
                            'features' => [
                                'Low-Dose Digital Bitewing Radiographs',
                                'BPE Periodontal Screening & Gum Health Score',
                                'Soft Tissue & Oral Cancer Screening Protocol'
                            ],
                            'nhs_band' => 'Band 1 (£26.80)',
                            'private_from' => '£45.00',
                            'image' => 'https://images.unsplash.com/photo-1588776814546-1ffcf47267a5?auto=format&fit=crop&q=80&w=800',
                            'link' => '/treatments/general-dentistry'
                        ],
                        [
                            'id' => 2,
                            'slug' => 'hygiene-periodontal-therapy',
                            'category' => 'hygiene',
                            'category_label' => 'Hygiene & Prevention',
                            'title' => 'Dental Hygiene & Periodontal Therapy',
                            'badge' => 'Direct Access Available',
                            'excerpt' => 'Professional ultrasonic scaling, targeted stain removal with AirFlow technology, and personalized periodontal maintenance to preserve bone support.',
                            'features' => [
                                'AirFlow High-Precision Polish & Stain Removal',
                                'Ultrasonic Plaque & Subgingival Calculus Debridement',
                                'Personalized Gum Health & Interdental Protocol'
                            ],
                            'nhs_band' => 'Band 2 (£73.50 if clinically needed)',
                            'private_from' => '£65.00',
                            'image' => 'https://images.unsplash.com/photo-1606811841689-23dfddce3e95?auto=format&fit=crop&q=80&w=800',
                            'link' => '/treatments/hygiene'
                        ],
                        [
                            'id' => 3,
                            'slug' => 'crowns-bridges-restorative',
                            'category' => 'restorative',
                            'category_label' => 'Restorative Care',
                            'title' => 'Crowns, Bridges & Restorative Dentistry',
                            'badge' => 'High-Durability Ceramics',
                            'excerpt' => 'Rebuilding broken or decayed teeth with biocompatible, natural-looking porcelain, lithium disilicate (E-Max), and high-strength zirconia prosthetics.',
                            'features' => [
                                'Monolithic Zirconia & E-Max Ceramic Formulations',
                                'Precision Digital Impressions (No Messy Trays)',
                                'Multi-Unit Fixed Bridges for Gap Replacement'
                            ],
                            'nhs_band' => 'Band 3 (£319.10)',
                            'private_from' => '£495.00',
                            'image' => 'https://images.unsplash.com/photo-1598256989800-fe5f95da9787?auto=format&fit=crop&q=80&w=800',
                            'link' => '/treatments/restorative'
                        ],
                        [
                            'id' => 4,
                            'slug' => 'clear-aligners-orthodontics',
                            'category' => 'aesthetic',
                            'category_label' => 'Aesthetic & Cosmetic',
                            'title' => 'Clear Aligners & Orthodontic Realignment',
                            'badge' => 'Invisalign & ClearCorrect',
                            'excerpt' => 'Discreet, removable clear aligners engineered to straighten crooked, crowded, or spaced teeth predictably without fixed metal brackets.',
                            'features' => [
                                'Custom 3D ClinCheck Virtual Outcome Simulation',
                                'Transparent, Removable & Lifestyle-Friendly',
                                'Includes Complimentary Teeth Whitening at Completion'
                            ],
                            'nhs_band' => 'Private Only',
                            'private_from' => '£1,495.00',
                            'image' => 'https://images.unsplash.com/photo-1579684385127-1ef15d508118?auto=format&fit=crop&q=80&w=800',
                            'link' => '/treatments/clear-aligners'
                        ],
                        [
                            'id' => 5,
                            'slug' => 'composite-bonding-cosmetic',
                            'category' => 'aesthetic',
                            'category_label' => 'Aesthetic & Cosmetic',
                            'title' => 'Composite Bonding & Aesthetic Contouring',
                            'badge' => 'Same-Day Transformation',
                            'excerpt' => 'Minimally invasive resin artistry to repair chipped edges, close unwanted gaps (diastemas), and harmonize tooth symmetry in a single appointment.',
                            'features' => [
                                'Zero or Minimal Enamel Removal (Preserves Natural Tooth)',
                                'Single-Visit Chairside Sculpting & High Polish',
                                'Color-Matched Micro-Hybrid Composite Resins'
                            ],
                            'nhs_band' => 'Private Only',
                            'private_from' => '£110.00 per tooth',
                            'image' => 'https://images.unsplash.com/photo-1609840114035-3c981b782dfe?auto=format&fit=crop&q=80&w=800',
                            'link' => '/treatments/composite-bonding'
                        ],
                        [
                            'id' => 6,
                            'slug' => 'emergency-dental-relief',
                            'category' => 'emergency',
                            'category_label' => 'Emergency & Surgery',
                            'title' => 'Emergency Dental Care & Same-Day Relief',
                            'badge' => 'Same-Day Slots Guaranteed',
                            'excerpt' => 'Rapid-response triage and diagnosis for severe toothaches, dental abscesses, broken teeth, lost restorations, and acute facial trauma.',
                            'features' => [
                                'Priority Same-Day Appointments Available Mon–Sat',
                                'Immediate Diagnostic Radiographs & Pulp Vitality Testing',
                                'Definitive Pain Relief & Infection Management Protocols'
                            ],
                            'nhs_band' => 'Urgent (£26.80)',
                            'private_from' => '£65.00 + treatment',
                            'image' => 'https://images.unsplash.com/photo-1629909613654-28e377c37b09?auto=format&fit=crop&q=80&w=800',
                            'link' => '/treatments/emergency'
                        ]
                    ],
                    'pricing_matrix' => [
                        'nhs_bands' => [
                            ['band' => 'Band 1', 'price' => '£26.80', 'description' => 'Covers clinical examination, diagnosis, advice, radiographs, scale & polish if clinically necessary, and preventive care plan.'],
                            ['band' => 'Band 2', 'price' => '£73.50', 'description' => 'Covers everything in Band 1 plus additional treatment including fillings, root canal therapy, and tooth extractions.'],
                            ['band' => 'Band 3', 'price' => '£319.10', 'description' => 'Covers everything in Bands 1 and 2 plus complex laboratory-fabricated items including crowns, dentures, and bridges.'],
                            ['band' => 'Urgent Emergency', 'price' => '£26.80', 'description' => 'Emergency pain relief, temporary fillings, or clinical triage if you require urgent dental attention.']
                        ],
                        'private_options' => [
                            ['procedure' => 'Private Routine Clinical Examination', 'price' => 'from £45.00'],
                            ['procedure' => 'Direct Access Hygiene / AirFlow Polish', 'price' => 'from £65.00'],
                            ['procedure' => 'Tooth-Coloured Composite Restoration', 'price' => 'from £110.00'],
                            ['procedure' => 'High-Strength Porcelain / Zirconia Crown', 'price' => 'from £495.00'],
                            ['procedure' => 'Clear Aligner Therapy (Single Arch)', 'price' => 'from £1,495.00'],
                            ['procedure' => 'Single Dental Implant (Fixture & Abutment)', 'price' => 'from £1,850.00']
                        ],
                        'finance_note' => '0% Interest-free patient payment plans available over 6 to 12 months for private treatment plans exceeding £500.'
                    ],
                    'clinical_pillars' => [
                        ['id' => 'digital_precision', 'icon' => 'biotech', 'title' => 'Digital Workflow & 3D Imaging', 'description' => 'Low-dose digital bitewings, high-resolution intraoral scanning, and precision diagnostics reduce chair time and eliminate uncomfortable impression trays.'],
                        ['id' => 'nhs_private', 'icon' => 'verified', 'title' => 'NHS & Private Parallel Care', 'description' => 'We operate an integrated care model offering both standard NHS dental fee bands and advanced private cosmetic solutions under one registered surgery roof.'],
                        ['id' => 'nervous_patients', 'icon' => 'spa', 'title' => 'Gentle, Nervous Patient Protocol', 'description' => 'Our clinical team is trained in empathetic, anxiety-reducing dentistry. We move at your pace, explain each step, and offer numbing gels before local anaesthesia.'],
                        ['id' => 'emergency_access', 'icon' => 'emergency', 'title' => 'Dedicated Emergency Access', 'description' => 'We reserve daily clinical emergency slots for acute toothache, broken crowns, dental abscesses, and urgent pain relief in Acocks Green B27.']
                    ],
                    'consultation_cta' => [
                        'headline' => 'Ready to Plan Your Treatment?',
                        'description' => 'Book a comprehensive dental examination or speak with our clinical reception team today. We welcome both NHS registered and new private patients.',
                        'phone' => '+44 121 765 2870',
                        'address' => '1078 Warwick Road, Acocks Green, Birmingham B27 6BH',
                        'hours' => 'Mon - Fri: 8:30am - 5:30pm',
                        'cta_primary' => 'Book Online Now',
                        'cta_secondary' => 'Call Practice Reception'
                    ],
                    'seo' => [
                        'meta_title' => 'Treatments & Services | Acocks Green Dental Practice Birmingham',
                        'meta_description' => 'Explore our full range of NHS and private dental treatments in Acocks Green, Birmingham B27 6BH. Routine check-ups, hygiene, crowns, aligners, and emergency care.',
                        'canonical_url' => 'https://acocksgreendentalpractice.co.uk/treatments',
                    ]
                ]
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
}
