@extends('layouts.admin')

@section('title', 'Multi-Clinic Locations & Branches - Advanced Dental PRO')
@section('page_title', 'Multi-Clinic Branch Manager')
@section('page_subtitle', 'Live operatory chairs, multi-facility scheduling, and inter-branch logistics')

@section('content')
<div class="row g-3 mb-4">
    <!-- Stat 1 -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-body p-3 d-flex align-items-center">
                <div class="rounded-3 p-3 me-3" style="background-color: #CCFBF1; color: #0F766E;">
                    <i class="bi bi-buildings-fill fs-3"></i>
                </div>
                <div>
                    <span class="text-muted small fw-medium d-block">Active Facilities</span>
                    <h3 class="fw-bold mb-0 text-dark">3 Locations</h3>
                    <span class="badge bg-success-subtle text-success small mt-1">100% Operational</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Stat 2 -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-body p-3 d-flex align-items-center">
                <div class="rounded-3 p-3 me-3" style="background-color: #E0E7FF; color: #4338CA;">
                    <i class="bi bi-person-workspace fs-3"></i>
                </div>
                <div>
                    <span class="text-muted small fw-medium d-block">Operatory Chairs</span>
                    <h3 class="fw-bold mb-0 text-dark">16 Chairs</h3>
                    <span class="text-muted small mt-1">11 in active procedures</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Stat 3 -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-body p-3 d-flex align-items-center">
                <div class="rounded-3 p-3 me-3" style="background-color: #FEF3C7; color: #D97706;">
                    <i class="bi bi-heart-pulse-fill fs-3"></i>
                </div>
                <div>
                    <span class="text-muted small fw-medium d-block">Clinical Specialists</span>
                    <h3 class="fw-bold mb-0 text-dark">12 Doctors</h3>
                    <span class="text-muted small mt-1">Cross-branch rotation</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Stat 4 -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-body p-3 d-flex align-items-center">
                <div class="rounded-3 p-3 me-3" style="background-color: #DCFCE7; color: #15803D;">
                    <i class="bi bi-calendar-check-fill fs-3"></i>
                </div>
                <div>
                    <span class="text-muted small fw-medium d-block">Daily Appointments</span>
                    <h3 class="fw-bold mb-0 text-dark">64 Booked</h3>
                    <span class="badge bg-success-subtle text-success small mt-1">87% Utilization</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Branch Cards Grid -->
