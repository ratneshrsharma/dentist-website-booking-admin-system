<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\DTOs\AppointmentBookingDTO;
use Illuminate\Foundation\Http\FormRequest;

final class StoreAppointmentBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Public booking wizard allows unauthenticated patient submissions
        return true;
    }

    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            // Step 1: Branch and Service Selection
            'clinic_id' => ['required', 'integer', 'exists:clinics,id'],
            'service_id' => ['required', 'integer', 'exists:services,id'],

            // Step 2: Doctor and Slot Selection
            'doctor_profile_id' => ['required', 'integer', 'exists:doctor_profiles,id'],
            'appointment_date' => ['required', 'date_format:Y-m-d', 'after_or_equal:today'],
            'start_time' => ['required', 'date_format:H:i'],

            // Step 3: Patient Demographic Intake
            'first_name' => ['required', 'string', 'min:2', 'max:100'],
            'last_name' => ['required', 'string', 'min:2', 'max:100'],
            'phone' => ['required', 'string', 'min:7', 'max:30'],
            'email' => ['nullable', 'email:rfc,dns', 'max:191'],
            'patient_notes' => ['nullable', 'string', 'max:1000'],

            // Step 4: Medical Intake Questionnaire & Disclosures
            'chief_complaint' => ['required', 'string', 'min:3', 'max:1000'],
            'pain_level' => ['required', 'integer', 'min:0', 'max:10'],
            'last_visit' => ['required', 'string', 'in:within_6_months,6_to_12_months,more_than_one_year,never'],
            'has_allergies' => ['required', 'boolean'],
            'allergy_details' => ['nullable', 'required_if:has_allergies,true', 'string', 'max:500'],

            // Step 5: Digital Signature & Consent
            'digital_signature' => ['required', 'string', 'min:2', 'max:100'],
        ];
    }

    /**
     * Sanitize and map validated request data directly into typed readonly DTO.
     */
    public function toDTO(): AppointmentBookingDTO
    {
        $validated = $this->validated();

        return new AppointmentBookingDTO(
            clinicId: (int) $validated['clinic_id'],
            doctorProfileId: (int) $validated['doctor_profile_id'],
            serviceId: (int) $validated['service_id'],
            appointmentDate: (string) $validated['appointment_date'],
            startTime: (string) $validated['start_time'],
            firstName: trim(strip_tags((string) $validated['first_name'])),
            lastName: trim(strip_tags((string) $validated['last_name'])),
            phone: trim((string) $validated['phone']),
            email: isset($validated['email']) ? trim((string) $validated['email']) : null,
            patientNotes: isset($validated['patient_notes']) ? trim(strip_tags((string) $validated['patient_notes'])) : null,
            chiefComplaint: trim(strip_tags((string) $validated['chief_complaint'])),
            painLevel: (int) $validated['pain_level'],
            lastVisit: (string) $validated['last_visit'],
            hasAllergies: (bool) $validated['has_allergies'],
            allergyDetails: isset($validated['allergy_details']) ? trim(strip_tags((string) $validated['allergy_details'])) : null,
            digitalSignature: trim(strip_tags((string) $validated['digital_signature'])),
        );
    }
}
