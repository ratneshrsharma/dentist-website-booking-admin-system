<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\App;
use App\Core\Auth;
use App\Core\SimplePdf;
use App\Services\InvoiceService;
use App\Services\PatientService;
use App\Services\ServicesService;
use App\Services\ThemeService;
use App\Services\ActivityLogService;

/**
 * Accounts & Invoices Controller (Super Admin, Admin & Accountant ONLY)
 */
class AccountsController
{
    public function index(): void
    {
        Auth::requirePermission('accounts');

        $statusFilter = trim((string) ($_GET['status'] ?? 'all'));
        $search = strtolower(trim((string) ($_GET['q'] ?? '')));
        $all = InvoiceService::getAllInvoices();

        $totalBilled = 0.0;
        $totalPaid = 0.0;
        foreach ($all as $inv) {
            $totalBilled += (float) ($inv['total_amount'] ?? 0);
            $totalPaid += (float) ($inv['paid_amount'] ?? 0);
        }

        $filtered = array_values(array_filter($all, static function ($inv) use ($statusFilter, $search) {
            if ($statusFilter !== 'all' && strcasecmp((string) ($inv['payment_status'] ?? ''), $statusFilter) !== 0) {
                return false;
            }
            if ($search !== '') {
                $hay = strtolower(($inv['invoice_no'] ?? '') . ' ' . ($inv['patient_name'] ?? '') . ' ' . ($inv['patient_phone'] ?? '') . ' ' . ($inv['treatment'] ?? ''));
                if (!str_contains($hay, $search)) {
                    return false;
                }
            }
            return true;
        }));

        App::render('admin/accounts/index', [
            'pageTitle' => 'Accounts & Invoices',
            'activeNav' => 'accounts',
            'invoices' => $filtered,
            'stats' => [
                'count' => count($all),
                'total_billed' => $totalBilled,
                'total_paid' => $totalPaid,
                'balance_due' => max(0, $totalBilled - $totalPaid),
            ],
            'statusFilter' => $statusFilter,
            'search' => $search,
            'patients' => PatientService::getAllPatientsRaw(),
            'services' => ServicesService::getAllServices(true),
        ]);
    }

    public function create(): void
    {
        Auth::requirePermission('accounts');

        $patientKey = trim((string) ($_POST['patient_key'] ?? ''));
        $pName = trim((string) ($_POST['patient_name'] ?? ''));
        $pPhone = trim((string) ($_POST['patient_phone'] ?? ''));
        $pEmail = trim((string) ($_POST['patient_email'] ?? ''));

        if ($patientKey !== '') {
            $p = PatientService::findByKey($patientKey);
            if ($p) {
                $pName = $p['name'] ?? $pName;
                $pPhone = $p['phone'] ?? $pPhone;
                $pEmail = $p['email'] ?? $pEmail;
            }
        }

        $inv = InvoiceService::createInvoice([
            'patient_key' => $patientKey,
            'patient_name' => $pName ?: 'Walk-in Patient',
            'patient_phone' => $pPhone,
            'patient_email' => $pEmail,
            'treatment' => $_POST['treatment'] ?? 'Dental Consultation',
            'total_amount' => $_POST['total_amount'] ?? 0,
            'paid_amount' => $_POST['paid_amount'] ?? 0,
            'payment_method' => $_POST['payment_method'] ?? 'Card',
            'payment_status' => $_POST['payment_status'] ?? 'Paid',
            'invoice_date' => $_POST['invoice_date'] ?? date('Y-m-d'),
            'notes' => $_POST['notes'] ?? '',
        ]);

        ActivityLogService::log('Created invoice ' . $inv['invoice_no'], 'Accounts', 'Success', ['amount' => $inv['total_amount'], 'patient' => $inv['patient_name']]);
        App::flash('success', 'Invoice ' . $inv['invoice_no'] . ' generated.');
        App::redirect('/admin/accounts');
    }

    public function markPaid(string $id): void
    {
        Auth::requirePermission('accounts');
        $inv = InvoiceService::markPaid($id);
        ActivityLogService::log('Marked invoice paid: ' . ($inv['invoice_no'] ?? $id), 'Accounts', 'Success');
        App::flash('success', 'Invoice marked as Paid.');
        App::redirect('/admin/accounts');
    }

    public function delete(string $id): void
    {
        Auth::requirePermission('accounts');
        InvoiceService::deleteInvoice($id);
        ActivityLogService::log('Deleted invoice ' . $id, 'Accounts', 'Warning');
        App::flash('success', 'Invoice deleted.');
        App::redirect('/admin/accounts');
    }

    public function streamPdf(string $id): void
    {
        // Allowed for Accounts OR Patients view
        if (!Auth::can('accounts') && !Auth::can('patients')) {
            Auth::requirePermission('accounts');
        }
        $inv = InvoiceService::findByIdOrNo($id);
        if (!$inv) {
            App::flash('error', 'Invoice not found.');
            App::redirect('/admin/accounts');
        }
        $theme = ThemeService::getTheme();
        SimplePdf::streamInvoicePdf($inv, $theme['branding'] ?? []);
    }

    public function sendEmail(string $id): void
    {
        if (!Auth::can('accounts') && !Auth::can('patients')) {
            Auth::requirePermission('accounts');
        }
        $inv = InvoiceService::findByIdOrNo($id);
        if (!$inv) {
            App::flash('error', 'Invoice not found.');
            App::redirect('/admin/accounts');
        }
        $to = trim((string) ($_POST['email'] ?? ($inv['patient_email'] ?? '')));
        if (!filter_var($to, FILTER_VALIDATE_EMAIL)) {
            App::flash('error', 'No valid patient email address on this invoice.');
            App::redirect('/admin/accounts');
        }

        $theme = ThemeService::getTheme();
        $clinicName = $theme['branding']['clinic_name'] ?? 'Acocks Green Dental Practice';
        $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
        $webUrl = $scheme . '://' . $host . App::url('/billing/invoice/' . $inv['invoice_no']);

        $subject = "{$clinicName} — Invoice {$inv['invoice_no']}";
        $body = "Hello {$inv['patient_name']},\n\n"
            . "Your clinical invoice {$inv['invoice_no']} (£" . number_format((float) $inv['total_amount'], 2) . ", Status: {$inv['payment_status']}) is ready.\n\n"
            . "View & Print Online: {$webUrl}\n"
            . "Password: Enter your registered mobile number.\n\n"
            . "Thank you,\n{$clinicName}";

        @mail($to, $subject, $body, "From: noreply@acocksgreendental.co.uk");
        ActivityLogService::log("Sent invoice {$inv['invoice_no']} to {$to}", 'Accounts', 'Success');
        App::flash('success', "Invoice {$inv['invoice_no']} link & summary sent to {$to}.");
        App::redirect($_POST['return_to'] ?? '/admin/accounts');
    }
}
