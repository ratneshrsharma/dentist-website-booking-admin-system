<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\App;

/**
 * Resilient Bookings & Doctor Availability Management Service
 * JSON file-backed storage with out-of-the-box seed data and dynamic calculations.
 */
final class BookingService
{
    private static function getBookingsFile(): string
    {
        return dirname(__DIR__, 2) . '/storage/app/bookings.json';
    }

    private static function getSchedulesFile(): string
    {
        return dirname(__DIR__, 2) . '/storage/app/doctor_schedules.json';
    }

    /**
     * Default doctors roster for scheduling
     */
    public static function getDefaultDoctors(): array
    {
        return [
            [
                'id' => 1,
                'name' => 'Dr. Atandrilla Das',
                'title' => 'BDS Associate Dental Surgeon',
                'badge' => 'Lead Associate Dentist',
                'avatar' => App::url('/images/doctor-das.jpg'),
                'speciality' => 'Restorative Dentistry & Pediatric Care',
                'email' => 'dr.das@acocksgreendental.co.uk',
                'phone' => '+44 121 706 0411',
                'is_active' => true,
            ],
            [
                'id' => 2,
                'name' => 'Dr. Harjeevan Rai',
                'title' => 'BDS Dental Surgeon',
                'badge' => 'Associate Dentist',
                'avatar' => App::url('/images/doctor-rai.jpg'),
                'speciality' => 'Preventive & Biomechanical Restorations',
                'email' => 'dr.rai@acocksgreendental.co.uk',
                'phone' => '+44 121 706 0411',
                'is_active' => true,
            ],
            [
                'id' => 3,
                'name' => 'Dr. Nadeem Sohail',
                'title' => 'BDS Dental Surgeon',
                'badge' => 'Associate Dentist',
                'avatar' => App::url('/images/doctor-sohail.jpg'),
                'speciality' => 'Endodontics & Oral Surgery Extractions',
                'email' => 'dr.sohail@acocksgreendental.co.uk',
                'phone' => '+44 121 706 0411',
                'is_active' => true,
            ],
            [
                'id' => 4,
                'name' => 'Claire',
                'title' => 'Dental Hygienist',
                'badge' => 'Dental Hygienist',
                'avatar' => App::url('/images/hygienist-claire.jpg'),
                'speciality' => 'Periodontal Therapy & Airflow Polish',
                'email' => 'claire.hygiene@acocksgreendental.co.uk',
                'phone' => '+44 121 706 0411',
                'is_active' => true,
            ],
        ];
    }

    /**
     * Default weekly schedule configuration per doctor
     */
    public static function getDefaultSchedules(): array
    {
        $days = [
            1 => ['day' => 'Monday', 'working' => true, 'start' => '09:00', 'end' => '17:30', 'break_start' => '13:00', 'break_end' => '14:00'],
            2 => ['day' => 'Tuesday', 'working' => true, 'start' => '09:00', 'end' => '17:30', 'break_start' => '13:00', 'break_end' => '14:00'],
            3 => ['day' => 'Wednesday', 'working' => true, 'start' => '09:00', 'end' => '17:30', 'break_start' => '13:00', 'break_end' => '14:00'],
            4 => ['day' => 'Thursday', 'working' => true, 'start' => '09:00', 'end' => '17:30', 'break_start' => '13:00', 'break_end' => '14:00'],
            5 => ['day' => 'Friday', 'working' => true, 'start' => '09:00', 'end' => '16:30', 'break_start' => '13:00', 'break_end' => '14:00'],
            6 => ['day' => 'Saturday', 'working' => false, 'start' => '09:30', 'end' => '13:30', 'break_start' => '', 'break_end' => ''],
            0 => ['day' => 'Sunday', 'working' => false, 'start' => '10:00', 'end' => '14:00', 'break_start' => '', 'break_end' => ''],
        ];

        return [
            1 => [
                'doctor_id' => 1,
                'slot_duration' => 30, // in minutes
                'max_chairs' => 1,
                'weekly' => $days,
                'exceptions' => [
                    [
                        'id' => 'lev_101',
                        'date' => date('Y-m-d', strtotime('+4 days')),
                        'session' => '1st_session', // 'full_day', '1st_session', '2nd_session'
                        'reason' => 'NHS Clinical Governance Morning Seminar',
                        'created_at' => date('Y-m-d H:i:s'),
                    ],
                ],
            ],
            2 => [
                'doctor_id' => 2,
                'slot_duration' => 30,
                'max_chairs' => 1,
                'weekly' => $days,
                'exceptions' => [
                    [
                        'id' => 'lev_201',
                        'date' => date('Y-m-d', strtotime('+8 days')),
                        'session' => 'full_day',
                        'reason' => 'Approved Annual Leave Day',
                        'created_at' => date('Y-m-d H:i:s'),
                    ],
                ],
            ],
            3 => [
                'doctor_id' => 3,
                'slot_duration' => 45,
                'max_chairs' => 1,
                'weekly' => [
                    1 => ['day' => 'Monday', 'working' => true, 'start' => '09:00', 'end' => '17:30', 'break_start' => '13:00', 'break_end' => '14:00'],
                    2 => ['day' => 'Tuesday', 'working' => true, 'start' => '09:00', 'end' => '17:30', 'break_start' => '13:00', 'break_end' => '14:00'],
                    3 => ['day' => 'Wednesday', 'working' => false, 'start' => '', 'end' => '', 'break_start' => '', 'break_end' => ''],
                    4 => ['day' => 'Thursday', 'working' => true, 'start' => '09:00', 'end' => '17:30', 'break_start' => '13:00', 'break_end' => '14:00'],
                    5 => ['day' => 'Friday', 'working' => true, 'start' => '09:00', 'end' => '16:30', 'break_start' => '13:00', 'break_end' => '14:00'],
                    6 => ['day' => 'Saturday', 'working' => true, 'start' => '09:00', 'end' => '14:00', 'break_start' => '', 'break_end' => ''],
                    0 => ['day' => 'Sunday', 'working' => false, 'start' => '', 'end' => '', 'break_start' => '', 'break_end' => ''],
                ],
                'exceptions' => [
                    [
                        'id' => 'lev_301',
                        'date' => date('Y-m-d', strtotime('+6 days')),
                        'session' => '2nd_session',
                        'reason' => 'Afternoon Surgical Training Workshop',
                        'created_at' => date('Y-m-d H:i:s'),
                    ],
                ],
            ],
            4 => [
                'doctor_id' => 4,
                'slot_duration' => 45,
                'max_chairs' => 1,
                'weekly' => $days,
                'exceptions' => [],
            ],
        ];
    }

