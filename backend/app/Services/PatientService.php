<?php

declare(strict_types=1);

namespace App\Services;

/**
 * Patients Management Service (Keyed by immutable patient_key, linked with Bookings & Invoices)
 */
class PatientService
{
    private static function getStorageFile(): string
    {
        return dirname(__DIR__, 2) . '/storage/app/patients.json';
    }

    public static function getAllPatientsRaw(): array
    {
        $file = self::getStorageFile();
        if (file_exists($file)) {
            $data = json_decode((string) file_get_contents($file), true);
            if (is_array($data) && !empty($data)) {
                return $data;
            }
        }
        $defaults = self::seedFromBookings();
        self::saveAllPatients($defaults);
        return $defaults;
    }

    public static function saveAllPatients(array $patients): void
    {
        $file = self::getStorageFile();
        $dir = dirname($file);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        file_put_contents($file, json_encode(array_values($patients), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public static function normalizePhone(string $phone): string
    {
        return preg_replace('/[^0-9]/', '', $phone) ?? '';
    }

    public static function getAllPatientsEnriched(): array
    {
        $patients = self::getAllPatientsRaw();
        $bookings = BookingService::getAllBookingsRaw();
        $invoices = InvoiceService::getAllInvoices();

        $enriched = [];
        foreach ($patients as $p) {
            $pPhoneNorm = self::normalizePhone((string) ($p['phone'] ?? ''));
            $pEmail = strtolower(trim((string) ($p['email'] ?? '')));
            $pKey = $p['patient_key'] ?? '';

            $matchedBookings = [];
            $visitCount = 0;
            $confirmedCount = 0;
            $rescheduledCount = 0;
            $cancelledCount = 0;

            foreach ($bookings as $b) {
                $bPhone = self::normalizePhone((string) ($b['patient_phone'] ?? ''));
                $bEmail = strtolower(trim((string) ($b['patient_email'] ?? '')));
                $match = ($pPhoneNorm !== '' && $bPhone === $pPhoneNorm)
                    || ($pEmail !== '' && $bEmail === $pEmail)
                    || (strcasecmp((string) ($b['patient_name'] ?? ''), (string) ($p['name'] ?? '')) === 0);
                if ($match) {
                    $matchedBookings[] = $b;
                    $st = strtolower((string) ($b['status'] ?? 'confirmed'));
                    if ($st === 'completed') $visitCount++;
                    elseif ($st === 'confirmed' || $st === 'pending') $confirmedCount++;
                    elseif ($st === 'rescheduled') $rescheduledCount++;
                    elseif ($st === 'cancelled') $cancelledCount++;
                }
            }

            $matchedInvoices = [];
            $totalBilled = 0.0;
            $totalPaid = 0.0;
            foreach ($invoices as $inv) {
                $invPhone = self::normalizePhone((string) ($inv['patient_phone'] ?? ''));
                if (($inv['patient_key'] ?? '') === $pKey || ($pPhoneNorm !== '' && $invPhone === $pPhoneNorm)) {
                    $matchedInvoices[] = $inv;
                    $totalBilled += (float) ($inv['total_amount'] ?? 0);
                    $totalPaid += (float) ($inv['paid_amount'] ?? 0);
                }
            }

            $p['stats'] = [
                'visits_completed' => $visitCount,
                'confirmed' => $confirmedCount,
                'rescheduled' => $rescheduledCount,
                'cancelled' => $cancelledCount,
                'total_appointments' => count($matchedBookings),
                'total_billed' => $totalBilled,
                'total_paid' => $totalPaid,
                'balance_due' => max(0, $totalBilled - $totalPaid),
            ];
            $p['bookings'] = $matchedBookings;
            $p['invoices'] = $matchedInvoices;
            $enriched[] = $p;
        }
        return $enriched;
    }

    public static function findByKey(string $patientKey): ?array
    {
        foreach (self::getAllPatientsEnriched() as $p) {
            if (($p['patient_key'] ?? '') === $patientKey) {
                return $p;
            }
        }
        return null;
    }

    public static function createPatient(array $input): array
    {
        $patients = self::getAllPatientsRaw();
        $newPatient = [
            'patient_key' => 'PAT_' . strtoupper(bin2hex(random_bytes(4))),
            'name' => trim((string) ($input['name'] ?? 'Patient')),
            'phone' => trim((string) ($input['phone'] ?? '')),
            'email' => strtolower(trim((string) ($input['email'] ?? ''))),
            'dob' => trim((string) ($input['dob'] ?? '')),
            'address' => trim((string) ($input['address'] ?? '')),
            'registration_status' => trim((string) ($input['registration_status'] ?? 'new')),
            'clinical_notes' => trim((string) ($input['clinical_notes'] ?? '')),
            'treatment_records' => [],
            'created_at' => date('c'),
            'updated_at' => date('c'),
        ];
        array_unshift($patients, $newPatient);
        self::saveAllPatients($patients);
        return $newPatient;
    }

    public static function updatePatient(string $patientKey, array $input): ?array
    {
        $patients = self::getAllPatientsRaw();
        foreach ($patients as &$p) {
            if (($p['patient_key'] ?? '') === $patientKey) {
                $p['name'] = trim((string) ($input['name'] ?? $p['name']));
                $p['phone'] = trim((string) ($input['phone'] ?? $p['phone']));
                $p['email'] = strtolower(trim((string) ($input['email'] ?? ($p['email'] ?? ''))));
                $p['dob'] = trim((string) ($input['dob'] ?? ($p['dob'] ?? '')));
                $p['address'] = trim((string) ($input['address'] ?? ($p['address'] ?? '')));
                $p['registration_status'] = trim((string) ($input['registration_status'] ?? ($p['registration_status'] ?? 'new')));
                $p['clinical_notes'] = trim((string) ($input['clinical_notes'] ?? ($p['clinical_notes'] ?? '')));
                $p['updated_at'] = date('c');
                self::saveAllPatients($patients);
                return $p;
            }
        }
        unset($p);
        return null;
    }

    public static function addTreatmentRecord(string $patientKey, array $record): void
    {
        $patients = self::getAllPatientsRaw();
        foreach ($patients as &$p) {
            if (($p['patient_key'] ?? '') === $patientKey) {
                $p['treatment_records'][] = [
                    'id' => 'TRT_' . uniqid(),
                    'date' => trim((string) ($record['date'] ?? date('Y-m-d'))),
                    'service' => trim((string) ($record['service'] ?? 'Dental Consultation')),
                    'doctor' => trim((string) ($record['doctor'] ?? 'Dr. Atandrilla Das')),
                    'fee' => (float) ($record['fee'] ?? 0),
                    'notes' => trim((string) ($record['notes'] ?? '')),
                ];
                $p['updated_at'] = date('c');
                self::saveAllPatients($patients);
                return;
            }
        }
        unset($p);
    }

    public static function deletePatient(string $patientKey): void
    {
        $patients = array_values(array_filter(
            self::getAllPatientsRaw(),
            static fn($p) => ($p['patient_key'] ?? '') !== $patientKey
        ));
        self::saveAllPatients($patients);
    }

    private static function seedFromBookings(): array
    {
        $bookings = BookingService::getAllBookingsRaw();
        $seen = [];
        $list = [];
        foreach ($bookings as $b) {
            $phone = trim((string) ($b['patient_phone'] ?? ''));
            $norm = self::normalizePhone($phone);
            if ($norm !== '' && isset($seen[$norm])) continue;
            if ($norm !== '') $seen[$norm] = true;

            $list[] = [
                'patient_key' => 'PAT_' . strtoupper(substr(md5($phone ?: ($b['patient_name'] ?? uniqid())), 0, 8)),
                'name' => $b['patient_name'] ?? 'Patient',
                'phone' => $phone,
                'email' => $b['patient_email'] ?? '',
                'dob' => '',
                'address' => 'Birmingham B27',
                'registration_status' => $b['patient_status'] ?? 'existing',
                'clinical_notes' => 'Seeded from clinical booking roster.',
                'treatment_records' => [
                    [
                        'id' => 'TRT_' . uniqid(),
                        'date' => $b['appointment_date'] ?? date('Y-m-d'),
                        'service' => $b['treatment'] ?? 'Routine Dental Examination',
                        'doctor' => $b['doctor_name'] ?? 'Dr. Atandrilla Das',
                        'fee' => 65.00,
                        'notes' => 'Routine clinical assessment completed.',
                    ],
                ],
                'created_at' => date('c'),
                'updated_at' => date('c'),
            ];
        }
        if (empty($list)) {
            $list[] = [
                'patient_key' => 'PAT_DEMO_001',
                'name' => 'Sarah Jenkins',
                'phone' => '+44 7700 900123',
                'email' => 'sarah.jenkins@example.co.uk',
                'dob' => '1991-04-15',
                'address' => '42 Warwick Road, Birmingham B27 6BH',
                'registration_status' => 'existing',
                'clinical_notes' => 'Routine 6-month Airflow hygiene & check-up patient.',
                'treatment_records' => [
                    [
                        'id' => 'TRT_SEED_1',
                        'date' => date('Y-m-d', strtotime('-14 days')),
                        'service' => 'Dental Hygiene & Airflow Polish',
                        'doctor' => 'Claire, Dental Hygienist',
                        'fee' => 65.00,
                        'notes' => 'Full Airflow warm-water stain removal completed.',
                    ],
                ],
                'created_at' => date('c'),
                'updated_at' => date('c'),
            ];
        }
        return $list;
    }
}
