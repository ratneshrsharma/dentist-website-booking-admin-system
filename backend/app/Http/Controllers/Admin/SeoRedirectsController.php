<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Models\SeoRedirect;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;

final class SeoRedirectsController extends Controller
{
    /**
     * Show SEO 301/302/404 Redirects Manager.
     */
    public function index(): View
    {
        $redirects = SeoRedirect::orderBy('created_at', 'desc')->get();

        return view('admin.seo.redirects', [
            'redirects' => $redirects,
        ]);
    }

    /**
     * Store new redirect rule.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'source_url' => ['required', 'string', 'max:255', 'unique:seo_redirects,source_url'],
            'target_url' => ['required', 'string', 'max:255'],
            'status_code' => ['required', 'integer', 'in:301,302,307,308,404,410'],
        ]);

        SeoRedirect::create([
            'source_url' => '/' . ltrim($validated['source_url'], '/'),
            'target_url' => '/' . ltrim($validated['target_url'], '/'),
            'status_code' => $validated['status_code'],
            'is_active' => true,
        ]);

        return redirect()->back()->with('success', 'URL redirection rule created successfully!');
    }

    /**
     * Delete a redirect rule.
     */
    public function destroy(int $id): RedirectResponse
    {
        SeoRedirect::findOrFail($id)->delete();

        return redirect()->back()->with('success', 'Redirect rule deleted.');
    }
}
