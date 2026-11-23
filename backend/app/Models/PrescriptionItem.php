<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $prescription_id
 * @property string $medication_name
 * @property string $dosage_form
 * @property string $frequency
 * @property string $timing
 * @property int $duration_days
 * @property int $total_quantity
 * @property string|null $special_instructions
 */
final class PrescriptionItem extends Model
{
    use HasFactory;

    protected $table = 'prescription_items';

    protected $fillable = [
        'prescription_id',
        'medication_name',
        'dosage_form',
        'frequency',
        'timing',
        'duration_days',
        'total_quantity',
        'special_instructions',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'duration_days' => 'integer',
            'total_quantity' => 'integer',
        ];
    }

    public function prescription(): BelongsTo
    {
        return $this->belongsTo(Prescription::class, 'prescription_id');
    }
}
