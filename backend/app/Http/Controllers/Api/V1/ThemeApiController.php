<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Models\ThemeSetting;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

final class ThemeApiController extends Controller
{
    /**
     * Get active visual theme tokens (colors, typography for h1-h6/p/a, uploaded fonts).
     */
    public function settings(): JsonResponse
    {
        $settings = ThemeSetting::all()->groupBy('group');

        // Defaults if no database settings configured yet
        $defaultColors = [
            'primary' => '#0D9488',
            'primaryHover' => '#0F766E',
            'secondary' => '#14B8A6',
            'accent' => '#0284C7',
            'surface' => '#FFFFFF',
            'surfaceMuted' => '#F8FAFC',
            'textMain' => '#0F172A',
            'textMuted' => '#64748B',
            'border' => '#E2E8F0',
        ];

        $defaultTypography = [
            'fontFamilyHeading' => "'Plus Jakarta Sans', sans-serif",
            'fontFamilyBody' => "'Plus Jakarta Sans', sans-serif",
            'tags' => [
                'h1' => ['fontSize' => '2.5rem', 'fontWeight' => '700', 'lineHeight' => '1.2', 'textTransform' => 'none'],
                'h2' => ['fontSize' => '2rem', 'fontWeight' => '700', 'lineHeight' => '1.25', 'textTransform' => 'none'],
                'h3' => ['fontSize' => '1.5rem', 'fontWeight' => '600', 'lineHeight' => '1.3', 'textTransform' => 'none'],
                'h4' => ['fontSize' => '1.25rem', 'fontWeight' => '600', 'lineHeight' => '1.35', 'textTransform' => 'none'],
                'h5' => ['fontSize' => '1.125rem', 'fontWeight' => '600', 'lineHeight' => '1.4', 'textTransform' => 'none'],
                'h6' => ['fontSize' => '1rem', 'fontWeight' => '600', 'lineHeight' => '1.4', 'textTransform' => 'none'],
                'p' => ['fontSize' => '1rem', 'fontWeight' => '400', 'lineHeight' => '1.6', 'textTransform' => 'none'],
                'a' => ['fontWeight' => '500', 'textDecoration' => 'none', 'textTransform' => 'none'],
            ],
        ];

        $colors = $settings->get('colors')?->pluck('value', 'key')->all() ?? $defaultColors;
        $typography = $settings->get('typography')?->pluck('value', 'key')->all() ?? $defaultTypography;
        $fonts = $settings->get('fonts')?->pluck('value', 'key')->all() ?? [];

        return response()->json([
            'success' => true,
            'data' => [
                'colors' => $colors,
                'typography' => $typography,
                'customFonts' => $fonts,
            ],
        ]);
    }

    /**
     * Get global brand color tokens, typography, and theme configuration.
     */
    public function global(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => [
                'theme_name' => 'acocks-green',
                'display_name' => 'Acocks Green Dental Practice (Primary British Healthcare Theme)',
                'colors' => [
                    'primary' => '#005f73',
                    'primary_hover' => '#004352',
                    'secondary' => '#0a9396',
                    'secondary_hover' => '#005f73',
                    'accent' => '#ee9b00',
                    'surface' => '#ffffff',
                    'surface_muted' => '#f4f6f8',
                    'surface_dark' => '#101d24',
                    'text_primary' => '#001e28',
                    'text_secondary' => '#3a5a68',
                    'text_muted' => '#6b828d',
                    'border' => '#e2e8f0',
                    'border_light' => '#edf2f7',
                    'nhs_blue' => '#005eb8',
                ],
                'typography' => [
                    'font_family_heading' => "'Plus Jakarta Sans', sans-serif",
                    'font_family_body' => "'Plus Jakarta Sans', sans-serif",
                    'font_family_serif' => "'Playfair Display', serif",
                    'google_fonts_url' => 'https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Work+Sans:wght@400;500;600&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap',
                ],
                'branding' => [
                    'clinic_name' => 'Acocks Green Dental Practice',
                    'tagline' => 'NHS & Private Family Dental Surgery Birmingham B27',
                    'logo_url' => '/images/acocks-green-logo.png',
                    'phone' => '+44 121 765 2870',
                    'whatsapp' => '+919904379260',
                    'address' => '1078 Warwick Road, Acocks Green, Birmingham B27 6BH',
                ],
                'tokens' => [
                    'border_radius' => '0.75rem',
                    'container_max_width' => '1280px',
                    'nav_height' => '80px',
                ],
            ],
        ]);
    }
}
