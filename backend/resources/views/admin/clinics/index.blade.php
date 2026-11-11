@extends('layouts.admin')

@section('title', 'Multi-Clinic Locations & Branches - Advanced Dental PRO')
@section('page_title', 'Multi-Clinic Branch Manager')
@section('page_subtitle', 'Live operatory chairs, multi-facility scheduling, and inter-branch logistics')

@section('page_actions')
<button type="button" class="btn btn-sm btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#addBranchModal" style="background-color: var(--app-primary); border-color: var(--app-primary);">
    <i class="bi bi-plus-circle-fill me-1"></i> Add New Clinic Branch
</button>
@endsection

@section('content')
<!-- Success Alert Toast Container -->
<div id="branchAlertPlaceholder" class="mb-3"></div>

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
                    <h3 class="fw-bold mb-0 text-dark" id="statActiveFacilities">3 Locations</h3>
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
                    <h3 class="fw-bold mb-0 text-dark" id="statTotalChairs">16 Chairs</h3>
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
<div class="row g-4 mb-4" id="clinicBranchesGrid">
    <!-- Branch 1: HQ Central -->
    <div class="col-12 col-lg-4 branch-card" id="branch-1" data-id="1" data-name="Metro Dental Central" data-type="Headquarters Flagship" data-address="450 Lexington Ave, Suite 1400, Manhattan, New York, NY 10017" data-chairs="8" data-occupied="6" data-doctor="Dr. Ethan Caldwell, DDS" data-hours="08:00 AM - 07:00 PM" data-phone="+1 (555) 010-0001">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                <div>
                    <span class="badge bg-primary-subtle text-primary mb-1 branch-type-label">Headquarters Flagship</span>
                    <h5 class="fw-bold mb-0 text-dark branch-name-label">Metro Dental Central</h5>
                </div>
                <span class="badge bg-success branch-status-badge"><i class="bi bi-circle-fill me-1" style="font-size: 0.5rem;"></i>Open Now</span>
            </div>
            <div class="card-body p-3">
                <p class="text-muted small mb-3 branch-address-label">
                    <i class="bi bi-geo-alt-fill text-danger me-1"></i>450 Lexington Ave, Suite 1400, Manhattan, New York, NY 10017
                </p>

                <div class="bg-light p-3 rounded-3 mb-3">
                    <div class="d-flex justify-content-between text-sm mb-2">
                        <span class="text-muted small">Chair Capacity:</span>
                        <span class="fw-bold text-dark branch-chairs-label">8 Operatories</span>
                    </div>
                    <div class="d-flex justify-content-between text-sm mb-2">
                        <span class="text-muted small">Current Chair Occupancy:</span>
                        <span class="fw-bold text-teal branch-occupied-label" style="color: #0D9488;">6 In Chair / 2 Sanitizing</span>
                    </div>
                    <div class="d-flex justify-content-between text-sm">
                        <span class="text-muted small">Lead Clinician:</span>
                        <span class="fw-bold text-dark branch-doctor-label">Dr. Ethan Caldwell, DDS</span>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center text-sm pt-2">
                    <span class="text-muted small branch-hours-label"><i class="bi bi-clock me-1"></i>08:00 AM - 07:00 PM</span>
                    <span class="fw-semibold text-dark small branch-phone-label"><i class="bi bi-telephone me-1 text-muted"></i>+1 (555) 010-0001</span>
                </div>
            </div>
            <div class="card-footer bg-white border-top p-3 d-flex gap-2">
                <button type="button" class="btn btn-sm btn-outline-primary flex-fill" onclick="openConfigureModal(1)">
                    <i class="bi bi-sliders me-1"></i>Operatories
                </button>
                <button type="button" class="btn btn-sm btn-outline-secondary flex-fill" onclick="openEditModal(1)">
                    <i class="bi bi-pencil me-1"></i>Edit
                </button>
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="openDeleteModal(1)" title="Deactivate Branch">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Branch 2: Westside -->
    <div class="col-12 col-lg-4 branch-card" id="branch-2" data-id="2" data-name="Westside Smile Studio" data-type="Orthodontic Suite" data-address="128 West 57th Street, Floor 3, New York, NY 10019" data-chairs="5" data-occupied="4" data-doctor="Dr. Maya Lin, DMD" data-hours="09:00 AM - 06:00 PM" data-phone="+1 (555) 010-0002">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                <div>
                    <span class="badge bg-indigo-subtle text-indigo mb-1 branch-type-label" style="background: #E0E7FF; color: #4338CA;">Orthodontic Suite</span>
                    <h5 class="fw-bold mb-0 text-dark branch-name-label">Westside Smile Studio</h5>
                </div>
                <span class="badge bg-success branch-status-badge"><i class="bi bi-circle-fill me-1" style="font-size: 0.5rem;"></i>Open Now</span>
            </div>
            <div class="card-body p-3">
                <p class="text-muted small mb-3 branch-address-label">
                    <i class="bi bi-geo-alt-fill text-danger me-1"></i>128 West 57th Street, Floor 3, New York, NY 10019
                </p>

                <div class="bg-light p-3 rounded-3 mb-3">
                    <div class="d-flex justify-content-between text-sm mb-2">
                        <span class="text-muted small">Chair Capacity:</span>
                        <span class="fw-bold text-dark branch-chairs-label">5 Operatories</span>
                    </div>
                    <div class="d-flex justify-content-between text-sm mb-2">
                        <span class="text-muted small">Current Chair Occupancy:</span>
                        <span class="fw-bold text-teal branch-occupied-label" style="color: #0D9488;">4 In Chair / 1 Available</span>
                    </div>
                    <div class="d-flex justify-content-between text-sm">
                        <span class="text-muted small">Lead Clinician:</span>
                        <span class="fw-bold text-dark branch-doctor-label">Dr. Maya Lin, DMD</span>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center text-sm pt-2">
                    <span class="text-muted small branch-hours-label"><i class="bi bi-clock me-1"></i>09:00 AM - 06:00 PM</span>
                    <span class="fw-semibold text-dark small branch-phone-label"><i class="bi bi-telephone me-1 text-muted"></i>+1 (555) 010-0002</span>
                </div>
            </div>
            <div class="card-footer bg-white border-top p-3 d-flex gap-2">
                <button type="button" class="btn btn-sm btn-outline-primary flex-fill" onclick="openConfigureModal(2)">
                    <i class="bi bi-sliders me-1"></i>Operatories
                </button>
                <button type="button" class="btn btn-sm btn-outline-secondary flex-fill" onclick="openEditModal(2)">
                    <i class="bi bi-pencil me-1"></i>Edit
                </button>
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="openDeleteModal(2)" title="Deactivate Branch">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Branch 3: North Surgical & Pediatric -->
    <div class="col-12 col-lg-4 branch-card" id="branch-3" data-id="3" data-name="North Dental Pavilion" data-type="Surgical & Pediatric" data-address="820 Northern Blvd, Suite B, Great Neck, NY 11021" data-chairs="3" data-occupied="2" data-doctor="Dr. Marcus Vance, DDS" data-hours="08:30 AM - 05:00 PM" data-phone="+1 (555) 010-0003">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                <div>
                    <span class="badge bg-warning-subtle text-warning mb-1 branch-type-label">Surgical & Pediatric</span>
                    <h5 class="fw-bold mb-0 text-dark branch-name-label">North Dental Pavilion</h5>
                </div>
                <span class="badge bg-success branch-status-badge"><i class="bi bi-circle-fill me-1" style="font-size: 0.5rem;"></i>Open Now</span>
            </div>
            <div class="card-body p-3">
                <p class="text-muted small mb-3 branch-address-label">
                    <i class="bi bi-geo-alt-fill text-danger me-1"></i>820 Northern Blvd, Suite B, Great Neck, NY 11021
                </p>

                <div class="bg-light p-3 rounded-3 mb-3">
                    <div class="d-flex justify-content-between text-sm mb-2">
                        <span class="text-muted small">Chair Capacity:</span>
                        <span class="fw-bold text-dark branch-chairs-label">3 Surgical Suites</span>
                    </div>
                    <div class="d-flex justify-content-between text-sm mb-2">
                        <span class="text-muted small">Current Chair Occupancy:</span>
                        <span class="fw-bold text-teal branch-occupied-label" style="color: #0D9488;">2 In Surgery / 1 Ready</span>
                    </div>
                    <div class="d-flex justify-content-between text-sm">
                        <span class="text-muted small">Lead Clinician:</span>
                        <span class="fw-bold text-dark branch-doctor-label">Dr. Marcus Vance, DDS</span>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center text-sm pt-2">
                    <span class="text-muted small branch-hours-label"><i class="bi bi-clock me-1"></i>08:30 AM - 05:00 PM</span>
                    <span class="fw-semibold text-dark small branch-phone-label"><i class="bi bi-telephone me-1 text-muted"></i>+1 (555) 010-0003</span>
                </div>
            </div>
            <div class="card-footer bg-white border-top p-3 d-flex gap-2">
                <button type="button" class="btn btn-sm btn-outline-primary flex-fill" onclick="openConfigureModal(3)">
                    <i class="bi bi-sliders me-1"></i>Operatories
                </button>
                <button type="button" class="btn btn-sm btn-outline-secondary flex-fill" onclick="openEditModal(3)">
                    <i class="bi bi-pencil me-1"></i>Edit
                </button>
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="openDeleteModal(3)" title="Deactivate Branch">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal 1: Add New Clinic Branch -->
<div class="modal fade" id="addBranchModal" tabindex="-1" aria-labelledby="addBranchModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-white border-bottom py-3">
                <h5 class="modal-title fw-bold text-dark" id="addBranchModalLabel">
                    <i class="bi bi-building-add text-primary me-2"></i>Add New Clinic Branch Facility
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addBranchForm" onsubmit="handleAddBranch(event)">
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label fw-semibold small">Branch Facility Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="addBranchName" required placeholder="e.g. Eastside Aesthetic Dental Suite">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold small">Branch Classification</label>
                            <select class="form-select" id="addBranchType">
                                <option value="Comprehensive Dental Suite">Comprehensive Dental Suite</option>
                                <option value="Orthodontic Studio">Orthodontic Studio</option>
                                <option value="Surgical & Implant Center">Surgical & Implant Center</option>
                                <option value="Pediatric Dental Pavilion">Pediatric Dental Pavilion</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold small">Physical Street Address <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="addBranchAddress" required placeholder="e.g. 742 Park Avenue, Floor 4, New York, NY 10021">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold small">Operatory Chairs <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="addBranchChairs" min="1" max="30" value="4" required>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label fw-semibold small">Lead Clinician / Dental Director</label>
                            <input type="text" class="form-control" id="addBranchDoctor" placeholder="e.g. Dr. Rachel Adams, DDS">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Operating Hours</label>
                            <input type="text" class="form-control" id="addBranchHours" value="08:30 AM - 06:00 PM">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Direct Telephone</label>
                            <input type="text" class="form-control" id="addBranchPhone" placeholder="+1 (555) 010-0004">
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-top py-2 px-4">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm" style="background-color: var(--app-primary); border-color: var(--app-primary);">
                        <i class="bi bi-check-circle me-1"></i>Provision Branch Facility
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal 2: Edit Clinic Branch Details -->
<div class="modal fade" id="editBranchModal" tabindex="-1" aria-labelledby="editBranchModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-white border-bottom py-3">
                <h5 class="modal-title fw-bold text-dark" id="editBranchModalLabel">
                    <i class="bi bi-pencil-square text-primary me-2"></i>Edit Branch Facility Details
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editBranchForm" onsubmit="handleEditBranch(event)">
                <input type="hidden" id="editBranchId">
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label fw-semibold small">Branch Facility Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="editBranchName" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold small">Branch Classification</label>
                            <input type="text" class="form-control" id="editBranchType" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold small">Physical Street Address <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="editBranchAddress" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold small">Operatory Chairs Capacity</label>
                            <input type="number" class="form-control" id="editBranchChairs" min="1" max="50" required>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label fw-semibold small">Lead Clinician</label>
                            <input type="text" class="form-control" id="editBranchDoctor" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Operating Hours</label>
                            <input type="text" class="form-control" id="editBranchHours" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Direct Telephone</label>
                            <input type="text" class="form-control" id="editBranchPhone" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-top py-2 px-4">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm" style="background-color: var(--app-primary); border-color: var(--app-primary);">
                        <i class="bi bi-save me-1"></i>Save Facility Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal 3: Deactivate / Delete Branch Confirmation -->
