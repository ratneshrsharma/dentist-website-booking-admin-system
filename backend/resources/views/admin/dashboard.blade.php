@extends('layouts.admin')

@section('title', 'Multi-Clinic Executive Dashboard - Advanced Dental Clinic')
@section('page_title', 'Multi-Clinic Executive Overview')
@section('page_subtitle', 'Consolidated daily appointments, chair utilization, revenue and inventory')

@section('page_actions')
    <div class="d-flex gap-2">
        <a href="{{ url('/admin/appointments/calendar') }}" class="btn btn-sm btn-primary">
            <i class="bi bi-calendar-plus me-1"></i> New Appointment
        </a>
        <a href="{{ url('/admin/emr/odontogram') }}" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-diagram-3 me-1"></i> Launch Odontogram EMR
        </a>
    </div>
@endsection

@section('content')
<!-- Row 1: KPI Statistics Widgets -->
<div class="row g-3 mb-4">
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card p-3 bg-white">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small fw-semibold text-uppercase">Today's Appointments</span>
                    <h3 class="fw-bold mb-0 mt-1">42</h3>
                    <span class="badge bg-success-subtle text-success small mt-1">
                        <i class="bi bi-arrow-up-right"></i> 14% vs yesterday
                    </span>
                </div>
                <div class="rounded-3 bg-primary-subtle text-primary p-3">
                    <i class="bi bi-calendar-check fs-3"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card p-3 bg-white">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small fw-semibold text-uppercase">Chair Occupancy Rate</span>
                    <h3 class="fw-bold mb-0 mt-1">87.5%</h3>
                    <span class="badge bg-success-subtle text-success small mt-1">
                        <i class="bi bi-check-circle"></i> 14 of 16 chairs active
                    </span>
                </div>
                <div class="rounded-3 bg-success-subtle text-success p-3">
                    <i class="bi bi-person-wheelchair fs-3"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card p-3 bg-white">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small fw-semibold text-uppercase">Daily Billed Revenue</span>
                    <h3 class="fw-bold mb-0 mt-1">$14,850</h3>
                    <span class="badge bg-primary-subtle text-primary small mt-1">
                        <i class="bi bi-receipt"></i> 28 Invoices Settled
                    </span>
                </div>
                <div class="rounded-3 bg-warning-subtle text-warning p-3">
                    <i class="bi bi-cash-stack fs-3"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card p-3 bg-white">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small fw-semibold text-uppercase">Active Clinical Patients</span>
                    <h3 class="fw-bold mb-0 mt-1">3,420</h3>
                    <span class="badge bg-info-subtle text-info small mt-1">
                        <i class="bi bi-shield-check"></i> EMR Charts Synced
                    </span>
                </div>
                <div class="rounded-3 bg-info-subtle text-info p-3">
                    <i class="bi bi-people-fill fs-3"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Row 2: Branch Comparison Matrix & Urgent Clinical Queue -->
