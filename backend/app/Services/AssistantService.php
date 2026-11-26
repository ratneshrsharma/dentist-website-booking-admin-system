<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\App;

/**
 * DB/CMS-Grounded Smart Dental Assistant (Zero external AI key required)
 * Answers from ServicesService, BookingService, ThemeService, CmsService, BlogService
 * and performs live slot checking, appointment booking, WhatsApp location sharing,
 * email detail dispatch, doctor profile lookup, and blog article sharing.
 */
class AssistantService
{
    public static function handleRequest(array $payload): array
    {
        $sessionId = trim((string) ($payload['session_id'] ?? ''));
        if ($sessionId === '') {
            $sessionId = 'chat_' . uniqid();
        }

        $action = trim((string) ($payload['action'] ?? 'message'));
        $visitorName = trim((string) ($payload['visitor_name'] ?? ''));
        $phone = trim((string) ($payload['phone'] ?? ''));
        $serviceInterest = trim((string) ($payload['service_interest'] ?? ''));

        $session = ChatLogService::upsertSession($sessionId, [
            'visitor_name' => $visitorName,
            'phone' => $phone,
            'service_interest' => $serviceInterest,
        ]);

        // 1. START SESSION WITH LEAD CAPTURE
        if ($action === 'start') {
            $name = $session['visitor_name'] ?: 'there';
            $svcName = $session['service_interest'] ?: 'Dental Care';
            $matchedSvc = self::findMatchingService($svcName);

            $greeting = "Hello {$name}! Welcome to Acocks Green Dental Practice. ";
            if ($matchedSvc) {
                $price = $matchedSvc['starting_price'] ?? 'Contact for pricing';
                $dur = $matchedSvc['duration'] ?? '30 mins';
                $greeting .= "I see you're interested in **{$matchedSvc['title']}** ({$price}, {$dur}). "
                    . ($matchedSvc['description'] ?? '')
                    . "\n\nHow can I help you today? You can ask about doctors, treatment pricing, blog guides, location on WhatsApp, or book an appointment.";
            } else {
                $greeting .= "I can help you with treatment pricing, doctor profiles, NHS & private guides, opening hours, or booking an appointment directly.";
            }

            $session = ChatLogService::appendMessage($sessionId, 'assistant', $greeting);

            return [
                'success' => true,
                'session_id' => $sessionId,
                'reply' => $greeting,
                'quick_replies' => [
                    'Check Available Slots',
                    'Book Appointment',
                    'Treatment Pricing',
                    'Our Dentists',
                    'Location on WhatsApp',
                ],
                'messages' => $session['messages'],
            ];
        }

        // 2. CHECK LIVE DOCTOR SLOTS
        if ($action === 'slots') {
            $doctorId = (int) ($payload['doctor_id'] ?? 1);
            $date = trim((string) ($payload['date'] ?? date('Y-m-d', strtotime('+1 day'))));
            $slots = BookingService::getAvailableSlots($doctorId, $date);
            $available = array_values(array_filter($slots, static fn($s) => !empty($s['available'])));
            $doctors = BookingService::getDefaultDoctors();

            return [
                'success' => true,
                'session_id' => $sessionId,
                'date' => $date,
                'doctor_id' => $doctorId,
                'doctors' => $doctors,
                'slots' => array_slice($available, 0, 12),
            ];
        }

        // 3. SEND CLINIC & TREATMENT DETAILS TO EMAIL
        if ($action === 'send_email') {
            $targetEmail = trim((string) ($payload['email'] ?? ''));
            if (!filter_var($targetEmail, FILTER_VALIDATE_EMAIL)) {
                return ['success' => false, 'message' => 'Please enter a valid email address.'];
            }
            $confirm = self::dispatchDetailsEmail($targetEmail, $session);
            ChatLogService::appendMessage($sessionId, 'user', "Send clinic & treatment details to {$targetEmail}");
            $session = ChatLogService::appendMessage($sessionId, 'assistant', $confirm);

            return [
                'success' => true,
                'session_id' => $sessionId,
                'reply' => $confirm,
                'quick_replies' => ['Book Appointment', 'Location on WhatsApp', 'Our Dentists'],
                'messages' => $session['messages'],
            ];
        }

        // 4. CREATE LIVE BOOKING FROM CHAT
        if ($action === 'book') {
            $doctorId = (int) ($payload['doctor_id'] ?? 1);
            $date = trim((string) ($payload['date'] ?? date('Y-m-d', strtotime('+1 day'))));
            $timeSlot = trim((string) ($payload['time_slot'] ?? '09:30'));
            $treatment = trim((string) ($payload['treatment'] ?? ($session['service_interest'] ?: 'Routine Dental Examination')));
            $patientStatus = trim((string) ($payload['patient_status'] ?? 'new'));

            $booking = BookingService::createBooking([
                'patient_name' => $session['visitor_name'] ?: ($visitorName ?: 'Patient Guest'),
                'patient_phone' => $session['phone'] ?: ($phone ?: '+44 7700 900000'),
                'patient_email' => trim((string) ($payload['email'] ?? '')),
                'doctor_id' => $doctorId,
                'treatment' => $treatment,
                'appointment_date' => $date,
                'appointment_time' => $timeSlot,
                'patient_status' => $patientStatus,
                'source' => 'Smart Dental Assistant',
            ]);

            $ref = $booking['reference'] ?? ('BKG-' . date('Y'));
            $docName = $booking['doctor_name'] ?? 'our clinician';
            $confirmText = "Your appointment is confirmed!\n"
                . "• Reference: **{$ref}**\n"
                . "• Treatment: {$treatment}\n"
                . "• Clinician: {$docName}\n"
                . "• Date & Time: {$date} at {$timeSlot}\n\n"
                . "Our reception team has received your booking.";

            $waUrl = $booking['whatsapp_url'] ?? '';
            $meta = [
                'booking_reference' => $ref,
                'whatsapp_url' => $waUrl,
            ];
            if ($waUrl !== '') {
                $meta['action_links'] = [
                    ['label' => 'Send Booking Pass on WhatsApp', 'url' => $waUrl, 'external' => true],
                ];
            }

            ChatLogService::appendMessage($sessionId, 'user', "Please book {$treatment} on {$date} at {$timeSlot}.");
            $session = ChatLogService::appendMessage($sessionId, 'assistant', $confirmText, $meta);

            return [
                'success' => true,
                'session_id' => $sessionId,
                'reply' => $confirmText,
                'booking_created' => $booking,
                'quick_replies' => ['Location on WhatsApp', 'Treatment Pricing'],
                'messages' => $session['messages'],
            ];
        }

        // 5. STANDARD USER MESSAGE -> DB/CMS INTENT MATCHING
        $userText = trim((string) ($payload['message'] ?? ''));
        if ($userText === '') {
            return ['success' => false, 'message' => 'Message cannot be empty.'];
        }

        ChatLogService::appendMessage($sessionId, 'user', $userText);
        $analysis = self::generateDbReply($userText, $session);
        $session = ChatLogService::appendMessage($sessionId, 'assistant', $analysis['reply'], $analysis['meta'] ?? []);

        return [
            'success' => true,
            'session_id' => $sessionId,
            'reply' => $analysis['reply'],
            'show_booking_picker' => !empty($analysis['show_booking_picker']),
            'show_email_input' => !empty($analysis['show_email_input']),
            'preferred_doctor_id' => $analysis['preferred_doctor_id'] ?? null,
            'doctors' => !empty($analysis['show_booking_picker']) ? BookingService::getDefaultDoctors() : [],
            'quick_replies' => $analysis['quick_replies'],
            'messages' => $session['messages'],
        ];
    }

