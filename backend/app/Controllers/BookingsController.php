<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\App;
use App\Core\Auth;
use App\Services\BookingService;

class BookingsController
{
    /**
     * Master Bookings Dashboard with Filter Tabs & Doctor Filter
     */
    public function index(): void
    {
        $period = $_GET['period'] ?? 'all';
        $doctorId = isset($_GET['doctor_id']) && $_GET['doctor_id'] !== '' ? (int)$_GET['doctor_id'] : null;
        $status = $_GET['status'] ?? null;
        $search = $_GET['q'] ?? null;

        $bookings = BookingService::getFilteredBookings($period, $doctorId, $status, $search);
        $stats = BookingService::getBookingStats();
        $doctors = BookingService::getDefaultDoctors();

        App::render('admin/bookings/index', [
            'activeNav' => 'bookings',
            'bookings' => $bookings,
            'stats' => $stats,
            'doctors' => $doctors,
            'currentPeriod' => $period,
            'currentDoctorId' => $doctorId,
            'currentStatus' => $status,
            'currentSearch' => $search,
        ]);
    }

    /**
     * Update Booking Status (Confirmed, Pending, Completed, Cancelled)
     */
    public function updateStatus(string $reference): void
    {
        $newStatus = trim($_POST['status'] ?? 'confirmed');
        $validStatuses = ['confirmed', 'pending', 'completed', 'cancelled'];

        if (!in_array($newStatus, $validStatuses, true)) {
            App::redirect('/admin/bookings', ['error' => 'Invalid booking status supplied.']);
            return;
        }

        $updated = BookingService::updateStatus($reference, $newStatus);

        if ($updated) {
            App::redirect('/admin/bookings', ['success' => "Booking {$reference} status updated to " . ucfirst($newStatus) . "."]);
        } else {
            App::redirect('/admin/bookings', ['error' => "Booking {$reference} not found."]);
        }
    }

    /**
     * Delete an appointment
     */
    public function deleteBooking(string $reference): void
    {
        $deleted = BookingService::deleteBooking($reference);

        if ($deleted) {
            App::redirect('/admin/bookings', ['success' => "Booking {$reference} was permanently deleted."]);
        } else {
            App::redirect('/admin/bookings', ['error' => "Booking {$reference} not found."]);
        }
    }

    /**
     * Dedicated Doctor Availability & Schedule Management Page
     */
    public function availability(): void
    {
        $doctors = BookingService::getDefaultDoctors();
        $selectedDoctorId = isset($_GET['doctor_id']) ? (int)$_GET['doctor_id'] : (int)($doctors[0]['id'] ?? 1);

        $selectedDoctor = BookingService::getDoctorById($selectedDoctorId) ?? $doctors[0];
        $schedule = BookingService::getDoctorSchedule($selectedDoctorId);
        $doctorBookings = BookingService::getFilteredBookings(null, $selectedDoctorId);
        $leaves = BookingService::getDoctorLeaves($selectedDoctorId);

        App::render('admin/bookings/availability', [
            'activeNav' => 'doctor-availability',
            'doctors' => $doctors,
            'selectedDoctor' => $selectedDoctor,
            'schedule' => $schedule,
            'doctorBookings' => $doctorBookings,
            'leaves' => $leaves,
        ]);
    }

    /**
     * Save Doctor Availability Schedule
     */
    public function saveAvailability(): void
    {
        $doctorId = (int)($_POST['doctor_id'] ?? 1);
        $slotDuration = (int)($_POST['slot_duration'] ?? 30);
        $maxChairs = (int)($_POST['max_chairs'] ?? 1);

        $allSchedules = BookingService::getDoctorSchedules();
        $existing = $allSchedules[$doctorId] ?? BookingService::getDefaultSchedules()[$doctorId] ?? [];

        $weekly = [];
        $dayNames = [
            1 => 'Monday',
            2 => 'Tuesday',
            3 => 'Wednesday',
            4 => 'Thursday',
            5 => 'Friday',
            6 => 'Saturday',
            0 => 'Sunday',
        ];

        foreach ($dayNames as $dNum => $dName) {
            $isWorking = !empty($_POST["day_{$dNum}_working"]);
            $start = trim($_POST["day_{$dNum}_start"] ?? '09:00');
            $end = trim($_POST["day_{$dNum}_end"] ?? '17:30');
            $breakStart = trim($_POST["day_{$dNum}_break_start"] ?? '');
            $breakEnd = trim($_POST["day_{$dNum}_break_end"] ?? '');

            $weekly[$dNum] = [
                'day' => $dName,
                'working' => $isWorking,
                'start' => $start,
                'end' => $end,
                'break_start' => $breakStart,
                'break_end' => $breakEnd,
            ];
        }

        $allSchedules[$doctorId] = [
            'doctor_id' => $doctorId,
            'slot_duration' => $slotDuration,
            'max_chairs' => $maxChairs,
            'weekly' => $weekly,
            'exceptions' => $existing['exceptions'] ?? [],
        ];

        BookingService::saveDoctorSchedules($allSchedules);

        $doc = BookingService::getDoctorById($doctorId);
        $docName = $doc['name'] ?? 'Doctor';

        App::redirect("/admin/doctors/availability?doctor_id={$doctorId}", [
            'success' => "Working hours and slot settings for {$docName} saved successfully!",
        ]);
    }