    /**
     * Default seed appointments covering Today, Tomorrow, Next Week, and This Month
     */
    public static function getDefaultBookings(): array
    {
        $today = date('Y-m-d');
        $tomorrow = date('Y-m-d', strtotime('+1 day'));
        $day3 = date('Y-m-d', strtotime('+3 days'));
        $nextWeek1 = date('Y-m-d', strtotime('+7 days'));
        $nextWeek2 = date('Y-m-d', strtotime('+9 days'));
        $nextWeek3 = date('Y-m-d', strtotime('+11 days'));
        $nextMonth = date('Y-m-d', strtotime('+18 days'));

        return [
            [
                'reference' => 'BKG-2026-1041',
                'patient_name' => 'Eleanor Vance',
                'patient_phone' => '+44 7700 900142',
                'patient_email' => 'eleanor.vance@example.co.uk',
                'patient_type' => 'returning', // 'new', 'returning' (attended within 3 months)
                'notification_channel' => 'whatsapp', // 'whatsapp', 'email', 'both'
                'doctor_id' => 1,
                'doctor_name' => 'Dr. Atandrilla Das',
                'treatment' => 'Routine Dental Examination',
                'appointment_date' => $today,
                'appointment_time' => '10:00 AM',
                'duration_minutes' => 30,
                'status' => 'confirmed', // 'confirmed', 'pending', 'completed', 'cancelled'
                'notes' => 'Patient reports mild sensitivity on upper right molar.',
                'created_at' => date('Y-m-d H:i:s', strtotime('-1 day')),
            ],
            [
                'reference' => 'BKG-2026-1042',
                'patient_name' => 'Marcus Chen',
                'patient_phone' => '+44 7700 900581',
                'patient_email' => 'm.chen@example.com',
                'patient_type' => 'new',
                'notification_channel' => 'both',
                'doctor_id' => 1,
                'doctor_name' => 'Dr. Atandrilla Das',
                'treatment' => 'White Tooth Fillings (Composite)',
                'appointment_date' => $today,
                'appointment_time' => '11:30 AM',
                'duration_minutes' => 45,
                'status' => 'confirmed',
                'notes' => 'Tooth #14 composite replacement. New patient intake complete.',
                'created_at' => date('Y-m-d H:i:s', strtotime('-2 days')),
            ],
            [
                'reference' => 'BKG-2026-1043',
                'patient_name' => 'Zara Gallagher',
                'patient_phone' => '+44 7700 900894',
                'patient_email' => 'zara.g@example.co.uk',
                'patient_type' => 'new',
                'notification_channel' => 'whatsapp',
                'doctor_id' => 2,
                'doctor_name' => 'Dr. Harjeevan Rai',
                'treatment' => 'Same-Day Emergency Relief',
                'appointment_date' => $today,
                'appointment_time' => '02:30 PM',
                'duration_minutes' => 30,
                'status' => 'pending',
                'notes' => 'Urgent pain relief request - lower left jaw throbbing. New emergency patient.',
                'created_at' => date('Y-m-d H:i:s', strtotime('-3 hours')),
            ],
            [
                'reference' => 'BKG-2026-1044',
                'patient_name' => 'Oliver Davies',
                'patient_phone' => '+44 7700 900223',
                'patient_email' => 'oliver.davies@example.com',
                'patient_type' => 'returning',
                'notification_channel' => 'email',
                'doctor_id' => 4,
                'doctor_name' => 'Claire',
                'treatment' => 'Dental Hygiene & Airflow Polish',
                'appointment_date' => $tomorrow,
                'appointment_time' => '10:30 AM',
                'duration_minutes' => 45,
                'status' => 'confirmed',
                'notes' => 'Routine 6-month scale & airflow polish.',
                'created_at' => date('Y-m-d H:i:s', strtotime('-1 day')),
            ],
            [
                'reference' => 'BKG-2026-1045',
                'patient_name' => 'Sophie Al-Mansoor',
                'patient_phone' => '+44 7700 900661',
                'patient_email' => 'sophie.am@example.co.uk',
                'patient_type' => 'new',
                'notification_channel' => 'both',
                'doctor_id' => 1,
                'doctor_name' => 'Dr. Atandrilla Das',
                'treatment' => 'Invisalign® Clear Aligners',
                'appointment_date' => $day3,
                'appointment_time' => '03:00 PM',
                'duration_minutes' => 45,
                'status' => 'confirmed',
                'notes' => 'Consultation for 3D iTero digital scan. Haven\'t visited dentist in 6 months.',
                'created_at' => date('Y-m-d H:i:s', strtotime('-2 days')),
            ],
            [
                'reference' => 'BKG-2026-1046',
                'patient_name' => 'James Harrison',
                'patient_phone' => '+44 7700 900445',
                'patient_email' => 'jharrison@example.co.uk',
                'patient_type' => 'returning',
                'notification_channel' => 'whatsapp',
                'doctor_id' => 3,
                'doctor_name' => 'Dr. Nadeem Sohail',
                'treatment' => 'Root Canal Therapy (Endodontics)',
                'appointment_date' => $nextWeek1,
                'appointment_time' => '09:30 AM',
                'duration_minutes' => 60,
                'status' => 'confirmed',
                'notes' => 'Stage 2 obturation treatment.',
                'created_at' => date('Y-m-d H:i:s', strtotime('-4 days')),
            ],
            [
                'reference' => 'BKG-2026-1047',
                'patient_name' => 'Aisha Begum',
                'patient_phone' => '+44 7700 900778',
                'patient_email' => 'aisha.b@example.com',
                'patient_type' => 'new',
                'notification_channel' => 'email',
                'doctor_id' => 2,
                'doctor_name' => 'Dr. Harjeevan Rai',
                'treatment' => 'Dental Crowns & Fixed Bridges',
                'appointment_date' => $nextWeek2,
                'appointment_time' => '11:00 AM',
                'duration_minutes' => 45,
                'status' => 'pending',
                'notes' => 'Crown preparation on upper premolar. Initial consultation.',
                'created_at' => date('Y-m-d H:i:s', strtotime('-1 day')),
            ],
            [
                'reference' => 'BKG-2026-1048',
                'patient_name' => 'Callum Wright',
                'patient_phone' => '+44 7700 900334',
                'patient_email' => 'cwright@example.co.uk',
                'patient_type' => 'returning',
                'notification_channel' => 'both',
                'doctor_id' => 1,
                'doctor_name' => 'Dr. Atandrilla Das',
                'treatment' => 'Routine Dental Examination',
                'appointment_date' => $nextWeek3,
                'appointment_time' => '02:00 PM',
                'duration_minutes' => 30,
                'status' => 'confirmed',
                'notes' => 'Regular recall family checkup.',
                'created_at' => date('Y-m-d H:i:s', strtotime('-3 days')),
            ],
            [
                'reference' => 'BKG-2026-1049',
                'patient_name' => 'Grace Kelly',
                'patient_phone' => '+44 7700 900912',
                'patient_email' => 'grace.k@example.com',
                'patient_type' => 'returning',
                'notification_channel' => 'whatsapp',
                'doctor_id' => 4,
                'doctor_name' => 'Claire',
                'treatment' => 'Dental Hygiene & Airflow Polish',
                'appointment_date' => $nextMonth,
                'appointment_time' => '03:30 PM',
                'duration_minutes' => 45,
                'status' => 'confirmed',
                'notes' => 'Airflow stain removal.',
                'created_at' => date('Y-m-d H:i:s', strtotime('-5 days')),
            ],
        ];
    }

