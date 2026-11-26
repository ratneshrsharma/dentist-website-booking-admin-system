<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\App;
use App\Core\SimplePdf;
use App\Services\InvoiceService;
use App\Services\ThemeService;

/**
 * Public Patient Invoice Web View (Password-protected by Patient's Mobile Number)
 */
class BillingController
{
    public function showInvoice(string $invoiceNo): void
    {
        App::initSession();
        $invoice = InvoiceService::findByIdOrNo($invoiceNo);
        if (!$invoice) {
            http_response_code(404);
            echo '<h2>Invoice Not Found</h2>';
            exit;
        }

        $verifiedList = $_SESSION['verified_invoices'] ?? [];
        $isVerified = in_array($invoice['invoice_no'], $verifiedList, true);
        $error = null;

        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
            $enteredMobile = trim((string) ($_POST['mobile_password'] ?? ''));
            if (InvoiceService::verifyMobilePassword($invoice, $enteredMobile)) {
                $verifiedList[] = $invoice['invoice_no'];
                $_SESSION['verified_invoices'] = array_values(array_unique($verifiedList));
                $isVerified = true;
            } else {
                $error = 'Mobile number does not match our records for this invoice. Please try again.';
            }
        }

        $theme = ThemeService::getTheme();
        App::render('billing/invoice', [
            'invoice' => $invoice,
            'theme' => $theme,
            'isVerified' => $isVerified,
            'error' => $error,
            'pageTitle' => 'Invoice ' . $invoice['invoice_no'],
        ], false);
    }

    public function downloadPdf(string $invoiceNo): void
    {
        App::initSession();
        $invoice = InvoiceService::findByIdOrNo($invoiceNo);
        if (!$invoice) {
            http_response_code(404);
            exit('Invoice not found');
        }
        $verifiedList = $_SESSION['verified_invoices'] ?? [];
        if (!in_array($invoice['invoice_no'], $verifiedList, true)) {
            App::redirect('/billing/invoice/' . urlencode($invoiceNo));
        }
        $theme = ThemeService::getTheme();
        SimplePdf::streamInvoicePdf($invoice, $theme['branding'] ?? []);
    }
}
