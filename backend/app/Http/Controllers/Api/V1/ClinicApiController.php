<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\V1\ClinicResource;
use App\Models\Clinic;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controller;

final class ClinicApiController extends Controller
{
    /**
     * Get list of active clinic branches with operating hours and coordinates.
     */
    public function index(): AnonymousResourceCollection
    {
        $clinics = Clinic::where('is_active', true)
            ->orderBy('is_headquarters', 'desc')
            ->orderBy('name', 'asc')
            ->get();

        return ClinicResource::collection($clinics);
    }

    /**
     * Get single clinic details.
     */
    public function show(string $slug): JsonResponse
    {
        $clinic = Clinic::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        return response()->json([
            'success' => true,
            'data' => new ClinicResource($clinic),
        ]);
    }
}