    /**
     * Get all bookings from JSON storage (or defaults)
     */
    public static function getAllBookingsRaw(): array
    {
        $file = self::getBookingsFile();
        if (file_exists($file)) {
            $data = json_decode((string)file_get_contents($file), true);
            if (is_array($data)) {
                // Ensure every booking has patient_type defined
                $modified = false;
                foreach ($data as &$item) {
                    if (empty($item['patient_type'])) {
                        $item['patient_type'] = 'new';
                        $modified = true;
                    }
                }
                if ($modified) {
                    self::saveAllBookings($data);
                }
                return $data;
            }
        }
        $defaults = self::getDefaultBookings();
        self::saveAllBookings($defaults);
        return $defaults;
    }

    /**
     * Save bookings array to storage
     */
    public static function saveAllBookings(array $bookings): bool
    {
        $file = self::getBookingsFile();
        $dir = dirname($file);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        return file_put_contents($file, json_encode(array_values($bookings), JSON_PRETTY_PRINT)) !== false;
    }

    /**
     * Get doctor schedules from JSON storage
     */
    public static function getDoctorSchedules(): array
    {
        $file = self::getSchedulesFile();
        if (file_exists($file)) {
            $data = json_decode((string)file_get_contents($file), true);
            if (is_array($data)) {
                return $data;
            }
        }
        $defaults = self::getDefaultSchedules();
        self::saveDoctorSchedules($defaults);
        return $defaults;
    }

