<?php

declare(strict_types=1);

namespace App\Services;

/**
 * Contact Form Submissions Storage & Comma-Separated Email Forwarding Service
 */
class ContactService
{
    private static function getStorageFile(): string
    {
        return dirname(__DIR__, 2) . '/storage/app/contact_submissions.json';
    }

    public static function getAllSubmissions(): array
    {
        $file = self::getStorageFile();
        if (file_exists($file)) {
            $data = json_decode((string) file_get_contents($file), true);
            if (is_array($data)) {
                usort($data, static function ($a, $b) {
                    return strtotime((string) ($b['created_at'] ?? '')) <=> strtotime((string) ($a['created_at'] ?? ''));
                });
                return $data;
            }
        }
        return [];
    }

    public static function saveSubmissions(array $items): void
    {
        $file = self::getStorageFile();
        $dir = dirname($file);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        file_put_contents($file, json_encode(array_values($items), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public static function getForwardingEmails(): array
    {
        $theme = ThemeService::getTheme();
        $branding = $theme['branding'] ?? [];
        $raw = trim((string) ($branding['contact_forward_emails'] ?? ($branding['form_email'] ?? '')));
        if ($raw === '') {
            return [];
        }
        $emails = [];
        foreach (explode(',', $raw) as $part) {
            $email = trim($part);
            if ($email !== '' && filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emails[] = $email;
            }
        }
        return array_values(array_unique($emails));
    }

    public static function createSubmission(array $input): array
    {
        $items = self::getAllSubmissions();
        $forwardEmails = self::getForwardingEmails();

        $patientStatus = (string) ($input['patient_status'] ?? 'new');
        if (!in_array($patientStatus, ['new', 'existing', 'emergency'], true)) {
            $patientStatus = 'new';
        }

        $entry = [
            'id' => 'enq_' . uniqid(),
            'reference' => 'ENQ-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4)),
            'patient_status' => $patientStatus,
            'full_name' => trim((string) ($input['full_name'] ?? '')),
            'phone' => trim((string) ($input['phone'] ?? '')),
            'email' => trim((string) ($input['email'] ?? '')),
            'service_required' => trim((string) ($input['service_required'] ?? 'General Practice Enquiry')),
            'preferred_time' => trim((string) ($input['preferred_time'] ?? 'morning')),
            'comm_method' => trim((string) ($input['comm_method'] ?? 'phone')),
            'message' => trim((string) ($input['message'] ?? '')),
            'gdpr_consent' => !empty($input['gdpr_consent']),
            'status' => 'new',
            'forwarded_to' => $forwardEmails,
            'email_sent' => false,
            'created_at' => date('c'),
        ];

        // Forward to configured comma-separated emails
        if (!empty($forwardEmails)) {
            $subject = '[' . $entry['reference'] . '] New Contact Enquiry: ' . $entry['full_name'];
            $body = "New Contact Form Submission\n"
                . "Reference: {$entry['reference']}\n"
                . "Patient Status: {$entry['patient_status']}\n"
                . "Name: {$entry['full_name']}\n"
                . "Phone: {$entry['phone']}\n"
                . "Email: {$entry['email']}\n"
                . "Service: {$entry['service_required']}\n"
                . "Preferred Time: {$entry['preferred_time']}\n"
                . "Preferred Contact: {$entry['comm_method']}\n\n"
                . "Message:\n{$entry['message']}\n";
            $headers = "From: noreply@acocksgreendental.co.uk\r\nReply-To: " . ($entry['email'] ?: 'noreply@acocksgreendental.co.uk');
            $sentAny = false;
            foreach ($forwardEmails as $to) {
                if (@mail($to, $subject, $body, $headers)) {
                    $sentAny = true;
                }
            }
            $entry['email_sent'] = $sentAny;
        }

        array_unshift($items, $entry);
        self::saveSubmissions($items);
        return $entry;
    }

    public static function updateStatus(string $id, string $status): void
    {
        if (!in_array($status, ['new', 'contacted', 'resolved'], true)) {
            return;
        }
        $items = self::getAllSubmissions();
        foreach ($items as &$item) {
            if (($item['id'] ?? '') === $id) {
                $item['status'] = $status;
                break;
            }
        }
        unset($item);
        self::saveSubmissions($items);
    }

    public static function deleteSubmission(string $id): void
    {
        $items = array_values(array_filter(
            self::getAllSubmissions(),
            static fn($item) => ($item['id'] ?? '') !== $id
        ));
        self::saveSubmissions($items);
    }
}
