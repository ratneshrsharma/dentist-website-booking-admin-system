@extends('layouts.admin')

@section('title', 'Website CMS Pages Manager - Advanced Dental PRO')
@section('page_title', 'WordPress-Grade Website Pages Manager')
@section('page_subtitle', 'Live management of pre-rendered Next.js patient website pages, status tabs, slide-out drawer editor, and code injection')

@section('page_actions')
<div class="d-flex align-items-center gap-2">
    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="loadCmsPagesTable()">
        <i class="bi bi-arrow-clockwise me-1"></i> Refresh Pages
    </button>
    <button type="button" class="btn btn-sm btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#addCmsPageModal" style="background-color: var(--app-primary); border-color: var(--app-primary);">
        <i class="bi bi-plus-circle me-1"></i> Add New Page
    </button>
</div>
@endsection

@section('content')
<!-- Feedback Toast -->
<div id="cmsAlertPlaceholder" class="mb-3"></div>

<!-- Stat Cards -->
<div class="row g-3 mb-4">
    <!-- Stat 1 -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-card-content">
                <span class="stat-label">Total CMS Pages</span>
                <div class="stat-value" id="statTotalPages">24 Pages</div>
                <span class="badge bg-success-subtle text-success stat-meta">
                    <i class="bi bi-check-circle me-1"></i> WordPress parity
                </span>
            </div>
            <div class="stat-icon-wrapper stat-icon-primary">
                <i class="bi bi-file-earmark-code"></i>
            </div>
        </div>
    </div>

    <!-- Stat 2 -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-card-content">
                <span class="stat-label">Published (Live)</span>
                <div class="stat-value text-success" id="statPublishedCount">20 Pages</div>
                <span class="badge bg-success-subtle text-success stat-meta">
                    <i class="bi bi-lightning-charge me-1"></i> SSG Active
                </span>
            </div>
            <div class="stat-icon-wrapper stat-icon-success">
                <i class="bi bi-globe"></i>
            </div>
        </div>
    </div>

    <!-- Stat 3 -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-card-content">
                <span class="stat-label">Drafts</span>
                <div class="stat-value text-warning" id="statDraftCount">3 Pages</div>
                <span class="badge bg-warning-subtle text-warning stat-meta">
                    <i class="bi bi-pencil me-1"></i> In Editing
                </span>
            </div>
            <div class="stat-icon-wrapper stat-icon-warning">
                <i class="bi bi-file-earmark-text"></i>
            </div>
        </div>
    </div>

    <!-- Stat 4 -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-card-content">
                <span class="stat-label">Trash (Archive)</span>
                <div class="stat-value text-danger" id="statTrashCount">1 Page</div>
                <span class="badge bg-danger-subtle text-danger stat-meta">
                    <i class="bi bi-trash me-1"></i> Recoverable
                </span>
            </div>
            <div class="stat-icon-wrapper stat-icon-danger">
                <i class="bi bi-archive"></i>
            </div>
        </div>
    </div>
</div>

<!-- WordPress Status Filter Tabs & Search Bar -->
<div class="card border-0 shadow-sm rounded-3 mb-4">
    <div class="card-body py-3 px-4 d-flex flex-wrap align-items-center justify-content-between gap-3">
        <!-- Status Tabs Bar (WordPress Style) -->
        <ul class="nav nav-pills nav-sm gap-1" id="cmsStatusTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active py-1 px-3 small fw-semibold" id="filter-all" onclick="switchCmsTab('all')">
                    All <span class="badge bg-secondary ms-1" id="countAll">24</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link py-1 px-3 small fw-semibold text-success" id="filter-published" onclick="switchCmsTab('published')">
                    Published <span class="badge bg-success-subtle text-success ms-1" id="countPublished">20</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link py-1 px-3 small fw-semibold text-warning" id="filter-draft" onclick="switchCmsTab('draft')">
                    Drafts <span class="badge bg-warning-subtle text-warning ms-1" id="countDraft">3</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link py-1 px-3 small fw-semibold text-danger" id="filter-trash" onclick="switchCmsTab('trash')">
                    Trash <span class="badge bg-danger-subtle text-danger ms-1" id="countTrash">1</span>
                </button>
            </li>
        </ul>

        <!-- Search & Filter Controls -->
        <div class="d-flex align-items-center gap-2">
            <div class="input-group input-group-sm" style="max-width: 260px;">
                <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                <input type="text" class="form-control border-start-0" id="cmsSearchInput" onkeyup="filterCmsPages()" placeholder="Search title or slug...">
            </div>
            <select class="form-select form-select-sm" id="cmsCategoryFilter" onchange="filterCmsPages()" style="max-width: 170px;">
                <option value="all">All Categories</option>
                <option value="core">Core Pages (6)</option>
                <option value="treatments">Treatments (9)</option>
                <option value="legal">Legal & Compliance (9)</option>
            </select>
        </div>
    </div>
</div>

<!-- Pages Directory Table Card -->
<div class="card border-0 shadow-sm rounded-3">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="cmsPagesTable">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3 text-nowrap" style="min-width: 240px;">Page Title & Subtitle</th>
                        <th class="text-nowrap" style="min-width: 170px;">URL Slug</th>
                        <th class="text-nowrap" style="min-width: 130px;">Category</th>
                        <th class="text-nowrap" style="min-width: 110px;">SEO Health</th>
                        <th class="text-nowrap" style="min-width: 130px;">Author / Role</th>
                        <th class="text-nowrap" style="min-width: 110px;">Updated</th>
                        <th class="text-nowrap" style="min-width: 90px;">Status</th>
                        <th class="text-end pe-3 text-nowrap" style="min-width: 180px;">Actions</th>
                    </tr>
                </thead>
                <tbody id="cmsPagesTableBody">
                    <!-- Populated dynamically or via backend seed -->
                    <tr>
                        <td colspan="8" class="text-center py-5">
                            <div class="spinner-border text-primary spinner-border-sm me-2" role="status"></div>
                            <span class="text-muted">Loading 24 WordPress-Grade CMS Pages...</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white py-3 px-4 d-flex justify-content-between align-items-center border-top">
        <span class="small text-muted" id="tablePaginationInfo">Showing 24 of 24 pages</span>
        <div class="pagination-sm mb-0" id="tablePaginationControls">
            <!-- Pagination buttons -->
        </div>
    </div>
</div>

