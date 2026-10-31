<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Actions\Appointments\CreateAppointmentAction;
use App\Http\Requests\StoreAppointmentBookingRequest;
use App\Http\Resources\V1\AppointmentResource;
use App\Models\Appointment;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;

final class AppointmentApiController extends Controller
{
    public function __construct(
        private readonly CreateAppointmentAction $createAppointmentAction
    ) {}

    /**
     * Submit real-time 5-step appointment booking.
     */
    public function store(StoreAppointmentBookingRequest $request): JsonResponse
    {
        $dto = $request->toDTO();

        $appointment = $this->createAppointmentAction->execute($dto);

        // Load relations for response resource
        $appointment->load(['clinic', 'doctorProfile.user', 'service', 'patientProfile']);

        return response()->json([
            'success' => true,
            'message' => 'Appointment successfully booked and confirmed.',
            'data' => new AppointmentResource($appointment),
        ], Response::HTTP_CREATED);
    }

    /**
     * Lookup appointment status by booking reference and patient phone.
     */
    public function lookup(string $reference): JsonResponse
    {
        $appointment = Appointment::with(['clinic', 'doctorProfile.user', 'service', 'patientProfile'])
            ->where('booking_reference', $reference)
            ->firstOrFail();

        return response()->json([
            'success' => true,
            'data' => new AppointmentResource($appointment),
        ]);
    }
}