    /**
     * Save doctor schedules
     */
    public static function saveDoctorSchedules(array $schedules): bool
    {
        $file = self::getSchedulesFile();
        $dir = dirname($file);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        return file_put_contents($file, json_encode($schedules, JSON_PRETTY_PRINT)) !== false;
    }

    /**
     * Get schedule for a specific doctor
     */
    public static function getDoctorSchedule(int $doctorId): array
    {
        $all = self::getDoctorSchedules();
        if (isset($all[$doctorId])) {
            return $all[$doctorId];
        }
        $defaults = self::getDefaultSchedules();
        return $defaults[$doctorId] ?? $defaults[1];
    }

    /**
     * Get leaves/exceptions for a specific doctor
     */
    public static function getDoctorLeaves(int $doctorId): array
    {
        $schedule = self::getDoctorSchedule($doctorId);
        return $schedule['exceptions'] ?? [];
    }

    /**
     * Add a date leave/blackout for a doctor (full day, 1st session, 2nd session)
     */
    public static function addDoctorLeave(int $doctorId, string $date, string $session, string $reason): array
    {
        $all = self::getDoctorSchedules();
        if (!isset($all[$doctorId])) {
            $all[$doctorId] = self::getDoctorSchedule($doctorId);
        }

        $leaveId = 'lev_' . time() . '_' . rand(100, 999);
        $newLeave = [
            'id' => $leaveId,
            'date' => $date,
            'session' => in_array($session, ['full_day', '1st_session', '2nd_session'], true) ? $session : 'full_day',
            'reason' => trim($reason) !== '' ? trim($reason) : 'Doctor Leave / Unavailable',
            'created_at' => date('Y-m-d H:i:s'),
        ];

        if (!isset($all[$doctorId]['exceptions']) || !is_array($all[$doctorId]['exceptions'])) {
            $all[$doctorId]['exceptions'] = [];
        }

        // Check if date already exists; replace if so
        $filtered = array_filter($all[$doctorId]['exceptions'], fn($l) => ($l['date'] ?? '') !== $date);
        $filtered[] = $newLeave;
        usort($filtered, fn($a, $b) => strcmp($a['date'], $b['date']));
        $all[$doctorId]['exceptions'] = array_values($filtered);

        self::saveDoctorSchedules($all);
        return $newLeave;
    }

    /**
     * Delete a doctor leave/exception by ID
     */
    public static function deleteDoctorLeave(int $doctorId, string $leaveId): bool
    {
        $all = self::getDoctorSchedules();
        if (!isset($all[$doctorId])) {
            $all[$doctorId] = self::getDoctorSchedule($doctorId);
        }

        if (empty($all[$doctorId]['exceptions'])) {
            return false;
        }

        $initial = count($all[$doctorId]['exceptions']);
        $all[$doctorId]['exceptions'] = array_values(array_filter(
            $all[$doctorId]['exceptions'],
            fn($l) => ($l['id'] ?? '') !== $leaveId
        ));

        if (count($all[$doctorId]['exceptions']) < $initial) {
            self::saveDoctorSchedules($all);
            return true;
        }
        return false;
    }

