<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\CmsTreatment;
use App\Models\SeoMetadata;
use App\Models\SeoRedirect;
use App\Models\ThemeSetting;
use Illuminate\Database\Seeder;

final class CmsAndThemeSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Headless CMS Treatments
        $treatments = [
            [
                'slug' => 'dental-implants',
                'title' => 'Dental Implants Overview',
                'category_name' => 'Dental Implants & Surgery',
                'subtitle' => 'The gold standard for permanent, natural-looking tooth replacement.',
                'hero_image_url' => 'https://images.unsplash.com/photo-1588776814546-1ffcf47267a5?auto=format&fit=crop&w=1200&q=80',
                'overview_html' => '<p>Dental implants are titanium or zirconia artificial tooth roots surgically placed into the jawbone. They provide a sturdy foundation for fixed or removable replacement teeth.</p>',
                'benefits_list' => [
                    'Looks, feels, and functions exactly like natural teeth',
                    'Prevents bone loss and preserves facial structure',
                    'Does not compromise adjacent healthy teeth',
                    'Long-lasting solution with 95%+ documented success rate',
                ],
                'procedure_steps' => [
                    ['step' => 1, 'title' => 'Comprehensive 3D CBCT Scan', 'description' => 'Precise digital scans and bone density mapping.'],
                    ['step' => 2, 'title' => 'Gentle Implant Fixture Placement', 'description' => 'Surgical insertion under comfortable local anesthesia.'],
                    ['step' => 3, 'title' => 'Osseointegration (Healing Phase)', 'description' => 'A 3-to-4 month period of secure bone fusion.'],
                    ['step' => 4, 'title' => 'Custom Crown Restoration', 'description' => 'Mounting of a handcrafted, color-matched porcelain crown.'],
                ],
                'faq_items' => [
                    ['question' => 'Are dental implant procedures painful?', 'answer' => 'The procedure is performed under local anesthesia with optional sedation for zero discomfort.'],
                ],
                'duration' => '1 to 2 Hours per Implant',
                'recovery_time' => '2 to 5 Days',
                'cost_estimate' => 'From $1,500 per implant',
                'featured_badge' => 'Lifetime Warranty',
                'display_order' => 1,
            ],
            [
                'slug' => 'computer-guided-implant-surgery',
                'title' => 'Computer Guided Implant Surgery',
                'category_name' => 'Dental Implants & Surgery',
                'subtitle' => 'Sub-millimeter precision surgery using 3D virtual planning and custom surgical guides.',
                'hero_image_url' => 'https://images.unsplash.com/photo-1629909613654-28e377c37b09?auto=format&fit=crop&w=1200&q=80',
                'overview_html' => '<p>Computer Guided Implant Surgery merges 3D CT scans with advanced digital planning software for flapless, minimally invasive surgery.</p>',
                'benefits_list' => [
                    'Flapless surgery with zero or minimal stitches',
                    'Significantly reduced post-operative swelling and discomfort',
                    'Absolute precision avoiding nerves and sinus cavities',
                ],
                'procedure_steps' => [
                    ['step' => 1, 'title' => '3D Virtual Implant Planning', 'description' => 'Mapping exact angulation and depth in CAD software.'],
                    ['step' => 2, 'title' => '3D Printed Surgical Guide', 'description' => 'Fabricating a custom guide that locks over existing teeth.'],
                    ['step' => 3, 'title' => 'Flapless Implant Insertion', 'description' => 'Inserting fixtures precisely through guide sleeves in minutes.'],
                ],
                'faq_items' => [
                    ['question' => 'What is the main advantage of guided surgery?', 'answer' => 'Surgical time is cut in half and healing is significantly faster.'],
                ],
                'duration' => '45 to 60 Minutes',
                'recovery_time' => '1 to 2 Days',
                'cost_estimate' => 'From $1,800 per implant',
                'featured_badge' => 'Advanced Tech',
                'display_order' => 2,
            ],
            [
                'slug' => 'all-on-4-dental-implants',
                'title' => 'All-on-4 / All-on-6 Systems',
                'category_name' => 'Dental Implants & Surgery',
                'subtitle' => 'Full-arch fixed teeth replacement supported on just 4 or 6 dental implants in 24 hours.',
                'hero_image_url' => 'https://images.unsplash.com/photo-1606811841689-23dfddce6395?auto=format&fit=crop&w=1200&q=80',
                'overview_html' => '<p>The All-on-4 treatment concept provides non-removable teeth in a single day for patients with missing or failing teeth.</p>',
                'benefits_list' => [
                    'Full arch of fixed teeth in just one or two visits',
                    'Eliminates the inconvenience and slipping of removable dentures',
                    'Often avoids the need for extensive bone grafting',
                ],
                'procedure_steps' => [
                    ['step' => 1, 'title' => 'Consultation & 3D Bite Analysis', 'description' => 'Comprehensive bone and facial evaluation.'],
                    ['step' => 2, 'title' => 'Implant Placement', 'description' => 'Precise surgical placement of 4 strategically angled implants.'],
                    ['step' => 3, 'title' => 'Same-Day Fixed Bridge', 'description' => 'Attaching temporary bridge so you leave with a confident smile.'],
                ],
                'faq_items' => [
                    ['question' => 'Can I eat normally with All-on-4?', 'answer' => 'Yes, once healed you can enjoy all your favorite foods with normal bite force.'],
                ],
                'duration' => '3 to 4 Hours per Arch',
                'recovery_time' => '3 to 7 Days',
                'cost_estimate' => 'Custom treatment quote',
                'featured_badge' => 'Popular',
                'display_order' => 3,
            ],
            [
                'slug' => 'clear-aligners',
                'title' => 'Clear Aligners & Invisible Orthodontics',
                'category_name' => 'Cosmetic Dentistry & Orthodontics',
                'subtitle' => 'Straighten your teeth discreetly with comfortable, removable transparent aligner trays.',
                'hero_image_url' => 'https://images.unsplash.com/photo-1598256989800-fe5f95da9787?auto=format&fit=crop&w=1200&q=80',
                'overview_html' => '<p>Clear aligners gently guide your teeth into optimal alignment using custom-molded medical-grade transparent trays without metal brackets.</p>',
                'benefits_list' => [
                    'Virtually invisible when worn—smile with absolute confidence',
                    'Removable for easy eating, brushing, and flossing',
                    'No sharp metal wires or broken brackets',
                ],
                'procedure_steps' => [
                    ['step' => 1, 'title' => 'Digital 3D Intraoral Scan', 'description' => 'Painless digital impression capturing tooth positions.'],
                    ['step' => 2, 'title' => 'Virtual 3D Smile Simulation', 'description' => 'Preview your teeth movement step-by-step on screen.'],
                    ['step' => 3, 'title' => 'Custom Tray Series', 'description' => 'Switch aligner trays every 10–14 days.'],
                ],
                'faq_items' => [
                    ['question' => 'How many hours a day must aligners be worn?', 'answer' => 'Aligners must be worn 20 to 22 hours per day for predictable results.'],
                ],
                'duration' => '6 to 18 Months Average',
                'recovery_time' => 'Zero downtime',
                'cost_estimate' => 'From $2,500 complete',
                'featured_badge' => 'No Metal',
                'display_order' => 4,
            ],
            [
                'slug' => 'root-canal-treatment',
                'title' => 'Painless Root Canal Treatment (RCT)',
                'category_name' => 'General & Restorative Care',
                'subtitle' => 'Advanced rotary endodontics to save infected teeth and eliminate pain in one comfortable visit.',
                'hero_image_url' => 'https://images.unsplash.com/photo-1579684385127-1ef15d508118?auto=format&fit=crop&w=1200&q=80',
                'overview_html' => '<p>Modern rotary endodontics eliminates nerve infection, eliminates pain, and preserves the natural tooth structure.</p>',
                'benefits_list' => [
                    'Immediately relieves severe toothache and infection pain',
                    'Saves your natural tooth structure and preserves bite alignment',
                    'High-tech rotary instruments make the visit fast and comfortable',
                ],
                'procedure_steps' => [
                    ['step' => 1, 'title' => 'Targeted Anesthesia & 3D Imaging', 'description' => 'Complete painless numbing of the affected nerve.'],
                    ['step' => 2, 'title' => 'Microscopic Canal Cleaning', 'description' => 'Removing bacteria using flexible rotary instruments.'],
                    ['step' => 3, 'title' => 'Biocompatible Sealing', 'description' => 'Hermetic sealing with gutta-percha to prevent reinfection.'],
                ],
                'faq_items' => [
                    ['question' => 'Is a root canal painful?', 'answer' => 'With modern rotary instruments and local anesthesia, it feels like a routine filling.'],
                ],
                'duration' => '45 to 60 Minutes',
                'recovery_time' => '1 to 2 Days',
                'cost_estimate' => 'From $350 per tooth',
                'featured_badge' => 'Same Day',
                'display_order' => 5,
            ],
        ];

        foreach ($treatments as $treatmentData) {
            CmsTreatment::updateOrCreate(
                ['slug' => $treatmentData['slug']],
                $treatmentData
            );
        }

        // 2. Seed Yoast-Style SEO Metadata
        $seoPages = [
            [
                'entity_type' => 'page',
                'entity_slug' => 'treatments',
                'meta_title' => 'Dental Treatments & Clinical Specialties | Advanced Dental Clinic',
                'meta_description' => 'Explore our full spectrum of specialized dental solutions from computer-guided implants to painless restorative care.',
                'meta_keywords' => 'dental treatments, dental implants, cosmetic dentistry, root canal, clear aligners',
                'canonical_url' => 'https://demo.ratneshsharma.com/advanced-dental-clinic/treatments',
                'og_title' => 'Treatments & Clinical Specialties | Advanced Dental Clinic',
                'og_description' => 'US-standard dental care with computer-guided surgical precision, digital dentistry, and painless treatment protocols.',
                'og_image_url' => 'https://images.unsplash.com/photo-1629909613654-28e377c37b09?auto=format&fit=crop&w=1200&q=80',
                'schema_type' => 'MedicalBusiness',
                'schema_json' => [
                    '@context' => 'https://schema.org',
                    '@type' => 'MedicalBusiness',
                    'name' => 'Advanced Dental Clinic',
                    'url' => 'https://demo.ratneshsharma.com/advanced-dental-clinic/treatments',
                    'telephone' => '+1 (800) 555-DENT',
                ],
                'custom_css' => '/* Custom per-page styles */ .page-badge { text-transform: uppercase; }',
                'custom_js_head' => 'console.log("Yoast SEO Head Script loaded for treatments");',
                'custom_js_footer' => 'console.log("Yoast SEO Footer Script loaded for treatments");',
            ],
            [
                'entity_type' => 'treatment',
                'entity_slug' => 'dental-implants',
                'meta_title' => 'Dental Implants Overview | Advanced Dental Clinic',
                'meta_description' => 'Permanent titanium & zirconia tooth replacements with 3D CBCT guided precision at Advanced Dental Clinic.',
                'meta_keywords' => 'dental implants, permanent teeth, titanium tooth roots, restorative dentistry',
                'canonical_url' => 'https://demo.ratneshsharma.com/advanced-dental-clinic/treatments/dental-implants',
                'og_title' => 'Dental Implants Overview | Advanced Dental Clinic',
                'og_description' => 'Restore your smile permanently with computer-guided dental implants at Advanced Dental Clinic.',
                'og_image_url' => 'https://images.unsplash.com/photo-1588776814546-1ffcf47267a5?auto=format&fit=crop&w=1200&q=80',
                'schema_type' => 'MedicalProcedure',
                'schema_json' => [
                    '@context' => 'https://schema.org',
                    '@type' => 'MedicalProcedure',
                    'name' => 'Dental Implants Overview',
                    'procedureType' => 'SurgicalProcedure',
                ],
            ],
        ];

        foreach ($seoPages as $seoData) {
            SeoMetadata::updateOrCreate(
                ['entity_slug' => $seoData['entity_slug']],
                $seoData
            );
        }

        // 3. Seed Theme Customizer Settings
        $themeSettings = [
            [
                'group' => 'colors',
                'key' => 'primary',
                'value' => ['hex' => '#0D9488', 'rgb' => '13, 148, 136', 'label' => 'Primary Teal'],
                'description' => 'Main brand color for primary buttons, active links, and highlights',
            ],
            [
                'group' => 'colors',
                'key' => 'secondary',
                'value' => ['hex' => '#14B8A6', 'rgb' => '20, 184, 166', 'label' => 'Secondary Mint'],
                'description' => 'Secondary accent for badges and interactive states',
            ],
            [
                'group' => 'colors',
                'key' => 'accent',
                'value' => ['hex' => '#0284C7', 'rgb' => '2, 132, 199', 'label' => 'Sky Blue'],
                'description' => 'Accent gradient tone for CTAs and banners',
            ],
            [
                'group' => 'typography',
                'key' => 'h1',
                'value' => [
                    'fontFamily' => 'Plus Jakarta Sans',
                    'fontSize' => '2.5rem',
                    'fontWeight' => '700',
                    'lineHeight' => '1.2',
                    'textTransform' => 'none',
                ],
                'description' => 'Hero and main page titles',
            ],
            [
                'group' => 'typography',
                'key' => 'h2',
                'value' => [
                    'fontFamily' => 'Plus Jakarta Sans',
                    'fontSize' => '2rem',
                    'fontWeight' => '700',
                    'lineHeight' => '1.25',
                    'textTransform' => 'none',
                ],
                'description' => 'Section headings',
            ],
            [
                'group' => 'typography',
                'key' => 'p',
                'value' => [
                    'fontFamily' => 'Plus Jakarta Sans',
                    'fontSize' => '1rem',
                    'fontWeight' => '400',
                    'lineHeight' => '1.6',
                    'textTransform' => 'none',
                ],
                'description' => 'Standard body paragraph text',
            ],
            [
                'group' => 'fonts',
                'key' => 'custom_fonts',
                'value' => [
                    [
                        'name' => 'Plus Jakarta Sans',
                        'type' => 'google',
                        'weights' => [400, 500, 600, 700],
                        'is_active' => true,
                    ],
                ],
                'description' => 'Configured and uploaded font families',
            ],
        ];

        foreach ($themeSettings as $setting) {
            ThemeSetting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }

        // 4. Seed SEO Redirects (301, 302, 404 tracking)
        $redirects = [
            ['source_url' => '/services/implants', 'target_url' => '/treatments/dental-implants', 'status_code' => 301],
            ['source_url' => '/services/aligners', 'target_url' => '/treatments/clear-aligners', 'status_code' => 301],
            ['source_url' => '/services/rct', 'target_url' => '/treatments/root-canal-treatment', 'status_code' => 301],
            ['source_url' => '/doctors', 'target_url' => '/our-team', 'status_code' => 301],
        ];

        foreach ($redirects as $redirect) {
            SeoRedirect::updateOrCreate(
                ['source_url' => $redirect['source_url']],
                $redirect
            );
        }
    }
}