    private static function generateDbReply(string $userText, array $session): array
    {
        $q = strtolower($userText);
        $theme = ThemeService::getTheme();
        $branding = $theme['branding'] ?? [];
        $phone = $branding['phone'] ?? '+44 121 765 2870';
        $waRaw = preg_replace('/[^0-9]/', '', (string) ($branding['whatsapp'] ?? '+441217652870')) ?: '441217652870';
        $address = $branding['address'] ?? '1078 Warwick Road, Acocks Green, Birmingham B27 6BH';
        $mapsUrl = 'https://maps.google.com/?q=' . urlencode($address);

        // A. Direct email address detected in message -> send details immediately
        if (preg_match('/[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}/i', $userText, $emMatch)) {
            $email = $emMatch[0];
            $confirm = self::dispatchDetailsEmail($email, $session);
            return [
                'reply' => $confirm,
                'quick_replies' => ['Book Appointment', 'Location on WhatsApp', 'Our Dentists'],
            ];
        }

        // B. Email details request ("send me details on email")
        if (str_contains($q, 'email') && (str_contains($q, 'send') || str_contains($q, 'detail') || str_contains($q, 'info') || str_contains($q, 'share') || str_contains($q, 'me'))) {
            return [
                'reply' => "I'd be happy to email you our clinic details, opening hours, and information about **" . ($session['service_interest'] ?: 'our treatments') . "**.\n\nPlease enter your email address below:",
                'show_email_input' => true,
                'quick_replies' => ['Location on WhatsApp', 'Book Appointment'],
            ];
        }

        // C. Location on WhatsApp ("send me location on whatsapp")
        if ((str_contains($q, 'whatsapp') && (str_contains($q, 'location') || str_contains($q, 'address') || str_contains($q, 'map') || str_contains($q, 'direction')))
            || (str_contains($q, 'location') && str_contains($q, 'send'))
        ) {
            $waText = "Acocks Green Dental Practice Location:\n{$address}\nGoogle Maps: {$mapsUrl}\nPhone: {$phone}";
            $waUrl = "https://wa.me/{$waRaw}?text=" . rawurlencode($waText);
            return [
                'reply' => "**Acocks Green Dental Practice Location**\n"
                    . "• Address: {$address}\n"
                    . "• Free on-site rear patient parking & step-free ground-floor access.\n\nTap below to open our location in WhatsApp or Google Maps:",
                'meta' => [
                    'action_links' => [
                        ['label' => 'Send Location on WhatsApp', 'url' => $waUrl, 'external' => true],
                        ['label' => 'Open Google Maps', 'url' => $mapsUrl, 'external' => true],
                    ],
                ],
                'quick_replies' => ['Book Appointment', 'Opening Hours', 'Email Clinic Details'],
            ];
        }

        // D. Specific Doctor Profile lookup (e.g. "I want to know about Dr. Atandrilla Das")
        $matchedDoctor = self::findMatchingDoctor($userText);
        if ($matchedDoctor) {
            $reply = "**{$matchedDoctor['name']}**\n"
                . "• Role: " . ($matchedDoctor['title'] ?? $matchedDoctor['role'] ?? 'Dental Clinician') . "\n"
                . (!empty($matchedDoctor['badge']) ? "• Specialty: {$matchedDoctor['badge']}\n" : '')
                . (!empty($matchedDoctor['bio']) ? "\n{$matchedDoctor['bio']}\n" : '')
                . "\nWould you like to book an appointment with **{$matchedDoctor['name']}**?";

            $docId = (int) ($matchedDoctor['id'] ?? 1);
            $bookingTriggers = str_contains($q, 'book') || str_contains($q, 'slot') || str_contains($q, 'appointment');
            return [
                'reply' => $reply,
                'show_booking_picker' => $bookingTriggers,
                'preferred_doctor_id' => $docId,
                'quick_replies' => ["Book with {$matchedDoctor['name']}", 'Our Dentists', 'Treatment Pricing'],
            ];
        }

        // E. Blog Post / Patient Guide lookup (e.g. "give me details for NHS vs Private Dental Care (share blog post link)")
        $matchedBlog = self::findMatchingBlogPost($userText);
        if ($matchedBlog && (str_contains($q, 'blog') || str_contains($q, 'post') || str_contains($q, 'article') || str_contains($q, 'guide') || str_contains($q, 'link') || str_contains($q, 'nhs') || $matchedBlog['score'] >= 2)) {
            $post = $matchedBlog['post'];
            $postUrl = App::url('/blog/' . $post['slug'] . '/');
            $reply = "**{$post['title']}**\n"
                . "• By {$post['author']} • {$post['read_time']}\n\n"
                . ($post['excerpt'] ?? '')
                . "\n\nClick below to read the full guide on our website:";
            return [
                'reply' => $reply,
                'meta' => [
                    'action_links' => [
                        ['label' => 'Read Full Guide →', 'url' => $postUrl, 'external' => false],
                    ],
                ],
                'quick_replies' => ['Book Appointment', 'Treatment Pricing', 'Location on WhatsApp'],
            ];
        }

        // F. Booking / Slots intent
        if (str_contains($q, 'book') || str_contains($q, 'slot') || str_contains($q, 'appointment') || str_contains($q, 'schedule')) {
            $svc = $session['service_interest'] ?: 'Routine Dental Examination';
            return [
                'reply' => "I can book **{$svc}** for you right now! Choose your preferred clinician, date, and available time slot below:",
                'show_booking_picker' => true,
                'quick_replies' => ['Treatment Pricing', 'Location on WhatsApp'],
            ];
        }

        // G. Emergency intent
        if (str_contains($q, 'emergenc') || str_contains($q, 'pain') || str_contains($q, 'toothache') || str_contains($q, 'swelling') || str_contains($q, 'urgent')) {
            return [
                'reply' => "For acute toothache, swelling, or dental trauma, we reserve **Same-Day Emergency Triage Slots**.\n"
                    . "• Emergency Triage Line: **{$phone}** (call before 10:00 AM for priority same-day care)\n"
                    . "• Emergency Triage Fee: From £50.00\n\nWould you like to check available slots?",
                'show_booking_picker' => true,
                'quick_replies' => ['Check Available Slots', 'Location on WhatsApp'],
            ];
        }

        // H. Opening hours / Location / Parking intent
        if (str_contains($q, 'hour') || str_contains($q, 'open') || str_contains($q, 'time') || str_contains($q, 'address') || str_contains($q, 'where') || str_contains($q, 'location') || str_contains($q, 'parking')) {
            $waText = "Acocks Green Dental Practice:\n{$address}\nGoogle Maps: {$mapsUrl}";
            $waUrl = "https://wa.me/{$waRaw}?text=" . rawurlencode($waText);
            return [
                'reply' => "**Acocks Green Dental Practice**\n"
                    . "• Address: {$address}\n"
                    . "• Phone: {$phone}\n"
                    . "• Mon–Thu: 8:30 AM – 5:30 PM | Fri: 8:30 AM – 5:00 PM | Sat–Sun: Emergency Triage On-Call\n"
                    . "• Free on-site rear patient parking & step-free ground-floor access.",
                'meta' => [
                    'action_links' => [
                        ['label' => 'Send Location on WhatsApp', 'url' => $waUrl, 'external' => true],
                    ],
                ],
                'quick_replies' => ['Book Appointment', 'Treatment Pricing', 'Our Dentists'],
            ];
        }

        // I. Doctors / Team list intent
        if (str_contains($q, 'doctor') || str_contains($q, 'dentist') || str_contains($q, 'team') || str_contains($q, 'clinician') || str_contains($q, 'hygienist')) {
            $doctors = self::getAllCliniciansWithBios();
            $lines = ["Our GDC-registered clinical team:"];
            foreach ($doctors as $d) {
                $role = $d['title'] ?? $d['role'] ?? 'Clinician';
                $lines[] = "• **{$d['name']}** — {$role}";
            }
            return [
                'reply' => implode("\n", $lines) . "\n\nAsk about any doctor by name (e.g. *Dr. Atandrilla Das*) or book below.",
                'quick_replies' => ['Dr. Atandrilla Das', 'Book Appointment', 'Treatment Pricing'],
            ];
        }

        // J. Specific treatment match
        $matchedSvc = self::findMatchingService($userText);
        if ($matchedSvc) {
            $price = $matchedSvc['starting_price'] ?? 'Contact clinic';
            $dur = $matchedSvc['duration'] ?? '30 mins';
            $reply = "**{$matchedSvc['title']}**\n"
                . "• Price: {$price} | Duration: {$dur}\n"
                . "• Overview: " . ($matchedSvc['description'] ?? '') . "\n";
            if (!empty($matchedSvc['faqs'][0])) {
                $faq = $matchedSvc['faqs'][0];
                $reply .= "\n*FAQ — {$faq['question']}*\n{$faq['answer']}";
            }
            return [
                'reply' => $reply,
                'meta' => [
                    'action_links' => [
                        ['label' => 'View Treatment Page →', 'url' => App::url('/treatments/' . ($matchedSvc['slug'] ?? '') . '/'), 'external' => false],
                    ],
                ],
                'quick_replies' => ['Book Appointment', 'Email Clinic Details', 'Location on WhatsApp'],
            ];
        }

        // K. Pricing / Treatments list intent
        if (str_contains($q, 'price') || str_contains($q, 'cost') || str_contains($q, 'fee') || str_contains($q, 'nhs') || str_contains($q, 'treatment') || str_contains($q, 'service')) {
            $services = ServicesService::getAllServices(true);
            $lines = ["Here are our current treatments & starting prices (NHS & Private):"];
            foreach (array_slice($services, 0, 8) as $s) {
                $lines[] = "• **{$s['title']}** — {$s['starting_price']} ({$s['duration']})";
            }
            $lines[] = "\nNHS Band 1: £26.80 | Band 2: £73.50 | Band 3: £319.10.";
            return [
                'reply' => implode("\n", $lines),
                'quick_replies' => ['Book Appointment', 'Email Clinic Details', 'Location on WhatsApp'],
            ];
        }

        // L. Fallback helpful response from DB
        return [
            'reply' => "Thank you for your message! I can share live information from our clinic database on:\n"
                . "• Doctor Profiles (e.g. *Dr. Atandrilla Das*)\n"
                . "• Treatments, NHS/Private Pricing & Blog Guides\n"
                . "• Available Doctor Slots & Instant Booking\n"
                . "• Sending Location on WhatsApp or Details via Email\n\nTap an option below or ask your question.",
            'quick_replies' => ['Book Appointment', 'Our Dentists', 'Location on WhatsApp', 'Email Clinic Details'],
        ];
    }

