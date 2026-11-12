@extends('layouts.admin')

@section('title', 'Theme & Typography Customizer - Advanced Dental Clinic')
@section('page_title', 'Visual Theme & Design Customizer')
@section('page_subtitle', 'Configure brand colors, typography for H1-H6 / P / A tags, and upload custom fonts deployed dynamically to Next.js')

@section('content')
<div class="container-fluid">
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="row">
        <!-- Theme & Color Settings Form -->
        <div class="col-lg-8">
            <form action="{{ url('/admin/theme-customizer/update') }}" method="POST">
                @csrf

                <!-- Section 1: Brand Colors Palette -->
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-white d-flex align-items-center justify-content-between py-3">
                        <span class="fs-5 fw-bold text-dark"><i class="bi bi-palette2 text-primary me-2"></i>Brand Color Tokens</span>
                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle">CSS Variables (:root)</span>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6 col-xl-3">
                                <label class="form-label small fw-bold">Primary Brand Color</label>
                                <div class="input-group">
                                    <input type="color" class="form-control form-control-color" name="colors[primary]" value="{{ $colors['primary']['hex'] ?? '#0D9488' }}" title="Choose Primary Color" id="pickerPrimary">
                                    <input type="text" class="form-control form-control-sm text-uppercase font-monospace" value="{{ $colors['primary']['hex'] ?? '#0D9488' }}" id="hexPrimary">
                                </div>
                                <small class="text-muted d-block mt-1">Buttons, active states, key icons</small>
                            </div>

                            <div class="col-md-6 col-xl-3">
                                <label class="form-label small fw-bold">Secondary Accent Color</label>
                                <div class="input-group">
                                    <input type="color" class="form-control form-control-color" name="colors[secondary]" value="{{ $colors['secondary']['hex'] ?? '#14B8A6' }}" id="pickerSecondary">
                                    <input type="text" class="form-control form-control-sm text-uppercase font-monospace" value="{{ $colors['secondary']['hex'] ?? '#14B8A6' }}" id="hexSecondary">
                                </div>
                                <small class="text-muted d-block mt-1">Badges, pills, secondary CTAs</small>
                            </div>

                            <div class="col-md-6 col-xl-3">
                                <label class="form-label small fw-bold">Highlight Gradient Accent</label>
                                <div class="input-group">
                                    <input type="color" class="form-control form-control-color" name="colors[accent]" value="{{ $colors['accent']['hex'] ?? '#0284C7' }}" id="pickerAccent">
                                    <input type="text" class="form-control form-control-sm text-uppercase font-monospace" value="{{ $colors['accent']['hex'] ?? '#0284C7' }}" id="hexAccent">
                                </div>
                                <small class="text-muted d-block mt-1">Emergency strip, gradients</small>
                            </div>

                            <div class="col-md-6 col-xl-3">
                                <label class="form-label small fw-bold">Card & Surface Background</label>
                                <div class="input-group">
                                    <input type="color" class="form-control form-control-color" name="colors[surface]" value="{{ $colors['surface']['hex'] ?? '#FFFFFF' }}" id="pickerSurface">
                                    <input type="text" class="form-control form-control-sm text-uppercase font-monospace" value="{{ $colors['surface']['hex'] ?? '#FFFFFF' }}" id="hexSurface">
                                </div>
                                <small class="text-muted d-block mt-1">Cards, dropdowns, modal panels</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 1.5: Clinic WhatsApp & Direct Triage Hub -->
                <div class="card mb-4 shadow-sm border-success-subtle">
                    <div class="card-header bg-white d-flex align-items-center justify-content-between py-3">
                        <span class="fs-5 fw-bold text-dark"><i class="bi bi-whatsapp text-success me-2"></i>Clinic WhatsApp & Patient Triage Channel</span>
                        <span class="badge bg-success-subtle text-success border border-success-subtle"><i class="bi bi-broadcast me-1"></i>Live Synchronized</span>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-center g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Official Clinic WhatsApp Number</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-success-subtle text-success"><i class="bi bi-whatsapp"></i></span>
                                    <input type="text" class="form-control" name="whatsapp_number" value="{{ $whatsapp_number }}" placeholder="+919904379260" required>
                                </div>
                                <small class="text-muted d-block mt-1">International format with country code (default: <code>+919904379260</code>). Updates public patient floating triage hub, booking confirmation WhatsApp notifications, and direct contact buttons instantly via API.</small>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 bg-light rounded border">
                                    <div class="d-flex align-items-center text-success fw-bold small mb-1">
                                        <i class="bi bi-check-circle-fill me-1"></i> Zero Code Re-Deploy
                                    </div>
                                    <span class="small text-muted">Whenever you update this phone number, the patient website and booking confirmation links reflect the new number immediately without rebuilding or re-deploying code!</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 2: Granular Typography Engine (H1-H6, P, A) -->
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-white d-flex align-items-center justify-content-between py-3">
                        <span class="fs-5 fw-bold text-dark"><i class="bi bi-fonts text-primary me-2"></i>Granular Typography Engine (Tags H1–H6, P, A)</span>
                        <span class="badge bg-secondary-subtle text-secondary border">Dynamic Style Rules</span>
                    </div>
                    <div class="card-body">
                        <!-- H1 Heading Rules -->
                        <div class="p-3 mb-3 bg-light rounded border">
                            <div class="row align-items-center g-3">
                                <div class="col-md-2">
                                    <span class="fw-bold fs-5 text-dark">&lt;h1&gt; Main Hero</span>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label small mb-1">Font Size</label>
                                    <input type="text" class="form-control form-control-sm" name="typography[h1][fontSize]" value="{{ $typography['h1']['fontSize'] ?? '2.5rem' }}" placeholder="e.g. 2.5rem">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label small mb-1">Font Weight</label>
                                    <select class="form-select form-select-sm" name="typography[h1][fontWeight]">
                                        <option value="600" @selected(($typography['h1']['fontWeight'] ?? '') == '600')>600 (Semi-Bold)</option>
                                        <option value="700" @selected(($typography['h1']['fontWeight'] ?? '700') == '700')>700 (Bold)</option>
                                        <option value="800" @selected(($typography['h1']['fontWeight'] ?? '') == '800')>800 (Extra-Bold)</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label small mb-1">Line Height</label>
                                    <input type="text" class="form-control form-control-sm" name="typography[h1][lineHeight]" value="{{ $typography['h1']['lineHeight'] ?? '1.2' }}" placeholder="1.2">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label small mb-1">Text Transform</label>
                                    <select class="form-select form-select-sm" name="typography[h1][textTransform]">
                                        <option value="none" @selected(($typography['h1']['textTransform'] ?? 'none') == 'none')>Normal</option>
                                        <option value="uppercase" @selected(($typography['h1']['textTransform'] ?? '') == 'uppercase')>ALL CAPS (Uppercase)</option>
                                        <option value="capitalize" @selected(($typography['h1']['textTransform'] ?? '') == 'capitalize')>Title Case (Capitalize)</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- H2 Heading Rules -->
                        <div class="p-3 mb-3 bg-light rounded border">
                            <div class="row align-items-center g-3">
                                <div class="col-md-2">
                                    <span class="fw-bold fs-6 text-dark">&lt;h2&gt; Section Titles</span>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label small mb-1">Font Size</label>
                                    <input type="text" class="form-control form-control-sm" name="typography[h2][fontSize]" value="{{ $typography['h2']['fontSize'] ?? '2rem' }}" placeholder="e.g. 2rem">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label small mb-1">Font Weight</label>
                                    <select class="form-select form-select-sm" name="typography[h2][fontWeight]">
                                        <option value="600" @selected(($typography['h2']['fontWeight'] ?? '') == '600')>600 (Semi-Bold)</option>
                                        <option value="700" @selected(($typography['h2']['fontWeight'] ?? '700') == '700')>700 (Bold)</option>
                                        <option value="800" @selected(($typography['h2']['fontWeight'] ?? '') == '800')>800 (Extra-Bold)</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label small mb-1">Line Height</label>
                                    <input type="text" class="form-control form-control-sm" name="typography[h2][lineHeight]" value="{{ $typography['h2']['lineHeight'] ?? '1.25' }}" placeholder="1.25">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label small mb-1">Text Transform</label>
                                    <select class="form-select form-select-sm" name="typography[h2][textTransform]">
                                        <option value="none" @selected(($typography['h2']['textTransform'] ?? 'none') == 'none')>Normal</option>
                                        <option value="uppercase" @selected(($typography['h2']['textTransform'] ?? '') == 'uppercase')>ALL CAPS (Uppercase)</option>
                                        <option value="capitalize" @selected(($typography['h2']['textTransform'] ?? '') == 'capitalize')>Title Case (Capitalize)</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- P Paragraph Rules -->
                        <div class="p-3 bg-light rounded border">
                            <div class="row align-items-center g-3">
                                <div class="col-md-2">
                                    <span class="fw-bold fs-6 text-dark">&lt;p&gt; Body Copy</span>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label small mb-1">Font Size</label>
                                    <input type="text" class="form-control form-control-sm" name="typography[p][fontSize]" value="{{ $typography['p']['fontSize'] ?? '1rem' }}" placeholder="e.g. 1rem">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label small mb-1">Font Weight</label>
                                    <select class="form-select form-select-sm" name="typography[p][fontWeight]">
                                        <option value="400" @selected(($typography['p']['fontWeight'] ?? '400') == '400')>400 (Regular)</option>
                                        <option value="500" @selected(($typography['p']['fontWeight'] ?? '') == '500')>500 (Medium)</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label small mb-1">Line Height</label>
                                    <input type="text" class="form-control form-control-sm" name="typography[p][lineHeight]" value="{{ $typography['p']['lineHeight'] ?? '1.6' }}" placeholder="1.6">
                                </div>
                                <div class="col-md-3">
                                    <span class="text-muted small">Standard body reading copy</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-white py-3 text-end">
                        <button type="submit" class="btn btn-primary px-4 fw-bold">
                            <i class="bi bi-save2 me-1"></i> Save & Deploy Theme Settings
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Right Column: Custom Font Uploader & Live Preview -->
        <div class="col-lg-4">
            <!-- Custom Font Uploader Card -->
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-white py-3">
                    <span class="fs-6 fw-bold text-dark"><i class="bi bi-cloud-arrow-up text-primary me-2"></i>Upload Custom Fonts</span>
                </div>
                <div class="card-body">
                    <form action="{{ url('/admin/theme-customizer/upload-font') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Font Family Display Name</label>
                            <input type="text" class="form-control form-control-sm" name="font_name" required placeholder="e.g. Gotham Clinical, Futura Modern">
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Font File (.woff2, .woff, .ttf)</label>
                            <input type="file" class="form-control form-control-sm" name="font_file" accept=".woff2,.woff,.ttf" required>
                            <small class="text-muted">Supports WOFF2 (recommended), WOFF, and TTF up to 5MB.</small>
                        </div>

                        <button type="submit" class="btn btn-sm btn-outline-primary w-100 fw-bold">
                            <i class="bi bi-upload me-1"></i> Upload & Register Font
                        </button>
                    </form>

                    <!-- Uploaded Fonts Registry -->
                    <div class="mt-4 pt-3 border-top">
                        <h6 class="small fw-bold text-muted text-uppercase mb-2">Registered Fonts</h6>
                        <ul class="list-group list-group-flush small">
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
                                <span><i class="bi bi-check-circle-fill text-success me-1"></i> Plus Jakarta Sans</span>
                                <span class="badge bg-light text-dark border">Google Font (Active)</span>
                            </li>
                            @foreach($fonts as $font)
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
                                <span><i class="bi bi-file-earmark-font me-1 text-primary"></i> {{ $font['name'] ?? 'Custom Font' }}</span>
                                <span class="badge bg-success-subtle text-success">Uploaded (Active)</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Instant Live Preview Widget -->
            <div class="card shadow-sm border-primary">
                <div class="card-header bg-primary text-white py-2">
                    <span class="small fw-bold"><i class="bi bi-eye-fill me-1"></i> Live Patient Site Preview</span>
                </div>
                <div class="card-body p-4" style="background-color: var(--app-surface, #ffffff);">
                    <span class="badge bg-primary text-white mb-2" id="previewBadge">Clinical Excellence</span>
                    <h3 class="fw-bold mb-2 text-dark" id="previewHeadline" style="font-size: 1.4rem;">Painless Dental Care</h3>
                    <p class="text-muted small mb-3" id="previewParagraph">Delivering sub-millimeter surgical implants, transparent orthodontics, and hospital-grade sterilization.</p>
                    <button class="btn btn-primary btn-sm fw-bold px-3">Book Appointment</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
