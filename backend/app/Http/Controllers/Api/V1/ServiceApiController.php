<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\V1\ServiceResource;
use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

final class ServiceApiController extends Controller
{
    /**
     * Get categorized dental treatments with pricing and durations.
     */
    public function index(): JsonResponse
    {
        $categories = ServiceCategory::with(['services' => function ($query): void {
            $query->where('is_active', true)->orderBy('base_cost', 'asc');
        }])
        ->orderBy('sort_order', 'asc')
        ->get();

        $data = $categories->map(function (ServiceCategory $category): array {
            return [
                'id' => $category->id,
                'name' => $category->name,
                'slug' => $category->slug,
                'description' => $category->description,
                'icon_name' => $category->icon_name,
                'services' => ServiceResource::collection($category->services),
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    /**
     * Get single service detail by slug.
     */
    public function show(string $slug): JsonResponse
    {
        $service = Service::with('category')
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        return response()->json([
            'success' => true,
            'data' => new ServiceResource($service),
        ]);
    }
}
