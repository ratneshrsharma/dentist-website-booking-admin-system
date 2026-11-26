<?php

declare(strict_types=1);

namespace App\Services;

/**
 * Accounts & Invoices Service (storage/app/invoices.json)
 */
class InvoiceService
{
    private static function getStorageFile(): string
    {
        return dirname(__DIR__, 2) . '/storage/app/invoices.json';
    }

    public static function getAllInvoices(): array
    {
        $file = self::getStorageFile();
        if (file_exists($file)) {
            $data = json_decode((string) file_get_contents($file), true);
            if (is_array($data) && !empty($data)) {
                usort($data, static fn($a, $b) => strtotime((string) ($b['created_at'] ?? '')) <=> strtotime((string) ($a['created_at'] ?? '')));
                return $data;
            }
        }
        $defaults = self::getDefaultInvoices();
        self::saveAllInvoices($defaults);
        return $defaults;
    }

    public static function saveAllInvoices(array $invoices): void
    {
        $file = self::getStorageFile();
        $dir = dirname($file);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        file_put_contents($file, json_encode(array_values($invoices), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public static function findByIdOrNo(string $idOrNo): ?array
    {
        foreach (self::getAllInvoices() as $inv) {
            if (($inv['id'] ?? '') === $idOrNo || ($inv['invoice_no'] ?? '') === $idOrNo) {
                return $inv;
            }
        }
        return null;
    }

    public static function createInvoice(array $input): array
    {
        $invoices = self::getAllInvoices();
        $total = (float) ($input['total_amount'] ?? 0);
        $paid = (float) ($input['paid_amount'] ?? 0);
        $status = $paid >= $total && $total > 0 ? 'Paid' : ($paid > 0 ? 'Partial' : 'Unpaid');
        if (!empty($input['payment_status']) && in_array($input['payment_status'], ['Paid', 'Partial', 'Unpaid'], true)) {
            $status = $input['payment_status'];
            if ($status === 'Paid' && $paid < $total) {
                $paid = $total;
            }
        }

        $invNo = 'INV-' . date('Y') . '-' . random_int(1000, 9999);
        $newInv = [
            'id' => 'inv_' . uniqid(),
            'invoice_no' => $invNo,
            'patient_key' => trim((string) ($input['patient_key'] ?? '')),
            'patient_name' => trim((string) ($input['patient_name'] ?? 'Patient')),
            'patient_phone' => trim((string) ($input['patient_phone'] ?? '')),
            'patient_email' => strtolower(trim((string) ($input['patient_email'] ?? ''))),
            'treatment' => trim((string) ($input['treatment'] ?? 'Dental Consultation')),
            'items' => $input['items'] ?? [
                ['description' => trim((string) ($input['treatment'] ?? 'Dental Consultation')), 'amount' => $total],
            ],
            'total_amount' => $total,
            'paid_amount' => $paid,
            'payment_method' => trim((string) ($input['payment_method'] ?? 'Card')),
            'payment_status' => $status,
            'invoice_date' => trim((string) ($input['invoice_date'] ?? date('Y-m-d'))),
            'notes' => trim((string) ($input['notes'] ?? '')),
            'created_at' => date('c'),
        ];

        array_unshift($invoices, $newInv);
        self::saveAllInvoices($invoices);
        return $newInv;
    }

    public static function markPaid(string $idOrNo): ?array
    {
        $invoices = self::getAllInvoices();
        foreach ($invoices as &$inv) {
            if (($inv['id'] ?? '') === $idOrNo || ($inv['invoice_no'] ?? '') === $idOrNo) {
                $inv['paid_amount'] = (float) ($inv['total_amount'] ?? 0);
                $inv['payment_status'] = 'Paid';
                self::saveAllInvoices($invoices);
                return $inv;
            }
        }
        unset($inv);
        return null;
    }

    public static function deleteInvoice(string $idOrNo): void
    {
        $invoices = array_values(array_filter(
            self::getAllInvoices(),
            static fn($inv) => ($inv['id'] ?? '') !== $idOrNo && ($inv['invoice_no'] ?? '') !== $idOrNo
        ));
        self::saveAllInvoices($invoices);
    }

    public static function verifyMobilePassword(array $invoice, string $enteredMobile): bool
    {
        $enteredDigits = preg_replace('/[^0-9]/', '', $enteredMobile) ?? '';
        $storedDigits = preg_replace('/[^0-9]/', '', (string) ($invoice['patient_phone'] ?? '')) ?? '';
        if ($enteredDigits === '' || $storedDigits === '') {
            return false;
        }
        return $enteredDigits === $storedDigits
            || (strlen($enteredDigits) >= 6 && str_ends_with($storedDigits, substr($enteredDigits, -8)));
    }

    private static function getDefaultInvoices(): array
    {
        return [
            [
                'id' => 'inv_seed_1001',
                'invoice_no' => 'INV-2026-1001',
                'patient_key' => 'PAT_DEMO_001',
                'patient_name' => 'Sarah Jenkins',
                'patient_phone' => '+44 7700 900123',
                'patient_email' => 'sarah.jenkins@example.co.uk',
                'treatment' => 'Dental Hygiene & Airflow Polish',
                'items' => [
                    ['description' => 'Dental Hygiene & Airflow Polish (45 mins)', 'amount' => 65.00],
                ],
                'total_amount' => 65.00,
                'paid_amount' => 65.00,
                'payment_method' => 'Card',
                'payment_status' => 'Paid',
                'invoice_date' => date('Y-m-d', strtotime('-7 days')),
                'notes' => 'Paid at reception desk.',
                'created_at' => date('c', strtotime('-7 days')),
            ],
            [
                'id' => 'inv_seed_1002',
                'invoice_no' => 'INV-2026-1002',
                'patient_key' => 'PAT_DEMO_001',
                'patient_name' => 'Sarah Jenkins',
                'patient_phone' => '+44 7700 900123',
                'patient_email' => 'sarah.jenkins@example.co.uk',
                'treatment' => 'White Tooth Fillings (Composite)',
                'items' => [
                    ['description' => 'White Composite Restoration (UR4)', 'amount' => 95.00],
                ],
                'total_amount' => 95.00,
                'paid_amount' => 45.00,
                'payment_method' => 'Card',
                'payment_status' => 'Partial',
                'invoice_date' => date('Y-m-d'),
                'notes' => 'Deposit £45 paid; £50 remaining.',
                'created_at' => date('c'),
            ],
        ];
    }
}
