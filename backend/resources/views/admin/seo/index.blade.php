@extends('layouts.admin')

@section('title', 'Yoast-Style SEO & Script Engine - Advanced Dental Clinic')
@section('page_title', 'Enterprise Yoast-Style SEO & Code Injection Engine')
@section('page_subtitle', 'Configure per-page Google SERP previews, Meta tags, OpenGraph, JSON-LD schemas, and head/footer custom scripts')

@section('content')
<div class="container-fluid">
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="row">
        <!-- Left: SEO & Script Injection Editor Form -->
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <span class="fs-5 fw-bold text-dark"><i class="bi bi-search text-primary me-2"></i>Page SEO Configuration</span>
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle">Yoast-Style Engine</span>
                </div>
                <div class="card-body">
                    <form action="{{ url('/admin/seo-manager/store') }}" method="POST">
                        @csrf

                        <!-- Target Page Selection -->
                        <div class="row g-3 mb-4 p-3 bg-light rounded border">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Select Page or Procedure URL</label>
                                <select class="form-select form-select-sm" name="entity_slug" id="pageSlugSelect" required>
                                    <optgroup label="Main Website Pages">
                                        <option value="home" selected>Home Page (/)</option>
                                        <option value="about-us">About Us (/about-us)</option>
                                        <option value="our-team">Our Clinical Specialists (/our-team)</option>
                                        <option value="technology">Technology & Sterilization (/technology)</option>
                                        <option value="why-choose-us">Why Choose Us & Accreditations (/why-choose-us)</option>
                                        <option value="contact">Contact & Branch Locations (/contact)</option>
                                        <option value="patient-faq">Patient FAQs & Emergency Care (/patient-faq)</option>
                                        <option value="plans-coverage">Insurance & Membership Plans (/plans-coverage)</option>
                                        <option value="first-visit">First Visit Guide (/first-visit)</option>
                                        <option value="smile-gallery">Smile Transformation Gallery (/smile-gallery)</option>
                                    </optgroup>
                                    <optgroup label="Clinical Procedures">
                                        @foreach($treatments as $treatment)
                                        <option value="treatments/{{ $treatment->slug }}">{{ $treatment->title }} (/treatments/{{ $treatment->slug }})</option>
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Entity Content Type</label>
                                <select class="form-select form-select-sm" name="entity_type" required>
                                    <option value="page" selected>Standard Static Page</option>
                                    <option value="treatment">Clinical Procedure (MedicalProcedure)</option>
                                    <option value="blog">Educational Article / Blog</option>
                                </select>
                            </div>
                        </div>

                        <!-- Google Search Preview Card (Yoast Style) -->
                        <div class="p-3 mb-4 rounded border bg-white shadow-xs">
                            <span class="small fw-bold text-muted text-uppercase d-block mb-2"><i class="bi bi-google me-1"></i> Google Search Snippet Preview</span>
                            <div class="serp-preview p-3 border rounded bg-light">
                                <div class="text-muted small mb-1" id="serpUrl">https://demo.ratneshsharma.com/advanced-dental-clinic/</div>
                                <div class="text-primary fw-bold fs-6 text-decoration-none mb-1" id="serpTitle">Dental Implants & Cosmetic Dentistry | Advanced Dental Clinic</div>
                                <div class="text-secondary small" id="serpDescription">Sub-millimeter 3D guided dental implants, painless single-visit root canals, and invisible aligners adhering to American clinical standards.</div>
                            </div>
                        </div>

                        <!-- Meta Title & Meta Description -->
                        <div class="mb-3">
                            <div class="d-flex justify-content-between">
                                <label class="form-label small fw-bold">Meta Title</label>
                                <span class="small text-muted" id="titleCharCount">0 / 60 chars</span>
                            </div>
                            <input type="text" class="form-control" name="meta_title" id="metaTitleInput" value="Dental Implants & Cosmetic Dentistry | Advanced Dental Clinic" required maxlength="120">
                            <small class="text-muted">Recommended length: 50-60 characters for optimal desktop/mobile search visibility.</small>
                        </div>

                        <div class="mb-3">
                            <div class="d-flex justify-content-between">
                                <label class="form-label small fw-bold">Meta Description</label>
                                <span class="small text-muted" id="descCharCount">0 / 160 chars</span>
                            </div>
                            <textarea class="form-control" name="meta_description" id="metaDescInput" rows="3" required maxlength="250">Sub-millimeter 3D guided dental implants, painless single-visit root canals, and invisible aligners adhering to American clinical standards.</textarea>
                            <small class="text-muted">Recommended length: 140-160 characters describing clinical services clearly.</small>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Meta Keywords</label>
                                <input type="text" class="form-control form-control-sm" name="meta_keywords" placeholder="dental implants, painless root canal, clear aligners" value="dental clinic, dental implants, cosmetic dentistry, painless root canal, invisalign">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Canonical URL Override</label>
                                <input type="url" class="form-control form-control-sm" name="canonical_url" placeholder="Leave blank to use default page URL">
                            </div>
                        </div>

                        <!-- Robots & Social Sharing Tabs -->
                        <ul class="nav nav-tabs mb-3" id="seoTabs" role="tablist">
                            <li class="nav-item">
                                <button class="nav-link active small fw-bold" id="social-tab" data-bs-toggle="tab" data-bs-target="#social" type="button"><i class="bi bi-share me-1"></i> Social (OG & X/Twitter)</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link small fw-bold" id="schema-tab" data-bs-toggle="tab" data-bs-target="#schema" type="button"><i class="bi bi-code-slash me-1"></i> JSON-LD Schema</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link small fw-bold" id="scripts-tab" data-bs-toggle="tab" data-bs-target="#scripts" type="button"><i class="bi bi-braces me-1"></i> Per-Page Scripts & CSS</button>
                            </li>
                        </ul>

                        <div class="tab-content" id="seoTabsContent">
                            <!-- Social Sharing Panel -->
                            <div class="tab-pane fade show active" id="social">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold">OpenGraph Title</label>
                                        <input type="text" class="form-control form-control-sm" name="og_title" placeholder="Defaults to Meta Title">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold">Twitter Card Type</label>
                                        <select class="form-select form-select-sm" name="twitter_card">
                                            <option value="summary_large_image" selected>summary_large_image (Large Hero Card)</option>
                                            <option value="summary">summary (Standard Square Card)</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label small fw-bold">Social Sharing Image URL</label>
                                        <input type="url" class="form-control form-control-sm" name="og_image_url" placeholder="https://images.unsplash.com/photo-1629909613654-28e377c37b09?w=1200&h=630&fit=crop">
                                    </div>
                                    <div class="col-12">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="robots_index" value="1" id="chkIndex" checked>
                                            <label class="form-check-label small" for="chkIndex">Index (Allow search engines to index this page)</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="robots_follow" value="1" id="chkFollow" checked>
                                            <label class="form-check-label small" for="chkFollow">Follow (Allow search engines to follow outbound links)</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- JSON-LD Schema Panel -->
                            <div class="tab-pane fade" id="schema">
                                <div class="mb-3">
                                    <label class="form-label small fw-bold">Primary Structured Data Schema Type</label>
                                    <select class="form-select form-select-sm" name="schema_type">
                                        <option value="MedicalBusiness" selected>MedicalBusiness (Dental Clinic Facility)</option>
                                        <option value="Dentist">Dentist (Individual Clinician / Practice)</option>
                                        <option value="MedicalProcedure">MedicalProcedure (Clinical Dental Procedure)</option>
                                        <option value="FAQPage">FAQPage (Patient Frequently Asked Questions)</option>
                                    </select>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label small fw-bold">Custom JSON-LD Schema JSON (Optional Override)</label>
                                    <textarea class="form-control font-monospace small" name="schema_json" rows="6" placeholder='{
  "@context": "https://schema.org",
  "@type": "MedicalBusiness",
  "name": "Advanced Dental Clinic",
  "medicalSpecialty": "Dentistry"
}'></textarea>
                                </div>
                            </div>

                            <!-- Custom Head/Body Script Injection -->
                            <div class="tab-pane fade" id="scripts">
                                <div class="mb-3">
                                    <label class="form-label small fw-bold">Per-Page Custom CSS (Injected inside &lt;head&gt;&lt;style&gt;)</label>
                                    <textarea class="form-control font-monospace small" name="custom_css" rows="3" placeholder=".custom-banner { background: #0d9488; }"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label small fw-bold">Custom JavaScript in &lt;head&gt; (Analytics, GTM, Meta Pixels)</label>
                                    <textarea class="form-control font-monospace small" name="custom_js_head" rows="3" placeholder="console.log('Page loaded');"></textarea>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label small fw-bold">Custom JavaScript before &lt;/body&gt; (Chatbots, Conversion Trackers)</label>
                                    <textarea class="form-control font-monospace small" name="custom_js_footer" rows="3" placeholder="window.initChatWidget && window.initChatWidget();"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 pt-3 border-top text-end">
                            <button type="submit" class="btn btn-primary px-4 fw-bold">
                                <i class="bi bi-save2 me-1"></i> Save SEO Settings & Deploy
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Right: Current Pages SEO Registry Table -->
        <div class="col-lg-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <span class="fs-6 fw-bold text-dark"><i class="bi bi-list-check text-primary me-2"></i>SEO Status Audit</span>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush small">
                        @forelse($seoList as $seo)
                        <div class="list-group-item p-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="fw-bold text-dark">/{{ $seo->entity_slug }}</span>
                                <span class="badge bg-success-subtle text-success border border-success-subtle">Configured</span>
                            </div>
                            <div class="text-truncate text-secondary mb-1" style="max-width: 280px;">{{ $seo->meta_title }}</div>
                            <div class="d-flex gap-2">
                                <span class="badge bg-light text-muted border">{{ $seo->schema_type }}</span>
                                @if($seo->custom_js_head || $seo->custom_js_footer)
                                <span class="badge bg-info-subtle text-info border">Scripts</span>
                                @endif
                            </div>
                        </div>
                        @empty
                        <div class="p-3 text-center text-muted">
                            No custom SEO records configured yet.
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const titleInput = document.getElementById('metaTitleInput');
        const descInput = document.getElementById('metaDescInput');
        const serpTitle = document.getElementById('serpTitle');
        const serpDesc = document.getElementById('serpDescription');
        const titleCount = document.getElementById('titleCharCount');
        const descCount = document.getElementById('descCharCount');

        function updatePreview() {
            serpTitle.textContent = titleInput.value || 'Page Title | Advanced Dental Clinic';
            serpDesc.textContent = descInput.value || 'Page description preview for search engine results.';
            titleCount.textContent = titleInput.value.length + ' / 60 chars';
            descCount.textContent = descInput.value.length + ' / 160 chars';
        }

        titleInput.addEventListener('input', updatePreview);
        descInput.addEventListener('input', updatePreview);
        updatePreview();
    });
</script>
@endsection