    /**
     * Reschedule an appointment to a new date, time, and optionally new clinician
     */
    public static function rescheduleBooking(
        string $reference,
        string $newDate,
        string $newTime,
        ?int $newDoctorId = null,
        string $notes = ''
    ): ?array {
        $bookings = self::getAllBookingsRaw();
        $target = null;

        foreach ($bookings as &$b) {
            if ($b['reference'] === $reference) {
                $b['appointment_date'] = $newDate;
                $b['appointment_time'] = $newTime;
                if ($newDoctorId !== null && $newDoctorId > 0) {
                    $newDoc = self::getDoctorById($newDoctorId);
                    if ($newDoc) {
                        $b['doctor_id'] = $newDoc['id'];
                        $b['doctor_name'] = $newDoc['name'];
                    }
                }
                $b['status'] = 'confirmed';
                if (!empty($notes)) {
                    $b['notes'] = trim(($b['notes'] ?? '') . " [Rescheduled: {$notes}]");
                }
                $b['rescheduled_at'] = date('Y-m-d H:i:s');
                $target = $b;
                break;
            }
        }

        if ($target) {
            self::saveAllBookings($bookings);
        }
        return $target;
    }

    /**
     * Get doctor profile by ID
     */
    public static function getDoctorById(int $doctorId): ?array
    {
        foreach (self::getDefaultDoctors() as $doc) {
            if ($doc['id'] === $doctorId) {
                return $doc;
            }
        }
        return null;
    }

    /**
     * Filter bookings by period, doctor, status, and search query
     */
    public static function getFilteredBookings(
        ?string $period = null,
        ?int $doctorId = null,
        ?string $status = null,
        ?string $search = null
    ): array {
        $bookings = self::getAllBookingsRaw();
        $today = date('Y-m-d');
        $nextWeekStart = date('Y-m-d', strtotime('monday next week'));
        $nextWeekEnd = date('Y-m-d', strtotime('sunday next week'));
        $endOfMonth = date('Y-m-t');

        return array_values(array_filter($bookings, function ($b) use ($period, $doctorId, $status, $search, $today, $nextWeekStart, $nextWeekEnd, $endOfMonth) {
            // Period filter
            if ($period === 'today' && $b['appointment_date'] !== $today) {
                return false;
            }
            if ($period === 'next_week') {
                $apptDate = $b['appointment_date'];
                if ($apptDate < $nextWeekStart || $apptDate > $nextWeekEnd) {
                    return false;
                }
            }
            if ($period === 'month') {
                $apptMonth = substr($b['appointment_date'], 0, 7);
                $currMonth = substr($today, 0, 7);
                if ($apptMonth !== $currMonth) {
                    return false;
                }
            }

            // Doctor filter
            if ($doctorId !== null && $doctorId > 0 && (int)($b['doctor_id'] ?? 0) !== $doctorId) {
                return false;
            }

            // Status filter
            if ($status !== null && $status !== '' && $status !== 'all' && ($b['status'] ?? '') !== $status) {
                return false;
            }

            // Search filter
            if ($search !== null && trim($search) !== '') {
                $q = strtolower(trim($search));
                $haystack = strtolower(
                    ($b['reference'] ?? '') . ' ' .
                    ($b['patient_name'] ?? '') . ' ' .
                    ($b['patient_phone'] ?? '') . ' ' .
                    ($b['patient_email'] ?? '') . ' ' .
                    ($b['treatment'] ?? '') . ' ' .
                    ($b['doctor_name'] ?? '')
                );
                if (!str_contains($haystack, $q)) {
                    return false;
                }
            }

            return true;
        }));
    }

    /**
     * Get summary KPI statistics for Bookings Roster (alias for backward compatibility)
     */
    public static function getBookingStats(): array
    {
        return self::getDashboardKpiStats();
    }

    /**
     * Get summary KPI statistics for Clinical Dashboard
     */
    public static function getDashboardKpiStats(): array
    {
        $bookings = self::getAllBookingsRaw();
        $today = date('Y-m-d');
        // Monday through Sunday of current week
        $thisWeekStart = date('Y-m-d', strtotime('monday this week'));
        $thisWeekEnd = date('Y-m-d', strtotime('sunday this week'));
        // Monday through Sunday of next week
        $nextWeekStart = date('Y-m-d', strtotime('monday next week'));
        $nextWeekEnd = date('Y-m-d', strtotime('sunday next week'));
        $thisMonth = date('Y-m');

        $stats = [
            'total' => count($bookings),
            'today' => 0,
            'this_week' => 0,
            'next_week' => 0,
            'this_month' => 0,
            'pending_triage' => 0,
            'confirmed' => 0,
            'completed' => 0,
        ];

        foreach ($bookings as $b) {
            $date = $b['appointment_date'] ?? '';
            $status = $b['status'] ?? 'pending';

            if ($date === $today) {
                $stats['today']++;
            }
            if ($date >= $thisWeekStart && $date <= $thisWeekEnd) {
                $stats['this_week']++;
            }
            if ($date >= $nextWeekStart && $date <= $nextWeekEnd) {
                $stats['next_week']++;
            }
            if (substr($date, 0, 7) === $thisMonth) {
                $stats['this_month']++;
            }
            if ($status === 'pending') {
                $stats['pending_triage']++;
            }
            if ($status === 'confirmed') {
                $stats['confirmed']++;
            }
            if ($status === 'completed') {
                $stats['completed']++;
            }
        }

        return $stats;
    }

