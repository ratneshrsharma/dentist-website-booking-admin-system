<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Models\CmsTreatment;
use App\Models\SeoMetadata;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;

final class SeoManagerController extends Controller
{
    /**
     * Show the Yoast-Style SEO & Code Injection Manager.
     */
    public function index(): View
    {
        $seoList = SeoMetadata::orderBy('updated_at', 'desc')->get();
        $treatments = CmsTreatment::where('is_published', true)->get();

        return view('admin.seo.index', [
            'seoList' => $seoList,
            'treatments' => $treatments,
        ]);
    }

    /**
     * Save/update SEO metadata, schema, and per-page script injection.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'entity_slug' => ['required', 'string', 'max:150'],
            'entity_type' => ['required', 'string', 'in:page,treatment,blog'],
            'meta_title' => ['required', 'string', 'max:200'],
            'meta_description' => ['required', 'string', 'max:500'],
            'meta_keywords' => ['nullable', 'string', 'max:255'],
            'canonical_url' => ['nullable', 'url', 'max:255'],
            'og_title' => ['nullable', 'string', 'max:200'],
            'og_description' => ['nullable', 'string', 'max:500'],
            'og_image_url' => ['nullable', 'url', 'max:255'],
            'twitter_card' => ['nullable', 'string', 'in:summary,summary_large_image'],
            'robots_index' => ['nullable', 'boolean'],
            'robots_follow' => ['nullable', 'boolean'],
            'schema_type' => ['nullable', 'string', 'max:60'],
            'schema_json' => ['nullable', 'string'],
            'custom_css' => ['nullable', 'string'],
            'custom_js_head' => ['nullable', 'string'],
            'custom_js_footer' => ['nullable', 'string'],
        ]);

        $schemaArray = null;
        if (! empty($validated['schema_json'])) {
            $decoded = json_decode($validated['schema_json'], true);
            $schemaArray = is_array($decoded) ? $decoded : null;
        }

        SeoMetadata::updateOrCreate(
            ['entity_slug' => $validated['entity_slug']],
            [
                'entity_type' => $validated['entity_type'],
                'meta_title' => $validated['meta_title'],
                'meta_description' => $validated['meta_description'],
                'meta_keywords' => $validated['meta_keywords'] ?? null,
                'canonical_url' => $validated['canonical_url'] ?? null,
                'og_title' => $validated['og_title'] ?? $validated['meta_title'],
                'og_description' => $validated['og_description'] ?? $validated['meta_description'],
                'og_image_url' => $validated['og_image_url'] ?? null,
                'twitter_card' => $validated['twitter_card'] ?? 'summary_large_image',
                'robots_index' => $request->boolean('robots_index', true),
                'robots_follow' => $request->boolean('robots_follow', true),
                'schema_type' => $validated['schema_type'] ?? 'MedicalBusiness',
                'schema_json' => $schemaArray,
                'custom_css' => $validated['custom_css'] ?? null,
                'custom_js_head' => $validated['custom_js_head'] ?? null,
                'custom_js_footer' => $validated['custom_js_footer'] ?? null,
            ]
        );

        return redirect()->back()->with('success', "SEO metadata and custom scripts for '{$validated['entity_slug']}' updated successfully!");
    }
}
