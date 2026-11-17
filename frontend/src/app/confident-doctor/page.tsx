'use client';

import React, { useState, useEffect } from 'react';
import { ConfidentDoctorTemplate } from '@/components/templates/ConfidentDoctorTemplate';
import { BookingWizard } from '@/components/organisms/BookingWizard/BookingWizard';
import { WhatsAppHub } from '@/components/ui/WhatsAppHub/WhatsAppHub';
import { TemplateSwitcher } from '@/components/ui/TemplateSwitcher';
import { useRouter } from 'next/navigation';

export default function ConfidentDoctorPage() {
  const [bookingOpen, setBookingOpen] = useState(false);
  const [selectedServiceId, setSelectedServiceId] = useState<number | undefined>(undefined);
  const [activeTheme, setActiveTheme] = useState<string>('modern');
  const router = useRouter();

  useEffect(() => {
    document.documentElement.setAttribute('data-theme', 'modern');
    localStorage.setItem('adc-template', 'confident-doctor');
    localStorage.setItem('adc-theme', 'modern');
  }, []);

  const handleOpenBooking = (serviceId?: number) => {
    setSelectedServiceId(serviceId);
    setBookingOpen(true);
  };

  const handleSelectTemplate = (template: 'acocks-green' | 'confident-doctor') => {
    if (template === 'acocks-green') {
      document.documentElement.setAttribute('data-theme', 'acocks-green');
      localStorage.setItem('adc-template', 'acocks-green');
      localStorage.setItem('adc-theme', 'acocks-green');
      router.push('/');
    }
  };

  const handleSelectTheme = (theme: string) => {
    setActiveTheme(theme);
    document.documentElement.setAttribute('data-theme', theme);
    localStorage.setItem('adc-theme', theme);
  };

  return (
    <>
      <ConfidentDoctorTemplate onOpenBooking={handleOpenBooking} />

      {/* Floating Template & Theme Switcher Bar */}
      <TemplateSwitcher
        activeTemplate="confident-doctor"
        onSelectTemplate={handleSelectTemplate}
        activeTheme={activeTheme}
        onSelectTheme={handleSelectTheme}
      />

      {/* Shared WhatsApp Hub */}
      <WhatsAppHub onOpenBooking={() => handleOpenBooking()} />

      {/* Shared Booking Wizard */}
      <BookingWizard
        isOpen={bookingOpen}
        onClose={() => setBookingOpen(false)}
        preselectedServiceId={selectedServiceId}
      />
    </>
  );
}