    /**
     * Get unique patient demographic analytics (New vs Returning)
     */
    public static function getPatientStats(): array
    {
        $bookings = self::getAllBookingsRaw();
        $thisWeekStart = date('Y-m-d', strtotime('monday this week'));
        $thisWeekEnd = date('Y-m-d', strtotime('sunday this week'));
        $thisMonth = date('Y-m');

        $uniquePatients = [];
        $thisWeekPatients = [];
        $thisMonthPatients = [];

        foreach ($bookings as $b) {
            $key = strtolower(trim($b['patient_phone'] ?: ($b['patient_email'] ?: $b['patient_name'])));
            if (empty($key)) continue;

            $pType = $b['patient_type'] ?? 'new';

            if (!isset($uniquePatients[$key])) {
                $uniquePatients[$key] = [
                    'name' => $b['patient_name'] ?? 'Patient',
                    'phone' => $b['patient_phone'] ?? '',
                    'email' => $b['patient_email'] ?? '',
                    'type' => $pType,
                    'last_visit' => $b['appointment_date'] ?? '',
                    'visits_count' => 1,
                ];
            } else {
                $uniquePatients[$key]['visits_count']++;
                if (($b['appointment_date'] ?? '') > $uniquePatients[$key]['last_visit']) {
                    $uniquePatients[$key]['last_visit'] = $b['appointment_date'];
                    $uniquePatients[$key]['type'] = $pType;
                }
            }

            $date = $b['appointment_date'] ?? '';
            if ($date >= $thisWeekStart && $date <= $thisWeekEnd) {
                $thisWeekPatients[$key] = true;
            }
            if (substr($date, 0, 7) === $thisMonth) {
                $thisMonthPatients[$key] = true;
            }
        }

        $totalUnique = count($uniquePatients);
        $newCount = 0;
        $returningCount = 0;

        foreach ($uniquePatients as $p) {
            if ($p['type'] === 'new') {
                $newCount++;
            } else {
                $returningCount++;
            }
        }

        $newPercent = $totalUnique > 0 ? (int)round(($newCount / $totalUnique) * 100) : 0;
        $returningPercent = $totalUnique > 0 ? (100 - $newPercent) : 0;

        return [
            'total_unique' => $totalUnique,
            'new_patients' => $newCount,
            'returning_patients' => $returningCount,
            'this_week_unique' => count($thisWeekPatients),
            'this_month_unique' => count($thisMonthPatients),
            'new_percent' => $newPercent,
            'returning_percent' => $returningPercent,
        ];
    }

    /**
     * Get upcoming doctor & staff leaves for This Week and Next Week
     */
    public static function getUpcomingDoctorLeavesSummary(): array
    {
        $doctors = self::getDefaultDoctors();
        $today = date('Y-m-d');
        $thisWeekStart = date('Y-m-d', strtotime('monday this week'));
        $thisWeekEnd = date('Y-m-d', strtotime('sunday this week'));
        $nextWeekStart = date('Y-m-d', strtotime('monday next week'));
        $nextWeekEnd = date('Y-m-d', strtotime('sunday next week'));

        $leaves = [];
        $totalThisWeek = 0;
        $totalNextWeek = 0;

        foreach ($doctors as $doc) {
            $docLeaves = self::getDoctorLeaves($doc['id']);
            foreach ($docLeaves as $leave) {
                $lDate = $leave['date'] ?? '';
                if ($lDate < $today) {
                    continue; // Skip past dates
                }

                $periodLabel = 'Upcoming';
                $badgeClass = 'bg-secondary';
                $isThisWeek = false;
                $isNextWeek = false;

                if ($lDate === $today) {
                    $periodLabel = 'Today';
                    $badgeClass = 'bg-danger text-white';
                    $totalThisWeek++;
                    $isThisWeek = true;
                } elseif ($lDate >= $thisWeekStart && $lDate <= $thisWeekEnd) {
                    $periodLabel = 'This Week';
                    $badgeClass = 'bg-warning text-dark';
                    $totalThisWeek++;
                    $isThisWeek = true;
                } elseif ($lDate >= $nextWeekStart && $lDate <= $nextWeekEnd) {
                    $periodLabel = 'Next Week';
                    $badgeClass = 'bg-info text-dark';
                    $totalNextWeek++;
                    $isNextWeek = true;
                }

                $sessionLabel = match ($leave['session'] ?? 'full_day') {
                    '1st_session' => 'Morning Shift (1st Session)',
                    '2nd_session' => 'Afternoon Shift (2nd Session)',
                    default => 'Full Day Blackout',
                };

                $leaves[] = [
                    'id' => $leave['id'] ?? '',
                    'doctor_id' => $doc['id'],
                    'doctor_name' => $doc['name'],
                    'doctor_badge' => $doc['badge'],
                    'doctor_avatar' => $doc['avatar'],
                    'date' => $lDate,
                    'date_formatted' => date('D, j M Y', strtotime($lDate)),
                    'session' => $leave['session'] ?? 'full_day',
                    'session_label' => $sessionLabel,
                    'reason' => $leave['reason'] ?? 'Clinician Leave',
                    'period_label' => $periodLabel,
                    'badge_class' => $badgeClass,
                    'is_this_week' => $isThisWeek,
                    'is_next_week' => $isNextWeek,
                ];
            }
        }

        usort($leaves, fn($a, $b) => strcmp($a['date'], $b['date']));

        return [
            'list' => $leaves,
            'count_this_week' => $totalThisWeek,
            'count_next_week' => $totalNextWeek,
            'total_upcoming' => count($leaves),
        ];
    }

