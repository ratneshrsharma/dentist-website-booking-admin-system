'use client';

import React, { useState, useEffect } from 'react';
import { ConfidentDoctorTemplate } from '@/components/templates/ConfidentDoctorTemplate';
import { BookingWizard } from '@/components/organisms/BookingWizard/BookingWizard';
import { WhatsAppHub } from '@/components/ui/WhatsAppHub/WhatsAppHub';

export default function SecondaryThemePage() {
  // Secondary Theme: Confident Doctor (US Multi-Clinic System & Dr. Ethan Caldwell)
  const [bookingOpen, setBookingOpen] = useState(false);
  const [selectedServiceId, setSelectedServiceId] = useState<number | undefined>(undefined);

  useEffect(() => {
    if (typeof window !== 'undefined') {
      document.documentElement.setAttribute('data-theme', 'modern');
    }
  }, []);

  const handleOpenBooking = (serviceId?: number) => {
    setSelectedServiceId(serviceId);
    setBookingOpen(true);
  };

  return (
    <>
      {/* Secondary Theme: Confident Doctor */}
      <ConfidentDoctorTemplate onOpenBooking={handleOpenBooking} />

      {/* Floating Emergency & Inquiries WhatsApp Hub */}
      <WhatsAppHub onOpenBooking={() => handleOpenBooking()} />

      {/* 5-Step Real-Time Booking Wizard Modal Drawer */}
      <BookingWizard
        isOpen={bookingOpen}
        onClose={() => setBookingOpen(false)}
        preselectedServiceId={selectedServiceId}
      />
    </>
  );
}