<div class="modal fade" id="deleteBranchModal" tabindex="-1" aria-labelledby="deleteBranchModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-danger text-white py-3">
                <h5 class="modal-title fw-bold" id="deleteBranchModalLabel">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>Deactivate Branch Location
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <input type="hidden" id="deleteBranchId">
                <div class="rounded-circle bg-danger-subtle text-danger d-inline-flex align-items-center justify-content-center p-3 mb-3">
                    <i class="bi bi-building-slash fs-1"></i>
                </div>
                <h5 class="fw-bold text-dark mb-2" id="deleteBranchNameDisplay">Metro Dental Central</h5>
                <p class="text-muted small mb-0">
                    Are you sure you want to de-provision this clinic location? Any active operatory appointments will need to be rescheduled or transferred to another branch.
                </p>
            </div>
            <div class="modal-footer bg-light border-top py-2 px-4 justify-content-center">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger btn-sm" onclick="confirmDeleteBranch()">
                    <i class="bi bi-trash-fill me-1"></i>Confirm Deactivation
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal 4: Configure Operatory Chairs & Realtime Status -->
<div class="modal fade" id="configureChairsModal" tabindex="-1" aria-labelledby="configureChairsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-white border-bottom py-3">
                <div>
                    <h5 class="modal-title fw-bold text-dark" id="configureChairsModalLabel">
                        <i class="bi bi-sliders text-teal me-2" style="color: #0D9488;"></i>Operatory Chairs Management
                    </h5>
                    <span class="text-muted small" id="configureBranchTitle">Metro Dental Central</span>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="fw-semibold text-dark small">Operatory Suites Status:</span>
                    <button type="button" class="btn btn-xs btn-outline-primary btn-sm" onclick="addNewChairRow()">
                        <i class="bi bi-plus me-1"></i>Add Chair
                    </button>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle text-sm mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Chair #</th>
                                <th>Suite Name</th>
                                <th>Equipped Modality</th>
                                <th>Current Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody id="chairsTableBody">
                            <!-- Populated dynamically -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer bg-light border-top py-2 px-4">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary btn-sm" onclick="saveChairConfiguration()" style="background-color: var(--app-primary); border-color: var(--app-primary);">
                    <i class="bi bi-check-lg me-1"></i>Save Operatory Status
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let activeBranchIdForChairs = 1;

    function showAlert(message, type = 'success') {
        const placeholder = document.getElementById('branchAlertPlaceholder');
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

    // 1. Add Branch Handler
    function handleAddBranch(event) {
        event.preventDefault();
        const name = document.getElementById('addBranchName').value.trim();
        const type = document.getElementById('addBranchType').value;
        const address = document.getElementById('addBranchAddress').value.trim();
        const chairs = parseInt(document.getElementById('addBranchChairs').value, 10) || 4;
        const doctor = document.getElementById('addBranchDoctor').value.trim() || 'Dr. Specialist TBA';
        const hours = document.getElementById('addBranchHours').value.trim() || '09:00 AM - 05:00 PM';
        const phone = document.getElementById('addBranchPhone').value.trim() || '+1 (555) 010-0099';

        const newId = Date.now();

        const grid = document.getElementById('clinicBranchesGrid');
        const cardHtml = `
            <div class="col-12 col-lg-4 branch-card" id="branch-${newId}" data-id="${newId}" data-name="${name}" data-type="${type}" data-address="${address}" data-chairs="${chairs}" data-occupied="0" data-doctor="${doctor}" data-hours="${hours}" data-phone="${phone}">
                <div class="card border-0 shadow-sm rounded-3 h-100">
                    <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                        <div>
                            <span class="badge bg-teal-subtle text-teal mb-1 branch-type-label" style="background: #CCFBF1; color: #0F766E;">${type}</span>
                            <h5 class="fw-bold mb-0 text-dark branch-name-label">${name}</h5>
                        </div>
                        <span class="badge bg-success branch-status-badge"><i class="bi bi-circle-fill me-1" style="font-size: 0.5rem;"></i>Active</span>
                    </div>
                    <div class="card-body p-3">
                        <p class="text-muted small mb-3 branch-address-label">
                            <i class="bi bi-geo-alt-fill text-danger me-1"></i>${address}
                        </p>
                        <div class="bg-light p-3 rounded-3 mb-3">
                            <div class="d-flex justify-content-between text-sm mb-2">
                                <span class="text-muted small">Chair Capacity:</span>
                                <span class="fw-bold text-dark branch-chairs-label">${chairs} Operatories</span>
                            </div>
                            <div class="d-flex justify-content-between text-sm mb-2">
                                <span class="text-muted small">Current Chair Occupancy:</span>
                                <span class="fw-bold text-teal branch-occupied-label" style="color: #0D9488;">0 In Chair / ${chairs} Available</span>
                            </div>
                            <div class="d-flex justify-content-between text-sm">
                                <span class="text-muted small">Lead Clinician:</span>
                                <span class="fw-bold text-dark branch-doctor-label">${doctor}</span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center text-sm pt-2">
                            <span class="text-muted small branch-hours-label"><i class="bi bi-clock me-1"></i>${hours}</span>
                            <span class="fw-semibold text-dark small branch-phone-label"><i class="bi bi-telephone me-1 text-muted"></i>${phone}</span>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-top p-3 d-flex gap-2">
                        <button type="button" class="btn btn-sm btn-outline-primary flex-fill" onclick="openConfigureModal(${newId})">
                            <i class="bi bi-sliders me-1"></i>Operatories
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-secondary flex-fill" onclick="openEditModal(${newId})">
                            <i class="bi bi-pencil me-1"></i>Edit
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="openDeleteModal(${newId})" title="Deactivate Branch">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;

        grid.insertAdjacentHTML('beforeend', cardHtml);

        // Update stat counter
        const count = document.querySelectorAll('.branch-card').length;
        document.getElementById('statActiveFacilities').innerText = `${count} Locations`;

        // Hide modal & reset form
        const modal = bootstrap.Modal.getInstance(document.getElementById('addBranchModal'));
        if (modal) modal.hide();
        document.getElementById('addBranchForm').reset();

        showAlert(`Clinic Branch <strong>${name}</strong> successfully provisioned with ${chairs} operatories!`);
    }

    // 2. Open & Populate Edit Modal
    function openEditModal(branchId) {
        const card = document.getElementById(`branch-${branchId}`);
        if (!card) return;

        document.getElementById('editBranchId').value = branchId;
        document.getElementById('editBranchName').value = card.getAttribute('data-name');
        document.getElementById('editBranchType').value = card.getAttribute('data-type');
        document.getElementById('editBranchAddress').value = card.getAttribute('data-address');
        document.getElementById('editBranchChairs').value = card.getAttribute('data-chairs');
        document.getElementById('editBranchDoctor').value = card.getAttribute('data-doctor');
        document.getElementById('editBranchHours').value = card.getAttribute('data-hours');
        document.getElementById('editBranchPhone').value = card.getAttribute('data-phone');

        const modal = new bootstrap.Modal(document.getElementById('editBranchModal'));
        modal.show();
    }

    // 3. Save Edit Branch Handler
    function handleEditBranch(event) {
        event.preventDefault();
        const branchId = document.getElementById('editBranchId').value;
        const card = document.getElementById(`branch-${branchId}`);
        if (!card) return;

        const name = document.getElementById('editBranchName').value.trim();
        const type = document.getElementById('editBranchType').value.trim();
        const address = document.getElementById('editBranchAddress').value.trim();
        const chairs = document.getElementById('editBranchChairs').value;
        const doctor = document.getElementById('editBranchDoctor').value.trim();
        const hours = document.getElementById('editBranchHours').value.trim();
        const phone = document.getElementById('editBranchPhone').value.trim();

        // Update dataset
        card.setAttribute('data-name', name);
        card.setAttribute('data-type', type);
        card.setAttribute('data-address', address);
        card.setAttribute('data-chairs', chairs);
        card.setAttribute('data-doctor', doctor);
        card.setAttribute('data-hours', hours);
        card.setAttribute('data-phone', phone);

        // Update DOM labels
        card.querySelector('.branch-name-label').innerText = name;
        card.querySelector('.branch-type-label').innerText = type;
        card.querySelector('.branch-address-label').innerHTML = `<i class="bi bi-geo-alt-fill text-danger me-1"></i>${address}`;
        card.querySelector('.branch-chairs-label').innerText = `${chairs} Operatories`;
        card.querySelector('.branch-doctor-label').innerText = doctor;
        card.querySelector('.branch-hours-label').innerHTML = `<i class="bi bi-clock me-1"></i>${hours}`;
        card.querySelector('.branch-phone-label').innerHTML = `<i class="bi bi-telephone me-1 text-muted"></i>${phone}`;

        const modal = bootstrap.Modal.getInstance(document.getElementById('editBranchModal'));
        if (modal) modal.hide();

        showAlert(`Facility details for <strong>${name}</strong> successfully updated!`);
    }

    // 4. Open Delete Modal
    function openDeleteModal(branchId) {
        const card = document.getElementById(`branch-${branchId}`);
        if (!card) return;
        document.getElementById('deleteBranchId').value = branchId;
        document.getElementById('deleteBranchNameDisplay').innerText = card.getAttribute('data-name');

        const modal = new bootstrap.Modal(document.getElementById('deleteBranchModal'));
        modal.show();
    }

    // 5. Confirm Delete Branch
    function confirmDeleteBranch() {
        const branchId = document.getElementById('deleteBranchId').value;
        const card = document.getElementById(`branch-${branchId}`);
        const name = card ? card.getAttribute('data-name') : 'Branch';

        if (card) {
            card.remove();
        }

        const count = document.querySelectorAll('.branch-card').length;
        document.getElementById('statActiveFacilities').innerText = `${count} Locations`;

        const modal = bootstrap.Modal.getInstance(document.getElementById('deleteBranchModal'));
        if (modal) modal.hide();

        showAlert(`Facility <strong>${name}</strong> has been deactivated and de-provisioned.`, 'warning');
    }

    // 6. Configure Operatory Chairs Modal
    function openConfigureModal(branchId) {
        activeBranchIdForChairs = branchId;
        const card = document.getElementById(`branch-${branchId}`);
        if (!card) return;

        const name = card.getAttribute('data-name');
        const chairsCount = parseInt(card.getAttribute('data-chairs'), 10) || 4;
        document.getElementById('configureBranchTitle').innerText = name;

        const tbody = document.getElementById('chairsTableBody');
        tbody.innerHTML = '';

        const modalities = ['Surgical Handpiece & 3D Sensor', 'Hygiene Ultrasonic Scaler', 'Aesthetic Laser & Curing Unit', 'General Operatory Unit', 'Nitrous Oxide Sedation Unit'];
        const statuses = ['In Procedure', 'Available', 'Sanitizing', 'Scheduled'];

        for (let i = 1; i <= chairsCount; i++) {
            const modality = modalities[(i - 1) % modalities.length];
            const status = i <= 2 ? 'In Procedure' : (i === 3 ? 'Sanitizing' : 'Available');
            const badgeClass = status === 'In Procedure' ? 'bg-danger-subtle text-danger' : (status === 'Sanitizing' ? 'bg-warning-subtle text-warning' : 'bg-success-subtle text-success');

            tbody.innerHTML += `
                <tr id="chair-row-${i}">
                    <td class="fw-bold">Chair #${i}</td>
                    <td><input type="text" class="form-control form-control-sm" value="Operatory Suite ${String.fromCharCode(64 + i)}"></td>
                    <td><span class="small text-muted">${modality}</span></td>
                    <td>
                        <select class="form-select form-select-sm" onchange="updateChairStatusBadge(this)">
                            <option value="Available" ${status === 'Available' ? 'selected' : ''}>Available</option>
                            <option value="In Procedure" ${status === 'In Procedure' ? 'selected' : ''}>In Procedure</option>
                            <option value="Sanitizing" ${status === 'Sanitizing' ? 'selected' : ''}>Sanitizing</option>
                            <option value="Maintenance" ${status === 'Maintenance' ? 'selected' : ''}>Maintenance</option>
                        </select>
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-xs btn-outline-danger btn-sm" onclick="this.closest('tr').remove()"><i class="bi bi-trash"></i></button>
                    </td>
                </tr>
            `;
        }

        const modal = new bootstrap.Modal(document.getElementById('configureChairsModal'));
        modal.show();
    }

    function addNewChairRow() {
        const tbody = document.getElementById('chairsTableBody');
        const count = tbody.querySelectorAll('tr').length + 1;
        tbody.insertAdjacentHTML('beforeend', `
            <tr id="chair-row-${count}">
                <td class="fw-bold">Chair #${count}</td>
                <td><input type="text" class="form-control form-control-sm" value="Operatory Suite ${String.fromCharCode(64 + count)}"></td>
                <td><span class="small text-muted">Multi-Purpose Chair Unit</span></td>
                <td>
                    <select class="form-select form-select-sm">
                        <option value="Available" selected>Available</option>
                        <option value="In Procedure">In Procedure</option>
                        <option value="Sanitizing">Sanitizing</option>
                        <option value="Maintenance">Maintenance</option>
                    </select>
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-xs btn-outline-danger btn-sm" onclick="this.closest('tr').remove()"><i class="bi bi-trash"></i></button>
                </td>
            </tr>
        `);
    }

    function saveChairConfiguration() {
        const tbody = document.getElementById('chairsTableBody');
        const totalRows = tbody.querySelectorAll('tr').length;
        let inProc = 0;
        tbody.querySelectorAll('select').forEach(sel => {
            if (sel.value === 'In Procedure') inProc++;
        });

        const card = document.getElementById(`branch-${activeBranchIdForChairs}`);
        if (card) {
            card.setAttribute('data-chairs', totalRows);
            card.querySelector('.branch-chairs-label').innerText = `${totalRows} Operatories`;
            card.querySelector('.branch-occupied-label').innerText = `${inProc} In Chair / ${totalRows - inProc} Ready`;
        }

        const modal = bootstrap.Modal.getInstance(document.getElementById('configureChairsModal'));
        if (modal) modal.hide();

        showAlert(`Operatory chair layout & telemetry updated successfully!`);
    }
</script>
@endpush
