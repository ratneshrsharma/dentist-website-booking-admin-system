<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\V1\DoctorResource;
use App\Models\DoctorProfile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controller;

final class DoctorApiController extends Controller
{
    /**
     * Get list of doctors with optional clinic filtering.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $clinicId = $request->query('clinic_id');

        $query = DoctorProfile::with('user')
            ->where('is_accepting_new_patients', true);

        if ($clinicId) {
            $query->whereHas('schedules', function ($scheduleQuery) use ($clinicId): void {
                $scheduleQuery->where('clinic_id', (int) $clinicId)
                    ->where('is_available', true);
            });
        }

        $doctors = $query->orderBy('years_of_experience', 'desc')->get();

        return DoctorResource::collection($doctors);
    }

    /**
     * Get single doctor profile by ID.
     */
    public function show(int $id): JsonResponse
    {
        $doctor = DoctorProfile::with(['user', 'services', 'schedules.clinic'])
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => new DoctorResource($doctor),
        ]);
    }
}