    private static function dispatchDetailsEmail(string $targetEmail, array $session): string
    {
        $theme = ThemeService::getTheme();
        $branding = $theme['branding'] ?? [];
        $clinicName = $branding['clinic_name'] ?? 'Acocks Green Dental Practice';
        $phone = $branding['phone'] ?? '+44 121 765 2870';
        $address = $branding['address'] ?? '1078 Warwick Road, Acocks Green, Birmingham B27 6BH';
        $svcName = $session['service_interest'] ?: 'General Dental Care';
        $matchedSvc = self::findMatchingService($svcName);

        $subject = "{$clinicName} — Treatment & Practice Information";
        $body = "Hello " . ($session['visitor_name'] ?: 'Patient') . ",\n\n"
            . "Thank you for chatting with {$clinicName}.\n\n"
            . "Practice Address: {$address}\n"
            . "Telephone / Emergency Triage: {$phone}\n"
            . "Opening Hours: Mon–Thu 8:30 AM – 5:30 PM | Fri 8:30 AM – 5:00 PM\n\n";
        if ($matchedSvc) {
            $body .= "Requested Treatment: {$matchedSvc['title']}\n"
                . "Starting Price: " . ($matchedSvc['starting_price'] ?? '') . "\n"
                . "Duration: " . ($matchedSvc['duration'] ?? '') . "\n"
                . "Details: " . ($matchedSvc['description'] ?? '') . "\n\n";
        }
        $body .= "Book online anytime or reply to this email for assistance.\n";

        @mail($targetEmail, $subject, $body, "From: noreply@acocksgreendental.co.uk");

        return "I've sent our practice details, opening hours, and **{$svcName}** information to **{$targetEmail}**!\n\nIs there anything else I can help you with?";
    }

