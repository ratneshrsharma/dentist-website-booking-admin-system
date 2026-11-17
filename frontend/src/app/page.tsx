'use client';

import React, { useState, useEffect } from 'react';
import { AcocksGreenTemplate } from '@/components/templates/AcocksGreenTemplate';
import { BookingWizard } from '@/components/organisms/BookingWizard/BookingWizard';
import { WhatsAppHub } from '@/components/ui/WhatsAppHub/WhatsAppHub';

export default function HomePage() {
  // Primary Main Theme: Acocks Green Dental Practice (Birmingham B27 6BH NHS & Private Surgery)
  const [bookingOpen, setBookingOpen] = useState(false);
  const [selectedServiceId, setSelectedServiceId] = useState<number | undefined>(undefined);

  useEffect(() => {
    if (typeof window !== 'undefined') {
      document.documentElement.setAttribute('data-theme', 'acocks-green');
    }
  }, []);

  const handleOpenBooking = (serviceId?: number) => {
    setSelectedServiceId(serviceId);
    setBookingOpen(true);
  };

  return (
    <>
      {/* Main Theme: Acocks Green Dental Practice */}
      <AcocksGreenTemplate
        onOpenBooking={handleOpenBooking}
        onOpenEmergency={() => handleOpenBooking(1)}
      />

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
