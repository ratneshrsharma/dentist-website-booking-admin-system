<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Services\BookingAvailabilityService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

final class AvailabilityApiController extends Controller
{
    public function __construct(
        private readonly BookingAvailabilityService $availabilityService
    ) {}

    /**
     * Get real-time available time slots for a doctor, clinic, service, and date.
     */
    public function slots(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'clinic_id' => ['required', 'integer', 'exists:clinics,id'],
            'doctor_profile_id' => ['required', 'integer', 'exists:doctor_profiles,id'],
            'service_id' => ['required', 'integer', 'exists:services,id'],
            'date' => ['required', 'date_format:Y-m-d', 'after_or_equal:today'],
        ]);

        $slots = $this->availabilityService->getAvailableSlots(
            (int) $validated['clinic_id'],
            (int) $validated['doctor_profile_id'],
            (int) $validated['service_id'],
            (string) $validated['date']
        );

        return response()->json([
            'success' => true,
            'clinic_id' => (int) $validated['clinic_id'],
            'doctor_profile_id' => (int) $validated['doctor_profile_id'],
            'date' => $validated['date'],
            'total_slots' => count($slots),
            'available_slots_count' => count(array_filter($slots, fn ($s) => $s['available'])),
            'slots' => $slots,
        ]);
    }

    /**
     * Get 30-day calendar availability map for doctor scheduling.
     */
    public function calendar(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'clinic_id' => ['required', 'integer', 'exists:clinics,id'],
            'doctor_profile_id' => ['required', 'integer', 'exists:doctor_profiles,id'],
            'days_ahead' => ['nullable', 'integer', 'min:7', 'max:90'],
        ]);

        $daysAhead = isset($validated['days_ahead']) ? (int) $validated['days_ahead'] : 30;

        $calendarMap = $this->availabilityService->getAvailableDateCalendar(
            (int) $validated['clinic_id'],
            (int) $validated['doctor_profile_id'],
            $daysAhead
        );

        return response()->json([
            'success' => true,
            'calendar' => $calendarMap,
        ]);
    }
}
