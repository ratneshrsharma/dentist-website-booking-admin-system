<?php

declare(strict_types=1);

namespace App\Services;

/**
 * DB/CMS-Grounded Smart Dental Assistant (Zero external AI key required)
 * Answers from ServicesService, BookingService, ThemeService, CmsService, BlogService
 * and performs live slot checking + appointment booking.
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
                    . "\n\nHow can I help you today? You can ask about pricing, FAQs, opening hours, or book an appointment right here.";
            } else {
                $greeting .= "I can help you with treatment pricing, NHS & private options, opening hours, or booking an appointment directly.";
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
                    'Opening Hours & Location',
                    'Emergency Triage',
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

        // 3. CREATE LIVE BOOKING FROM CHAT
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

            $ref = $booking['reference'] ?? ('APT-' . date('Ymd'));
            $docName = $booking['doctor_name'] ?? 'our clinician';
            $confirmText = "Your appointment is confirmed!\n"
                . "• Reference: **{$ref}**\n"
                . "• Treatment: {$treatment}\n"
                . "• Clinician: {$docName}\n"
                . "• Date & Time: {$date} at {$timeSlot}\n\n"
                . "Our reception team has received your booking. You can also send your pass via WhatsApp below.";

            ChatLogService::appendMessage($sessionId, 'user', "Please book {$treatment} on {$date} at {$timeSlot}.");
            $session = ChatLogService::appendMessage($sessionId, 'assistant', $confirmText, [
                'booking_reference' => $ref,
                'whatsapp_url' => $booking['whatsapp_url'] ?? '',
            ]);

            return [
                'success' => true,
                'session_id' => $sessionId,
                'reply' => $confirmText,
                'booking_created' => $booking,
                'quick_replies' => ['Opening Hours & Location', 'View All Treatments'],
                'messages' => $session['messages'],
            ];
        }

        // 4. STANDARD USER MESSAGE -> DB/CMS INTENT MATCHING
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
        $address = $branding['address'] ?? '1078 Warwick Road, Acocks Green, Birmingham B27 6BH';

        // Booking / Slots intent
        if (str_contains($q, 'book') || str_contains($q, 'slot') || str_contains($q, 'appointment') || str_contains($q, 'schedule')) {
            $svc = $session['service_interest'] ?: 'Routine Dental Examination';
            return [
                'reply' => "I can book **{$svc}** for you right now! Choose your preferred clinician, date, and available time slot below:",
                'show_booking_picker' => true,
                'quick_replies' => ['Treatment Pricing', 'Opening Hours & Location'],
            ];
        }

        // Emergency intent
        if (str_contains($q, 'emergenc') || str_contains($q, 'pain') || str_contains($q, 'toothache') || str_contains($q, 'swelling') || str_contains($q, 'urgent')) {
            return [
                'reply' => "For acute toothache, swelling, or dental trauma, we reserve **Same-Day Emergency Triage Slots**.\n"
                    . "• Emergency Triage Line: **{$phone}** (call before 10:00 AM for priority same-day care)\n"
                    . "• Emergency Triage Fee: From £50.00\n\nWould you like to check today's/tomorrow's available slots?",
                'show_booking_picker' => true,
                'quick_replies' => ['Check Available Slots', 'Opening Hours & Location'],
            ];
        }

        // Opening hours / Location / Parking intent
        if (str_contains($q, 'hour') || str_contains($q, 'open') || str_contains($q, 'time') || str_contains($q, 'address') || str_contains($q, 'where') || str_contains($q, 'location') || str_contains($q, 'parking')) {
            return [
                'reply' => "**Acocks Green Dental Practice**\n"
                    . "• Address: {$address}\n"
                    . "• Phone: {$phone}\n"
                    . "• Mon–Thu: 8:30 AM – 5:30 PM | Fri: 8:30 AM – 5:00 PM | Sat–Sun: Emergency Triage On-Call\n"
                    . "• Free on-site rear patient parking & step-free ground-floor access.",
                'quick_replies' => ['Book Appointment', 'Treatment Pricing', 'Our Dentists'],
            ];
        }

        // Doctors / Team intent
        if (str_contains($q, 'doctor') || str_contains($q, 'dentist') || str_contains($q, 'team') || str_contains($q, 'clinician') || str_contains($q, 'hygienist')) {
            $doctors = BookingService::getDefaultDoctors();
            $lines = ["Our GDC-registered clinical team:"];
            foreach ($doctors as $d) {
                $lines[] = "• **{$d['name']}** — {$d['role']}";
            }
            return [
                'reply' => implode("\n", $lines) . "\n\nWould you like to book with one of our clinicians?",
                'quick_replies' => ['Book Appointment', 'Treatment Pricing'],
            ];
        }

        // Specific treatment match
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
                'quick_replies' => ['Book Appointment', 'View All Treatments', 'Opening Hours & Location'],
            ];
        }

        // Pricing / Treatments list intent
        if (str_contains($q, 'price') || str_contains($q, 'cost') || str_contains($q, 'fee') || str_contains($q, 'nhs') || str_contains($q, 'treatment') || str_contains($q, 'service')) {
            $services = ServicesService::getAllServices(true);
            $lines = ["Here are our current treatments & starting prices (NHS & Private):"];
            foreach (array_slice($services, 0, 8) as $s) {
                $lines[] = "• **{$s['title']}** — {$s['starting_price']} ({$s['duration']})";
            }
            $lines[] = "\nNHS Band 1: £26.80 | Band 2: £73.50 | Band 3: £319.10.";
            return [
                'reply' => implode("\n", $lines),
                'quick_replies' => ['Book Appointment', 'Opening Hours & Location', 'Emergency Triage'],
            ];
        }

        // Fallback helpful response from DB
        return [
            'reply' => "Thank you for your message! I can share live information from our clinic database on:\n"
                . "• Treatments & NHS/Private Pricing\n"
                . "• Available Doctor Slots & Instant Booking\n"
                . "• Opening Hours, Address & Parking\n"
                . "• Same-Day Emergency Triage ({$phone})\n\nTap an option below or tell me which treatment you're looking for.",
            'quick_replies' => ['Book Appointment', 'Treatment Pricing', 'Opening Hours & Location', 'Emergency Triage'],
        ];
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
