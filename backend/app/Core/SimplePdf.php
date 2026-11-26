<?php

declare(strict_types=1);

namespace App\Core;

/**
 * Lightweight Pure-PHP PDF 1.4 Generator (Zero dependencies, streams on-the-fly without saving to disk)
 */
class SimplePdf
{
    public static function streamInvoicePdf(array $invoice, array $clinic): void
    {
        $lines = [];
        $clinicName = self::ascii($clinic['clinic_name'] ?? 'Acocks Green Dental Practice');
        $address = self::ascii($clinic['address'] ?? '1078 Warwick Road, Acocks Green, Birmingham B27 6BH');
        $phone = self::ascii($clinic['phone'] ?? '+44 121 765 2870');
        $email = self::ascii($clinic['email'] ?? 'reception@acocksgreendental.co.uk');

        $invNo = self::ascii($invoice['invoice_no'] ?? 'INV-000');
        $invDate = self::ascii($invoice['invoice_date'] ?? date('Y-m-d'));
        $status = strtoupper(self::ascii($invoice['payment_status'] ?? 'PAID'));
        $method = self::ascii($invoice['payment_method'] ?? 'Card');
        $pName = self::ascii($invoice['patient_name'] ?? 'Patient');
        $pPhone = self::ascii($invoice['patient_phone'] ?? '');
        $pEmail = self::ascii($invoice['patient_email'] ?? '');

        // Build PDF content stream
        $stream = "BT\n";
        // Header bar text
        $stream .= "/F2 18 Tf 50 770 Td ({$clinicName}) Tj\n";
        $stream .= "/F1 9 Tf 0 -16 Td ({$address} | Tel: {$phone} | {$email}) Tj\n";
        $stream .= "/F2 14 Tf 0 -32 Td (CLINICAL INVOICE: {$invNo}) Tj\n";
        $stream .= "/F1 10 Tf 0 -18 Td (Invoice Date: {$invDate}    |    Payment Status: {$status}    |    Method: {$method}) Tj\n";

        $stream .= "/F2 11 Tf 0 -28 Td (BILLED TO PATIENT:) Tj\n";
        $stream .= "/F1 10 Tf 0 -16 Td (Name: {$pName}) Tj\n";
        $stream .= "0 -14 Td (Phone: {$pPhone}    Email: {$pEmail}) Tj\n";

        $stream .= "/F2 11 Tf 0 -28 Td (TREATMENT & SERVICE ITEMS:) Tj\n";
        $stream .= "/F1 10 Tf 0 -16 Td (--------------------------------------------------------------------------------------------) Tj\n";

        $items = $invoice['items'] ?? [
            ['description' => ($invoice['treatment'] ?? 'Dental Consultation'), 'amount' => (float) ($invoice['total_amount'] ?? 0)]
        ];
        foreach ($items as $it) {
            $desc = self::ascii(substr((string) ($it['description'] ?? 'Treatment'), 0, 62));
            $amt = 'GBP ' . number_format((float) ($it['amount'] ?? 0), 2);
            $stream .= "0 -16 Td ({$desc}  -  {$amt}) Tj\n";
        }

        $stream .= "0 -16 Td (--------------------------------------------------------------------------------------------) Tj\n";
        $total = 'GBP ' . number_format((float) ($invoice['total_amount'] ?? 0), 2);
        $paid = 'GBP ' . number_format((float) ($invoice['paid_amount'] ?? 0), 2);
        $bal = 'GBP ' . number_format(max(0, (float) ($invoice['total_amount'] ?? 0) - (float) ($invoice['paid_amount'] ?? 0)), 2);

        $stream .= "/F2 11 Tf 0 -20 Td (Total Amount: {$total}) Tj\n";
        $stream .= "/F1 10 Tf 0 -16 Td (Amount Paid:  {$paid}) Tj\n";
        $stream .= "0 -16 Td (Balance Due:  {$bal}) Tj\n";

        if (!empty($invoice['notes'])) {
            $notes = self::ascii(substr((string) $invoice['notes'], 0, 90));
            $stream .= "0 -26 Td (Notes: {$notes}) Tj\n";
        }

        $stream .= "/F1 9 Tf 0 -36 Td (Thank you for choosing {$clinicName}. Generated live on demand.) Tj\n";
        $stream .= "ET";

        // Assemble minimal valid PDF 1.4
        $objs = [];
        $objs[] = "1 0 obj << /Type /Catalog /Pages 2 0 R >> endobj\n";
        $objs[] = "2 0 obj << /Type /Pages /Kids [3 0 R] /Count 1 >> endobj\n";
        $objs[] = "3 0 obj << /Type /Page /Parent 2 0 R /MediaBox [0 0 595 842] /Contents 4 0 R /Resources << /Font << /F1 5 0 R /F2 6 0 R >> >> >> endobj\n";
        $objs[] = "4 0 obj << /Length " . strlen($stream) . " >> stream\n{$stream}\nendstream endobj\n";
        $objs[] = "5 0 obj << /Type /Font /Subtype /Type1 /BaseFont /Helvetica >> endobj\n";
        $objs[] = "6 0 obj << /Type /Font /Subtype /Type1 /BaseFont /Helvetica-Bold >> endobj\n";

        $pdf = "%PDF-1.4\n";
        $offsets = [0];
        foreach ($objs as $o) {
            $offsets[] = strlen($pdf);
            $pdf .= $o;
        }
        $xrefPos = strlen($pdf);
        $pdf .= "xref\n0 " . (count($objs) + 1) . "\n0000000000 65535 f \n";
        for ($i = 1; $i <= count($objs); $i++) {
            $pdf .= sprintf("%010d 00000 n \n", $offsets[$i]);
        }
        $pdf .= "trailer << /Size " . (count($objs) + 1) . " /Root 1 0 R >>\nstartxref\n{$xrefPos}\n%%EOF";

        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="' . $invNo . '.pdf"');
        header('Content-Length: ' . strlen($pdf));
        header('Cache-Control: no-store, no-cache, must-revalidate');
        echo $pdf;
        exit;
    }

    private static function ascii(string $s): string
    {
        $s = str_replace(['£', '–', '—', '’', '“', '”'], ['GBP ', '-', '-', "'", '"', '"'], $s);
        $s = preg_replace('/[^\x20-\x7E]/', '', $s) ?? '';
        return str_replace(['\\', '(', ')'], ['\\\\', '\\(', '\\)'], $s);
    }
}