<div class="row g-4 mb-4">
    <!-- Branch Comparison Table -->
    <div class="col-12 col-lg-8">
        <div class="card shadow-sm h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-buildings-fill text-primary me-2"></i>Branch-Wise Operational Metrics</span>
                <span class="badge bg-light text-dark border">Live Data Feed</span>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Clinic Branch</th>
                            <th>Doctor Shifts</th>
                            <th>Active Chairs</th>
                            <th>Today's Appts</th>
                            <th>Revenue (MTD)</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <strong class="d-block text-dark">Metro Dental Headquarters</strong>
                                <span class="text-muted small">New York, NY (Main Diagnostic Lab)</span>
                            </td>
                            <td>4 Doctors On-Duty</td>
                            <td>
                                <div class="progress" style="height: 6px; width: 80px;">
                                    <div class="progress-bar bg-success" style="width: 85%;"></div>
                                </div>
                                <span class="small text-muted">6 / 8 Chairs</span>
                            </td>
                            <td><span class="badge bg-primary">22 Appts</span></td>
                            <td><strong class="text-success">$54,200</strong></td>
                            <td><span class="badge bg-success-subtle text-success">Optimal</span></td>
                        </tr>
                        <tr>
                            <td>
                                <strong class="d-block text-dark">Downtown Smiles Branch</strong>
                                <span class="text-muted small">West 57th Street (Cosmetic Center)</span>
                            </td>
                            <td>2 Doctors On-Duty</td>
                            <td>
                                <div class="progress" style="height: 6px; width: 80px;">
                                    <div class="progress-bar bg-warning" style="width: 95%;"></div>
                                </div>
                                <span class="small text-muted">4 / 4 Chairs</span>
                            </td>
                            <td><span class="badge bg-primary">12 Appts</span></td>
                            <td><strong class="text-success">$38,600</strong></td>
                            <td><span class="badge bg-warning-subtle text-warning">High Load</span></td>
                        </tr>
                        <tr>
                            <td>
                                <strong class="d-block text-dark">Westside Pediatric & Family</strong>
                                <span class="text-muted small">Columbus Avenue (Orthodontics)</span>
                            </td>
                            <td>2 Doctors On-Duty</td>
                            <td>
                                <div class="progress" style="height: 6px; width: 80px;">
                                    <div class="progress-bar bg-success" style="width: 75%;"></div>
                                </div>
                                <span class="small text-muted">3 / 4 Chairs</span>
                            </td>
                            <td><span class="badge bg-primary">8 Appts</span></td>
                            <td><strong class="text-success">$21,450</strong></td>
                            <td><span class="badge bg-success-subtle text-success">Normal</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Live Urgent Queue / Patient Flow -->
    <div class="col-12 col-lg-4">
        <div class="card shadow-sm h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-clock-history text-danger me-2"></i>Live Patient Triage Queue</span>
                <span class="badge bg-danger">3 Urgent</span>
            </div>
            <div class="list-group list-group-flush">
                <div class="list-group-item p-3">
                    <div class="d-flex w-100 justify-content-between">
                        <h6 class="mb-1 fw-bold text-danger">Sarah Jenkins (Pain: 8/10)</h6>
                        <small class="text-muted">10:00 AM</small>
                    </div>
                    <p class="mb-1 small text-dark">Suspected Acute Pulpitis (Tooth #19). Awaiting chair 2.</p>
                    <small class="text-muted"><i class="bi bi-person-fill"></i> Dr. Alexander Vance • Metro HQ</small>
                </div>

                <div class="list-group-item p-3">
                    <div class="d-flex w-100 justify-content-between">
                        <h6 class="mb-1 fw-bold text-primary">Michael Rodriguez</h6>
                        <small class="text-muted">10:30 AM</small>
                    </div>
                    <p class="mb-1 small text-dark">All-on-4 Guided Surgical Consultation & 3D CT Review.</p>
                    <small class="text-muted"><i class="bi bi-person-fill"></i> Dr. Vance • Metro HQ</small>
                </div>

                <div class="list-group-item p-3">
                    <div class="d-flex w-100 justify-content-between">
                        <h6 class="mb-1 fw-bold text-success">Emily Watson</h6>
                        <small class="text-muted">11:00 AM</small>
                    </div>
                    <p class="mb-1 small text-dark">Invisalign Tray Delivery & Attachment Bonding.</p>
                    <small class="text-muted"><i class="bi bi-person-fill"></i> Dr. Elena Rostova • Westside</small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Row 3: Inventory Alerts & Quick Operations -->
<div class="row g-4">
    <div class="col-12 col-lg-6">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-exclamation-octagon-fill text-warning me-2"></i>Critical Dental Stock Alerts</span>
                <a href="{{ url('/admin/inventory') }}" class="btn btn-sm btn-link text-decoration-none">Manage Inventory &rarr;</a>
            </div>
            <div class="table-responsive">
                <table class="table table-sm align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Item Code</th>
                            <th>Dental Supply</th>
                            <th>Current Stock</th>
                            <th>Reorder Threshold</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><code>IMP-4010</code></td>
                            <td>Straumann Titanium Implant Fixture 4.1mm</td>
                            <td><span class="badge bg-danger">3 units</span></td>
                            <td>10 units</td>
                            <td><button class="btn btn-xs btn-outline-primary btn-sm">Order Stock</button></td>
                        </tr>
                        <tr>
                            <td><code>LIDO-2P</code></td>
                            <td>Lidocaine 2% with Epinephrine 1:100k</td>
                            <td><span class="badge bg-warning text-dark">12 ampules</span></td>
                            <td>20 ampules</td>
                            <td><button class="btn btn-xs btn-outline-primary btn-sm">Transfer</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="card shadow-sm">
            <div class="card-header">
                <span><i class="bi bi-lightning-charge-fill text-primary me-2"></i>Quick Clinical Operations</span>
            </div>
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-6">
                        <a href="{{ url('/admin/emr/odontogram') }}" class="btn btn-outline-secondary w-100 p-3 text-start">
                            <i class="bi bi-diagram-3-fill fs-4 text-primary d-block mb-1"></i>
                            <strong class="d-block text-dark">New Odontogram Chart</strong>
                            <span class="text-muted small">Record 32-tooth surfaces</span>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="{{ url('/admin/appointments/calendar') }}" class="btn btn-outline-secondary w-100 p-3 text-start">
                            <i class="bi bi-calendar-event-fill fs-4 text-success d-block mb-1"></i>
                            <strong class="d-block text-dark">Doctor Rostering</strong>
                            <span class="text-muted small">Drag-and-drop chair slots</span>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="{{ url('/admin/billing') }}" class="btn btn-outline-secondary w-100 p-3 text-start">
                            <i class="bi bi-credit-card-2-front-fill fs-4 text-warning d-block mb-1"></i>
                            <strong class="d-block text-dark">POS Bill Settlement</strong>
                            <span class="text-muted small">Generate itemized receipts</span>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="{{ url('/admin/cms') }}" class="btn btn-outline-secondary w-100 p-3 text-start">
                            <i class="bi bi-globe fs-4 text-info d-block mb-1"></i>
                            <strong class="d-block text-dark">Patient Portal CMS</strong>
                            <span class="text-muted small">Switch web templates</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
