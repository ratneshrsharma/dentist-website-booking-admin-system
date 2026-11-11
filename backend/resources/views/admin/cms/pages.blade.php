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
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-body p-3 d-flex align-items-center">
                <div class="rounded-3 p-3 me-3" style="background-color: #CCFBF1; color: #0F766E;">
                    <i class="bi bi-file-earmark-code fs-3"></i>
                </div>
                <div>
                    <span class="text-muted small fw-medium d-block">Published Pages</span>
                    <h3 class="fw-bold mb-0 text-dark" id="statPublishedPages">24 Pages</h3>
                    <span class="badge bg-success-subtle text-success small mt-1">100% Pre-rendered</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Stat 2 -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-body p-3 d-flex align-items-center">
                <div class="rounded-3 p-3 me-3" style="background-color: #E0E7FF; color: #4338CA;">
                    <i class="bi bi-layers-fill fs-3"></i>
                </div>
                <div>
                    <span class="text-muted small fw-medium d-block">Active Theme Template</span>
                    <h3 class="fw-bold mb-0 text-dark">Template 1</h3>
                    <span class="text-muted small mt-1">Confident Doctor (Modern Trust)</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Stat 3 -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-body p-3 d-flex align-items-center">
                <div class="rounded-3 p-3 me-3" style="background-color: #FEF3C7; color: #D97706;">
                    <i class="bi bi-palette2 fs-3"></i>
                </div>
                <div>
                    <span class="text-muted small fw-medium d-block">Fluid Edge-to-Edge</span>
                    <h3 class="fw-bold mb-0 text-dark">Active</h3>
                    <span class="text-muted small mt-1">0px Horizontal Overflow</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Stat 4 -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-body p-3 d-flex align-items-center">
                <div class="rounded-3 p-3 me-3" style="background-color: #DCFCE7; color: #15803D;">
                    <i class="bi bi-speedometer2 fs-3"></i>
                </div>
                <div>
                    <span class="text-muted small fw-medium d-block">Core Web Vitals</span>
                    <h3 class="fw-bold mb-0 text-dark">99/100</h3>
                    <span class="badge bg-success-subtle text-success small mt-1">Lighthouse Performance</span>
                </div>
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
                        <th class="ps-3">Page Name</th>
                        <th>URL Slug</th>
                        <th>Category</th>
                        <th>Template Engine</th>
                        <th>SEO Health</th>
                        <th>Last Modified</th>
                        <th>Status</th>
                        <th class="text-end pe-3">Actions</th>
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
                    <button type="submit" class="btn btn-primary btn-sm" style="background-color: var(--app-primary); border-color: var(--app-primary);">
                        <i class="bi bi-cloud-arrow-up-fill me-1"></i>Publish Page to Next.js
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal 2: Edit CMS Page & SEO -->
<div class="modal fade" id="editCmsPageModal" tabindex="-1" aria-labelledby="editCmsPageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-white border-bottom py-3">
                <h5 class="modal-title fw-bold text-dark" id="editCmsPageModalLabel">
                    <i class="bi bi-pencil-square text-primary me-2"></i>Edit Page Content & SEO Metadata
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editCmsPageForm" onsubmit="handleEditCmsSubmit(event)">
                <input type="hidden" id="editPageRowId">
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-7">
                            <label class="form-label fw-semibold small">Page Title (H1 Headline)</label>
                            <input type="text" class="form-control" id="editPageTitle" required>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label fw-semibold small">URL Slug</label>
                            <input type="text" class="form-control" id="editPageSlug" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Page Category</label>
                            <select class="form-select" id="editPageCategory">
                                <option value="Core Page">Core Practice Page</option>
                                <option value="Treatments">Treatments & Procedures</option>
                                <option value="Patient Resources">Patient Resources</option>
                                <option value="Legal & Privacy">Legal & Privacy</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Publish Status</label>
                            <select class="form-select" id="editPageStatus">
                                <option value="Published">Published</option>
                                <option value="Draft">Draft</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold small">Hero Subtitle</label>
                            <input type="text" class="form-control" id="editPageSubtitle">
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-top py-2 px-4">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm" style="background-color: var(--app-primary); border-color: var(--app-primary);">
                        <i class="bi bi-save me-1"></i>Save Page Updates
                    </button>
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
        }, 4000);
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

    // 3. Add Page Handler
    function handleAddCmsPage(event) {
        event.preventDefault();
        const title = document.getElementById('addPageTitle').value.trim();
        let slug = document.getElementById('addPageSlug').value.trim();
        if (!slug.startsWith('/')) slug = '/' + slug;
        const cat = document.getElementById('addPageCategory').value;
        const status = document.getElementById('addPageStatus').value;
        const subtitle = document.getElementById('addPageSubtitle').value.trim() || 'Comprehensive dental care procedures';

        const rowId = 'page-row-' + Date.now();
        const catBadgeClass = (cat === 'Treatments') ? 'style="background: #CCFBF1; color: #0F766E;"' : '';
        const statusBadge = (status === 'Published') ? '<span class="badge bg-success page-status">Published</span>' : '<span class="badge bg-warning text-dark page-status">Draft</span>';

        const rowHtml = `
            <tr id="${rowId}" data-title="${title}" data-subtitle="${subtitle}" data-slug="${slug}" data-category="${cat}" data-status="${status}">
                <td class="ps-3">
                    <span class="fw-bold text-dark d-block page-title">${title}</span>
                    <small class="text-muted page-subtitle">${subtitle}</small>
                </td>
                <td><span class="badge bg-light text-dark border fw-mono page-slug">${slug}</span></td>
                <td><span class="badge bg-teal-subtle text-teal page-cat" ${catBadgeClass}>${cat}</span></td>
                <td>Template 1 (Fluid)</td>
                <td><span class="badge bg-success-subtle text-success"><i class="bi bi-check-circle me-1"></i>Score: 95</span></td>
                <td><span class="small text-muted page-date">Just Now</span></td>
                <td>${statusBadge}</td>
                <td class="text-end pe-3">
                    <div class="btn-group btn-group-sm">
                        <a href="{{ url('/') }}" target="_blank" class="btn btn-outline-secondary" title="View Live"><i class="bi bi-eye"></i></a>
                        <button type="button" class="btn btn-outline-secondary" onclick="openEditCmsModal('${rowId}')" title="Edit Page Content & SEO"><i class="bi bi-pencil"></i></button>
                        <a href="{{ url('/admin/seo-manager') }}" class="btn btn-outline-secondary" title="Yoast Meta & Schema"><i class="bi bi-search"></i></a>
                        <button type="button" class="btn btn-outline-danger" onclick="deleteCmsPage('${rowId}')" title="Unpublish / Delete"><i class="bi bi-trash"></i></button>
                    </div>
                </td>
            </tr>
        `;

        document.getElementById('cmsPagesTableBody').insertAdjacentHTML('afterbegin', rowHtml);

        const totalPages = document.querySelectorAll('#cmsPagesTableBody tr').length;
        document.getElementById('statPublishedPages').innerText = `${24 + totalPages - 5} Pages`;

        const modal = bootstrap.Modal.getInstance(document.getElementById('addCmsPageModal'));
        if (modal) modal.hide();
        document.getElementById('addCmsPageForm').reset();

        showCmsAlert(`CMS Page <strong>"${title}"</strong> created and published to Next.js API!`);
    }

    // 4. Edit Page Modal
    function openEditCmsModal(rowId) {
        const row = document.getElementById(rowId);
        if (!row) return;

        document.getElementById('editPageRowId').value = rowId;
        document.getElementById('editPageTitle').value = row.getAttribute('data-title');
        document.getElementById('editPageSubtitle').value = row.getAttribute('data-subtitle');
        document.getElementById('editPageSlug').value = row.getAttribute('data-slug');
        document.getElementById('editPageCategory').value = row.getAttribute('data-category');
        document.getElementById('editPageStatus').value = row.getAttribute('data-status');

        const modal = new bootstrap.Modal(document.getElementById('editCmsPageModal'));
        modal.show();
    }

    function handleEditCmsSubmit(event) {
        event.preventDefault();
        const rowId = document.getElementById('editPageRowId').value;
        const row = document.getElementById(rowId);
        if (!row) return;

        const title = document.getElementById('editPageTitle').value.trim();
        const subtitle = document.getElementById('editPageSubtitle').value.trim();
        const slug = document.getElementById('editPageSlug').value.trim();
        const cat = document.getElementById('editPageCategory').value;
        const status = document.getElementById('editPageStatus').value;

        row.setAttribute('data-title', title);
        row.setAttribute('data-subtitle', subtitle);
        row.setAttribute('data-slug', slug);
        row.setAttribute('data-category', cat);
        row.setAttribute('data-status', status);

        row.querySelector('.page-title').innerText = title;
        row.querySelector('.page-subtitle').innerText = subtitle;
        row.querySelector('.page-slug').innerText = slug;
        row.querySelector('.page-cat').innerText = cat;

        const statusBadge = row.querySelector('.page-status');
        if (status === 'Published') {
            statusBadge.className = 'badge bg-success page-status';
            statusBadge.innerText = 'Published';
        } else {
            statusBadge.className = 'badge bg-warning text-dark page-status';
            statusBadge.innerText = 'Draft';
        }

        const modal = bootstrap.Modal.getInstance(document.getElementById('editCmsPageModal'));
        if (modal) modal.hide();

        showCmsAlert(`Page <strong>"${title}"</strong> content and URL configuration saved successfully!`);
    }

    // 5. Delete / Unpublish Page
    function deleteCmsPage(rowId) {
        const row = document.getElementById(rowId);
        if (!row) return;
        const title = row.getAttribute('data-title');
        if (confirm(`Unpublish and delete CMS Page "${title}" from patient-facing site?`)) {
            row.remove();
            showCmsAlert(`Page <strong>"${title}"</strong> removed from live website directory.`, 'warning');
        }
    }
</script>
@endpush
