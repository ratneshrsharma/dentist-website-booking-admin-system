'use client';

import React from 'react';
import Link from 'next/link';

interface AcocksGreenFooterProps {
  onOpenBooking?: () => void;
  onOpenEmergency?: () => void;
}

export const AcocksGreenFooter: React.FC<AcocksGreenFooterProps> = ({
  onOpenBooking,
  onOpenEmergency,
}) => {
  return (
    <footer className="bg-surface-card border-t border-border-subtle/80 text-on-surface">
      {/* Top Urgent Emergency Callout Bar */}
      <div className="bg-primary text-on-primary py-4 px-6">
        <div className="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-4">
          <div className="flex items-center gap-3 text-center sm:text-left">
            <span className="w-3 h-3 rounded-full bg-amber-400 animate-pulse shrink-0" />
            <p className="font-body-sm text-[13px] sm:text-body-sm text-on-primary leading-snug">
              <strong>Acute Dental Emergency in Birmingham?</strong> Same-day emergency triage and pain relief available for registered and new patients.
            </p>
          </div>
          <div className="flex items-center gap-2.5 shrink-0">
            <button
              type="button"
              onClick={onOpenEmergency}
              className="bg-on-primary text-primary hover:bg-surface-card px-4 py-1.5 rounded-lg font-label-sm text-label-sm font-bold transition-all shadow-xs cursor-pointer flex items-center gap-1.5"
            >
              <span className="material-symbols-outlined text-[16px]">emergency</span>
              <span>Emergency Appointment</span>
            </button>
            <a
              href="tel:01217652870"
              className="bg-primary-container text-on-primary hover:bg-primary-container/80 px-4 py-1.5 rounded-lg font-label-sm text-label-sm font-semibold transition-all border border-on-primary/20 flex items-center gap-1.5"
            >
              <span className="material-symbols-outlined text-[16px]">call</span>
              <span>0121 765 2870</span>
            </a>
          </div>
        </div>
      </div>

      {/* Main Multi-Column Footer Content */}
      <div className="max-w-7xl mx-auto px-6 lg:px-12 py-16 lg:py-20">
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-10 lg:gap-12 items-start">
          {/* Column 1: Surgery Identity & Clinical Accreditations (4 cols) */}
          <div className="lg:col-span-4 space-y-5">
            <div className="flex items-center gap-3">
              <div className="w-10 h-10 rounded-xl bg-primary flex items-center justify-center text-on-primary shadow-xs">
                <span className="material-symbols-outlined text-[24px]">dentistry</span>
              </div>
              <div>
                <span className="font-headline-sm text-[20px] font-bold text-on-surface block tracking-tight">
                  Acocks Green
                </span>
                <span className="font-subheading-eyebrow text-[11px] uppercase tracking-wider text-primary font-bold block -mt-1">
                  Dental Practice
                </span>
              </div>
            </div>

            <p className="font-body-sm text-body-sm text-on-surface-variant leading-relaxed">
              Providing dedicated NHS and private dental care to families across Acocks Green, Hall Green, Solihull, and Greater Birmingham since 1990.
            </p>

            {/* Compliance & Accreditation Badges */}
            <div className="pt-2 space-y-2.5">
              <div className="flex items-center gap-2.5 text-on-surface-variant font-body-sm text-[13px]">
                <span className="material-symbols-outlined text-primary text-[18px]">verified_user</span>
                <span>Regulated by the <strong>Care Quality Commission (CQC)</strong></span>
              </div>
              <div className="flex items-center gap-2.5 text-on-surface-variant font-body-sm text-[13px]">
                <span className="material-symbols-outlined text-primary text-[18px]">school</span>
                <span><strong>General Dental Council (GDC)</strong> Registered Surgeons</span>
              </div>
              <div className="flex items-center gap-2.5 text-on-surface-variant font-body-sm text-[13px]">
                <span className="material-symbols-outlined text-primary text-[18px]">health_and_safety</span>
                <span>Official Signatory: <strong>NHS Sexual Safety Charter</strong></span>
              </div>
            </div>
          </div>

          {/* Column 2: Clinical Services & Treatments (3 cols) */}
          <div className="lg:col-span-3 space-y-4">
            <h4 className="font-label-md text-label-md uppercase tracking-wider text-on-surface font-bold">
              Dental Treatments
            </h4>
            <ul className="space-y-2.5 font-body-sm text-body-sm text-on-surface-variant">
              <li>
                <Link href="/treatments/general-dentistry" className="hover:text-primary transition-colors flex items-center gap-1.5">
                  <span className="material-symbols-outlined text-[14px] text-primary">chevron_right</span>
                  <span>General NHS Dentistry &amp; Exams</span>
                </Link>
              </li>
              <li>
                <Link href="/treatments/dental-implants" className="hover:text-primary transition-colors flex items-center gap-1.5">
                  <span className="material-symbols-outlined text-[14px] text-primary">chevron_right</span>
                  <span>Dental Implants &amp; Bone Grafts</span>
                </Link>
              </li>
              <li>
                <Link href="/treatments/crowns-and-bridges" className="hover:text-primary transition-colors flex items-center gap-1.5">
                  <span className="material-symbols-outlined text-[14px] text-primary">chevron_right</span>
                  <span>Restorative Crowns &amp; Bridges</span>
                </Link>
              </li>
              <li>
                <Link href="/treatments/clear-aligners" className="hover:text-primary transition-colors flex items-center gap-1.5">
                  <span className="material-symbols-outlined text-[14px] text-primary">chevron_right</span>
                  <span>Clear Aligners (Invisalign®)</span>
                </Link>
              </li>
              <li>
                <Link href="/treatments/root-canal-treatment" className="hover:text-primary transition-colors flex items-center gap-1.5">
                  <span className="material-symbols-outlined text-[14px] text-primary">chevron_right</span>
                  <span>Root Canal Endodontics</span>
                </Link>
              </li>
              <li>
                <Link href="/treatments/teeth-whitening" className="hover:text-primary transition-colors flex items-center gap-1.5">
                  <span className="material-symbols-outlined text-[14px] text-primary">chevron_right</span>
                  <span>Boutique Teeth Whitening</span>
                </Link>
              </li>
              <li className="pt-1 border-t border-border-subtle/50">
                <Link href="/treatments" className="text-primary font-bold hover:underline transition-colors flex items-center gap-1 text-[13px]">
                  <span className="material-symbols-outlined text-[14px]">arrow_forward</span>
                  <span>View All Treatments &amp; NHS Fees</span>
                </Link>
              </li>
            </ul>
          </div>

          {/* Column 3: Surgery Quick Links & Compliance (2 cols) */}
          <div className="lg:col-span-2 space-y-4">
            <h4 className="font-label-md text-label-md uppercase tracking-wider text-on-surface font-bold">
              Surgery Links
            </h4>
            <ul className="space-y-2.5 font-body-sm text-body-sm text-on-surface-variant">
              <li>
                <a href="#about" className="hover:text-primary transition-colors">
                  About Our Surgery
                </a>
              </li>
              <li>
                <a href="#team" className="hover:text-primary transition-colors">
                  Meet Our Clinicians
                </a>
              </li>
              <li>
                <a href="#reviews" className="hover:text-primary transition-colors">
                  Patient Reviews (4.9★)
                </a>
              </li>
              <li>
                <a href="#charter" className="hover:text-primary transition-colors">
                  NHS Safety Charter
                </a>
              </li>
              <li>
                <a href="#contact" className="hover:text-primary transition-colors">
                  Location &amp; Parking
                </a>
              </li>
              <li>
                <button
                  type="button"
                  onClick={onOpenBooking}
                  className="text-primary font-semibold hover:underline cursor-pointer"
                >
                  Book Online
                </button>
              </li>
            </ul>
          </div>

          {/* Column 4: Contact & Clinical Hours (3 cols) */}
          <div className="lg:col-span-3 space-y-4">
            <h4 className="font-label-md text-label-md uppercase tracking-wider text-on-surface font-bold">
              Practice Contact
            </h4>
            <div className="space-y-3 font-body-sm text-body-sm text-on-surface-variant">
              <div className="flex items-start gap-2.5">
                <span className="material-symbols-outlined text-primary text-[18px] shrink-0 mt-0.5">
                  location_on
                </span>
                <p>
                  Warwick Road, Acocks Green<br />
                  Birmingham, B27 6BH
                </p>
              </div>

              <div className="flex items-center gap-2.5">
                <span className="material-symbols-outlined text-primary text-[18px] shrink-0">
                  call
                </span>
                <a href="tel:01217652870" className="hover:text-primary font-semibold text-on-surface">
                  0121 765 2870
                </a>
              </div>

              <div className="flex items-center gap-2.5">
                <span className="material-symbols-outlined text-primary text-[18px] shrink-0">
                  schedule
                </span>
                <span>Mon&ndash;Thu: 9:00&ndash;17:30 | Fri: 9:00&ndash;17:00</span>
              </div>

              <div className="flex items-center gap-2.5 pt-1">
                <span className="material-symbols-outlined text-amber-600 text-[18px] shrink-0">
                  support_agent
                </span>
                <span className="text-[13px]">
                  Out-of-hours: <strong>Call NHS 111</strong>
                </span>
              </div>

              <div className="pt-2">
                <a
                  href="https://wa.me/919904379260?text=Hello%20Acocks%20Green%20Dental%20Practice!%20I%20would%20like%20to%20inquire%20about%20an%20appointment."
                  target="_blank"
                  rel="noopener noreferrer"
                  className="inline-flex items-center gap-2 text-primary bg-brand-accent-glow px-3.5 py-2 rounded-lg font-label-sm text-[13px] font-semibold hover:bg-primary hover:text-on-primary transition-all border border-primary/20"
                >
                  <span className="material-symbols-outlined text-[18px]">chat</span>
                  <span>WhatsApp Practice Hub</span>
                </a>
              </div>
            </div>
          </div>
        </div>

        {/* Bottom Legal & Compliance Strip */}
        <div className="mt-14 pt-8 border-t border-border-subtle/60 flex flex-col md:flex-row items-center justify-between gap-4 font-body-sm text-[12px] text-on-surface-variant">
          <p>
            &copy; {new Date().getFullYear()} <strong>Acocks Green Dental Practice</strong>. All rights reserved.
          </p>

          <div className="flex flex-wrap items-center gap-4 sm:gap-6">
            <a href="#charter" className="hover:text-primary transition-colors">
              NHS Sexual Safety Charter
            </a>
            <span className="text-border-subtle">&bull;</span>
            <a
              href="https://www.cqc.org.uk"
              target="_blank"
              rel="noopener noreferrer"
              className="hover:text-primary transition-colors"
            >
              CQC Registered Provider
            </a>
            <span className="text-border-subtle">&bull;</span>
            <a
              href="https://www.gdc-uk.org"
              target="_blank"
              rel="noopener noreferrer"
              className="hover:text-primary transition-colors"
            >
              GDC Compliance
            </a>
            <span className="text-border-subtle">&bull;</span>
            <span className="text-on-surface-variant">
              Engineered by <strong className="text-primary">Ratnesh Sharma</strong>
            </span>
          </div>
        </div>
      </div>
    </footer>
  );
};