<!-- WordPress-Style Slide-Out Drawer for CMS Editing (`offcanvas-end`, 780px wide) -->
<div class="offcanvas offcanvas-end shadow-lg" tabindex="-1" id="editCmsPageModal" aria-labelledby="editCmsPageModalLabel" style="width: 780px; max-width: 100vw;">
    <div class="offcanvas-header bg-white border-bottom py-3 px-4 d-flex align-items-center justify-content-between">
        <div>
            <h5 class="offcanvas-title fw-bold text-dark mb-0" id="editCmsPageModalLabel">
                <i class="bi bi-pencil-square text-primary me-2"></i>WordPress-Style CMS Editor Studio
            </h5>
            <small class="text-muted" id="editModalSubtitle">Edit live page content, WYSIWYG rich text, sections, and SEO</small>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-light text-dark border font-monospace small px-2 py-1" id="activeEditingSlugBadge">/home</span>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
    </div>

    <form id="editCmsPageForm" onsubmit="handleEditCmsSubmit(event)" class="d-flex flex-column h-100">
        <input type="hidden" id="editPageRowId">
        <input type="hidden" id="editPageCleanSlug" value="home">

        <!-- Drawer Tabs Header -->
        <div class="bg-light px-4 pt-3 border-bottom flex-shrink-0">
            <ul class="nav nav-tabs border-bottom-0" id="editPageTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active fw-semibold small" id="tab-content-tab" data-bs-toggle="tab" data-bs-target="#tab-content" type="button" role="tab">
                        <i class="bi bi-file-earmark-text me-1 text-primary"></i> 1. Content & WYSIWYG
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-semibold small" id="tab-sections-tab" data-bs-toggle="tab" data-bs-target="#tab-sections" type="button" role="tab">
                        <i class="bi bi-layout-text-window-reverse me-1 text-info"></i> 2. Sections & CTA
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-semibold small" id="tab-seo-tab" data-bs-toggle="tab" data-bs-target="#tab-seo" type="button" role="tab">
                        <i class="bi bi-google me-1 text-success"></i> 3. Yoast SEO & Meta
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-semibold small" id="tab-code-tab" data-bs-toggle="tab" data-bs-target="#tab-code" type="button" role="tab">
                        <i class="bi bi-code-slash me-1 text-danger"></i> 4. Code Injection
                    </button>
                </li>
            </ul>
        </div>

        <!-- Drawer Body Content -->
        <div class="offcanvas-body p-4 flex-grow-1" style="overflow-y: auto;">
            <!-- Loading Spinner -->
            <div id="modalDataSpinner" class="text-center py-5 d-none">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading page configurations...</span>
                </div>
                <p class="small text-muted mt-2 mb-0">Synchronizing page schema and content from REST API...</p>
            </div>

            <div id="modalTabContentWrapper" class="tab-content">
                <!-- TAB 1: Content & WYSIWYG Editor -->
                <div class="tab-pane fade show active" id="tab-content" role="tabpanel">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label fw-semibold small">Page Title (H1 Headline) <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="editPageTitle" placeholder="e.g. Treatments & Clinical Services" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold small">URL Slug <span class="text-danger">*</span></label>
                            <input type="text" class="form-control font-monospace" id="editPageSlug" placeholder="treatments" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Page Category</label>
                            <select class="form-select" id="editPageCategory">
                                <option value="core">Core Page</option>
                                <option value="treatments">Treatments & Procedures</option>
                                <option value="legal">Legal & Compliance</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Publish Status</label>
                            <select class="form-select" id="editPageStatus">
                                <option value="published">Published (Live to SSG)</option>
                                <option value="draft">Draft (Hidden)</option>
                                <option value="trash">Trash (Archived)</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold small">Hero Subtitle / Narrative Teaser</label>
                            <textarea class="form-control" id="editPageSubtitle" rows="2" placeholder="Clinical explanation describing treatments and care philosophy."></textarea>
                        </div>
                        <div class="col-12">
                            <hr class="my-2">
                            <label class="form-label fw-semibold small d-flex justify-content-between align-items-center">
                                <span><i class="bi bi-file-richtext text-primary me-1"></i> Visual WYSIWYG Rich Text Editor</span>
                                <span class="text-muted small">No HTML knowledge required</span>
                            </label>
                            <!-- WYSIWYG Formatting Toolbar -->
                            <div class="btn-toolbar bg-light border border-bottom-0 rounded-top p-1 gap-1" role="toolbar">
                                <div class="btn-group btn-group-sm">
                                    <button type="button" class="btn btn-outline-secondary" onclick="formatWysiwyg('bold')" title="Bold"><i class="bi bi-type-bold"></i></button>
                                    <button type="button" class="btn btn-outline-secondary" onclick="formatWysiwyg('italic')" title="Italic"><i class="bi bi-type-italic"></i></button>
                                    <button type="button" class="btn btn-outline-secondary" onclick="formatWysiwyg('underline')" title="Underline"><i class="bi bi-type-underline"></i></button>
                                </div>
                                <div class="btn-group btn-group-sm">
                                    <button type="button" class="btn btn-outline-secondary" onclick="formatWysiwyg('formatBlock', '<h2>')" title="Heading H2">H2</button>
                                    <button type="button" class="btn btn-outline-secondary" onclick="formatWysiwyg('formatBlock', '<h3>')" title="Heading H3">H3</button>
                                    <button type="button" class="btn btn-outline-secondary" onclick="formatWysiwyg('formatBlock', '<p>')" title="Paragraph">P</button>
                                </div>
                                <div class="btn-group btn-group-sm">
                                    <button type="button" class="btn btn-outline-secondary" onclick="formatWysiwyg('insertUnorderedList')" title="Bullet List"><i class="bi bi-list-ul"></i></button>
                                    <button type="button" class="btn btn-outline-secondary" onclick="formatWysiwyg('insertOrderedList')" title="Numbered List"><i class="bi bi-list-ol"></i></button>
                                </div>
                                <div class="btn-group btn-group-sm">
                                    <button type="button" class="btn btn-outline-secondary" onclick="insertWysiwygLink()" title="Insert Link"><i class="bi bi-link-45deg"></i></button>
                                </div>
                            </div>
                            <!-- Editable Rich Text Area -->
                            <div class="form-control rounded-bottom" id="editPageWysiwygBody" contenteditable="true" style="min-height: 180px; max-height: 320px; overflow-y: auto; background: #fff;" placeholder="Enter section content with rich formatting..."></div>
                            <input type="hidden" id="editPageHtmlContent">
                        </div>
                    </div>
                </div>

                <!-- TAB 2: Page Sections & CTA -->
                <div class="tab-pane fade" id="tab-sections" role="tabpanel">
                    <!-- Home-Specific 7 Sections Accordion Manager -->
                    <div id="homeSectionsContainer" class="d-none">
                        <div class="alert alert-primary py-2 px-3 small d-flex align-items-center mb-3">
                            <i class="bi bi-layers fs-5 me-2 text-primary"></i>
                            <div>
                                <strong>Homepage Section Manager:</strong>
                                Edit all 7 live patient-facing sections. Changes reflect instantly on the homepage upon refresh.
                            </div>
                        </div>

                        <div class="accordion" id="accordionHomeSections">
                            <!-- Section 1: Hero Banner -->
                            <div class="accordion-item mb-2 border rounded-2 overflow-hidden">
                                <h2 class="accordion-header" id="headingSecHero">
                                    <button class="accordion-button py-2 px-3 fw-bold small text-dark bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSecHero" aria-expanded="true">
                                        <i class="bi bi-star-fill text-warning me-2"></i> Section 1: Hero Banner & Patient Numbers
                                    </button>
                                </h2>
                                <div id="collapseSecHero" class="accordion-collapse collapse show" data-bs-parent="#accordionHomeSections">
                                    <div class="accordion-body p-3 bg-white">
                                        <div class="row g-2">
                                            <div class="col-12">
                                                <label class="form-label small fw-semibold">Hero Eyebrow</label>
                                                <input type="text" class="form-control form-control-sm" id="homeHeroEyebrow" placeholder="B27 6BH Birmingham Dental Surgery">
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label small fw-semibold">Hero Main Headline</label>
                                                <input type="text" class="form-control form-control-sm" id="homeHeroHeadline" placeholder="Welcoming NHS & Private Dental Patients in Acocks Green">
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label small fw-semibold">Hero Subtitle</label>
                                                <textarea class="form-control form-control-sm" id="homeHeroSubtitle" rows="2" placeholder="High-quality, gentle family dentistry, routine check-ups..."></textarea>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label small fw-semibold">Emergency Triage Phone</label>
                                                <input type="text" class="form-control form-control-sm" id="homeHeroPhone" placeholder="+44 121 765 2870">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label small fw-semibold">Primary CTA Label</label>
                                                <input type="text" class="form-control form-control-sm" id="homeHeroCtaPrimary" placeholder="Book Consultation">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label small fw-semibold">Secondary CTA Label</label>
                                                <input type="text" class="form-control form-control-sm" id="homeHeroCtaSecondary" placeholder="Call Practice Reception">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label small fw-semibold">Registered Patients Stat</label>
                                                <input type="text" class="form-control form-control-sm" id="homeHeroStatPatients" placeholder="15,000+">
                                            </div>
                                            <div class="col-12 text-end mt-2">
                                                <button type="button" class="btn btn-outline-primary btn-sm py-1 px-3" onclick="saveSpecificSection('hero')">
                                                    <i class="bi bi-check2 me-1"></i> Save Hero Section
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Section 2: Services Overview -->
                            <div class="accordion-item mb-2 border rounded-2 overflow-hidden">
                                <h2 class="accordion-header" id="headingSecServices">
                                    <button class="accordion-button collapsed py-2 px-3 fw-bold small text-dark bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSecServices">
                                        <i class="bi bi-grid-3x3-gap-fill text-primary me-2"></i> Section 2: 9 Clinical Procedures & Services
                                    </button>
                                </h2>
                                <div id="collapseSecServices" class="accordion-collapse collapse" data-bs-parent="#accordionHomeSections">
                                    <div class="accordion-body p-3 bg-white">
                                        <div class="row g-2">
                                            <div class="col-12">
                                                <label class="form-label small fw-semibold">Services Section Badge</label>
                                                <input type="text" class="form-control form-control-sm" id="homeServicesBadge" placeholder="Our 9 Clinical Procedures & Services">
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label small fw-semibold">Services Section Headline</label>
                                                <input type="text" class="form-control form-control-sm" id="homeServicesHeadline" placeholder="Evidence-Based Clinical Dentistry in Acocks Green">
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label small fw-semibold">Services Section Subtitle</label>
                                                <textarea class="form-control form-control-sm" id="homeServicesSubtitle" rows="2" placeholder="Delivering statutory NHS fee bandings and bespoke private solutions..."></textarea>
                                            </div>
                                            <div class="col-12 text-end mt-2">
                                                <button type="button" class="btn btn-outline-primary btn-sm py-1 px-3" onclick="saveSpecificSection('services')">
                                                    <i class="bi bi-check2 me-1"></i> Save Services Section
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Section 3: About & Clinical Director -->
                            <div class="accordion-item mb-2 border rounded-2 overflow-hidden">
                                <h2 class="accordion-header" id="headingSecAbout">
                                    <button class="accordion-button collapsed py-2 px-3 fw-bold small text-dark bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSecAbout">
                                        <i class="bi bi-person-badge-fill text-success me-2"></i> Section 3: Surgery Overview & Clinical Director
                                    </button>
                                </h2>
                                <div id="collapseSecAbout" class="accordion-collapse collapse" data-bs-parent="#accordionHomeSections">
                                    <div class="accordion-body p-3 bg-white">
                                        <div class="row g-2">
                                            <div class="col-md-6">
                                                <label class="form-label small fw-semibold">Clinical Director Name</label>
                                                <input type="text" class="form-control form-control-sm" id="homeDirectorName" placeholder="Dr. Richard C. Williams">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label small fw-semibold">Director Title</label>
                                                <input type="text" class="form-control form-control-sm" id="homeDirectorTitle" placeholder="Clinical Director & Lead Implant Surgeon">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label small fw-semibold">Credentials</label>
                                                <input type="text" class="form-control form-control-sm" id="homeDirectorCredentials" placeholder="BDS (Birm), MJDF RCS (Eng), PgCert Implantology">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label small fw-semibold">GDC Registration Number</label>
                                                <input type="text" class="form-control form-control-sm" id="homeDirectorGdc" placeholder="GDC No: 178924">
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label small fw-semibold">Director Personal Quote / Message</label>
                                                <textarea class="form-control form-control-sm" id="homeDirectorQuote" rows="2" placeholder="For over two decades, our practice has served the families of Acocks Green..."></textarea>
                                            </div>
                                            <div class="col-12 text-end mt-2">
                                                <button type="button" class="btn btn-outline-primary btn-sm py-1 px-3" onclick="saveSpecificSection('about')">
                                                    <i class="bi bi-check2 me-1"></i> Save About & Director Section
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Section 4: Clinical Team -->
                            <div class="accordion-item mb-2 border rounded-2 overflow-hidden">
                                <h2 class="accordion-header" id="headingSecTeam">
                                    <button class="accordion-button collapsed py-2 px-3 fw-bold small text-dark bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSecTeam">
                                        <i class="bi bi-people-fill text-info me-2"></i> Section 4: Clinical Team & GDC Registrations
                                    </button>
                                </h2>
                                <div id="collapseSecTeam" class="accordion-collapse collapse" data-bs-parent="#accordionHomeSections">
                                    <div class="accordion-body p-3 bg-white">
                                        <div class="row g-2">
                                            <div class="col-12">
                                                <label class="form-label small fw-semibold">Team Section Badge</label>
                                                <input type="text" class="form-control form-control-sm" id="homeTeamBadge" placeholder="Meet Our Clinicians">
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label small fw-semibold">Team Section Headline</label>
                                                <input type="text" class="form-control form-control-sm" id="homeTeamHeadline" placeholder="Experienced GDC-Registered Dental Professionals">
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label small fw-semibold">Team Section Subtitle</label>
                                                <textarea class="form-control form-control-sm" id="homeTeamSubtitle" rows="2" placeholder="Our team of dentists, dental hygienists, and dedicated dental nurses..."></textarea>
                                            </div>
                                            <div class="col-12 text-end mt-2">
                                                <button type="button" class="btn btn-outline-primary btn-sm py-1 px-3" onclick="saveSpecificSection('team')">
                                                    <i class="bi bi-check2 me-1"></i> Save Team Section
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Section 5: Patient Reviews -->
                            <div class="accordion-item mb-2 border rounded-2 overflow-hidden">
                                <h2 class="accordion-header" id="headingSecReviews">
                                    <button class="accordion-button collapsed py-2 px-3 fw-bold small text-dark bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSecReviews">
                                        <i class="bi bi-chat-square-quote-fill text-warning me-2"></i> Section 5: Patient Feedback & Community Reviews
                                    </button>
                                </h2>
                                <div id="collapseSecReviews" class="accordion-collapse collapse" data-bs-parent="#accordionHomeSections">
                                    <div class="accordion-body p-3 bg-white">
                                        <div class="row g-2">
                                            <div class="col-md-6">
                                                <label class="form-label small fw-semibold">Reviews Section Headline</label>
                                                <input type="text" class="form-control form-control-sm" id="homeReviewsHeadline" placeholder="Hear From Our Acocks Green Community">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label small fw-semibold">Overall Rating</label>
                                                <input type="text" class="form-control form-control-sm" id="homeReviewsRating" placeholder="4.9">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label small fw-semibold">Total Reviews Count</label>
                                                <input type="text" class="form-control form-control-sm" id="homeReviewsTotal" placeholder="140+">
                                            </div>
                                            <div class="col-12 text-end mt-2">
                                                <button type="button" class="btn btn-outline-primary btn-sm py-1 px-3" onclick="saveSpecificSection('reviews')">
                                                    <i class="bi bi-check2 me-1"></i> Save Reviews Section
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Section 6: Safety Charter -->
                            <div class="accordion-item mb-2 border rounded-2 overflow-hidden">
                                <h2 class="accordion-header" id="headingSecCharter">
                                    <button class="accordion-button collapsed py-2 px-3 fw-bold small text-dark bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSecCharter">
                                        <i class="bi bi-shield-check text-success me-2"></i> Section 6: NHS Sexual Safety Charter
                                    </button>
                                </h2>
                                <div id="collapseSecCharter" class="accordion-collapse collapse" data-bs-parent="#accordionHomeSections">
                                    <div class="accordion-body p-3 bg-white">
                                        <div class="row g-2">
                                            <div class="col-12">
                                                <label class="form-label small fw-semibold">Charter Headline</label>
                                                <input type="text" class="form-control form-control-sm" id="homeCharterHeadline" placeholder="NHS Sexual Safety Charter & Patient Protection">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label small fw-semibold">Practice Manager Contact</label>
                                                <input type="text" class="form-control form-control-sm" id="homeCharterManager" placeholder="Rebecca Solly">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label small fw-semibold">Charter PDF Document URL</label>
                                                <input type="text" class="form-control form-control-sm" id="homeCharterPdfUrl" placeholder="https://www.acocksgreendentalpractice.co.uk/wp-content/uploads/2026/04/SEXUAL-SAFETY-CHARTER.pdf">
                                            </div>
                                            <div class="col-12 text-end mt-2">
                                                <button type="button" class="btn btn-outline-primary btn-sm py-1 px-3" onclick="saveSpecificSection('charter')">
                                                    <i class="bi bi-check2 me-1"></i> Save Safety Charter Section
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Section 7: Practice Location & Hours -->
                            <div class="accordion-item mb-2 border rounded-2 overflow-hidden">
                                <h2 class="accordion-header" id="headingSecContact">
                                    <button class="accordion-button collapsed py-2 px-3 fw-bold small text-dark bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSecContact">
                                        <i class="bi bi-geo-alt-fill text-danger me-2"></i> Section 7: Practice Location, Opening Hours & Direct Transit
                                    </button>
                                </h2>
                                <div id="collapseSecContact" class="accordion-collapse collapse" data-bs-parent="#accordionHomeSections">
                                    <div class="accordion-body p-3 bg-white">
                                        <div class="row g-2">
                                            <div class="col-12">
                                                <label class="form-label small fw-semibold">Location Section Headline</label>
                                                <input type="text" class="form-control form-control-sm" id="homeContactHeadline" placeholder="Visiting Acocks Green Dental Practice">
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label small fw-semibold">Surgery Address</label>
                                                <input type="text" class="form-control form-control-sm" id="homeContactAddress" placeholder="1078 Warwick Road, Acocks Green, Birmingham B27 6BH">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label small fw-semibold">Surgery Phone</label>
                                                <input type="text" class="form-control form-control-sm" id="homeContactPhone" placeholder="0121 765 2870">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label small fw-semibold">Emergency Triage Line</label>
                                                <input type="text" class="form-control form-control-sm" id="homeContactEmergencyPhone" placeholder="0121 765 2870">
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label small fw-semibold">Opening Hours Summary</label>
                                                <input type="text" class="form-control form-control-sm" id="homeContactHours" placeholder="Mon - Thu: 09:00 – 17:30 | Fri: 09:00 – 17:00 | Sat - Sun: Closed">
                                            </div>
                                            <div class="col-12 text-end mt-2">
                                                <button type="button" class="btn btn-outline-primary btn-sm py-1 px-3" onclick="saveSpecificSection('contact')">
                                                    <i class="bi bi-check2 me-1"></i> Save Location & Hours Section
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Inner Page Default Section Controls (Visible for non-home pages) -->
                    <div id="innerPageSectionsContainer" class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Hero Eyebrow Tagline</label>
                            <input type="text" class="form-control" id="editPageEyebrow" placeholder="e.g. Evidence-Based Dental Excellence">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Hero Accreditation Badge</label>
                            <input type="text" class="form-control" id="editPageBadge" placeholder="e.g. B27 6BH Dental Surgery">
                        </div>
                        <div class="col-12">
                            <hr class="my-2">
                            <h6 class="fw-bold text-dark mb-1"><i class="bi bi-chat-heart text-primary me-1"></i> Patient Consultation CTA Section</h6>
                            <small class="text-muted d-block mb-3">Configure the bottom appointment conversion banner for this page</small>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label fw-semibold small">Consultation Headline</label>
                            <input type="text" class="form-control" id="editCtaHeadline" placeholder="e.g. Ready to Plan Your Treatment?">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold small">Practice Telephone</label>
                            <input type="text" class="form-control" id="editCtaPhone" placeholder="e.g. +44 121 765 2870">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold small">Consultation Supporting Copy</label>
                            <textarea class="form-control" id="editCtaDescription" rows="2" placeholder="Book a comprehensive dental examination or speak with our clinical reception team today."></textarea>
                        </div>
                    </div>
                </div>

                <!-- TAB 3: Yoast SEO & Meta -->
                <div class="tab-pane fade" id="tab-seo" role="tabpanel">
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <label class="form-label fw-semibold small mb-0">Meta Title (Google Snippet)</label>
                                <small class="text-muted"><span id="metaTitleCount">0</span> / 60 characters</small>
                            </div>
                            <input type="text" class="form-control" id="editSeoMetaTitle" placeholder="e.g. Treatments & Services | Acocks Green Dental Practice Birmingham" oninput="updateSeoCounts()">
                        </div>
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <label class="form-label fw-semibold small mb-0">Meta Description</label>
                                <small class="text-muted"><span id="metaDescCount">0</span> / 160 characters</small>
                            </div>
                            <textarea class="form-control" id="editSeoMetaDesc" rows="3" placeholder="Explore our full range of NHS and private dental treatments in Acocks Green, Birmingham B27 6BH." oninput="updateSeoCounts()"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">SEO Keywords (Comma Separated)</label>
                            <input type="text" class="form-control" id="editSeoKeywords" placeholder="Dentist Birmingham, NHS Dentist B27, Dental Implants">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Canonical URL</label>
                            <input type="url" class="form-control" id="editSeoCanonical" placeholder="https://acocksgreendentalpractice.co.uk/treatments">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold small">Social Share Image (OpenGraph URL)</label>
                            <input type="url" class="form-control" id="editSeoOgImage" placeholder="https://images.unsplash.com/photo-1629909613654-28e377c37b09">
                        </div>
                    </div>
                </div>

                <!-- TAB 4: Code Injection -->
                <div class="tab-pane fade" id="tab-code" role="tabpanel">
                    <div class="alert alert-info py-2 px-3 small d-flex align-items-center mb-3">
                        <i class="bi bi-shield-check fs-5 me-2 text-info"></i>
                        <div>
                            <strong>Dual-Scope Code Injection Engine:</strong>
                            Scope A applies sitewide. Scope B applies only to this specific page.
                        </div>
                    </div>

                    <!-- Scope A -->
                    <div class="card border rounded-3 mb-3 bg-light-subtle">
                        <div class="card-header bg-light py-2 px-3 d-flex align-items-center justify-content-between">
                            <span class="fw-bold small text-dark"><i class="bi bi-globe me-1 text-primary"></i> Scope A: Sitewide (Global)</span>
                        </div>
                        <div class="card-body p-3">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label fw-semibold small mb-1">Global Sitewide CSS</label>
                                    <textarea class="form-control font-monospace small" id="editCommonCss" rows="2" placeholder="/* Global CSS */"></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small mb-1">Global Head JS (GTM, GA4)</label>
                                    <textarea class="form-control font-monospace small" id="editCommonHeadJs" rows="3" placeholder="<!-- GTM Head -->"></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small mb-1">Global Body JS (WhatsApp Widget)</label>
                                    <textarea class="form-control font-monospace small" id="editCommonBodyJs" rows="3" placeholder="<!-- WhatsApp Widget -->"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Scope B -->
                    <div class="card border rounded-3">
                        <div class="card-header bg-white py-2 px-3 d-flex align-items-center justify-content-between">
                            <span class="fw-bold small text-dark"><i class="bi bi-file-earmark-code me-1 text-teal" style="color: #0F766E;"></i> Scope B: Page-Specific</span>
                            <span class="badge bg-teal-subtle text-teal small" id="badgeTargetPageSlug" style="background: #CCFBF1; color: #0F766E;">/home</span>
                        </div>
                        <div class="card-body p-3">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label fw-semibold small mb-1">Page-Specific Custom CSS</label>
                                    <textarea class="form-control font-monospace small" id="editPageCss" rows="2" placeholder="/* Page specific CSS */"></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small mb-1">Page Head Scripts</label>
                                    <textarea class="form-control font-monospace small" id="editPageHeadJs" rows="3" placeholder="<!-- Head Script -->"></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small mb-1">Page Body Scripts</label>
                                    <textarea class="form-control font-monospace small" id="editPageBodyJs" rows="3" placeholder="<!-- Body Script -->"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Drawer Footer -->
        <div class="offcanvas-footer bg-light border-top py-2 px-4 d-flex justify-content-between align-items-center flex-shrink-0">
            <div>
                <span class="small text-muted" id="editSaveStatusText">
                    <i class="bi bi-cloud-check text-success me-1"></i> Auto-sync with Next.js SSG REST API
                </span>
            </div>
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="offcanvas">Cancel</button>
                <button type="submit" class="btn btn-primary btn-sm px-3" id="btnSaveCmsPage" style="background-color: var(--app-primary); border-color: var(--app-primary);">
                    <span class="spinner-border spinner-border-sm me-1 d-none" id="savePageSpinner" role="status"></span>
                    <i class="bi bi-cloud-arrow-up-fill me-1" id="savePageIcon"></i>Publish / Update Page
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Modal: Add New Page -->
<div class="modal fade" id="addCmsPageModal" tabindex="-1" aria-labelledby="addCmsPageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-white border-bottom py-3">
                <h5 class="modal-title fw-bold text-dark" id="addCmsPageModalLabel">
                    <i class="bi bi-file-earmark-plus-fill text-primary me-2"></i>Create New Patient Website CMS Page
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addCmsPageForm" onsubmit="handleAddCmsPage(event)">
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-7">
                            <label class="form-label fw-semibold small">Page Title (H1 Headline) <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="addPageTitle" placeholder="e.g. Root Canal Therapy & Endodontics" onkeyup="autoGenerateSlug()" required>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label fw-semibold small">URL Slug <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted small">/</span>
                                <input type="text" class="form-control" id="addPageSlug" placeholder="treatments/root-canal" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Page Category</label>
                            <select class="form-select" id="addPageCategory">
                                <option value="treatments">Treatments & Procedures</option>
                                <option value="core">Core Practice Page</option>
                                <option value="legal">Legal & Compliance Policy</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Publishing Status</label>
                            <select class="form-select" id="addPageStatus">
                                <option value="published">Published (Live to Next.js API)</option>
                                <option value="draft">Draft (Hidden from public navigation)</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold small">Hero Subtitle / Clinical Teaser</label>
                            <input type="text" class="form-control" id="addPageSubtitle" placeholder="e.g. Painless tooth preservation with microscopic rotary endodontic technology.">
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-top py-2 px-4">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm" id="btnAddPageSubmit" style="background-color: var(--app-primary); border-color: var(--app-primary);">
                        <span class="spinner-border spinner-border-sm me-1 d-none" id="addPageSpinner" role="status" aria-hidden="true"></span>
                        <i class="bi bi-cloud-arrow-up-fill me-1" id="addPageIcon"></i>Publish Page to Next.js
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let globalCmsPagesCache = [];
    let currentCmsStatusTab = 'all';

    document.addEventListener('DOMContentLoaded', () => {
        loadCmsPagesTable();
    });

    function showCmsAlert(message, type = 'success') {
        const placeholder = document.getElementById('cmsAlertPlaceholder');
        if (!placeholder) return;
        placeholder.innerHTML = `
            <div class="alert alert-${type} alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;
        setTimeout(() => {
            const alert = placeholder.querySelector('.alert');
            if (alert) {
                const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
                bsAlert.close();
            }
        }, 5000);
    }

    // Switch WordPress Status Tab
    function switchCmsTab(statusTab) {
        currentCmsStatusTab = statusTab;
        document.querySelectorAll('#cmsStatusTabs .nav-link').forEach(el => el.classList.remove('active'));
        const activeBtn = document.getElementById('filter-' + statusTab);
        if (activeBtn) activeBtn.classList.add('active');
        renderCmsTableRows();
    }

    // Load Pages from REST API
    async function loadCmsPagesTable() {
        try {
            const response = await fetch('{{ url("/api/v1/cms/pages") }}?status=all');
            const result = await response.json();
            if (result.success && Array.isArray(result.data)) {
                globalCmsPagesCache = result.data;

                // Update count badges
                if (result.counts) {
                    document.getElementById('countAll').innerText = result.counts.all || 0;
                    document.getElementById('countPublished').innerText = result.counts.published || 0;
                    document.getElementById('countDraft').innerText = result.counts.draft || 0;
                    document.getElementById('countTrash').innerText = result.counts.trash || 0;

                    document.getElementById('statTotalPages').innerText = (result.counts.all || 24) + ' Pages';
                    document.getElementById('statPublishedCount').innerText = (result.counts.published || 20) + ' Pages';
                    document.getElementById('statDraftCount').innerText = (result.counts.draft || 3) + ' Pages';
                    document.getElementById('statTrashCount').innerText = (result.counts.trash || 1) + ' Page';
                }

                renderCmsTableRows();
            }
        } catch (err) {
            console.error('Failed to load CMS pages from API:', err);
            showCmsAlert('Could not fetch pages from REST API. Using fallback state.', 'warning');
        }
    }

    // Render Table Rows with WordPress Hover Actions & Status Badges
    function renderCmsTableRows() {
        const tbody = document.getElementById('cmsPagesTableBody');
        if (!tbody) return;

        const search = (document.getElementById('cmsSearchInput')?.value || '').toLowerCase();
        const catFilter = document.getElementById('cmsCategoryFilter')?.value || 'all';

        const filtered = globalCmsPagesCache.filter(p => {
            // Status tab filter
            if (currentCmsStatusTab !== 'all' && p.status !== currentCmsStatusTab) return false;
            // Category filter
            if (catFilter !== 'all' && p.category !== catFilter) return false;
            // Search query
            if (search !== '') {
                const matchTitle = (p.title || '').toLowerCase().includes(search);
                const matchSlug = (p.slug || '').toLowerCase().includes(search);
                if (!matchTitle && !matchSlug) return false;
            }
            return true;
        });

        if (filtered.length === 0) {
            tbody.innerHTML = `<tr><td colspan="8" class="text-center py-5 text-muted">No pages found matching status "${currentCmsStatusTab}" and filters.</td></tr>`;
            document.getElementById('tablePaginationInfo').innerText = `Showing 0 pages`;
            return;
        }

        let html = '';
        filtered.forEach((p, index) => {
            const rowId = `page-row-api-${index}-${Math.abs(p.slug.hashCode ? p.slug.hashCode() : index)}`;
            const isTrash = p.status === 'trash';
            const isPublished = p.status === 'published';
            const statusBadgeClass = isPublished ? 'bg-success' : (isTrash ? 'bg-danger' : 'bg-warning text-dark');
            const statusLabel = isPublished ? 'Published' : (isTrash ? 'Trash' : 'Draft');

            const catLabel = p.category_label || (p.category === 'treatments' ? 'Treatments' : (p.category === 'core' ? 'Core Page' : 'Legal & Compliance'));
            const catBadgeStyle = p.category === 'treatments' ? 'background: #CCFBF1; color: #0F766E;' : 'background: #E0E7FF; color: #3730A3;';

            // WordPress Hover Action links: Edit | Quick Edit | Move to Trash | View Page ↗
            let actionsHtml = '';
            if (isTrash) {
                actionsHtml = `
                    <div class="btn-group btn-group-sm">
                        <button type="button" class="btn btn-outline-success" onclick="restoreCmsPage('${p.slug}')" title="Restore from Trash"><i class="bi bi-arrow-counterclockwise me-1"></i> Restore</button>
                        <button type="button" class="btn btn-outline-danger" onclick="forceDeleteCmsPage('${p.slug}')" title="Delete Permanently"><i class="bi bi-x-circle"></i></button>
                    </div>
                `;
            } else {
                actionsHtml = `
                    <div class="btn-group btn-group-sm">
                        <a href="{{ url('/') }}/${p.slug === '/' ? '' : p.slug}" target="_blank" class="btn btn-outline-secondary" title="View Live"><i class="bi bi-eye"></i></a>
                        <button type="button" class="btn btn-outline-secondary" onclick="openEditCmsDrawer('${p.slug}', '${encodeURIComponent(p.title)}')">Edit</button>
                        <button type="button" class="btn btn-outline-danger" onclick="trashCmsPage('${p.slug}')" title="Move to Trash"><i class="bi bi-trash"></i></button>
                    </div>
                `;
            }

            html += `
                <tr id="${rowId}" data-slug="${p.slug}" data-title="${p.title}" data-category="${p.category}" data-status="${p.status}">
                    <td class="ps-3">
                        <span class="fw-bold text-dark d-block page-title">${p.title}</span>
                        <small class="text-muted page-subtitle">${p.subtitle || 'Pre-rendered Next.js patient page'}</small>
                    </td>
                    <td><span class="badge bg-light text-dark border font-monospace page-slug">/${p.slug === '/' ? '' : p.slug}</span></td>
                    <td><span class="badge page-cat" style="${catBadgeStyle}">${catLabel}</span></td>
                    <td><span class="badge bg-success-subtle text-success"><i class="bi bi-check-circle me-1"></i>Score: ${p.seo_score || 96}</span></td>
                    <td><span class="small text-muted">${p.author || 'Dr. Richard C. Williams'}</span></td>
                    <td><span class="small text-muted">${p.updated_at || 'Today'}</span></td>
                    <td><span class="badge ${statusBadgeClass} page-status">${statusLabel}</span></td>
                    <td class="text-end pe-3">${actionsHtml}</td>
                </tr>
            `;
        });

        tbody.innerHTML = html;
        document.getElementById('tablePaginationInfo').innerText = `Showing ${filtered.length} of ${globalCmsPagesCache.length} pages`;
    }

    // Live search filter input trigger
    function filterCmsPages() {
        renderCmsTableRows();
    }

    // WYSIWYG Formatting Helper
    function formatWysiwyg(command, value = null) {
        document.execCommand(command, false, value);
        document.getElementById('editPageWysiwygBody').focus();
    }

    function insertWysiwygLink() {
        const url = prompt('Enter hyperlink URL:', 'https://');
        if (url) {
            document.execCommand('createLink', false, url);
        }
    }

    // Open Slide-Out Drawer (`offcanvas-end`) for Editing CMS Page
    async function openEditCmsDrawer(slug, encodedTitle) {
        const title = decodeURIComponent(encodedTitle);
        let cleanSlug = slug.replace(/^\/+/, '');
        if (!cleanSlug || cleanSlug === '') {
            cleanSlug = 'home';
        }

        const setVal = (id, val) => { const el = document.getElementById(id); if (el) el.value = val; };
        const setTxt = (id, txt) => { const el = document.getElementById(id); if (el) el.innerText = txt; };

        setVal('editPageCleanSlug', cleanSlug);
        setVal('editPageTitle', title);
        setVal('editPageSlug', cleanSlug);
        setTxt('activeEditingSlugBadge', cleanSlug === 'home' ? '/' : '/' + cleanSlug);
        setTxt('badgeTargetPageSlug', cleanSlug === 'home' ? '/' : '/' + cleanSlug);
        setTxt('editModalSubtitle', `Editing page content, sections, and SEO for ${cleanSlug === 'home' ? '/' : '/' + cleanSlug}`);

        // Show loading spinner
        const spinner = document.getElementById('modalDataSpinner');
        if (spinner) spinner.classList.remove('d-none');

        // Show Bootstrap 5 offcanvas drawer
        const drawerEl = document.getElementById('editCmsPageModal');
        if (drawerEl && window.bootstrap && bootstrap.Offcanvas) {
            const offcanvas = bootstrap.Offcanvas.getOrCreateInstance(drawerEl);
            offcanvas.show();
        }

        try {
            const res = await fetch(`{{ url('/api/v1/cms/pages') }}/${cleanSlug}`);
            const json = await res.json();
            if (json.success && json.data) {
                const d = json.data;
                if (d.title) setVal('editPageTitle', d.title);
                if (d.subtitle) setVal('editPageSubtitle', d.subtitle);
                if (d.category) setVal('editPageCategory', d.category);
                if (d.status) setVal('editPageStatus', d.status);
                setVal('editPageEyebrow', d.eyebrow || '');
                setVal('editPageBadge', d.badge || '');

                if (d.consultation_cta) {
                    setVal('editCtaHeadline', d.consultation_cta.headline || '');
                    setVal('editCtaPhone', d.consultation_cta.phone || '');
                    setVal('editCtaDescription', d.consultation_cta.description || '');
                }

                if (d.seo) {
                    setVal('editSeoMetaTitle', d.seo.meta_title || '');
                    setVal('editSeoMetaDesc', d.seo.meta_description || '');
                    setVal('editSeoKeywords', Array.isArray(d.seo.keywords) ? d.seo.keywords.join(', ') : (d.seo.keywords || ''));
                    setVal('editSeoCanonical', d.seo.canonical_url || '');
                    setVal('editSeoOgImage', d.seo.og_image || '');
                    updateSeoCounts();
                }

                const wysiwyg = document.getElementById('editPageWysiwygBody');
                if (wysiwyg) {
                    wysiwyg.innerHTML = d.body_html || `<p>${d.subtitle || 'Welcome to Advanced Dental Clinic patient care portal.'}</p>`;
                }

                // Populate Homepage 7-Section Accordion if editing Home
                const homeContainer = document.getElementById('homeSectionsContainer');
                const innerContainer = document.getElementById('innerPageSectionsContainer');
                if (cleanSlug === 'home') {
                    if (homeContainer) homeContainer.classList.remove('d-none');
                    if (innerContainer) innerContainer.classList.add('d-none');

                    // Section 1: Hero
                    const hero = d.hero || {};
                    setVal('homeHeroEyebrow', hero.eyebrow || d.eyebrow || '');
                    setVal('homeHeroHeadline', hero.title || hero.headline || d.title || '');
                    setVal('homeHeroSubtitle', hero.subtitle || d.subtitle || '');
                    setVal('homeHeroPhone', hero.emergency_phone || hero.phone || '');
                    setVal('homeHeroCtaText', hero.primary_cta_label || 'Book Free Consultation');
                    setVal('homeHeroCtaLink', hero.primary_cta_link || '/book');
                    if (Array.isArray(hero.stats)) {
                        for (let i = 0; i < 4; i++) {
                            const st = hero.stats[i] || {};
                            setVal(`homeHeroStat${i}Val`, st.value || '');
                            setVal(`homeHeroStat${i}Lbl`, st.label || '');
                            setVal(`homeHeroStat${i}Sub`, st.subtext || '');
                        }
                    }

                    // Section 2: Services
                    const services = d.services || {};
                    setVal('homeServicesBadge', services.badge || '');
                    setVal('homeServicesHeadline', services.headline || services.title || '');
                    setVal('homeServicesSubtitle', services.subtitle || '');

                    // Section 3: About & Director
                    const about = d.about || {};
                    const director = d.director || about.director || {};
                    setVal('homeAboutBadge', about.badge || '');
                    setVal('homeAboutHeadline', about.headline || about.title || '');
                    setVal('homeAboutSubtitle', about.subtitle || '');
                    setVal('homeDirectorName', director.name || '');
                    setVal('homeDirectorTitle', director.title || '');
                    setVal('homeDirectorCreds', director.credentials || '');
                    setVal('homeDirectorGdc', director.gdc_number || '');
                    setVal('homeDirectorQuote', director.quote || '');
                    setVal('homeDirectorImage', director.image || '');

                    // Section 4: Team
                    const team = d.team || {};
                    setVal('homeTeamBadge', team.badge || '');
                    setVal('homeTeamHeadline', team.headline || team.title || '');
                    setVal('homeTeamSubtitle', team.subtitle || '');

                    // Section 5: Reviews
                    const reviews = d.reviews || {};
                    setVal('homeReviewsBadge', reviews.badge || '');
                    setVal('homeReviewsHeadline', reviews.headline || reviews.title || '');
                    setVal('homeReviewsSubtitle', reviews.subtitle || '');
                    setVal('homeReviewsRating', reviews.overall_rating || reviews.rating || '4.9');
                    setVal('homeReviewsCount', reviews.total_reviews_count || reviews.total_reviews || '284');

                    // Section 6: Safety Charter
                    const charter = d.charter || {};
                    setVal('homeCharterBadge', charter.badge || '');
                    setVal('homeCharterHeadline', charter.headline || charter.title || '');
                    setVal('homeCharterDesc', charter.description || '');
                    setVal('homeCharterManager', charter.practice_manager_contact || '');
                    setVal('homeCharterPdfUrl', charter.charter_pdf_url || '');

                    // Section 7: Contact & Hours
                    const contact = d.contact || {};
                    setVal('homeContactHeadline', contact.headline || contact.title || '');
                    setVal('homeContactAddress', contact.surgery_address || contact.address || '');
                    setVal('homeContactPhone', contact.surgery_phone || contact.phone || '');
                    setVal('homeContactEmergencyPhone', contact.emergency_triage_line || contact.emergency_phone || '');
                    setVal('homeContactHours', contact.opening_hours_summary || '');
                } else {
                    if (homeContainer) homeContainer.classList.add('d-none');
                    if (innerContainer) innerContainer.classList.remove('d-none');
                }
            }
        } catch (err) {
            console.warn('Could not fetch page details:', err);
        } finally {
            if (spinner) spinner.classList.add('d-none');
        }
    }

    // Submit Drawer Edits via REST API
    async function handleEditCmsSubmit(event) {
        event.preventDefault();
        const cleanSlug = document.getElementById('editPageCleanSlug')?.value || 'home';
        const btnSave = document.getElementById('btnSaveCmsPage');
        const spinner = document.getElementById('savePageSpinner');
        const icon = document.getElementById('savePageIcon');

        if (btnSave) btnSave.disabled = true;
        if (spinner) spinner.classList.remove('d-none');
        if (icon) icon.classList.add('d-none');

        const title = document.getElementById('editPageTitle')?.value.trim() || '';
        const subtitle = document.getElementById('editPageSubtitle')?.value.trim() || '';
        const category = document.getElementById('editPageCategory')?.value || 'treatments';
        const status = document.getElementById('editPageStatus')?.value || 'published';
        const bodyHtml = document.getElementById('editPageWysiwygBody')?.innerHTML || '';

        const payload = {
            slug: cleanSlug,
            title: title,
            subtitle: subtitle,
            category: category,
            status: status,
            body_html: bodyHtml,
            eyebrow: document.getElementById('editPageEyebrow')?.value || '',
            badge: document.getElementById('editPageBadge')?.value || '',
            consultation_cta: {
                headline: document.getElementById('editCtaHeadline')?.value || '',
                phone: document.getElementById('editCtaPhone')?.value || '',
                description: document.getElementById('editCtaDescription')?.value || ''
            },
            seo: {
                meta_title: document.getElementById('editSeoMetaTitle')?.value || '',
                meta_description: document.getElementById('editSeoMetaDesc')?.value || '',
                keywords: (document.getElementById('editSeoKeywords')?.value || '').split(',').map(s => s.trim()).filter(Boolean),
                canonical_url: document.getElementById('editSeoCanonical')?.value || '',
                og_image: document.getElementById('editSeoOgImage')?.value || ''
            }
        };

        if (cleanSlug === 'home') {
            payload.hero = {
                eyebrow: document.getElementById('homeHeroEyebrow')?.value || '',
                title: document.getElementById('homeHeroHeadline')?.value || '',
                headline: document.getElementById('homeHeroHeadline')?.value || '',
                subtitle: document.getElementById('homeHeroSubtitle')?.value || '',
                emergency_phone: document.getElementById('homeHeroPhone')?.value || '',
                primary_cta_label: document.getElementById('homeHeroCtaText')?.value || '',
                primary_cta_link: document.getElementById('homeHeroCtaLink')?.value || '',
                stats: [
                    { value: document.getElementById('homeHeroStat0Val')?.value || '', label: document.getElementById('homeHeroStat0Lbl')?.value || '', subtext: document.getElementById('homeHeroStat0Sub')?.value || '' },
                    { value: document.getElementById('homeHeroStat1Val')?.value || '', label: document.getElementById('homeHeroStat1Lbl')?.value || '', subtext: document.getElementById('homeHeroStat1Sub')?.value || '' },
                    { value: document.getElementById('homeHeroStat2Val')?.value || '', label: document.getElementById('homeHeroStat2Lbl')?.value || '', subtext: document.getElementById('homeHeroStat2Sub')?.value || '' },
                    { value: document.getElementById('homeHeroStat3Val')?.value || '', label: document.getElementById('homeHeroStat3Lbl')?.value || '', subtext: document.getElementById('homeHeroStat3Sub')?.value || '' }
                ]
            };
            payload.services = {
                badge: document.getElementById('homeServicesBadge')?.value || '',
                headline: document.getElementById('homeServicesHeadline')?.value || '',
                subtitle: document.getElementById('homeServicesSubtitle')?.value || ''
            };
            payload.director = {
                name: document.getElementById('homeDirectorName')?.value || '',
                title: document.getElementById('homeDirectorTitle')?.value || '',
                credentials: document.getElementById('homeDirectorCreds')?.value || '',
                gdc_number: document.getElementById('homeDirectorGdc')?.value || '',
                quote: document.getElementById('homeDirectorQuote')?.value || '',
                image: document.getElementById('homeDirectorImage')?.value || ''
            };
            payload.about = {
                badge: document.getElementById('homeAboutBadge')?.value || '',
                headline: document.getElementById('homeAboutHeadline')?.value || '',
                subtitle: document.getElementById('homeAboutSubtitle')?.value || '',
                director: payload.director
            };
            payload.team = {
                badge: document.getElementById('homeTeamBadge')?.value || '',
                headline: document.getElementById('homeTeamHeadline')?.value || '',
                subtitle: document.getElementById('homeTeamSubtitle')?.value || ''
            };
            payload.reviews = {
                badge: document.getElementById('homeReviewsBadge')?.value || '',
                headline: document.getElementById('homeReviewsHeadline')?.value || '',
                subtitle: document.getElementById('homeReviewsSubtitle')?.value || '',
                overall_rating: document.getElementById('homeReviewsRating')?.value || '4.9',
                total_reviews_count: document.getElementById('homeReviewsCount')?.value || '284'
            };
            payload.charter = {
                badge: document.getElementById('homeCharterBadge')?.value || '',
                headline: document.getElementById('homeCharterHeadline')?.value || '',
                description: document.getElementById('homeCharterDesc')?.value || '',
                practice_manager_contact: document.getElementById('homeCharterManager')?.value || '',
                charter_pdf_url: document.getElementById('homeCharterPdfUrl')?.value || ''
            };
            payload.contact = {
                headline: document.getElementById('homeContactHeadline')?.value || '',
                surgery_address: document.getElementById('homeContactAddress')?.value || '',
                surgery_phone: document.getElementById('homeContactPhone')?.value || '',
                emergency_triage_line: document.getElementById('homeContactEmergencyPhone')?.value || '',
                opening_hours_summary: document.getElementById('homeContactHours')?.value || ''
            };
        }

        try {
            const res = await fetch('{{ url("/api/v1/admin/cms/pages/save") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                body: JSON.stringify(payload)
            });
            const json = await res.json();
            if (!json.success) throw new Error(json.message || 'Server error');

            // Hide offcanvas drawer
            const drawerEl = document.getElementById('editCmsPageModal');
            if (drawerEl && window.bootstrap && bootstrap.Offcanvas) {
                const offcanvas = bootstrap.Offcanvas.getInstance(drawerEl);
                if (offcanvas) offcanvas.hide();
            }

            showCmsAlert(`CMS Page <strong>"${title}"</strong> successfully saved and synced to Next.js SSG!`);
            loadCmsPagesTable();
        } catch (err) {
            console.error('Save error:', err);
            showCmsAlert(`Failed to save CMS page: ${err.message}`, 'danger');
        } finally {
            if (btnSave) btnSave.disabled = false;
            if (spinner) spinner.classList.add('d-none');
            if (icon) icon.classList.remove('d-none');
        }
    }

    // Save Specific Section (Granular 1-Click Update for 7 Sections)
    async function saveSpecificSection(sectionKey) {
        const cleanSlug = document.getElementById('editPageCleanSlug')?.value || 'home';
        let sectionData = {};

        if (sectionKey === 'hero') {
            sectionData = {
                eyebrow: document.getElementById('homeHeroEyebrow')?.value || '',
                title: document.getElementById('homeHeroHeadline')?.value || '',
                headline: document.getElementById('homeHeroHeadline')?.value || '',
                subtitle: document.getElementById('homeHeroSubtitle')?.value || '',
                emergency_phone: document.getElementById('homeHeroPhone')?.value || '',
                primary_cta_label: document.getElementById('homeHeroCtaText')?.value || '',
                primary_cta_link: document.getElementById('homeHeroCtaLink')?.value || '',
                stats: [
                    { value: document.getElementById('homeHeroStat0Val')?.value || '', label: document.getElementById('homeHeroStat0Lbl')?.value || '', subtext: document.getElementById('homeHeroStat0Sub')?.value || '' },
                    { value: document.getElementById('homeHeroStat1Val')?.value || '', label: document.getElementById('homeHeroStat1Lbl')?.value || '', subtext: document.getElementById('homeHeroStat1Sub')?.value || '' },
                    { value: document.getElementById('homeHeroStat2Val')?.value || '', label: document.getElementById('homeHeroStat2Lbl')?.value || '', subtext: document.getElementById('homeHeroStat2Sub')?.value || '' },
                    { value: document.getElementById('homeHeroStat3Val')?.value || '', label: document.getElementById('homeHeroStat3Lbl')?.value || '', subtext: document.getElementById('homeHeroStat3Sub')?.value || '' }
                ]
            };
        } else if (sectionKey === 'services') {
            sectionData = {
                badge: document.getElementById('homeServicesBadge')?.value || '',
                headline: document.getElementById('homeServicesHeadline')?.value || '',
                subtitle: document.getElementById('homeServicesSubtitle')?.value || ''
            };
        } else if (sectionKey === 'about') {
            sectionData = {
                badge: document.getElementById('homeAboutBadge')?.value || '',
                headline: document.getElementById('homeAboutHeadline')?.value || '',
                subtitle: document.getElementById('homeAboutSubtitle')?.value || '',
                director: {
                    name: document.getElementById('homeDirectorName')?.value || '',
                    title: document.getElementById('homeDirectorTitle')?.value || '',
                    credentials: document.getElementById('homeDirectorCreds')?.value || '',
                    gdc_number: document.getElementById('homeDirectorGdc')?.value || '',
                    quote: document.getElementById('homeDirectorQuote')?.value || '',
                    image: document.getElementById('homeDirectorImage')?.value || ''
                }
            };
        } else if (sectionKey === 'team') {
            sectionData = {
                badge: document.getElementById('homeTeamBadge')?.value || '',
                headline: document.getElementById('homeTeamHeadline')?.value || '',
                subtitle: document.getElementById('homeTeamSubtitle')?.value || ''
            };
        } else if (sectionKey === 'reviews') {
            sectionData = {
                badge: document.getElementById('homeReviewsBadge')?.value || '',
                headline: document.getElementById('homeReviewsHeadline')?.value || '',
                subtitle: document.getElementById('homeReviewsSubtitle')?.value || '',
                overall_rating: document.getElementById('homeReviewsRating')?.value || '4.9',
                total_reviews_count: document.getElementById('homeReviewsCount')?.value || '284'
            };
        } else if (sectionKey === 'charter') {
            sectionData = {
                badge: document.getElementById('homeCharterBadge')?.value || '',
                headline: document.getElementById('homeCharterHeadline')?.value || '',
                description: document.getElementById('homeCharterDesc')?.value || '',
                practice_manager_contact: document.getElementById('homeCharterManager')?.value || '',
                charter_pdf_url: document.getElementById('homeCharterPdfUrl')?.value || ''
            };
        } else if (sectionKey === 'contact') {
            sectionData = {
                headline: document.getElementById('homeContactHeadline')?.value || '',
                surgery_address: document.getElementById('homeContactAddress')?.value || '',
                surgery_phone: document.getElementById('homeContactPhone')?.value || '',
                emergency_triage_line: document.getElementById('homeContactEmergencyPhone')?.value || '',
                opening_hours_summary: document.getElementById('homeContactHours')?.value || ''
            };
        }

        const payload = {
            slug: cleanSlug,
            section: sectionKey,
            data: sectionData
        };

        try {
            const res = await fetch('{{ url("/api/v1/admin/cms/sections/save") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                body: JSON.stringify(payload)
            });
            const json = await res.json();
            if (!json.success) throw new Error(json.message || 'Server error');
            showCmsAlert(`Section <strong>"${sectionKey.toUpperCase()}"</strong> successfully saved and synced to live frontend!`);
        } catch (err) {
            console.error('Section save error:', err);
            showCmsAlert(`Failed to save section ${sectionKey}: ${err.message}`, 'danger');
        }
    }

    // Trash, Restore, and Force Delete
    async function trashCmsPage(slug) {
        if (!confirm(`Move page "/${slug}" to Trash?`)) return;
        try {
            await fetch('{{ url("/api/v1/admin/cms/pages/trash") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                body: JSON.stringify({ slug: slug })
            });
            showCmsAlert(`Page "/${slug}" moved to Trash.`, 'warning');
            loadCmsPagesTable();
        } catch (err) {
            showCmsAlert(`Failed to trash page: ${err.message}`, 'danger');
        }
    }

    async function restoreCmsPage(slug) {
        try {
            await fetch('{{ url("/api/v1/admin/cms/pages/restore") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                body: JSON.stringify({ slug: slug })
            });
            showCmsAlert(`Page "/${slug}" restored successfully!`);
            loadCmsPagesTable();
        } catch (err) {
            showCmsAlert(`Failed to restore page: ${err.message}`, 'danger');
        }
    }

    async function forceDeleteCmsPage(slug) {
        if (!confirm(`Permanently delete page "/${slug}"? This cannot be undone.`)) return;
        try {
            await fetch('{{ url("/api/v1/admin/cms/pages/force-delete") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                body: JSON.stringify({ slug: slug })
            });
            showCmsAlert(`Page "/${slug}" permanently deleted.`, 'danger');
            loadCmsPagesTable();
        } catch (err) {
            showCmsAlert(`Failed to delete page: ${err.message}`, 'danger');
        }
    }

    function updateSeoCounts() {
        const title = document.getElementById('editSeoMetaTitle')?.value || '';
        const desc = document.getElementById('editSeoMetaDesc')?.value || '';
        const tCount = document.getElementById('metaTitleCount');
        const dCount = document.getElementById('metaDescCount');
        if (tCount) tCount.innerText = title.length;
        if (dCount) dCount.innerText = desc.length;
    }

    function autoGenerateSlug() {
        const title = document.getElementById('addPageTitle')?.value || '';
        const clean = title.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '');
        const slugInput = document.getElementById('addPageSlug');
        if (slugInput) slugInput.value = clean;
    }

    async function handleAddCmsPage(event) {
        event.preventDefault();
        const title = document.getElementById('addPageTitle')?.value.trim() || '';
        const slug = document.getElementById('addPageSlug')?.value.trim() || '';
        const category = document.getElementById('addPageCategory')?.value || 'treatments';
        const status = document.getElementById('addPageStatus')?.value || 'published';
        const subtitle = document.getElementById('addPageSubtitle')?.value.trim() || '';

        const payload = { slug, title, subtitle, category, status };
        try {
            const res = await fetch('{{ url("/api/v1/admin/cms/pages/save") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                body: JSON.stringify(payload)
            });
            const json = await res.json();
            if (!json.success) throw new Error(json.message);

            const modalEl = document.getElementById('addCmsPageModal');
            if (modalEl && window.bootstrap && bootstrap.Modal) {
                const modal = bootstrap.Modal.getInstance(modalEl);
                if (modal) modal.hide();
            }
            document.getElementById('addCmsPageForm')?.reset();
            showCmsAlert(`New CMS page "${title}" created successfully!`);
            loadCmsPagesTable();
        } catch (err) {
            showCmsAlert(`Failed to create page: ${err.message}`, 'danger');
        }
    }
</script>
@endpush
