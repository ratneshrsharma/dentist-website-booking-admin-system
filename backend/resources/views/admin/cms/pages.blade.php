@extends('layouts.admin')

@section('title', 'Website CMS Pages Manager - Advanced Dental PRO')
@section('page_title', 'Website CMS Pages Manager')
@section('page_subtitle', 'Live management of pre-rendered Next.js patient website pages, layout templates, and page metadata')

@section('content')
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
                    <h3 class="fw-bold mb-0 text-dark">24 Pages</h3>
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
            <a href="{{ url('/') }}" target="_blank" class="btn btn-sm btn-outline-primary">
                <i class="bi bi-box-arrow-up-right me-1"></i>View Live Website
            </a>
            <a href="{{ url('/admin/theme-customizer') }}" class="btn btn-sm btn-primary" style="background-color: var(--app-primary); border-color: var(--app-primary);">
                <i class="bi bi-palette me-1"></i>Theme Customizer
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
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
                <tbody>
                    <!-- Page 1 -->
                    <tr>
                        <td class="ps-3">
                            <span class="fw-bold text-dark d-block">Home Landing Page</span>
                            <small class="text-muted">Pain-Free Restorations & Confident Smiles</small>
                        </td>
                        <td><span class="badge bg-light text-dark border fw-mono">/</span></td>
                        <td><span class="badge bg-primary-subtle text-primary">Core Page</span></td>
                        <td>Template 1 (Fluid)</td>
                        <td><span class="badge bg-success-subtle text-success"><i class="bi bi-check-circle me-1"></i>Score: 98</span></td>
                        <td><span class="small text-muted">21 Mar 2026</span></td>
                        <td><span class="badge bg-success">Published</span></td>
                        <td class="text-end pe-3">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ url('/') }}" target="_blank" class="btn btn-outline-secondary" title="View Live"><i class="bi bi-eye"></i></a>
                                <a href="{{ url('/admin/seo-manager') }}" class="btn btn-outline-secondary" title="Edit SEO"><i class="bi bi-search"></i></a>
                            </div>
                        </td>
                    </tr>

                    <!-- Page 2 -->
                    <tr>
                        <td class="ps-3">
                            <span class="fw-bold text-dark d-block">About Us & Clinical Team</span>
                            <small class="text-muted">Doctor bios, clinical credentials & technology</small>
                        </td>
                        <td><span class="badge bg-light text-dark border fw-mono">/about-us</span></td>
                        <td><span class="badge bg-primary-subtle text-primary">Core Page</span></td>
                        <td>Template 1 (Fluid)</td>
                        <td><span class="badge bg-success-subtle text-success"><i class="bi bi-check-circle me-1"></i>Score: 96</span></td>
                        <td><span class="small text-muted">18 Mar 2026</span></td>
                        <td><span class="badge bg-success">Published</span></td>
                        <td class="text-end pe-3">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ url('/about-us') }}" target="_blank" class="btn btn-outline-secondary" title="View Live"><i class="bi bi-eye"></i></a>
                                <a href="{{ url('/admin/seo-manager') }}" class="btn btn-outline-secondary" title="Edit SEO"><i class="bi bi-search"></i></a>
                            </div>
                        </td>
                    </tr>

                    <!-- Page 3 -->
                    <tr>
                        <td class="ps-3">
                            <span class="fw-bold text-dark d-block">Dental Implants</span>
                            <small class="text-muted">Single, Multiple & Full-Arch Guided Restorations</small>
                        </td>
                        <td><span class="badge bg-light text-dark border fw-mono">/treatments/dental-implants</span></td>
                        <td><span class="badge bg-teal-subtle text-teal" style="background: #CCFBF1; color: #0F766E;">Treatments</span></td>
                        <td>Template 1 (Fluid)</td>
                        <td><span class="badge bg-success-subtle text-success"><i class="bi bi-check-circle me-1"></i>Score: 100</span></td>
                        <td><span class="small text-muted">19 Mar 2026</span></td>
                        <td><span class="badge bg-success">Published</span></td>
                        <td class="text-end pe-3">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ url('/treatments/dental-implants') }}" target="_blank" class="btn btn-outline-secondary" title="View Live"><i class="bi bi-eye"></i></a>
                                <a href="{{ url('/admin/seo-manager') }}" class="btn btn-outline-secondary" title="Edit SEO"><i class="bi bi-search"></i></a>
                            </div>
                        </td>
                    </tr>

                    <!-- Page 4 -->
                    <tr>
                        <td class="ps-3">
                            <span class="fw-bold text-dark d-block">Clear Aligners & Orthodontics</span>
                            <small class="text-muted">Invisalign, ClearCorrect & Digital 3D Simulation</small>
                        </td>
                        <td><span class="badge bg-light text-dark border fw-mono">/treatments/clear-aligners</span></td>
                        <td><span class="badge bg-teal-subtle text-teal" style="background: #CCFBF1; color: #0F766E;">Treatments</span></td>
                        <td>Template 1 (Fluid)</td>
                        <td><span class="badge bg-success-subtle text-success"><i class="bi bi-check-circle me-1"></i>Score: 97</span></td>
                        <td><span class="small text-muted">19 Mar 2026</span></td>
                        <td><span class="badge bg-success">Published</span></td>
                        <td class="text-end pe-3">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ url('/treatments/clear-aligners') }}" target="_blank" class="btn btn-outline-secondary" title="View Live"><i class="bi bi-eye"></i></a>
                                <a href="{{ url('/admin/seo-manager') }}" class="btn btn-outline-secondary" title="Edit SEO"><i class="bi bi-search"></i></a>
                            </div>
                        </td>
                    </tr>

                    <!-- Page 5 -->
                    <tr>
                        <td class="ps-3">
                            <span class="fw-bold text-dark d-block">Contact & Multi-Clinics</span>
                            <small class="text-muted">Branch locator, interactive maps & emergency hotline</small>
                        </td>
                        <td><span class="badge bg-light text-dark border fw-mono">/contact</span></td>
                        <td><span class="badge bg-primary-subtle text-primary">Core Page</span></td>
                        <td>Template 1 (Fluid)</td>
                        <td><span class="badge bg-success-subtle text-success"><i class="bi bi-check-circle me-1"></i>Score: 99</span></td>
                        <td><span class="small text-muted">20 Mar 2026</span></td>
                        <td><span class="badge bg-success">Published</span></td>
                        <td class="text-end pe-3">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ url('/contact') }}" target="_blank" class="btn btn-outline-secondary" title="View Live"><i class="bi bi-eye"></i></a>
                                <a href="{{ url('/admin/seo-manager') }}" class="btn btn-outline-secondary" title="Edit SEO"><i class="bi bi-search"></i></a>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