    private static function getAllCliniciansWithBios(): array
    {
        $home = CmsService::getHomePageData();
        $cmsDocs = array_merge($home['clinicians'] ?? [], $home['support_team'] ?? []);
        if (!empty($cmsDocs)) {
            return $cmsDocs;
        }
        return BookingService::getDefaultDoctors();
    }

    private static function findMatchingDoctor(string $query): ?array
    {
        $q = strtolower(trim($query));
        if ($q === '') return null;
        $docs = self::getAllCliniciansWithBios();
        foreach ($docs as $d) {
            $name = strtolower((string) ($d['name'] ?? ''));
            if ($name === '') continue;
            if (str_contains($q, $name)) {
                return $d;
            }
            $cleanParts = array_filter(explode(' ', preg_replace('/[^a-z\s]/', '', $name) ?? ''));
            foreach ($cleanParts as $part) {
                if (strlen($part) >= 3 && $part !== 'dr' && str_contains($q, $part)) {
                    return $d;
                }
            }
        }
        return null;
    }

    private static function findMatchingBlogPost(string $query): ?array
    {
        $q = strtolower(trim($query));
        if ($q === '') return null;
        $stopWords = ['give', 'details', 'detail', 'for', 'the', 'and', 'share', 'blog', 'post', 'link', 'view', 'read', 'about', 'want', 'know', 'could', 'you', 'send', 'this', 'that', 'with', 'from'];
        $words = array_filter(explode(' ', preg_replace('/[^a-z0-9\s]/', ' ', $q) ?? ''), static function ($w) use ($stopWords) {
            return strlen($w) >= 3 && !in_array($w, $stopWords, true);
        });
        if (empty($words)) return null;

        $best = null;
        $bestScore = 0;
        foreach (BlogService::getAllPosts(true) as $post) {
            $hay = strtolower(($post['title'] ?? '') . ' ' . ($post['excerpt'] ?? ''));
            $score = 0;
            foreach ($words as $w) {
                if (str_contains($hay, $w)) {
                    $score++;
                }
            }
            if ($score > $bestScore) {
                $bestScore = $score;
                $best = $post;
            }
        }
        if ($best && $bestScore >= 2) {
            return ['post' => $best, 'score' => $bestScore];
        }
        return null;
    }

