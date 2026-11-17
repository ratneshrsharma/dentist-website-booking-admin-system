'use client';

import React, { useState, useEffect } from 'react';
import { AcocksGreenTemplate } from '@/components/templates/AcocksGreenTemplate';
import { ConfidentDoctorTemplate } from '@/components/templates/ConfidentDoctorTemplate';
import { TemplateSwitcher, TemplateType } from '@/components/ui/TemplateSwitcher';
import { BookingWizard } from '@/components/organisms/BookingWizard/BookingWizard';
import { WhatsAppHub } from '@/components/ui/WhatsAppHub/WhatsAppHub';

export default function HomePage() {
  // Acocks Green Dental Practice is the PRIMARY DEFAULT template
  const [activeTemplate, setActiveTemplate] = useState<TemplateType>('acocks-green');
  const [activeTheme, setActiveTheme] = useState<string>('acocks-green');
  const [bookingOpen, setBookingOpen] = useState(false);
  const [selectedServiceId, setSelectedServiceId] = useState<number | undefined>(undefined);

  useEffect(() => {
    // Check URL search parameters or localStorage for template override
    if (typeof window !== 'undefined') {
      const urlParams = new URLSearchParams(window.location.search);
      const templateParam = urlParams.get('template');
      const savedTemplate = (localStorage.getItem('adc-template') as TemplateType) || null;
      const savedTheme = localStorage.getItem('adc-theme') || null;

      if (templateParam === 'confident-doctor' || (!templateParam && savedTemplate === 'confident-doctor')) {
        setActiveTemplate('confident-doctor');
        setActiveTheme(savedTheme || 'modern');
        document.documentElement.setAttribute('data-theme', savedTheme || 'modern');
      } else {
        // Default to Primary: Acocks Green Practice
        setActiveTemplate('acocks-green');
        setActiveTheme(savedTheme || 'acocks-green');
        document.documentElement.setAttribute('data-theme', savedTheme || 'acocks-green');
      }
    }
  }, []);

  const handleOpenBooking = (serviceId?: number) => {
    setSelectedServiceId(serviceId);
    setBookingOpen(true);
  };

  const handleSelectTemplate = (template: TemplateType) => {
    setActiveTemplate(template);
    if (typeof window !== 'undefined') {
      localStorage.setItem('adc-template', template);
      const targetTheme = template === 'acocks-green' ? 'acocks-green' : 'modern';
      setActiveTheme(targetTheme);
      localStorage.setItem('adc-theme', targetTheme);
      document.documentElement.setAttribute('data-theme', targetTheme);
    }
  };

  const handleSelectTheme = (theme: string) => {
    setActiveTheme(theme);
    if (typeof window !== 'undefined') {
      localStorage.setItem('adc-theme', theme);
      document.documentElement.setAttribute('data-theme', theme);
    }
  };

  return (
    <>
      {/* ========================================================
          RENDER ACTIVE TEMPLATE
          Primary Default: Acocks Green Practice (NHS & Private Birmingham)
          Secondary Option: Confident Doctor (US Multi-Clinic System)
          ======================================================== */}
      {activeTemplate === 'acocks-green' ? (
        <AcocksGreenTemplate
          onOpenBooking={handleOpenBooking}
          onOpenEmergency={() => handleOpenBooking(1)}
        />
      ) : (
        <ConfidentDoctorTemplate
          onOpenBooking={handleOpenBooking}
        />
      )}

      {/* Floating Clinical Template & Theme Switcher Bar */}
      <TemplateSwitcher
        activeTemplate={activeTemplate}
        onSelectTemplate={handleSelectTemplate}
        activeTheme={activeTheme}
        onSelectTheme={handleSelectTheme}
      />

      {/* High-Conversion Floating WhatsApp Hub */}
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