    /**
     * Get upcoming queue appointments for Dashboard table
     */
    public static function getUpcomingAppointments(int $limit = 8): array
    {
        $bookings = self::getAllBookingsRaw();
        $today = date('Y-m-d');

        // All bookings from today onwards
        $upcoming = array_filter($bookings, fn($b) => ($b['appointment_date'] ?? '') >= $today);

        usort($upcoming, function ($a, $b) {
            $cmp = strcmp($a['appointment_date'], $b['appointment_date']);
            if ($cmp !== 0) return $cmp;
            return strcmp($a['appointment_time'], $b['appointment_time']);
        });

        return array_slice(array_values($upcoming), 0, $limit);
    }

    /**
     * Update appointment status
     */
    public static function updateStatus(string $reference, string $newStatus): bool
    {
        $bookings = self::getAllBookingsRaw();
        $updated = false;

        foreach ($bookings as &$b) {
            if ($b['reference'] === $reference) {
                $b['status'] = $newStatus;
                $updated = true;
                break;
            }
        }

        if ($updated) {
            self::saveAllBookings($bookings);
        }
        return $updated;
    }

    /**
     * Delete an appointment
     */
    public static function deleteBooking(string $reference): bool
    {
        $bookings = self::getAllBookingsRaw();
        $initialCount = count($bookings);
        $bookings = array_filter($bookings, fn($b) => $b['reference'] !== $reference);

        if (count($bookings) < $initialCount) {
            self::saveAllBookings($bookings);
            return true;
        }
        return false;
    }

    /**
     * Create a new appointment booking
     */
    public static function createBooking(array $data): array
    {
        $bookings = self::getAllBookingsRaw();

        $doctorId = (int)($data['doctor_id'] ?? 1);
        $doctor = self::getDoctorById($doctorId) ?? self::getDefaultDoctors()[0];

        $ref = 'BKG-' . date('Y') . '-' . rand(1000, 9999);
        $notification = in_array($data['notification_channel'] ?? '', ['whatsapp', 'email', 'both'], true)
            ? $data['notification_channel']
            : 'whatsapp';

        $patientType = in_array($data['patient_type'] ?? '', ['new', 'returning'], true)
            ? $data['patient_type']
            : 'new';

        $newBooking = [
            'reference' => $ref,
            'patient_name' => trim($data['patient_name'] ?? 'Patient'),
            'patient_phone' => trim($data['patient_phone'] ?? ''),
            'patient_email' => trim($data['patient_email'] ?? ''),
            'patient_type' => $patientType,
            'notification_channel' => $notification,
            'doctor_id' => $doctor['id'],
            'doctor_name' => $doctor['name'],
            'treatment' => trim($data['treatment'] ?? 'Routine Dental Examination'),
            'appointment_date' => trim($data['appointment_date'] ?? date('Y-m-d', strtotime('+1 day'))),
            'appointment_time' => trim($data['appointment_time'] ?? '10:00 AM'),
            'duration_minutes' => (int)($data['duration_minutes'] ?? 30),
            'status' => 'pending',
            'notes' => trim($data['notes'] ?? ''),
            'created_at' => date('Y-m-d H:i:s'),
        ];

        // Prepend to list
        array_unshift($bookings, $newBooking);
        self::saveAllBookings($bookings);

        // Compute direct WhatsApp link
        $theme = ThemeService::getTheme();
        $waNum = preg_replace('/\D/', '', $theme['branding']['whatsapp'] ?? '441217652870');
        $msg = "Hello Acocks Green Dental Surgery,\nI requested appointment Ref: {$ref}\nClinician: {$doctor['name']}\nTreatment: {$newBooking['treatment']}\nDate: {$newBooking['appointment_date']} at {$newBooking['appointment_time']}\nPatient: {$newBooking['patient_name']}\nNotification: {$notification}";
        $whatsappUrl = "https://wa.me/{$waNum}?text=" . urlencode($msg);

        $newBooking['whatsapp_url'] = $whatsappUrl;
        return $newBooking;
    }

