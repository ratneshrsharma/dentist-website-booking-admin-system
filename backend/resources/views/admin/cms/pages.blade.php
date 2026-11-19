@extends('layouts.admin')

@section('title', 'Website CMS Pages Manager - Advanced Dental PRO')
@section('page_title', 'Website CMS Pages Manager')
@section('page_subtitle', 'Live management of pre-rendered Next.js patient website pages, layout templates, and page metadata')

@section('page_actions')
<button type="button" class="btn btn-sm btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#addCmsPageModal" style="background-color: var(--app-primary); border-color: var(--app-primary);">
    <i class="bi bi-plus-circle me-1"></i> Add New CMS Page
</button>
@endsection

@section('content')
<!-- Feedback Toast -->
<div id="cmsAlertPlaceholder" class="mb-3"></div>

<div class="row g-3 mb-4">
    <!-- Stat 1 -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-card-content">
                <span class="stat-label">Published Pages</span>
                <div class="stat-value" id="statPublishedPages">24 Pages</div>
                <span class="badge bg-success-subtle text-success stat-meta">
                    <i class="bi bi-check-circle me-1"></i> 100% Pre-rendered
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
                <span class="stat-label">Active Theme Template</span>
                <div class="stat-value">Template 1</div>
                <span class="badge bg-primary-subtle text-primary stat-meta">
                    <i class="bi bi-shield-check me-1"></i> Confident Doctor
                </span>
            </div>
            <div class="stat-icon-wrapper stat-icon-info">
                <i class="bi bi-layers-fill"></i>
            </div>
        </div>
    </div>

    <!-- Stat 3 -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-card-content">
                <span class="stat-label">Layout Architecture</span>
                <div class="stat-value text-warning">Fluid</div>
                <span class="badge bg-warning-subtle text-warning stat-meta">
                    <i class="bi bi-phone me-1"></i> 0px Overflow Edge-to-Edge
                </span>
            </div>
            <div class="stat-icon-wrapper stat-icon-warning">
                <i class="bi bi-palette2"></i>
            </div>
        </div>
    </div>

    <!-- Stat 4 -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-card-content">
                <span class="stat-label">Core Web Vitals</span>
                <div class="stat-value text-success">99/100</div>
                <span class="badge bg-success-subtle text-success stat-meta">
                    <i class="bi bi-lightning-charge me-1"></i> Lighthouse High Speed
                </span>
            </div>
            <div class="stat-icon-wrapper stat-icon-success">
                <i class="bi bi-speedometer2"></i>
            </div>
        </div>
    </div>
</div>

