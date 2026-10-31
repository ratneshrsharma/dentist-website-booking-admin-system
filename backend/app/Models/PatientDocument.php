<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $patient_profile_id
 * @property int|null $appointment_id
 * @property string $document_type
 * @property string $file_title
 * @property string $stored_file_path
 * @property string $original_filename
 * @property string $mime_type
 * @property int $file_size_bytes
 * @property string $sha256_checksum
 * @property int|null $uploaded_by_user_id
 */
final class PatientDocument extends Model
{
    use HasFactory;

    protected $table = 'patient_documents';

    protected $fillable = [
        'patient_profile_id',
        'appointment_id',
        'document_type',
        'file_title',
        'stored_file_path',
        'original_filename',
        'mime_type',
        'file_size_bytes',
        'sha256_checksum',
        'uploaded_by_user_id',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'file_size_bytes' => 'integer',
        ];
    }

    public function patientProfile(): BelongsTo
    {
        return $this->belongsTo(PatientProfile::class, 'patient_profile_id');
    }

    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class, 'appointment_id');
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by_user_id');
    }
}