    /**
     * Compute real-time available time slots for a doctor on a specific date (Calendly logic)
     */
    public static function getAvailableSlots(int $doctorId, string $date): array
    {
        $timestamp = strtotime($date);
        if (!$timestamp) {
            return [];
        }

        $dayOfWeek = (int)date('w', $timestamp); // 0 (Sun) to 6 (Sat)
        $schedule = self::getDoctorSchedule($doctorId);
        $weekly = $schedule['weekly'][$dayOfWeek] ?? null;

        if (!$weekly || empty($weekly['working'])) {
            return []; // Doctor not working on this day
        }

        $startTimeStr = $weekly['start'] ?? '09:00';
        $endTimeStr = $weekly['end'] ?? '17:30';
        $breakStartStr = $weekly['break_start'] ?? '';
        $breakEndStr = $weekly['break_end'] ?? '';
        $slotMinutes = (int)($schedule['slot_duration'] ?? 30);

        if ($slotMinutes < 15) {
            $slotMinutes = 30;
        }

        // Check leaves/exceptions for this doctor on this date
        $leaves = self::getDoctorLeaves($doctorId);
        $leaveOnDate = null;
        foreach ($leaves as $l) {
            if (($l['date'] ?? '') === $date) {
                $leaveOnDate = $l;
                break;
            }
        }

        if ($leaveOnDate) {
            $session = $leaveOnDate['session'] ?? 'full_day';
            if ($session === 'full_day') {
                return []; // Doctor on full day leave: zero available slots!
            }
        }

        // Existing bookings for this doctor on this date
        $allBookings = self::getAllBookingsRaw();
        $bookedTimes = [];
        foreach ($allBookings as $b) {
            if (
                (int)($b['doctor_id'] ?? 0) === $doctorId &&
                ($b['appointment_date'] ?? '') === $date &&
                in_array($b['status'] ?? '', ['confirmed', 'pending'], true)
            ) {
                // Normalize booked time format to H:i
                $bTime = date('H:i', strtotime($b['appointment_time']));
                $bookedTimes[] = $bTime;
            }
        }

        $slots = [];
        $current = strtotime("{$date} {$startTimeStr}");
        $end = strtotime("{$date} {$endTimeStr}");
        $breakStart = !empty($breakStartStr) ? strtotime("{$date} {$breakStartStr}") : 0;
        $breakEnd = !empty($breakEndStr) ? strtotime("{$date} {$breakEndStr}") : 0;

        $now = time();
        $isToday = ($date === date('Y-m-d'));

        while ($current + ($slotMinutes * 60) <= $end) {
            $slotTime24 = date('H:i', $current);
            $slotDisplay = date('g:i A', $current);

            // Check if in lunch break
            $isInBreak = false;
            if ($breakStart > 0 && $breakEnd > 0) {
                if ($current >= $breakStart && $current < $breakEnd) {
                    $isInBreak = true;
                }
            }

            // Check if slot has already passed today
            $isPast = false;
            if ($isToday && $current <= ($now + 1800)) { // 30 min buffer
                $isPast = true;
            }

            $isBooked = in_array($slotTime24, $bookedTimes, true);

            // Check if slot falls in a partial leave session
            $isOnLeave = false;
            if ($leaveOnDate) {
                $hour = (int)date('H', $current);
                $session = $leaveOnDate['session'] ?? 'full_day';
                if ($session === '1st_session' && $hour < 13) {
                    $isOnLeave = true; // Morning session leave (9:00 - 13:00)
                } elseif ($session === '2nd_session' && $hour >= 13) {
                    $isOnLeave = true; // Afternoon session leave (13:00 - 17:30)
                }
            }

            $available = !$isInBreak && !$isPast && !$isBooked && !$isOnLeave;

            $reason = 'available';
            if ($isBooked) {
                $reason = 'booked';
            } elseif ($isOnLeave) {
                $reason = 'doctor_leave';
            } elseif ($isInBreak) {
                $reason = 'break';
            } elseif ($isPast) {
                $reason = 'past';
            }

            $slots[] = [
                'time_24' => $slotTime24,
                'display' => $slotDisplay,
                'available' => $available,
                'reason' => $reason,
                'period' => (int)date('H', $current) < 12 ? 'morning' : 'afternoon',
            ];

            $current += ($slotMinutes * 60);
        }

        return $slots;
    }
}