<!-- Pages Table Card -->
<div class="card border-0 shadow-sm rounded-3">
    <div class="card-header bg-white border-bottom py-3 d-flex flex-wrap align-items-center justify-content-between gap-3">
        <div>
            <h5 class="fw-bold mb-0 text-dark">Patient-Facing Pages Directory</h5>
            <span class="text-muted small">Manage headings, treatment procedure pages, and dynamic schema links</span>
        </div>
        <div class="d-flex align-items-center gap-2">
            <div class="input-group input-group-sm" style="max-width: 280px;">
                <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                <input type="text" class="form-control border-start-0" id="cmsSearchInput" onkeyup="filterCmsPages()" placeholder="Search title or slug...">
            </div>
            <a href="{{ url('/') }}" target="_blank" class="btn btn-sm btn-outline-primary">
                <i class="bi bi-box-arrow-up-right me-1"></i>View Website
            </a>
            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addCmsPageModal" style="background-color: var(--app-primary); border-color: var(--app-primary);">
                <i class="bi bi-plus-circle me-1"></i>Add Page
            </button>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="cmsPagesTable">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3 text-nowrap" style="min-width: 180px;">Page Name</th>
                        <th class="text-nowrap" style="min-width: 140px;">URL Slug</th>
                        <th class="text-nowrap" style="min-width: 130px;">Category</th>
                        <th class="text-nowrap" style="min-width: 130px;">Template Engine</th>
                        <th class="text-nowrap" style="min-width: 110px;">SEO Health</th>
                        <th class="text-nowrap" style="min-width: 110px;">Last Modified</th>
                        <th class="text-nowrap" style="min-width: 100px;">Status</th>
                        <th class="text-end pe-3 text-nowrap" style="min-width: 130px;">Actions</th>
                    </tr>
                </thead>
                <tbody id="cmsPagesTableBody">
                    <!-- Page 1 -->
                    <tr id="page-row-1" data-title="Home Landing Page" data-subtitle="Pain-Free Restorations & Confident Smiles" data-slug="/" data-category="Core Page" data-status="Published">
                        <td class="ps-3">
                            <span class="fw-bold text-dark d-block page-title">Home Landing Page</span>
                            <small class="text-muted page-subtitle">Pain-Free Restorations & Confident Smiles</small>
                        </td>
                        <td><span class="badge bg-light text-dark border fw-mono page-slug">/</span></td>
                        <td><span class="badge bg-primary-subtle text-primary page-cat">Core Page</span></td>
                        <td>Template 1 (Fluid)</td>
                        <td><span class="badge bg-success-subtle text-success"><i class="bi bi-check-circle me-1"></i>Score: 98</span></td>
                        <td><span class="small text-muted page-date">21 Mar 2026</span></td>
                        <td><span class="badge bg-success page-status">Published</span></td>
                        <td class="text-end pe-3">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ url('/') }}" target="_blank" class="btn btn-outline-secondary" title="View Live"><i class="bi bi-eye"></i></a>
                                <button type="button" class="btn btn-outline-secondary" onclick="openEditCmsModal('page-row-1')" title="Edit Page Content & SEO"><i class="bi bi-pencil"></i></button>
                                <a href="{{ url('/admin/seo-manager') }}" class="btn btn-outline-secondary" title="Yoast Meta & Schema"><i class="bi bi-search"></i></a>
                                <button type="button" class="btn btn-outline-danger" onclick="deleteCmsPage('page-row-1')" title="Unpublish / Delete"><i class="bi bi-trash"></i></button>
                            </div>
                        </td>
                    </tr>

                    <!-- Page 2 -->
                    <tr id="page-row-2" data-title="About Us & Clinical Team" data-subtitle="Doctor bios, clinical credentials & technology" data-slug="/about-us" data-category="Core Page" data-status="Published">
                        <td class="ps-3">
                            <span class="fw-bold text-dark d-block page-title">About Us & Clinical Team</span>
                            <small class="text-muted page-subtitle">Doctor bios, clinical credentials & technology</small>
                        </td>
                        <td><span class="badge bg-light text-dark border fw-mono page-slug">/about-us</span></td>
                        <td><span class="badge bg-primary-subtle text-primary page-cat">Core Page</span></td>
                        <td>Template 1 (Fluid)</td>
                        <td><span class="badge bg-success-subtle text-success"><i class="bi bi-check-circle me-1"></i>Score: 96</span></td>
                        <td><span class="small text-muted page-date">18 Mar 2026</span></td>
                        <td><span class="badge bg-success page-status">Published</span></td>
                        <td class="text-end pe-3">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ url('/about-us') }}" target="_blank" class="btn btn-outline-secondary" title="View Live"><i class="bi bi-eye"></i></a>
                                <button type="button" class="btn btn-outline-secondary" onclick="openEditCmsModal('page-row-2')" title="Edit Page Content & SEO"><i class="bi bi-pencil"></i></button>
                                <a href="{{ url('/admin/seo-manager') }}" class="btn btn-outline-secondary" title="Yoast Meta & Schema"><i class="bi bi-search"></i></a>
                                <button type="button" class="btn btn-outline-danger" onclick="deleteCmsPage('page-row-2')" title="Unpublish / Delete"><i class="bi bi-trash"></i></button>
                            </div>
                        </td>
                    </tr>

                    <!-- Page: Treatments & Services Main Catalog -->
                    <tr id="page-row-treatments" data-title="Treatments & Services (Main Catalog)" data-subtitle="Evidence-Based Dental Excellence: NHS Fee Bands, Private Options & Category Filter" data-slug="/treatments" data-category="Treatments Main" data-status="Published">
                        <td class="ps-3">
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge bg-primary px-2 py-1"><i class="bi bi-stars"></i></span>
                                <div>
                                    <span class="fw-bold text-dark d-block page-title">Treatments & Services (Main Catalog)</span>
                                    <small class="text-muted page-subtitle">Evidence-Based Dental Excellence: NHS Fee Bands, Private Options & Category Filter</small>
                                </div>
                            </div>
                        </td>
                        <td><span class="badge bg-light text-dark border fw-mono page-slug">/treatments</span></td>
                        <td><span class="badge text-teal page-cat" style="background: #CCFBF1; color: #0F766E;">Treatments Main</span></td>
                        <td>Acocks Green Clinical</td>
                        <td><span class="badge bg-success-subtle text-success"><i class="bi bi-check-circle me-1"></i>Score: 99</span></td>
                        <td><span class="small text-muted page-date">21 Mar 2026</span></td>
                        <td><span class="badge bg-success page-status">Published</span></td>
                        <td class="text-end pe-3">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ url('/treatments') }}" target="_blank" class="btn btn-outline-secondary" title="View Live Website"><i class="bi bi-eye"></i></a>
                                <button type="button" class="btn btn-outline-secondary" onclick="openEditCmsModal('page-row-treatments')" title="Edit Page Content & SEO"><i class="bi bi-pencil"></i></button>
                                <a href="{{ url('/admin/seo-manager') }}" class="btn btn-outline-secondary" title="Yoast Meta & Schema"><i class="bi bi-search"></i></a>
                                <button type="button" class="btn btn-outline-danger" onclick="deleteCmsPage('page-row-treatments')" title="Unpublish / Delete"><i class="bi bi-trash"></i></button>
                            </div>
                        </td>
                    </tr>

                    <!-- Page: General Dentistry & Routine Check-ups (Inner Procedure Template) -->
                    <tr id="page-row-general-dentistry" data-title="General Dentistry & Routine Dental Check-ups" data-subtitle="Comprehensive oral examinations, gentle precision care, low-dose digital radiographs & NHS Band 1" data-slug="/treatments/general-dentistry" data-category="Treatments" data-status="Published">
                        <td class="ps-3">
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge px-2 py-1" style="background: #0F766E; color: #fff;"><i class="bi bi-shield-check"></i></span>
                                <div>
                                    <span class="fw-bold text-dark d-block page-title">General Dentistry & Routine Dental Check-ups</span>
                                    <small class="text-muted page-subtitle">14-Point Check-up, 4 Everyday Procedures, 3-Tier Pricing & NHS vs Private</small>
                                </div>
                            </div>
                        </td>
                        <td><span class="badge bg-light text-dark border fw-mono page-slug">/treatments/general-dentistry</span></td>
                        <td><span class="badge text-teal page-cat" style="background: #CCFBF1; color: #0F766E;">Treatments</span></td>
                        <td>Acocks Green Detail</td>
                        <td><span class="badge bg-success-subtle text-success"><i class="bi bi-check-circle me-1"></i>Score: 100</span></td>
                        <td><span class="small text-muted page-date">21 Mar 2026</span></td>
                        <td><span class="badge bg-success page-status">Published</span></td>
                        <td class="text-end pe-3">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ url('/treatments/general-dentistry') }}" target="_blank" class="btn btn-outline-secondary" title="View Live Treatment Detail"><i class="bi bi-eye"></i></a>
                                <button type="button" class="btn btn-outline-secondary" onclick="openEditCmsModal('page-row-general-dentistry')" title="Edit Treatment Content, SEO & Code"><i class="bi bi-pencil"></i></button>
                                <a href="{{ url('/admin/seo-manager') }}" class="btn btn-outline-secondary" title="Yoast Meta & Schema"><i class="bi bi-search"></i></a>
                                <button type="button" class="btn btn-outline-danger" onclick="deleteCmsPage('page-row-general-dentistry')" title="Unpublish / Delete"><i class="bi bi-trash"></i></button>
                            </div>
                        </td>
                    </tr>

                    <!-- Page 3 -->
                    <tr id="page-row-3" data-title="Dental Implants" data-subtitle="Single, Multiple & Full-Arch Guided Restorations" data-slug="/treatments/dental-implants" data-category="Treatments" data-status="Published">
                        <td class="ps-3">
                            <span class="fw-bold text-dark d-block page-title">Dental Implants</span>
                            <small class="text-muted page-subtitle">Single, Multiple & Full-Arch Guided Restorations</small>
                        </td>
                        <td><span class="badge bg-light text-dark border fw-mono page-slug">/treatments/dental-implants</span></td>
                        <td><span class="badge bg-teal-subtle text-teal page-cat" style="background: #CCFBF1; color: #0F766E;">Treatments</span></td>
                        <td>Template 1 (Fluid)</td>
                        <td><span class="badge bg-success-subtle text-success"><i class="bi bi-check-circle me-1"></i>Score: 100</span></td>
                        <td><span class="small text-muted page-date">19 Mar 2026</span></td>
                        <td><span class="badge bg-success page-status">Published</span></td>
                        <td class="text-end pe-3">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ url('/treatments/dental-implants') }}" target="_blank" class="btn btn-outline-secondary" title="View Live"><i class="bi bi-eye"></i></a>
                                <button type="button" class="btn btn-outline-secondary" onclick="openEditCmsModal('page-row-3')" title="Edit Page Content & SEO"><i class="bi bi-pencil"></i></button>
                                <a href="{{ url('/admin/seo-manager') }}" class="btn btn-outline-secondary" title="Yoast Meta & Schema"><i class="bi bi-search"></i></a>
                                <button type="button" class="btn btn-outline-danger" onclick="deleteCmsPage('page-row-3')" title="Unpublish / Delete"><i class="bi bi-trash"></i></button>
                            </div>
                        </td>
                    </tr>

                    <!-- Page 4 -->
                    <tr id="page-row-4" data-title="Clear Aligners & Orthodontics" data-subtitle="Invisalign, ClearCorrect & Digital 3D Simulation" data-slug="/treatments/clear-aligners" data-category="Treatments" data-status="Published">
                        <td class="ps-3">
                            <span class="fw-bold text-dark d-block page-title">Clear Aligners & Orthodontics</span>
                            <small class="text-muted page-subtitle">Invisalign, ClearCorrect & Digital 3D Simulation</small>
                        </td>
                        <td><span class="badge bg-light text-dark border fw-mono page-slug">/treatments/clear-aligners</span></td>
                        <td><span class="badge bg-teal-subtle text-teal page-cat" style="background: #CCFBF1; color: #0F766E;">Treatments</span></td>
                        <td>Template 1 (Fluid)</td>
                        <td><span class="badge bg-success-subtle text-success"><i class="bi bi-check-circle me-1"></i>Score: 97</span></td>
                        <td><span class="small text-muted page-date">19 Mar 2026</span></td>
                        <td><span class="badge bg-success page-status">Published</span></td>
                        <td class="text-end pe-3">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ url('/treatments/clear-aligners') }}" target="_blank" class="btn btn-outline-secondary" title="View Live"><i class="bi bi-eye"></i></a>
                                <button type="button" class="btn btn-outline-secondary" onclick="openEditCmsModal('page-row-4')" title="Edit Page Content & SEO"><i class="bi bi-pencil"></i></button>
                                <a href="{{ url('/admin/seo-manager') }}" class="btn btn-outline-secondary" title="Yoast Meta & Schema"><i class="bi bi-search"></i></a>
                                <button type="button" class="btn btn-outline-danger" onclick="deleteCmsPage('page-row-4')" title="Unpublish / Delete"><i class="bi bi-trash"></i></button>
                            </div>
                        </td>
                    </tr>

                    <!-- Page 5 -->
                    <tr id="page-row-5" data-title="Contact & Multi-Clinics" data-subtitle="Branch locator, interactive maps & emergency hotline" data-slug="/contact" data-category="Core Page" data-status="Published">
                        <td class="ps-3">
                            <span class="fw-bold text-dark d-block page-title">Contact & Multi-Clinics</span>
                            <small class="text-muted page-subtitle">Branch locator, interactive maps & emergency hotline</small>
                        </td>
                        <td><span class="badge bg-light text-dark border fw-mono page-slug">/contact</span></td>
                        <td><span class="badge bg-primary-subtle text-primary page-cat">Core Page</span></td>
                        <td>Template 1 (Fluid)</td>
                        <td><span class="badge bg-success-subtle text-success"><i class="bi bi-check-circle me-1"></i>Score: 99</span></td>
                        <td><span class="small text-muted page-date">20 Mar 2026</span></td>
                        <td><span class="badge bg-success page-status">Published</span></td>
                        <td class="text-end pe-3">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ url('/contact') }}" target="_blank" class="btn btn-outline-secondary" title="View Live"><i class="bi bi-eye"></i></a>
                                <button type="button" class="btn btn-outline-secondary" onclick="openEditCmsModal('page-row-5')" title="Edit Page Content & SEO"><i class="bi bi-pencil"></i></button>
                                <a href="{{ url('/admin/seo-manager') }}" class="btn btn-outline-secondary" title="Yoast Meta & Schema"><i class="bi bi-search"></i></a>
                                <button type="button" class="btn btn-outline-danger" onclick="deleteCmsPage('page-row-5')" title="Unpublish / Delete"><i class="bi bi-trash"></i></button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal 1: Add New CMS Page -->
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
                                <option value="Treatments">Treatments & Procedures</option>
                                <option value="Core Page">Core Practice Page</option>
                                <option value="Patient Resources">Patient Resources & Guides</option>
                                <option value="Legal & Privacy">Legal & Compliance Policy</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Publishing Status</label>
                            <select class="form-select" id="addPageStatus">
                                <option value="Published">Published (Live to Next.js API)</option>
                                <option value="Draft">Draft (Hidden from public navigation)</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold small">Hero Subtitle / Clinical Teaser</label>
                            <input type="text" class="form-control" id="addPageSubtitle" placeholder="e.g. Painless tooth preservation with microscopic rotary endodontic technology.">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold small">Target Yoast SEO Meta Description</label>
                            <textarea class="form-control" id="addPageMetaDesc" rows="2" placeholder="e.g. Expert microscopic root canal treatment at Advanced Dental Clinic. Gentle, single-visit pain relief with 98% clinical success rate."></textarea>
                            <small class="text-muted">Recommended length: 140–160 characters for maximum Google click-through rate.</small>
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

