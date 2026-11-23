<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\ToothRecordDTO;
use App\Enums\ToothCondition;
use App\Enums\ToothSurface;
use App\Models\DentalChart;
use App\Models\ToothRecord;
use InvalidArgumentException;

final class OdontogramEngineService
{
    /**
     * Update or record condition of a specific tooth within a dental chart.
     */
    public function recordToothCondition(DentalChart $chart, ToothRecordDTO $dto): ToothRecord
    {
        if ($dto->toothNumber < 1 || $dto->toothNumber > 32) {
            throw new InvalidArgumentException("Invalid tooth number {$dto->toothNumber}. Must be between 1 and 32.");
        }

        // Validate anatomical surfaces
        if ($dto->affectedSurfaces !== null) {
            $validSurfaces = array_map(fn (ToothSurface $surface) => $surface->value, ToothSurface::cases());
            foreach ($dto->affectedSurfaces as $surface) {
                if (! in_array($surface, $validSurfaces, true)) {
                    throw new InvalidArgumentException("Invalid tooth surface: {$surface}");
                }
            }
        }

        return ToothRecord::updateOrCreate(
            [
                'dental_chart_id' => $chart->id,
                'tooth_number' => $dto->toothNumber,
            ],
            [
                'condition_code' => $dto->conditionCode,
                'affected_surfaces' => $dto->affectedSurfaces,
                'periodontal_pocket_depths' => $dto->pocketDepths,
                'clinical_remarks' => $dto->remarks,
            ]
        );
    }

    /**
     * Map a diagnosed tooth condition into recommended clinical procedures.
     *
     * @return array<array{procedure_name: string, default_phase: int, urgency: string}>
     */
    public function getRecommendedProceduresForCondition(ToothCondition $condition): array
    {
        return match ($condition) {
            ToothCondition::CARIES_DECAY => [
                [
                    'procedure_name' => 'Composite Resin Tooth Restoration',
                    'default_phase' => 1,
                    'urgency' => 'routine',
                ],
            ],
            ToothCondition::ROOT_CANAL_TREATED => [
                [
                    'procedure_name' => 'Porcelain-Fused-to-Zirconia Full Crown',
                    'default_phase' => 2,
                    'urgency' => 'routine',
                ],
            ],
            ToothCondition::MISSING_EXTRACTED => [
                [
                    'procedure_name' => 'Single Tooth Titanium Dental Implant & Abutment',
                    'default_phase' => 2,
                    'urgency' => 'elective',
                ],
            ],
            ToothCondition::FRACTURED_TOOTH => [
                [
                    'procedure_name' => 'Emergency Pulpotomy & Diagnostic Evaluation',
                    'default_phase' => 1,
                    'urgency' => 'urgent',
                ],
                [
                    'procedure_name' => 'Full Coverage Ceramic Crown',
                    'default_phase' => 2,
                    'urgency' => 'routine',
                ],
            ],
            ToothCondition::PERIAPICAL_ABSCESS => [
                [
                    'procedure_name' => 'Endodontic Canal Debridement & Calcium Hydroxide',
                    'default_phase' => 1,
                    'urgency' => 'emergency',
                ],
            ],
            default => [],
        };
    }

    /**
     * Compute comprehensive dental chart health summary.
     *
     * @return array{healthy_count: int, caries_count: int, treated_count: int, missing_count: int, total_charted: int}
     */
    public function getChartHealthMetrics(DentalChart $chart): array
    {
        $records = $chart->toothRecords()->get();

        $healthy = 0;
        $caries = 0;
        $treated = 0;
        $missing = 0;

        foreach ($records as $record) {
            match ($record->condition_code) {
                ToothCondition::SOUND_HEALTHY => $healthy++,
                ToothCondition::CARIES_DECAY => $caries++,
                ToothCondition::MISSING_EXTRACTED => $missing++,
                default => $treated++,
            };
        }

        // Adult chart has 32 teeth; unrecorded teeth default to sound healthy
        $chartedCount = $records->count();
        $unrecorded = max(0, 32 - $chartedCount);

        return [
            'healthy_count' => $healthy + $unrecorded,
            'caries_count' => $caries,
            'treated_count' => $treated,
            'missing_count' => $missing,
            'total_charted' => $chartedCount,
        ];
    }
}