<div class="row g-4 mb-4">
    <!-- Branch 1: HQ Central -->
    <div class="col-12 col-lg-4">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                <div>
                    <span class="badge bg-primary-subtle text-primary mb-1">Headquarters Flagship</span>
                    <h5 class="fw-bold mb-0 text-dark">Metro Dental Central</h5>
                </div>
                <span class="badge bg-success"><i class="bi bi-circle-fill me-1" style="font-size: 0.5rem;"></i>Open Now</span>
            </div>
            <div class="card-body p-3">
                <p class="text-muted small mb-3">
                    <i class="bi bi-geo-alt-fill text-danger me-1"></i>450 Lexington Ave, Suite 1400, Manhattan, New York, NY 10017
                </p>

                <div class="bg-light p-3 rounded-3 mb-3">
                    <div class="d-flex justify-content-between text-sm mb-2">
                        <span class="text-muted small">Chair Capacity:</span>
                        <span class="fw-bold text-dark">8 Operatories</span>
                    </div>
                    <div class="d-flex justify-content-between text-sm mb-2">
                        <span class="text-muted small">Current Chair Occupancy:</span>
                        <span class="fw-bold text-teal" style="color: #0D9488;">6 In Chair / 2 Sanitizing</span>
                    </div>
                    <div class="d-flex justify-content-between text-sm">
                        <span class="text-muted small">Lead Clinician:</span>
                        <span class="fw-bold text-dark">Dr. Ethan Caldwell, DDS</span>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center text-sm pt-2">
                    <span class="text-muted small"><i class="bi bi-clock me-1"></i>08:00 AM - 07:00 PM</span>
                    <span class="fw-semibold text-dark small"><i class="bi bi-telephone me-1 text-muted"></i>+1 (555) 010-0001</span>
                </div>
            </div>
            <div class="card-footer bg-white border-top p-3 d-flex gap-2">
                <a href="{{ url('/admin/appointments/calendar') }}" class="btn btn-sm btn-outline-primary w-50">
                    <i class="bi bi-calendar-week me-1"></i>View Calendar
                </a>
                <button type="button" class="btn btn-sm btn-outline-secondary w-50">
                    <i class="bi bi-sliders me-1"></i>Configure
                </button>
            </div>
        </div>
    </div>

    <!-- Branch 2: Westside -->
    <div class="col-12 col-lg-4">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                <div>
                    <span class="badge bg-indigo-subtle text-indigo mb-1" style="background: #E0E7FF; color: #4338CA;">Orthodontic Suite</span>
                    <h5 class="fw-bold mb-0 text-dark">Westside Smile Studio</h5>
                </div>
                <span class="badge bg-success"><i class="bi bi-circle-fill me-1" style="font-size: 0.5rem;"></i>Open Now</span>
            </div>
            <div class="card-body p-3">
                <p class="text-muted small mb-3">
                    <i class="bi bi-geo-alt-fill text-danger me-1"></i>128 West 57th Street, Floor 3, New York, NY 10019
                </p>

                <div class="bg-light p-3 rounded-3 mb-3">
                    <div class="d-flex justify-content-between text-sm mb-2">
                        <span class="text-muted small">Chair Capacity:</span>
                        <span class="fw-bold text-dark">5 Operatories</span>
                    </div>
                    <div class="d-flex justify-content-between text-sm mb-2">
                        <span class="text-muted small">Current Chair Occupancy:</span>
                        <span class="fw-bold text-teal" style="color: #0D9488;">4 In Chair / 1 Available</span>
                    </div>
                    <div class="d-flex justify-content-between text-sm">
                        <span class="text-muted small">Lead Clinician:</span>
                        <span class="fw-bold text-dark">Dr. Maya Lin, DMD</span>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center text-sm pt-2">
                    <span class="text-muted small"><i class="bi bi-clock me-1"></i>09:00 AM - 06:00 PM</span>
                    <span class="fw-semibold text-dark small"><i class="bi bi-telephone me-1 text-muted"></i>+1 (555) 010-0002</span>
                </div>
            </div>
            <div class="card-footer bg-white border-top p-3 d-flex gap-2">
                <a href="{{ url('/admin/appointments/calendar') }}" class="btn btn-sm btn-outline-primary w-50">
                    <i class="bi bi-calendar-week me-1"></i>View Calendar
                </a>
                <button type="button" class="btn btn-sm btn-outline-secondary w-50">
                    <i class="bi bi-sliders me-1"></i>Configure
                </button>
            </div>
        </div>
    </div>

    <!-- Branch 3: North Surgical & Pediatric -->
    <div class="col-12 col-lg-4">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                <div>
                    <span class="badge bg-warning-subtle text-warning mb-1">Surgical & Pediatric</span>
                    <h5 class="fw-bold mb-0 text-dark">North Dental Pavilion</h5>
                </div>
                <span class="badge bg-success"><i class="bi bi-circle-fill me-1" style="font-size: 0.5rem;"></i>Open Now</span>
            </div>
            <div class="card-body p-3">
                <p class="text-muted small mb-3">
                    <i class="bi bi-geo-alt-fill text-danger me-1"></i>820 Northern Blvd, Suite B, Great Neck, NY 11021
                </p>

                <div class="bg-light p-3 rounded-3 mb-3">
                    <div class="d-flex justify-content-between text-sm mb-2">
                        <span class="text-muted small">Chair Capacity:</span>
                        <span class="fw-bold text-dark">3 Surgical Suites</span>
                    </div>
                    <div class="d-flex justify-content-between text-sm mb-2">
                        <span class="text-muted small">Current Chair Occupancy:</span>
                        <span class="fw-bold text-teal" style="color: #0D9488;">2 In Surgery / 1 Ready</span>
                    </div>
                    <div class="d-flex justify-content-between text-sm">
                        <span class="text-muted small">Lead Clinician:</span>
                        <span class="fw-bold text-dark">Dr. Marcus Vance, DDS</span>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center text-sm pt-2">
                    <span class="text-muted small"><i class="bi bi-clock me-1"></i>08:30 AM - 05:00 PM</span>
                    <span class="fw-semibold text-dark small"><i class="bi bi-telephone me-1 text-muted"></i>+1 (555) 010-0003</span>
                </div>
            </div>
            <div class="card-footer bg-white border-top p-3 d-flex gap-2">
                <a href="{{ url('/admin/appointments/calendar') }}" class="btn btn-sm btn-outline-primary w-50">
                    <i class="bi bi-calendar-week me-1"></i>View Calendar
                </a>
                <button type="button" class="btn btn-sm btn-outline-secondary w-50">
                    <i class="bi bi-sliders me-1"></i>Configure
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
