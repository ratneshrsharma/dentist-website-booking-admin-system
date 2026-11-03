<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Models\ThemeSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;

final class ThemeCustomizerController extends Controller
{
    /**
     * Show the AdminLTE 4 Visual Theme & Typography Customizer.
     */
    public function index(): View
    {
        $settings = ThemeSetting::all()->groupBy('group');

        return view('admin.theme.customizer', [
            'colors' => $settings->get('colors')?->pluck('value', 'key')->all() ?? [],
            'typography' => $settings->get('typography')?->pluck('value', 'key')->all() ?? [],
            'fonts' => $settings->get('fonts')?->pluck('value', 'key')->all() ?? [],
        ]);
    }

    /**
     * Update brand colors and typography settings.
     */
    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'colors.primary' => ['nullable', 'string', 'max:20'],
            'colors.secondary' => ['nullable', 'string', 'max:20'],
            'colors.accent' => ['nullable', 'string', 'max:20'],
            'colors.surface' => ['nullable', 'string', 'max:20'],
            'typography.h1.fontSize' => ['nullable', 'string', 'max:20'],
            'typography.h1.fontWeight' => ['nullable', 'string', 'max:20'],
            'typography.h1.lineHeight' => ['nullable', 'string', 'max:20'],
            'typography.h1.textTransform' => ['nullable', 'string', 'max:20'],
            'typography.h2.fontSize' => ['nullable', 'string', 'max:20'],
            'typography.h2.fontWeight' => ['nullable', 'string', 'max:20'],
            'typography.p.fontSize' => ['nullable', 'string', 'max:20'],
            'typography.p.lineHeight' => ['nullable', 'string', 'max:20'],
        ]);

        if (isset($data['colors'])) {
            foreach ($data['colors'] as $key => $hex) {
                if ($hex) {
                    ThemeSetting::updateOrCreate(
                        ['key' => $key, 'group' => 'colors'],
                        ['value' => ['hex' => $hex], 'description' => ucfirst($key) . ' color']
                    );
                }
            }
        }

        if (isset($data['typography'])) {
            foreach ($data['typography'] as $tag => $props) {
                ThemeSetting::updateOrCreate(
                    ['key' => $tag, 'group' => 'typography'],
                    ['value' => $props, 'description' => "Typography settings for <{$tag}>"]
                );
            }
        }

        return redirect()->back()->with('success', 'Theme customizer settings successfully saved and deployed to Next.js frontend!');
    }

    /**
     * Upload custom font (.woff2, .ttf, .woff).
     */
    public function uploadFont(Request $request): RedirectResponse
    {
        $request->validate([
            'font_name' => ['required', 'string', 'max:100'],
            'font_file' => ['required', 'file', 'mimes:woff,woff2,ttf', 'max:5120'], // Max 5MB
        ]);

        $file = $request->file('font_file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('public/fonts', $fileName);

        $customFonts = ThemeSetting::where('key', 'custom_fonts')->first();
        $list = $customFonts ? ($customFonts->value ?? []) : [];
        $list[] = [
            'name' => $request->input('font_name'),
            'type' => 'uploaded',
            'file_path' => '/storage/fonts/' . $fileName,
            'format' => $file->getClientOriginalExtension(),
            'uploaded_at' => now()->toIso8601String(),
            'is_active' => true,
        ];

        ThemeSetting::updateOrCreate(
            ['key' => 'custom_fonts', 'group' => 'fonts'],
            ['value' => $list, 'description' => 'User-uploaded custom fonts']
        );

        return redirect()->back()->with('success', "Custom font '{$request->input('font_name')}' uploaded and registered!");
    }
}
