@extends('layouts.admin')

@section('title', 'Clinical Scheduler & Calendar - DentaFlow')
@section('page_title', 'Doctor Appointment Scheduler')
@section('page_subtitle', 'FullCalendar 6 Resource TimeGrid with real-time chair concurrency')

@section('page_actions')
    <div class="d-flex gap-2">
        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#newApptModal">
            <i class="bi bi-calendar-plus me-1"></i> Quick Walk-In Booking
        </button>
        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="window.calendar.refetchEvents()">
            <i class="bi bi-arrow-clockwise me-1"></i> Sync Roster
        </button>
    </div>
@endsection

@section('content')
<div class="row g-4">
    <!-- Left Filter & Doctor Column -->
    <div class="col-12 col-xl-3">
        <div class="card shadow-sm mb-4">
            <div class="card-header">
                <i class="bi bi-funnel-fill text-primary me-2"></i>Filter Schedule
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label small fw-bold">Select Clinic Branch</label>
                    <select class="form-select form-select-sm" id="branchFilter">
                        <option value="1" selected>Metro Dental Headquarters (HQ)</option>
                        <option value="2">Downtown Smiles Branch</option>
                        <option value="3">Westside Pediatric & Family</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold">Doctor Specialists</label>
                    <div class="d-flex flex-column gap-2">
                        <label class="form-check small">
                            <input class="form-check-input" type="checkbox" value="1" checked>
                            <span class="badge bg-teal" style="background-color: #0D9488;"></span>
                            Dr. Alexander Vance (Prostho)
                        </label>
                        <label class="form-check small">
                            <input class="form-check-input" type="checkbox" value="2" checked>
                            <span class="badge bg-primary"></span>
                            Dr. Elena Rostova (Ortho)
                        </label>
                        <label class="form-check small">
                            <input class="form-check-input" type="checkbox" value="3" checked>
                            <span class="badge bg-warning"></span>
                            Dr. Marcus Chen (Endo)
                        </label>
                    </div>
                </div>

                <hr>

                <h6 class="small fw-bold mb-2">Chair Capacities</h6>
                <div class="d-flex justify-content-between small text-muted mb-1">
                    <span>Chair 1 (Surgical Unit):</span>
                    <strong class="text-danger">Booked (10-12)</strong>
                </div>
                <div class="d-flex justify-content-between small text-muted mb-1">
                    <span>Chair 2 (General / Hygiene):</span>
                    <strong class="text-success">Available</strong>
                </div>
                <div class="d-flex justify-content-between small text-muted mb-1">
                    <span>Chair 3 (Orthodontics):</span>
                    <strong class="text-success">Available</strong>
                </div>
            </div>
        </div>

        <!-- Status Legend -->
        <div class="card shadow-sm">
            <div class="card-header small fw-bold">Appointment Color Status</div>
            <div class="card-body small">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <div style="width: 14px; height: 14px; border-radius: 3px; background: #0D9488;"></div>
                    <span>Confirmed Consultation</span>
                </div>
                <div class="d-flex align-items-center gap-2 mb-2">
                    <div style="width: 14px; height: 14px; border-radius: 3px; background: #3B82F6;"></div>
                    <span>In-Progress In Chair</span>
                </div>
                <div class="d-flex align-items-center gap-2 mb-2">
                    <div style="width: 14px; height: 14px; border-radius: 3px; background: #10B981;"></div>
                    <span>Completed & Invoiced</span>
                </div>
                <div class="d-flex align-items-center gap-2 mb-2">
                    <div style="width: 14px; height: 14px; border-radius: 3px; background: #EF4444;"></div>
                    <span>Urgent Emergency Trauma</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Right: FullCalendar Interactive Surface -->
    <div class="col-12 col-xl-9">
        <div class="card shadow-sm">
            <div class="card-body p-3">
                <div id="clinicalCalendar" style="min-height: 700px;"></div>
            </div>
        </div>
    </div>
</div>

<!-- Modal: New Appointment Walk-In -->
<div class="modal fade" id="newApptModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">New Walk-In Appointment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="quickBookingForm">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Patient Name *</label>
                        <input type="text" class="form-control" placeholder="e.g. Robert Smith" required>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-bold">Phone Number *</label>
                            <input type="tel" class="form-control" placeholder="+1 (555) 000-0000" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-bold">Doctor *</label>
                            <select class="form-select">
                                <option value="1">Dr. Alexander Vance</option>
                                <option value="2">Dr. Elena Rostova</option>
                                <option value="3">Dr. Marcus Chen</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Procedure *</label>
                        <select class="form-select">
                            <option value="1">Comprehensive Exam ($89)</option>
                            <option value="2">Dental Implant Review ($1,850)</option>
                            <option value="5">Root Canal Treatment ($650)</option>
                            <option value="6">Emergency Toothache Relief ($150)</option>
                        </select>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-bold">Date *</label>
                            <input type="date" class="form-control" value="{{ date('Y-m-d') }}">
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-bold">Time Slot *</label>
                            <select class="form-select">
                                <option>09:00 AM</option>
                                <option>10:00 AM</option>
                                <option>11:30 AM</option>
                                <option>02:00 PM</option>
                                <option>03:30 PM</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary btn-sm" onclick="alert('Appointment saved to schedule!'); $('#newApptModal').modal('hide');">
                    <i class="bi bi-check-lg"></i> Lock Slot
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const calendarEl = document.getElementById('clinicalCalendar');
        const today = new Date().toISOString().split('T')[0];

        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'timeGridDay',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'timeGridDay,timeGridWeek,dayGridMonth'
            },
            slotMinTime: '08:00:00',
            slotMaxTime: '20:00:00',
            allDaySlot: false,
            editable: true,
            selectable: true,
            events: [
                {
                    id: '1',
                    title: 'Sarah Jenkins - Tooth #19 Pulpitis',
                    start: today + 'T09:00:00',
                    end: today + 'T10:15:00',
                    backgroundColor: '#EF4444',
                    borderColor: '#DC2626'
                },
                {
                    id: '2',
                    title: 'Michael Rodriguez - All-on-4 Implant Review',
                    start: today + 'T10:30:00',
                    end: today + 'T12:00:00',
                    backgroundColor: '#0D9488',
                    borderColor: '#0F766E'
                },
                {
                    id: '3',
                    title: 'Emily Watson - Invisalign Scan',
                    start: today + 'T14:00:00',
                    end: today + 'T14:45:00',
                    backgroundColor: '#3B82F6',
                    borderColor: '#2563EB'
                },
                {
                    id: '4',
                    title: 'David Miller - Routine Cleaning',
                    start: today + 'T15:30:00',
                    end: today + 'T16:15:00',
                    backgroundColor: '#10B981',
                    borderColor: '#059669'
                }
            ],
            eventClick: function(info) {
                alert('Appointment: ' + info.event.title + '\nStart: ' + info.event.start.toLocaleTimeString());
            },
            select: function(info) {
                const modal = new bootstrap.Modal(document.getElementById('newApptModal'));
                modal.show();
            }
        });

        calendar.render();
        window.calendar = calendar;
    });
</script>
@endpush
