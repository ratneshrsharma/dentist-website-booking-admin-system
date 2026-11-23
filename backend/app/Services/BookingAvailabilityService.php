<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\AppointmentStatus;
use App\Models\Appointment;
use App\Models\DoctorProfile;
use App\Models\DoctorSchedule;
use App\Models\Service;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

final class BookingAvailabilityService
{
    /**
     * Compute available time slots for a specific doctor, clinic, and service on a given date.
     *
     * @param int $clinicId
     * @param int $doctorProfileId
     * @param int $serviceId
     * @param string $date Y-m-d format
     * @return array<array{time: string, display: string, available: bool, remaining_chairs: int}>
     */
    public function getAvailableSlots(int $clinicId, int $doctorProfileId, int $serviceId, string $date): array
    {
        $targetDate = Carbon::parse($date);

        // Disallow booking for dates in the past
        if ($targetDate->isPast() && ! $targetDate->isToday()) {
            return [];
        }

        $dayOfWeek = (int) $targetDate->dayOfWeek; // 0 (Sun) to 6 (Sat)

        // Fetch doctor's roster schedule for this day and clinic
        $schedule = DoctorSchedule::where('doctor_profile_id', $doctorProfileId)
            ->where('clinic_id', $clinicId)
            ->where('day_of_week', $dayOfWeek)
            ->where('is_available', true)
            ->first();

        if (! $schedule) {
            return [];
        }

        $service = Service::find($serviceId);
        $durationMinutes = $service ? $service->standard_duration_minutes : $schedule->slot_duration_minutes;
        $maxChairs = $schedule->max_parallel_chairs;

        $shiftStart = Carbon::parse($date . ' ' . $schedule->shift_start_time);
        $shiftEnd = Carbon::parse($date . ' ' . $schedule->shift_end_time);

        // Existing active appointments that occupy calendar slots
        $bookedAppointments = Appointment::where('clinic_id', $clinicId)
            ->where('doctor_profile_id', $doctorProfileId)
            ->where('appointment_date', $date)
            ->whereIn('status', [
                AppointmentStatus::PENDING_CONFIRMATION->value,
                AppointmentStatus::CONFIRMED->value,
                AppointmentStatus::CHECKED_IN->value,
                AppointmentStatus::IN_TREATMENT->value,
            ])
            ->get(['start_time', 'end_time']);

        $slots = [];
        $currentTime = $shiftStart->copy();
        $now = Carbon::now();

        while ($currentTime->copy()->addMinutes($durationMinutes)->lte($shiftEnd)) {
            $slotStart = $currentTime->copy();
            $slotEnd = $currentTime->copy()->addMinutes($durationMinutes);
            $timeString = $slotStart->format('H:i');

            // If the booking date is today, ensure slot is at least 30 minutes in the future
            if ($targetDate->isToday() && $slotStart->lte($now->copy()->addMinutes(30))) {
                $slots[] = [
                    'time' => $timeString,
                    'display' => $slotStart->format('g:i A'),
                    'available' => false,
                    'remaining_chairs' => 0,
                    'reason' => 'past_or_too_soon',
                ];
                $currentTime->addMinutes($schedule->slot_duration_minutes);
                continue;
            }

            // Count overlapping bookings for this doctor in this window
            $overlapCount = $bookedAppointments->filter(function ($appointment) use ($slotStart, $slotEnd): bool {
                $apptStart = Carbon::parse($slotStart->toDateString() . ' ' . $appointment->start_time);
                $apptEnd = Carbon::parse($slotStart->toDateString() . ' ' . $appointment->end_time);

                return $slotStart->lt($apptEnd) && $slotEnd->gt($apptStart);
            })->count();

            $remainingChairs = max(0, $maxChairs - $overlapCount);
            $isAvailable = $remainingChairs > 0;

            $slots[] = [
                'time' => $timeString,
                'display' => $slotStart->format('g:i A'),
                'available' => $isAvailable,
                'remaining_chairs' => $remainingChairs,
            ];

            $currentTime->addMinutes($schedule->slot_duration_minutes);
        }

        return $slots;
    }

    /**
     * Compute summary of upcoming available dates over a specified rolling window.
     *
     * @param int $clinicId
     * @param int $doctorProfileId
     * @param int $daysAhead
     * @return array<string, bool> Array of [ '2026-11-01' => true, ... ]
     */
    public function getAvailableDateCalendar(int $clinicId, int $doctorProfileId, int $daysAhead = 30): array
    {
        $startDate = Carbon::today();
        $endDate = $startDate->copy()->addDays($daysAhead);
        $period = CarbonPeriod::create($startDate, $endDate);

        $activeDaysOfWeek = DoctorSchedule::where('doctor_profile_id', $doctorProfileId)
            ->where('clinic_id', $clinicId)
            ->where('is_available', true)
            ->pluck('day_of_week')
            ->toArray();

        $availabilityMap = [];

        foreach ($period as $date) {
            $dateString = $date->format('Y-m-d');
            $dayOfWeek = (int) $date->dayOfWeek;

            $availabilityMap[$dateString] = in_array($dayOfWeek, $activeDaysOfWeek, true);
        }

        return $availabilityMap;
    }
}
