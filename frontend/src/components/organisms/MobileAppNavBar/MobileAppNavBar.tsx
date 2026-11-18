'use client';

import React, { useState } from 'react';
import Link from 'next/link';
import { usePathname } from 'next/navigation';

interface MobileAppNavBarProps {
  onOpenBooking?: () => void;
  onOpenEmergency?: () => void;
  phone?: string;
  whatsappNumber?: string;
}

export const MobileAppNavBar: React.FC<MobileAppNavBarProps> = ({
  onOpenBooking,
  onOpenEmergency,
  phone = '+441217652870',
  whatsappNumber = '919904379260',
}) => {
  const pathname = usePathname();
  const [treatmentsSheetOpen, setTreatmentsSheetOpen] = useState(false);

  const isHome = pathname === '/' || pathname === '';
  const isTreatments = pathname?.startsWith('/treatments');

  const cleanPhone = phone.replace(/[^0-9+]/g, '');
  const cleanWhatsapp = whatsappNumber.replace(/[^0-9]/g, '');
  const whatsappUrl = `https://wa.me/${cleanWhatsapp}?text=${encodeURIComponent(
    'Hello Acocks Green Dental Practice, I would like to book an appointment or ask about treatments.'
  )}`;

  const quickTreatments = [
    {
      title: 'General Dentistry & Routine Check-ups',
      badge: 'NHS & Private',
      href: '/treatments/general-dentistry',
      icon: 'dentistry',
    },
    {
      title: 'Dental Implants & Bone Grafting',
      badge: 'Lifetime Root Replacement',
      href: '/treatments/dental-implants',
      icon: 'vital_signs',
    },
    {
      title: 'Clear Aligners & Invisalign®',
      badge: 'Discreet Orthodontics',
      href: '/treatments/clear-aligners',
      icon: 'auto_awesome',
    },
    {
      title: 'Dental Crowns & Bridgework',
      badge: 'Restorative Care',
      href: '/treatments/crowns-and-bridges',
      icon: 'architecture',
    },
    {
      title: 'Root Canal Endodontics',
      badge: 'Single-Visit Pain Relief',
      href: '/treatments/root-canal-treatment',
      icon: 'medical_services',
    },
    {
      title: 'Professional Teeth Whitening',
      badge: 'Boutique Aesthetic Care',
      href: '/treatments/teeth-whitening',
      icon: 'clean_hands',
    },
  ];

  return (
    <>
      {/* ========================================================
          QUICK TREATMENTS BOTTOM DRAWER (Mobile App Sheet)
          ======================================================== */}
      {treatmentsSheetOpen && (
        <div
          className="fixed inset-0 z-50 bg-black/60 backdrop-blur-xs flex flex-col justify-end xl:hidden animate-in fade-in duration-200"
          onClick={() => setTreatmentsSheetOpen(false)}
        >
          <div
            className="bg-surface-card rounded-t-3xl border-t border-border-subtle p-6 max-h-[82vh] overflow-y-auto shadow-2xl animate-in slide-in-from-bottom duration-250"
            onClick={(e) => e.stopPropagation()}
          >
            {/* Grab handle */}
            <div className="w-12 h-1.5 bg-border-subtle rounded-full mx-auto mb-4" />

            <div className="flex items-center justify-between mb-4 pb-3 border-b border-border-subtle">
              <div>
                <h3 className="font-headline-sm text-[18px] font-bold text-on-surface">
                  Clinical Treatments &amp; Services
                </h3>
                <p className="text-[12px] text-on-surface-variant">
                  Select a clinical pathway for transparent NHS &amp; private care
                </p>
              </div>
              <button
                type="button"
                onClick={() => setTreatmentsSheetOpen(false)}
                className="w-8 h-8 rounded-full bg-surface-container-low flex items-center justify-center text-on-surface-variant hover:text-on-surface"
                aria-label="Close treatments menu"
              >
                <span className="material-symbols-outlined text-[18px]">close</span>
              </button>
            </div>

            <div className="grid grid-cols-1 gap-2.5 mb-5">
              {quickTreatments.map((t) => (
                <Link
                  key={t.href}
                  href={t.href}
                  onClick={() => setTreatmentsSheetOpen(false)}
                  className="flex items-center justify-between p-3 rounded-xl bg-surface-container-low/70 hover:bg-surface-container-low border border-border-subtle/60 active:scale-[0.98] transition-all"
                >
                  <div className="flex items-center gap-3">
                    <div className="w-10 h-10 rounded-lg bg-primary-container text-on-primary flex items-center justify-center shrink-0">
                      <span className="material-symbols-outlined text-[20px]">{t.icon}</span>
                    </div>
                    <div>
                      <span className="font-label-md text-[13px] font-bold text-on-surface block leading-snug">
                        {t.title}
                      </span>
                      <span className="text-[11px] text-primary font-medium block">
                        {t.badge}
                      </span>
                    </div>
                  </div>
                  <span className="material-symbols-outlined text-primary text-[18px]">
                    chevron_right
                  </span>
                </Link>
              ))}
            </div>

            {/* View Full Catalog Link */}
            <Link
              href="/treatments"
              onClick={() => setTreatmentsSheetOpen(false)}
              className="w-full flex items-center justify-center gap-2 py-3 rounded-xl bg-primary text-on-primary font-label-md text-[14px] font-bold hover:bg-primary-container transition-colors shadow-sm"
            >
              <span className="material-symbols-outlined text-[18px]">grid_view</span>
              <span>View Full Treatments Catalog &amp; NHS Fees</span>
            </Link>

            {/* Emergency Fast Triage Trigger */}
            {onOpenEmergency && (
              <button
                type="button"
                onClick={() => {
                  setTreatmentsSheetOpen(false);
                  onOpenEmergency();
                }}
                className="w-full mt-2.5 flex items-center justify-center gap-2 py-2.5 rounded-xl bg-status-error/10 text-status-error border border-status-error/30 font-label-md text-[13px] font-bold hover:bg-status-error hover:text-white transition-colors cursor-pointer"
              >
                <span className="material-symbols-outlined text-[16px]">e911_emergency</span>
                <span>Urgent Emergency Consultation</span>
              </button>
            )}
          </div>
        </div>
      )}

      {/* ========================================================
          STICKY MOBILE APP BOTTOM NAVIGATION BAR
          ======================================================== */}
      <nav
        aria-label="Mobile Bottom App Navigation"
        className="fixed bottom-0 left-0 right-0 z-40 bg-surface/92 backdrop-blur-xl border-t border-border-subtle/70 shadow-[0_-4px_20px_rgba(0,0,0,0.06)] xl:hidden safe-area-inset-bottom"
        style={{
          paddingBottom: 'max(env(safe-area-inset-bottom, 0px), 6px)',
        }}
      >
        <div className="max-w-md mx-auto px-4 py-2 flex items-center justify-around">
          {/* Tab 1: Home */}
          <Link
            href="/"
            className={`flex flex-col items-center justify-center min-w-[56px] py-1 transition-colors ${
              isHome
                ? 'text-primary font-bold'
                : 'text-on-surface-variant hover:text-on-surface'
            }`}
          >
            <div className={`p-1 rounded-xl transition-all ${isHome ? 'bg-primary/10' : ''}`}>
              <span className="material-symbols-outlined text-[22px] block">home</span>
            </div>
            <span className="text-[10px] tracking-tight font-medium mt-0.5">Home</span>
          </Link>

          {/* Tab 2: Treatments Quick Drawer */}
          <button
            type="button"
            onClick={() => setTreatmentsSheetOpen(true)}
            className={`flex flex-col items-center justify-center min-w-[56px] py-1 transition-colors cursor-pointer ${
              isTreatments
                ? 'text-primary font-bold'
                : 'text-on-surface-variant hover:text-on-surface'
            }`}
            aria-label="Open treatments menu"
          >
            <div className={`p-1 rounded-xl transition-all ${isTreatments ? 'bg-primary/10' : ''}`}>
              <span className="material-symbols-outlined text-[22px] block">dentistry</span>
            </div>
            <span className="text-[10px] tracking-tight font-medium mt-0.5">Treatments</span>
          </button>

          {/* Tab 3: Center Elevated Book Appointment CTA Button */}
          <div className="flex flex-col items-center justify-center -mt-5 px-1">
            <button
              type="button"
              onClick={onOpenBooking}
              className="w-13 h-13 rounded-2xl bg-gradient-to-tr from-primary to-primary-container text-on-primary flex items-center justify-center shadow-lg hover:shadow-xl hover:scale-105 active:scale-95 transition-all duration-200 border-2 border-surface cursor-pointer"
              aria-label="Book Dental Appointment"
            >
              <span className="material-symbols-outlined text-[26px]">calendar_month</span>
            </button>
            <span className="text-[10px] font-bold text-primary tracking-tight mt-1">Book</span>
          </div>

          {/* Tab 4: Direct Phone Call */}
          <a
            href={`tel:${cleanPhone}`}
            className="flex flex-col items-center justify-center min-w-[56px] py-1 text-on-surface-variant hover:text-primary transition-colors"
            aria-label="Call Acocks Green Dental Practice"
          >
            <div className="p-1 rounded-xl">
              <span className="material-symbols-outlined text-[22px] block">call</span>
            </div>
            <span className="text-[10px] tracking-tight font-medium mt-0.5">Call Us</span>
          </a>

          {/* Tab 5: WhatsApp Chat */}
          <a
            href={whatsappUrl}
            target="_blank"
            rel="noopener noreferrer"
            className="flex flex-col items-center justify-center min-w-[56px] py-1 text-on-surface-variant hover:text-[#25D366] transition-colors"
            aria-label="WhatsApp Instant Chat"
          >
            <div className="p-1 rounded-xl">
              <span className="material-symbols-outlined text-[22px] block text-[#25D366]">chat</span>
            </div>
            <span className="text-[10px] tracking-tight font-medium mt-0.5">WhatsApp</span>
          </a>
        </div>
      </nav>
    </>
  );
};
