<?php

declare(strict_types=1);

namespace App\DTOs;

use App\Enums\ToothCondition;
use App\Enums\ToothSurface;

final readonly class ToothRecordDTO
{
    /**
     * @param list<string> $affectedSurfaces
     * @param list<int> $pocketDepths 6 periodontal probing measurements [MB, B, DB, ML, L, DL]
     */
    public function __construct(
        public int $dentalChartId,
        public int $toothNumber,
        public ToothCondition $condition,
        public array $affectedSurfaces = [],
        public array $pocketDepths = [],
        public ?string $clinicalRemarks = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        $condition = is_string($data['condition_code'])
            ? ToothCondition::from($data['condition_code'])
            : ToothCondition::SOUND_HEALTHY;

        /** @var list<string> $surfaces */
        $surfaces = isset($data['affected_surfaces']) && is_array($data['affected_surfaces'])
            ? array_values(array_filter($data['affected_surfaces'], fn ($s): bool => is_string($s)))
            : [];

        /** @var list<int> $depths */
        $depths = isset($data['periodontal_pocket_depths']) && is_array($data['periodontal_pocket_depths'])
            ? array_values(array_map(fn ($d): int => (int) $d, $data['periodontal_pocket_depths']))
            : [];

        return new self(
            dentalChartId: (int) $data['dental_chart_id'],
            toothNumber: (int) $data['tooth_number'],
            condition: $condition,
            affectedSurfaces: $surfaces,
            pocketDepths: $depths,
            clinicalRemarks: isset($data['clinical_remarks']) && is_string($data['clinical_remarks']) ? $data['clinical_remarks'] : null,
        );
    }
}