<!-- Modal 2: Edit CMS Page, Sections, SEO & Custom Code Injection -->
<div class="modal fade" id="editCmsPageModal" tabindex="-1" aria-labelledby="editCmsPageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-white border-bottom py-3 px-4 d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="modal-title fw-bold text-dark mb-0" id="editCmsPageModalLabel">
                        <i class="bi bi-pencil-square text-primary me-2"></i>Edit CMS Page Studio
                    </h5>
                    <small class="text-muted" id="editModalSubtitle">Edit live page content, structured sections, Yoast SEO, and custom script injection</small>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-light text-dark border font-monospace small px-2 py-1" id="activeEditingSlugBadge">/home</span>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <form id="editCmsPageForm" onsubmit="handleEditCmsSubmit(event)">
                <input type="hidden" id="editPageRowId">
                <input type="hidden" id="editPageCleanSlug" value="home">

                <!-- Modal Tabs Header -->
                <div class="bg-light px-4 pt-3 border-bottom">
                    <ul class="nav nav-tabs border-bottom-0" id="editPageTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active fw-semibold small" id="tab-content-tab" data-bs-toggle="tab" data-bs-target="#tab-content" type="button" role="tab">
                                <i class="bi bi-file-earmark-text me-1 text-primary"></i> 1. Content & Headlines
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link fw-semibold small" id="tab-sections-tab" data-bs-toggle="tab" data-bs-target="#tab-sections" type="button" role="tab">
                                <i class="bi bi-layout-text-window-reverse me-1 text-info"></i> 2. Page Sections & CTA
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link fw-semibold small" id="tab-seo-tab" data-bs-toggle="tab" data-bs-target="#tab-seo" type="button" role="tab">
                                <i class="bi bi-google me-1 text-success"></i> 3. Yoast SEO & Social
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link fw-semibold small" id="tab-code-tab" data-bs-toggle="tab" data-bs-target="#tab-code" type="button" role="tab">
                                <i class="bi bi-code-slash me-1 text-danger"></i> 4. Custom Code Injection
                            </button>
                        </li>
                    </ul>
                </div>

                <div class="modal-body p-4" style="max-height: calc(85vh - 180px); overflow-y: auto;">
                    <!-- Loading Skeleton when fetching page data -->
                    <div id="modalDataSpinner" class="text-center py-4 d-none">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading page configurations...</span>
                        </div>
                        <p class="small text-muted mt-2 mb-0">Synchronizing page schema and code injection from REST API...</p>
                    </div>

                    <div id="modalTabContentWrapper" class="tab-content">
                        <!-- TAB 1: Content & Headlines -->
                        <div class="tab-pane fade show active" id="tab-content" role="tabpanel">
                            <div class="row g-3">
                                <div class="col-md-8">
                                    <label class="form-label fw-semibold small">Page Title (Primary H1 Headline) <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="editPageTitle" placeholder="e.g. Treatments & Clinical Services" required>
                                    <small class="text-muted">Main headline rendered in the top hero section of the Next.js page.</small>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold small">URL Slug <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control font-monospace" id="editPageSlug" placeholder="treatments" required>
                                    <small class="text-muted">Target Next.js routing path.</small>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small">Page Category</label>
                                    <select class="form-select" id="editPageCategory">
                                        <option value="Core Page">Core Practice Page</option>
                                        <option value="Treatments">Treatments & Procedures</option>
                                        <option value="Patient Resources">Patient Resources</option>
                                        <option value="Legal & Privacy">Legal & Compliance Policy</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small">Publish Status</label>
                                    <select class="form-select" id="editPageStatus">
                                        <option value="Published">Published (Active on API)</option>
                                        <option value="Draft">Draft (Hidden)</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold small">Hero Subtitle / Narrative Copy</label>
                                    <textarea class="form-control" id="editPageSubtitle" rows="2" placeholder="Clinical explanation describing treatments and care philosophy."></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- TAB 2: Page Sections & Consultation CTA -->
                        <div class="tab-pane fade" id="tab-sections" role="tabpanel">
                            <div class="row g-3">
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
                                    <small class="text-muted d-block mb-3">Configure the bottom appointment conversion panel for this page</small>
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

                        <!-- TAB 3: Yoast SEO & Social -->
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

                        <!-- TAB 4: Custom Code Injection (Dual Scope) -->
                        <div class="tab-pane fade" id="tab-code" role="tabpanel">
                            <!-- Dual-Scope Guidance Alert -->
                            <div class="alert alert-info py-2 px-3 small d-flex align-items-center mb-3">
                                <i class="bi bi-shield-check fs-5 me-2 text-info"></i>
                                <div>
                                    <strong>Dual-Scope Code Injection Engine:</strong>
                                    Scope A applies globally across every page on the patient website (e.g., GTM, GA4, live chat). Scope B applies only to this specific page. Both are safely injected at runtime.
                                </div>
                            </div>

                            <!-- Section A: Common for All Pages -->
                            <div class="card border rounded-3 mb-3 bg-light-subtle">
                                <div class="card-header bg-light py-2 px-3 d-flex align-items-center justify-content-between">
                                    <span class="fw-bold small text-dark"><i class="bi bi-globe me-1 text-primary"></i> Scope A: Common For All Pages (Global Sitewide)</span>
                                    <span class="badge bg-primary-subtle text-primary small">Applies Sitewide</span>
                                </div>
                                <div class="card-body p-3">
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label class="form-label fw-semibold small mb-1">Global Sitewide CSS <small class="text-muted">(Injected in &lt;head&gt; across all pages)</small></label>
                                            <textarea class="form-control font-monospace small" id="editCommonCss" rows="3" placeholder="/* Global CSS across all pages */"></textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold small mb-1">Global Head JavaScript <small class="text-muted">(GTM, GA4, Pixel)</small></label>
                                            <textarea class="form-control font-monospace small" id="editCommonHeadJs" rows="4" placeholder="<!-- <script>GTM / GA4 Snippet</script> -->"></textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold small mb-1">Global Body JavaScript <small class="text-muted">(Before &lt;/body&gt;: WhatsApp, Chat widget)</small></label>
                                            <textarea class="form-control font-monospace small" id="editCommonBodyJs" rows="4" placeholder="<!-- <script>WhatsApp Chat Widget</script> -->"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Section B: Individual for This Page -->
                            <div class="card border rounded-3">
                                <div class="card-header bg-white py-2 px-3 d-flex align-items-center justify-content-between">
                                    <span class="fw-bold small text-dark"><i class="bi bi-file-earmark-code me-1 text-teal" style="color: #0F766E;"></i> Scope B: Individual For This Page Only</span>
                                    <span class="badge bg-teal-subtle text-teal small" id="badgeTargetPageSlug" style="background: #CCFBF1; color: #0F766E;">/treatments</span>
                                </div>
                                <div class="card-body p-3">
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label class="form-label fw-semibold small mb-1">Page-Specific Custom CSS <small class="text-muted">(Scoped style overrides for this page only)</small></label>
                                            <textarea class="form-control font-monospace small" id="editPageCss" rows="3" placeholder="/* Page-specific CSS overrides */"></textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold small mb-1">Page-Specific Head Scripts <small class="text-muted">(Injected into &lt;head&gt;)</small></label>
                                            <textarea class="form-control font-monospace small" id="editPageHeadJs" rows="4" placeholder="<script>/* Page-specific tracking or schema */</script>"></textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold small mb-1">Page-Specific Body Scripts <small class="text-muted">(Injected before &lt;/body&gt;)</small></label>
                                            <textarea class="form-control font-monospace small" id="editPageBodyJs" rows="4" placeholder="<script>/* Page-specific conversion listeners */</script>"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-light border-top py-2 px-4 d-flex justify-content-between align-items-center">
                    <span class="small text-muted" id="editSaveStatusText">
                        <i class="bi bi-cloud-check text-success me-1"></i> Changes persist immediately to REST API
                    </span>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary btn-sm px-3" id="btnSaveCmsPage" style="background-color: var(--app-primary); border-color: var(--app-primary);">
                            <span class="spinner-border spinner-border-sm me-1 d-none" id="savePageSpinner" role="status"></span>
                            <i class="bi bi-cloud-arrow-up-fill me-1" id="savePageIcon"></i>Save Page & Code Injection
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function showCmsAlert(message, type = 'success') {
        const placeholder = document.getElementById('cmsAlertPlaceholder');
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

    // 1. Live Filter
    function filterCmsPages() {
        const query = document.getElementById('cmsSearchInput').value.toLowerCase();
        const rows = document.querySelectorAll('#cmsPagesTableBody tr');
        rows.forEach(row => {
            const text = row.innerText.toLowerCase();
            row.style.display = text.includes(query) ? '' : 'none';
        });
    }

    // 2. Slug Auto-generator
    function autoGenerateSlug() {
        const title = document.getElementById('addPageTitle').value;
        const cat = document.getElementById('addPageCategory').value;
        const cleanSlug = title.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '');
        if (cat === 'Treatments') {
            document.getElementById('addPageSlug').value = 'treatments/' + cleanSlug;
        } else {
            document.getElementById('addPageSlug').value = cleanSlug;
        }
    }

    function updateSeoCounts() {
        const title = document.getElementById('editSeoMetaTitle').value;
        const desc = document.getElementById('editSeoMetaDesc').value;
        document.getElementById('metaTitleCount').innerText = title.length;
        document.getElementById('metaDescCount').innerText = desc.length;
    }

    // 3. Add Page Handler with AJAX Persistence
    async function handleAddCmsPage(event) {
        event.preventDefault();

        const btnSubmit = document.getElementById('btnAddPageSubmit');
        const spinner = document.getElementById('addPageSpinner');
        const icon = document.getElementById('addPageIcon');

        if (btnSubmit) btnSubmit.disabled = true;
        if (spinner) spinner.classList.remove('d-none');
        if (icon) icon.classList.add('d-none');

        const title = document.getElementById('addPageTitle')?.value.trim() || '';
        let rawSlug = document.getElementById('addPageSlug')?.value.trim() || '';
        const cat = document.getElementById('addPageCategory')?.value || 'Treatments';
        const status = document.getElementById('addPageStatus')?.value || 'Published';
        const subtitle = document.getElementById('addPageSubtitle')?.value.trim() || 'Comprehensive dental care procedures';
        const metaDesc = document.getElementById('addPageMetaDesc')?.value.trim() || '';

        // Strict slug normalization
        const cleanSlug = rawSlug.toLowerCase().replace(/^\/+/, '').replace(/[^a-z0-9\-_]/g, '-').replace(/-+/g, '-').replace(/^-+|-+$/g, '') || ('page-' + Date.now());
        const displaySlug = '/' + cleanSlug;

        const payload = {
            slug: cleanSlug,
            title: title,
            subtitle: subtitle,
            category: cat,
            status: status,
            seo: {
                meta_title: `${title} | Acocks Green Dental Practice Birmingham`,
                meta_description: metaDesc || subtitle,
                canonical_url: `https://acocksgreendentalpractice.co.uk/${cleanSlug}`,
            }
        };

        try {
            const response = await fetch('{{ url("/api/v1/admin/cms/pages/save") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                body: JSON.stringify(payload)
            });
            const result = await response.json();

            const rowId = 'page-row-' + Date.now();
            const catBadgeClass = (cat === 'Treatments') ? 'style="background: #CCFBF1; color: #0F766E;"' : '';
            const statusBadge = (status === 'Published')
                ? '<span class="badge bg-success page-status">Published</span>'
                : '<span class="badge bg-warning text-dark page-status">Draft</span>';

            const rowHtml = `
                <tr id="${rowId}" data-title="${title}" data-subtitle="${subtitle}" data-slug="${displaySlug}" data-category="${cat}" data-status="${status}">
                    <td class="ps-3">
                        <span class="fw-bold text-dark d-block page-title">${title}</span>
                        <small class="text-muted page-subtitle">${subtitle}</small>
                    </td>
                    <td><span class="badge bg-light text-dark border font-monospace page-slug">${displaySlug}</span></td>
                    <td><span class="badge bg-teal-subtle text-teal page-cat" ${catBadgeClass}>${cat}</span></td>
                    <td>Template 1 (Fluid)</td>
                    <td><span class="badge bg-success-subtle text-success"><i class="bi bi-check-circle me-1"></i>Score: 99</span></td>
                    <td><span class="small text-muted page-date">Just Now</span></td>
                    <td>${statusBadge}</td>
                    <td class="text-end pe-3">
                        <div class="btn-group btn-group-sm">
                            <a href="{{ url('/') }}${displaySlug}" target="_blank" class="btn btn-outline-secondary" title="View Live"><i class="bi bi-eye"></i></a>
                            <button type="button" class="btn btn-outline-secondary" onclick="openEditCmsModal('${rowId}')" title="Edit Page Content & SEO"><i class="bi bi-pencil"></i></button>
                            <a href="{{ url('/admin/seo-manager') }}" class="btn btn-outline-secondary" title="Yoast Meta & Schema"><i class="bi bi-search"></i></a>
                            <button type="button" class="btn btn-outline-danger" onclick="deleteCmsPage('${rowId}')" title="Unpublish / Delete"><i class="bi bi-trash"></i></button>
                        </div>
                    </td>
                </tr>
            `;

            const tbody = document.getElementById('cmsPagesTableBody');
            if (tbody) tbody.insertAdjacentHTML('afterbegin', rowHtml);
            const totalPages = document.querySelectorAll('#cmsPagesTableBody tr').length;
            const statPublished = document.getElementById('statPublishedPages');
            if (statPublished) statPublished.innerText = `${totalPages} Pages`;

            const addModalEl = document.getElementById('addCmsPageModal');
            if (addModalEl && window.bootstrap && bootstrap.Modal) {
                const modal = bootstrap.Modal.getInstance(addModalEl) || (bootstrap.Modal.getOrCreateInstance ? bootstrap.Modal.getOrCreateInstance(addModalEl) : null);
                if (modal) modal.hide();
            }
            const addForm = document.getElementById('addCmsPageForm');
            if (addForm) addForm.reset();

            showCmsAlert(`Page <strong>"${title}"</strong> created and persistently stored to REST API!`);
        } catch (err) {
            console.error('Error adding CMS page:', err);
            showCmsAlert(`Failed to save page to backend: ${err.message}`, 'danger');
        } finally {
            if (btnSubmit) btnSubmit.disabled = false;
            if (spinner) spinner.classList.add('d-none');
            if (icon) icon.classList.remove('d-none');
        }
    }

    // 4. Open Edit Page Modal with Real Data Hydration from REST APIs
    async function openEditCmsModal(rowId) {
        const row = document.getElementById(rowId);
        if (!row) return;

        const title = row.getAttribute('data-title') || '';
        const subtitle = row.getAttribute('data-subtitle') || '';
        const rawSlug = row.getAttribute('data-slug') || '/home';
        const cat = row.getAttribute('data-category') || 'Treatments';
        const status = row.getAttribute('data-status') || 'Published';

        const cleanSlug = rawSlug.toLowerCase().replace(/^\/+/, '').replace(/[^a-z0-9\-_]/g, '-').replace(/-+/g, '-').replace(/^-+|-+$/g, '') || 'home';

        // Prepopulate basic Tab 1 fields safely
        const setVal = (id, val) => { const el = document.getElementById(id); if (el) el.value = val; };
        const setTxt = (id, txt) => { const el = document.getElementById(id); if (el) el.innerText = txt; };

        setVal('editPageRowId', rowId);
        setVal('editPageCleanSlug', cleanSlug);
        setVal('editPageTitle', title);
        setVal('editPageSubtitle', subtitle);
        setVal('editPageSlug', cleanSlug);
        setVal('editPageCategory', cat);
        setVal('editPageStatus', status);

        setTxt('activeEditingSlugBadge', '/' + cleanSlug);
        setTxt('badgeTargetPageSlug', '/' + cleanSlug);
        setTxt('editModalSubtitle', `Managing page content, Yoast SEO, and scripts for /${cleanSlug}`);

        // Switch to Tab 1 by default
        const tabEl = document.getElementById('tab-content-tab');
        if (tabEl && window.bootstrap && bootstrap.Tab) {
            const firstTab = bootstrap.Tab.getOrCreateInstance ? bootstrap.Tab.getOrCreateInstance(tabEl) : new bootstrap.Tab(tabEl);
            firstTab.show();
        }

        const editModalEl = document.getElementById('editCmsPageModal');
        if (editModalEl && window.bootstrap && bootstrap.Modal) {
            const modal = bootstrap.Modal.getOrCreateInstance ? bootstrap.Modal.getOrCreateInstance(editModalEl) : (bootstrap.Modal.getInstance(editModalEl) || new bootstrap.Modal(editModalEl));
            modal.show();
        }

        // Hydrate from Backend APIs
        try {
            const [pageRes, codeRes] = await Promise.all([
                fetch(`{{ url('/api/v1/cms/pages') }}/${cleanSlug}`).then(r => r.json()).catch(() => null),
                fetch(`{{ url('/api/v1/cms/code-injection') }}/${cleanSlug}`).then(r => r.json()).catch(() => null)
            ]);

            if (pageRes && pageRes.success && pageRes.data) {
                const pageData = pageRes.data;
                if (pageData.title) setVal('editPageTitle', pageData.title);
                if (pageData.subtitle) setVal('editPageSubtitle', pageData.subtitle);
                setVal('editPageEyebrow', pageData.eyebrow || '');
                setVal('editPageBadge', pageData.badge || '');

                if (pageData.consultation_cta) {
                    setVal('editCtaHeadline', pageData.consultation_cta.headline || '');
                    setVal('editCtaPhone', pageData.consultation_cta.phone || '');
                    setVal('editCtaDescription', pageData.consultation_cta.description || '');
                }

                if (pageData.seo) {
                    setVal('editSeoMetaTitle', pageData.seo.meta_title || '');
                    setVal('editSeoMetaDesc', pageData.seo.meta_description || '');
                    setVal('editSeoKeywords', Array.isArray(pageData.seo.keywords) ? pageData.seo.keywords.join(', ') : (pageData.seo.keywords || ''));
                    setVal('editSeoCanonical', pageData.seo.canonical_url || '');
                    setVal('editSeoOgImage', pageData.seo.og_image || '');
                    updateSeoCounts();
                }
            }

            if (codeRes && codeRes.success && codeRes.data) {
                const codeData = codeRes.data;
                // Scope A: Common Global
                if (codeData.common) {
                    setVal('editCommonCss', codeData.common.custom_css || '');
                    setVal('editCommonHeadJs', codeData.common.head_scripts || '');
                    setVal('editCommonBodyJs', codeData.common.body_scripts || '');
                }
                // Scope B: Page Specific
                if (codeData.page) {
                    setVal('editPageCss', codeData.page.custom_css || '');
                    setVal('editPageHeadJs', codeData.page.head_scripts || '');
                    setVal('editPageBodyJs', codeData.page.body_scripts || '');
                }
            }
        } catch (fetchErr) {
            console.warn('API hydration note:', fetchErr);
        }
    }

    // 5. Submit Updates to REST API with AJAX Persistence
    async function handleEditCmsSubmit(event) {
        event.preventDefault();
        const rowId = document.getElementById('editPageRowId')?.value;
        const cleanSlug = document.getElementById('editPageCleanSlug')?.value || 'home';
        const row = document.getElementById(rowId);

        const btnSave = document.getElementById('btnSaveCmsPage');
        const spinner = document.getElementById('savePageSpinner');
        const icon = document.getElementById('savePageIcon');

        if (btnSave) btnSave.disabled = true;
        if (spinner) spinner.classList.remove('d-none');
        if (icon) icon.classList.add('d-none');

        const title = document.getElementById('editPageTitle')?.value.trim() || '';
        const subtitle = document.getElementById('editPageSubtitle')?.value.trim() || '';
        const rawInputSlug = document.getElementById('editPageSlug')?.value.trim() || '';
        const normalizedSlug = rawInputSlug.toLowerCase().replace(/^\/+/, '').replace(/[^a-z0-9\-_]/g, '-').replace(/-+/g, '-').replace(/^-+|-+$/g, '') || cleanSlug;
        const cat = document.getElementById('editPageCategory')?.value || 'Treatments';
        const status = document.getElementById('editPageStatus')?.value || 'Published';

        const eyebrow = document.getElementById('editPageEyebrow')?.value.trim() || '';
        const badge = document.getElementById('editPageBadge')?.value.trim() || '';

        const ctaHeadline = document.getElementById('editCtaHeadline')?.value.trim() || '';
        const ctaPhone = document.getElementById('editCtaPhone')?.value.trim() || '';
        const ctaDescription = document.getElementById('editCtaDescription')?.value.trim() || '';

        const metaTitle = document.getElementById('editSeoMetaTitle')?.value.trim() || '';
        const metaDesc = document.getElementById('editSeoMetaDesc')?.value.trim() || '';
        const keywordsStr = document.getElementById('editSeoKeywords')?.value.trim() || '';
        const canonicalUrl = document.getElementById('editSeoCanonical')?.value.trim() || '';
        const ogImage = document.getElementById('editSeoOgImage')?.value.trim() || '';

        const commonCss = document.getElementById('editCommonCss')?.value || '';
        const commonHeadJs = document.getElementById('editCommonHeadJs')?.value || '';
        const commonBodyJs = document.getElementById('editCommonBodyJs')?.value || '';

        const pageCss = document.getElementById('editPageCss')?.value || '';
        const pageHeadJs = document.getElementById('editPageHeadJs')?.value || '';
        const pageBodyJs = document.getElementById('editPageBodyJs')?.value || '';

        const payload = {
            slug: normalizedSlug,
            title: title,
            subtitle: subtitle,
            eyebrow: eyebrow,
            badge: badge,
            category: cat,
            status: status,
            consultation_cta: {
                headline: ctaHeadline,
                phone: ctaPhone,
                description: ctaDescription
            },
            seo: {
                slug: normalizedSlug,
                meta_title: metaTitle,
                meta_description: metaDesc,
                keywords: keywordsStr ? keywordsStr.split(',').map(s => s.trim()).filter(Boolean) : [],
                canonical_url: canonicalUrl,
                og_image: ogImage
            },
            common_code: {
                custom_css: commonCss,
                head_scripts: commonHeadJs,
                body_scripts: commonBodyJs
            },
            code_injection: {
                custom_css: pageCss,
                head_scripts: pageHeadJs,
                body_scripts: pageBodyJs
            }
        };

        try {
            const response = await fetch('{{ url("/api/v1/admin/cms/pages/save") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(payload)
            });

            const result = await response.json();
            if (!result.success) {
                throw new Error(result.message || 'Server reported failure.');
            }

            // Update row in DOM
            if (row) {
                row.setAttribute('data-title', title);
                row.setAttribute('data-subtitle', subtitle);
                row.setAttribute('data-slug', '/' + normalizedSlug);
                row.setAttribute('data-category', cat);
                row.setAttribute('data-status', status);

                const titleEl = row.querySelector('.page-title');
                const subtitleEl = row.querySelector('.page-subtitle');
                const slugEl = row.querySelector('.page-slug');
                const catEl = row.querySelector('.page-cat');

                if (titleEl) titleEl.innerText = title;
                if (subtitleEl) subtitleEl.innerText = subtitle;
                if (slugEl) slugEl.innerText = '/' + normalizedSlug;
                if (catEl) catEl.innerText = cat;

                const statusBadge = row.querySelector('.page-status');
                if (statusBadge) {
                    if (status === 'Published') {
                        statusBadge.className = 'badge bg-success page-status';
                        statusBadge.innerText = 'Published';
                    } else {
                        statusBadge.className = 'badge bg-warning text-dark page-status';
                        statusBadge.innerText = 'Draft';
                    }
                }
            }

            const editModalEl = document.getElementById('editCmsPageModal');
            if (editModalEl && window.bootstrap && bootstrap.Modal) {
                const modal = bootstrap.Modal.getInstance(editModalEl) || (bootstrap.Modal.getOrCreateInstance ? bootstrap.Modal.getOrCreateInstance(editModalEl) : null);
                if (modal) modal.hide();
            }

            showCmsAlert(`Page <strong>"${title}"</strong>, SEO metadata, and Custom Code Injection saved to API!`);
        } catch (err) {
            console.error('Save error:', err);
            showCmsAlert(`Failed to save page updates: ${err.message}`, 'danger');
        } finally {
            if (btnSave) btnSave.disabled = false;
            if (spinner) spinner.classList.add('d-none');
            if (icon) icon.classList.remove('d-none');
        }
    }

    // 6. Delete / Unpublish Page
    async function deleteCmsPage(rowId) {
        const row = document.getElementById(rowId);
        if (!row) return;
        const title = row.getAttribute('data-title') || 'this page';
        const rawSlug = row.getAttribute('data-slug') || '';
        const cleanSlug = rawSlug.toLowerCase().replace(/^\/+/, '').replace(/[^a-z0-9\-_]/g, '-').replace(/-+/g, '-').replace(/^-+|-+$/g, '') || 'home';

        if (confirm(`Unpublish and archive CMS Page "${title}" (${rawSlug}) from patient-facing site?`)) {
            try {
                await fetch('{{ url("/api/v1/admin/cms/pages/save") }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                    body: JSON.stringify({ slug: cleanSlug, status: 'Draft', is_published: false })
                });
                row.remove();
                const totalPages = document.querySelectorAll('#cmsPagesTableBody tr').length;
                const statEl = document.getElementById('statPublishedPages');
                if (statEl) statEl.innerText = `${totalPages} Pages`;
                showCmsAlert(`Page <strong>"${title}"</strong> has been unpublished and archived from the live site directory.`, 'warning');
            } catch (err) {
                console.error('Delete error:', err);
                row.remove();
                showCmsAlert(`Page <strong>"${title}"</strong> removed from view, but API sync had an issue.`, 'warning');
            }
        }
    }
</script>
@endpush
