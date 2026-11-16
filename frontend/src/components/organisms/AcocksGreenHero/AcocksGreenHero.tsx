'use client';

import React, { useState } from 'react';
import { getAssetPath } from '@/lib/assetPath';

const REMOTE_FALLBACK_URL =
  'https://lh3.googleusercontent.com/aida-public/AB6AXuAc-hxxzCtIWRDIKCxFtim5T-K6eVYMo2HDC72Ixk0JspPXhfYh9bx-hlPbbzWKxJwDBVXZ18x8XTjA8N7ct0sUC7maDUdUSC3xGBEJU0Qbn0BqfJN-yxOj_MPYoIkkEk6ajkiDIeF_Zh5sg-JuD21N9kTqulTFkCNmIvB54qwKha9fn_yvSgXlq56PvBF2fB_zAGz8IfHEGFy0ZFZTckeYRabxogj2qIthy8AXA-aX';

interface AcocksGreenHeroProps {
  onOpenBooking?: () => void;
  onOpenEmergency?: () => void;
}

export const AcocksGreenHero: React.FC<AcocksGreenHeroProps> = ({
  onOpenBooking,
  onOpenEmergency,
}) => {
  const [imageSrc, setImageSrc] = useState(() => getAssetPath('/images/hero-patient.jpg'));
  const [imageError, setImageError] = useState(false);

  const handleImageError = () => {
    if (imageSrc !== REMOTE_FALLBACK_URL) {
      setImageSrc(REMOTE_FALLBACK_URL);
    } else {
      setImageError(true);
    }
  };

  return (
    <section className="relative bg-surface-container-low overflow-hidden pt-12 md:pt-16 pb-16 md:pb-24">
      {/* Ambient organic medical background glow elements */}
      <div
        className="absolute -top-32 -left-32 w-96 h-96 rounded-full bg-brand-accent-glow blur-3xl opacity-70 pointer-events-none"
        aria-hidden="true"
      />
      <div
        className="absolute top-1/3 -right-24 w-[32rem] h-[32rem] rounded-full bg-secondary-fixed/40 blur-3xl opacity-50 pointer-events-none"
        aria-hidden="true"
      />

      <div className="max-w-7xl mx-auto px-6 lg:px-12 relative z-10">
        <div className="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
          {/* ========================================================
              LEFT HERO CONTENT COLUMN (7 cols)
              ======================================================== */}
          <div className="lg:col-span-7 flex flex-col space-y-6">
            {/* Clinical Eyebrow */}
            <span className="font-subheading-eyebrow text-subheading-eyebrow uppercase text-primary tracking-wider font-bold block">
              NHS &amp; Private Patients Welcomed
            </span>

            {/* Display Hero Headline */}
            <h1 className="font-display-hero text-[34px] sm:text-[42px] lg:text-display-hero text-on-surface tracking-tight leading-[1.15]">
              Make your Dental Experience a{' '}
              <span className="text-primary underline decoration-primary-fixed decoration-4 underline-offset-8">
                Lot Brighter
              </span>
            </h1>

            {/* Value Proposition Clinical Copy */}
            <p className="font-body-lg text-body-lg text-on-surface-variant max-w-2xl leading-relaxed">
              Welcome to Acocks Green Dental Practice. Delivering gentle, high-standard dental care for patients of all ages across Birmingham B27. From preventive family appointments to transformative aesthetics, our clinical team puts your comfort first.
            </p>

            {/* Key Metrics Stat Strip */}
            <div className="grid grid-cols-3 gap-3 sm:gap-4 pt-2 pb-2">
              <div className="bg-surface-card p-4 rounded-xl shadow-xs border border-border-subtle/60 hover:shadow-sm transition-shadow">
                <span className="font-headline-lg text-[26px] sm:text-headline-lg text-primary block leading-none font-bold">
                  5,000+
                </span>
                <span className="font-label-sm text-label-sm text-on-surface-variant mt-1.5 block">
                  Happy Patients
                </span>
              </div>
              <div className="bg-surface-card p-4 rounded-xl shadow-xs border border-border-subtle/60 hover:shadow-sm transition-shadow">
                <span className="font-headline-lg text-[26px] sm:text-headline-lg text-primary block leading-none font-bold">
                  7+
                </span>
                <span className="font-label-sm text-label-sm text-on-surface-variant mt-1.5 block">
                  Dentists &amp; Staff
                </span>
              </div>
              <div className="bg-surface-card p-4 rounded-xl shadow-xs border border-border-subtle/60 hover:shadow-sm transition-shadow">
                <span className="font-headline-lg text-[26px] sm:text-headline-lg text-primary block leading-none font-bold">
                  20+
                </span>
                <span className="font-label-sm text-label-sm text-on-surface-variant mt-1.5 block">
                  Years of Trust
                </span>
              </div>
            </div>

            {/* Hero CTAs: Slide-out Booking Drawer + Emergency Triage */}
            <div className="flex flex-wrap items-center gap-4 sm:gap-6 pt-2">
              <button
                type="button"
                onClick={onOpenBooking}
                className="inline-flex items-center gap-2 bg-primary-container text-on-primary font-label-md text-label-md px-6 py-3.5 rounded-lg shadow-md hover:bg-primary hover:shadow-lg transition-all duration-200 cursor-pointer"
              >
                <span>Book An Appointment</span>
                <span className="material-symbols-outlined text-[18px]">calendar_month</span>
              </button>

              <div className="flex items-center gap-3">
                <div className="w-10 h-10 rounded-full bg-brand-accent-glow flex items-center justify-center text-primary shrink-0">
                  <span className="material-symbols-outlined text-[20px]">call</span>
                </div>
                <div className="flex flex-col">
                  <span className="font-label-sm text-[11px] uppercase tracking-wider text-on-surface-variant font-medium">
                    Emergency Triage Line
                  </span>
                  <a
                    className="font-label-md text-label-md text-on-surface hover:text-primary font-semibold transition-colors"
                    href="tel:+441217652870"
                  >
                    +44 121 765 2870
                  </a>
                </div>
              </div>
            </div>
          </div>

          {/* ========================================================
              RIGHT HERO VISUAL COLUMN (5 cols)
              ======================================================== */}
          <div className="lg:col-span-5 relative mt-6 lg:mt-0">
            <div className="relative rounded-2xl overflow-hidden shadow-xl aspect-[4/5] bg-surface-variant max-w-lg mx-auto border border-border-subtle/50">
              {!imageError ? (
                /* eslint-disable-next-line @next/next/no-img-element */
                <img
                  className="w-full h-full object-cover"
                  alt="A female patient smiling brightly while undergoing a gentle dental hygiene checkup at Acocks Green Dental Practice in Birmingham"
                  src={imageSrc}
                  onError={handleImageError}
                  loading="eager"
                  width={512}
                  height={640}
                />
              ) : (
                <div className="w-full h-full bg-gradient-to-br from-primary-container/20 to-surface-variant flex flex-col items-center justify-center p-6 text-center">
                  <span className="material-symbols-outlined text-primary text-[64px] mb-2">dentistry</span>
                  <span className="font-headline-sm text-primary font-bold">Acocks Green Dental Practice</span>
                  <span className="text-body-sm text-on-surface-variant mt-1">1078 Warwick Road, Birmingham B27</span>
                </div>
              )}

              {/* Dark subtle gradient overlay at bottom for card readability */}
              <div
                className="absolute inset-0 bg-gradient-to-t from-appointment-card-bg/80 via-appointment-card-bg/20 to-transparent pointer-events-none"
                aria-hidden="true"
              />

              {/* Top Floating Badge: CQC Regulated Standards */}
              <div className="absolute top-4 left-4 bg-surface-card/95 backdrop-blur-md px-3.5 py-2 rounded-xl shadow-md flex items-center gap-2 border border-border-subtle/80">
                <span className="material-symbols-outlined text-primary text-[20px]">verified</span>
                <span className="font-label-sm text-label-sm text-on-surface font-semibold">
                  CQC Regulated Standards
                </span>
              </div>

              {/* Bottom Floating Interactive Emergency Card */}
              <div
                onClick={onOpenEmergency || onOpenBooking}
                className="absolute bottom-4 left-4 right-4 bg-surface-card/95 backdrop-blur-md p-4 rounded-xl shadow-lg border border-border-subtle/80 cursor-pointer hover:bg-surface-card transition-all group"
                role="button"
                tabIndex={0}
                aria-label="Request Same-Day Emergency Slot"
                onKeyDown={(e) => {
                  if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    (onOpenEmergency || onOpenBooking)?.();
                  }
                }}
              >
                <div className="flex items-center justify-between gap-3">
                  <div className="flex items-center gap-3">
                    <div className="w-10 h-10 rounded-full bg-brand-accent-glow flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-on-primary transition-colors shrink-0">
                      <span className="material-symbols-outlined text-[20px]">e911_emergency</span>
                    </div>
                    <div>
                      <p className="font-label-md text-label-md text-on-surface font-semibold group-hover:text-primary transition-colors">
                        Same-Day Emergency Slots
                      </p>
                      <p className="font-body-sm text-body-sm text-on-surface-variant text-[12px] leading-tight">
                        Fast relief for severe toothache &amp; trauma
                      </p>
                    </div>
                  </div>
                  <span className="font-label-sm text-[11px] bg-primary-fixed text-on-primary-fixed px-2.5 py-1 rounded-full font-bold shrink-0">
                    Available
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  );
};
