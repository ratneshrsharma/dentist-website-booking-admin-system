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
}