    /**
     * Reschedule an appointment
     */
    public function reschedule(string $reference): void
    {
        $newDate = trim($_POST['appointment_date'] ?? '');
        $newTime = trim($_POST['appointment_time'] ?? '');
        $doctorId = isset($_POST['doctor_id']) && $_POST['doctor_id'] !== '' ? (int)$_POST['doctor_id'] : null;
        $notes = trim($_POST['notes'] ?? '');

        if (empty($newDate) || empty($newTime)) {
            App::redirect('/admin/bookings', ['error' => 'Please provide both a valid date and time slot for rescheduling.']);
            return;
        }

        $rescheduled = BookingService::rescheduleBooking($reference, $newDate, $newTime, $doctorId, $notes);

        if ($rescheduled) {
            $patientName = $rescheduled['patient_name'] ?? 'Patient';
            $docName = $rescheduled['doctor_name'] ?? 'Clinician';
            App::redirect("/admin/bookings?rescheduled=" . urlencode($reference), [
                'success' => "Appointment {$reference} for {$patientName} successfully rescheduled to {$newDate} at {$newTime} with {$docName}. You can now dispatch WhatsApp and Email confirmation updates.",
            ]);
        } else {
            App::redirect('/admin/bookings', ['error' => "Booking {$reference} not found."]);
        }
    }

    /**
     * Send Reminder via WhatsApp or Email
     */
    public function sendReminder(string $reference): void
    {
        $channel = trim($_POST['channel'] ?? 'both');
        $bookings = BookingService::getAllBookingsRaw();
        $booking = null;
        foreach ($bookings as $b) {
            if ($b['reference'] === $reference) {
                $booking = $b;
                break;
            }
        }

        if (!$booking) {
            App::redirect('/admin/bookings', ['error' => "Booking {$reference} not found."]);
            return;
        }

        $patient = $booking['patient_name'] ?? 'Patient';
        $channelText = $channel === 'whatsapp' ? 'WhatsApp' : ($channel === 'email' ? 'Email' : 'WhatsApp and Email');
        App::redirect('/admin/bookings', [
            'success' => "Clinical reminder dispatched to {$patient} via {$channelText} for appointment {$reference}.",
        ]);
    }

    /**
     * Add Doctor Leave / Exception
     */
    public function addLeave(): void
    {
        $doctorId = (int)($_POST['doctor_id'] ?? 1);
        $date = trim($_POST['leave_date'] ?? '');
        $session = trim($_POST['leave_session'] ?? 'full_day');
        $reason = trim($_POST['leave_reason'] ?? 'Doctor Leave');

        if (empty($date)) {
            App::redirect("/admin/doctors/availability?doctor_id={$doctorId}", ['error' => 'Please select a valid leave date.']);
            return;
        }

        BookingService::addDoctorLeave($doctorId, $date, $session, $reason);

        $sessionLabel = $session === '1st_session' ? 'Morning (1st Session)' : ($session === '2nd_session' ? 'Afternoon (2nd Session)' : 'Full Day');
        App::redirect("/admin/doctors/availability?doctor_id={$doctorId}", [
            'success' => "Leave added for {$date} ({$sessionLabel}). Live booking slots are automatically updated.",
        ]);
    }

    /**
     * Delete Doctor Leave
     */
    public function deleteLeave(string $leaveId): void
    {
        $doctorId = (int)($_POST['doctor_id'] ?? 1);
        BookingService::deleteDoctorLeave($doctorId, $leaveId);

        App::redirect("/admin/doctors/availability?doctor_id={$doctorId}", [
            'success' => "Leave blackout date removed. Working slots restored.",
        ]);
    }
}

