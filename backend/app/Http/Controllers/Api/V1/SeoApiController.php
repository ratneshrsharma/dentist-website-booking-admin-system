<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Models\SeoMetadata;
use App\Models\SeoRedirect;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

final class SeoApiController extends Controller
{
    /**
     * Get Yoast-style SEO metadata for a page or treatment route.
     */
    public function metadata(string $slug): JsonResponse
    {
        $seo = SeoMetadata::where('entity_slug', $slug)->first();

        if (! $seo) {
            // Sensible fallback
            $formattedTitle = ucwords(str_replace('-', ' ', $slug));
            return response()->json([
                'success' => true,
                'data' => [
                    'meta_title' => $formattedTitle . ' | Advanced Dental Clinic',
                    'meta_description' => 'Comprehensive dental care and clinical specialties at Advanced Dental Clinic.',
                    'meta_keywords' => 'dentist, dental clinic, dental implants, cosmetic dentistry',
                    'canonical_url' => url('/' . $slug),
                    'og_title' => $formattedTitle . ' | Advanced Dental Clinic',
                    'og_description' => 'Comprehensive dental care and clinical specialties at Advanced Dental Clinic.',
                    'og_image_url' => 'https://images.unsplash.com/photo-1629909613654-28e377c37b09?auto=format&fit=crop&w=1200&q=80',
                    'og_type' => 'website',
                    'twitter_card' => 'summary_large_image',
                    'robots_index' => true,
                    'robots_follow' => true,
                    'schema_type' => 'MedicalBusiness',
                    'schema_json' => [
                        '@context' => 'https://schema.org',
                        '@type' => 'Dentist',
                        'name' => 'Advanced Dental Clinic',
                        'telephone' => '+1 (800) 555-DENT',
                    ],
                    'custom_css' => null,
                    'custom_js_head' => null,
                    'custom_js_footer' => null,
                ],
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $seo,
        ]);
    }

    /**
     * Get active 301/302/404 URL redirects list.
     */
    public function redirects(): JsonResponse
    {
        $redirects = SeoRedirect::where('is_active', true)
            ->get(['source_url', 'target_url', 'status_code']);

        return response()->json([
            'success' => true,
            'data' => $redirects,
        ]);
    }
}
