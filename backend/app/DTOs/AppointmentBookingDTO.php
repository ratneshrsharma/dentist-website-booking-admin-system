<?php

declare(strict_types=1);

namespace App\DTOs;

final readonly class AppointmentBookingDTO
{
    /**
     * @param array<string, mixed>|null $metadata
     */
    public function __construct(
        public int $clinicId,
        public int $doctorProfileId,
        public int $serviceId,
        public string $appointmentDate,
        public string $startTime,
        public string $firstName,
        public string $lastName,
        public string $phone,
        public ?string $email,
        public ?string $patientNotes,
        public string $chiefComplaint,
        public int $painLevel,
        public string $lastVisit,
        public bool $hasAllergies,
        public ?string $allergyDetails,
        public string $digitalSignature,
        public ?array $metadata = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            clinicId: (int) $data['clinic_id'],
            doctorProfileId: (int) $data['doctor_profile_id'],
            serviceId: (int) $data['service_id'],
            appointmentDate: (string) $data['appointment_date'],
            startTime: (string) $data['start_time'],
            firstName: (string) $data['first_name'],
            lastName: (string) $data['last_name'],
            phone: (string) $data['phone'],
            email: isset($data['email']) && is_string($data['email']) ? $data['email'] : null,
            patientNotes: isset($data['patient_notes']) && is_string($data['patient_notes']) ? $data['patient_notes'] : null,
            chiefComplaint: (string) ($data['chief_complaint'] ?? 'General Consultation'),
            painLevel: (int) ($data['pain_level'] ?? 0),
            lastVisit: (string) ($data['last_visit'] ?? 'within_6_months'),
            hasAllergies: (bool) ($data['has_allergies'] ?? false),
            allergyDetails: isset($data['allergy_details']) && is_string($data['allergy_details']) ? $data['allergy_details'] : null,
            digitalSignature: (string) ($data['digital_signature'] ?? ''),
            metadata: isset($data['metadata']) && is_array($data['metadata']) ? $data['metadata'] : null,
        );
    }
}
