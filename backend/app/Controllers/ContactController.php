<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\App;
use App\Core\Auth;
use App\Services\ContactService;

/**
 * Admin Controller for Contact Form Entries
 */
class ContactController
{
    public function submissions(): void
    {
        Auth::requirePermission('contact_submissions');

        $statusFilter = trim((string) ($_GET['status'] ?? 'all'));
        $all = ContactService::getAllSubmissions();
        $counts = [
            'all' => count($all),
            'new' => 0,
            'contacted' => 0,
            'resolved' => 0,
        ];
        foreach ($all as $item) {
            $st = $item['status'] ?? 'new';
            if (isset($counts[$st])) {
                $counts[$st]++;
            }
        }

        $filtered = array_values(array_filter($all, static function ($item) use ($statusFilter) {
            if ($statusFilter !== 'all' && ($item['status'] ?? 'new') !== $statusFilter) {
                return false;
            }
            return true;
        }));

        App::render('admin/contact/submissions', [
            'pageTitle' => 'Contact Form Entries',
            'activeNav' => 'contact-submissions',
            'submissions' => $filtered,
            'counts' => $counts,
            'statusFilter' => $statusFilter,
            'forwardingEmails' => ContactService::getForwardingEmails(),
        ]);
    }

    public function updateStatus(string $id): void
    {
        Auth::requirePermission('contact_submissions');
        $status = trim((string) ($_POST['status'] ?? 'contacted'));
        ContactService::updateStatus($id, $status);
        App::flash('success', 'Enquiry status updated.');
        App::redirect('/admin/contact/submissions');
    }

    public function delete(string $id): void
    {
        Auth::requirePermission('contact_submissions');
        ContactService::deleteSubmission($id);
        App::flash('success', 'Contact form entry deleted.');
        App::redirect('/admin/contact/submissions');
    }
}