    private static function findMatchingService(string $query): ?array
    {
        $q = strtolower(trim($query));
        if ($q === '') {
            return null;
        }
        $services = ServicesService::getAllServices(true);

        // Pass 1: Exact or full-title match across all services
        foreach ($services as $s) {
            $title = strtolower((string) ($s['title'] ?? ''));
            if ($title !== '' && ($title === $q || str_contains($q, $title) || str_contains($title, $q))) {
                return $s;
            }
        }

        // Pass 2: Specific keyword / category match (excluding generic 'dental'/'teeth')
        $generic = ['dental', 'teeth', 'tooth', 'clinic', 'practice', 'care'];
        foreach ($services as $s) {
            $title = strtolower((string) ($s['title'] ?? ''));
            $cat = strtolower((string) ($s['category'] ?? ''));
            foreach (explode(' ', $title) as $word) {
                $cleanWord = preg_replace('/[^a-z]/', '', $word) ?? '';
                if (strlen($cleanWord) >= 5 && !in_array($cleanWord, $generic, true) && str_contains($q, $cleanWord)) {
                    return $s;
                }
            }
            if ($cat !== '' && strlen($cat) >= 5 && !in_array($cat, $generic, true) && str_contains($q, $cat)) {
                return $s;
            }
        }
        return null;
    }
}
