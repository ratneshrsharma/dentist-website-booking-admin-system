'use client';

import React, { useState } from 'react';
import Link from 'next/link';
import { CLINICAL_9_TREATMENTS, TreatmentItem } from '@/components/shared/treatmentsData';

interface AcocksGreenServicesProps {
  onOpenBooking?: (serviceId?: number) => void;
}

const CATEGORIES = [
  { id: 'all', label: 'All 9 Treatments' },
  { id: 'general', label: 'NHS & General Dentistry' },
  { id: 'restorative', label: 'Restorative & Implants' },
  { id: 'cosmetic', label: 'Cosmetic & Aligners' },
  { id: 'emergency', label: 'Emergency Pain Relief' },
];

export const AcocksGreenServices: React.FC<AcocksGreenServicesProps> = ({
  onOpenBooking,
}) => {
  const [activeCategory, setActiveCategory] = useState<string>('all');

  const filteredServices: TreatmentItem[] = CLINICAL_9_TREATMENTS.filter((t) => {
    if (activeCategory === 'all') return true;
    if (activeCategory === 'general') return t.category === 'general' || t.category === 'hygiene';
    if (activeCategory === 'restorative') return t.category === 'restorative' || t.category === 'implants';
    if (activeCategory === 'cosmetic') return t.category === 'cosmetic' || t.category === 'orthodontics';
    if (activeCategory === 'emergency') return t.category === 'emergency';
    return true;
  });

  return (
    <section id="services" className="py-16 md:py-24 bg-surface relative">
      <div className="max-w-7xl mx-auto px-6 lg:px-12 pt-4">
        {/* Section Header */}
        <div className="flex flex-col md:flex-row md:items-end justify-between mb-8 md:mb-12 gap-6">
          <div className="max-w-2xl">
            <span className="font-subheading-eyebrow text-subheading-eyebrow uppercase text-primary tracking-wider block mb-2 font-bold">
              Our 9 Clinical Procedures &amp; Services
            </span>
            <h2 className="font-headline-lg text-[28px] sm:text-[34px] lg:text-headline-lg text-on-surface font-bold tracking-tight">
              Evidence-Based Clinical Dentistry in Acocks Green
            </h2>
          </div>
          <p className="font-body-md text-body-md text-on-surface-variant max-w-md leading-relaxed">
            Delivering statutory NHS fee bandings and bespoke private cosmetic &amp; restorative solutions at 1078 Warwick Road, Birmingham B27 6BH.
          </p>
        </div>

        {/* Category Filter Pills (Clean, High Contrast) */}
        <div className="flex flex-wrap items-center gap-2 mb-10 pb-3 border-b border-border-subtle/60" role="tablist" aria-label="Treatment categories">
          {CATEGORIES.map((cat) => {
            const isActive = activeCategory === cat.id;
            return (
              <button
                key={cat.id}
                type="button"
                role="tab"
                aria-selected={isActive}
                onClick={() => setActiveCategory(cat.id)}
                className={`font-label-md text-label-md px-4 py-2 rounded-xl transition-all duration-150 cursor-pointer font-medium ${
                  isActive
                    ? 'bg-primary text-white shadow-sm font-semibold'
                    : 'bg-white hover:bg-slate-100 text-slate-700 border border-slate-200 hover:border-slate-300'
                }`}
              >
                {cat.label}
              </button>
            );
          })}
        </div>

        {/* 9 Treatment Cards Grid (3 Columns, Complete Thumbnails) */}
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          {filteredServices.map((service) => {
            return (
              <article
                key={service.id}
                className="service-card group bg-surface-card rounded-2xl border border-border-subtle shadow-sm overflow-hidden flex flex-col transition-all duration-300 hover:-translate-y-1.5 hover:shadow-lg hover:border-primary/40"
              >
                {/* Visual Image with Category & Badge */}
                <div className="relative h-56 w-full overflow-hidden bg-surface-container-high">
                  <Link href={service.href} className="block w-full h-full">
                    {/* eslint-disable-next-line @next/next/no-img-element */}
                    <img
                      alt={service.title}
                      className="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                      src={service.image}
                      loading="lazy"
                    />
                  </Link>
                  <div className="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent pointer-events-none" />
                  <div className="absolute top-4 left-4 flex flex-wrap gap-1.5">
                    <span className="font-label-sm text-[11px] px-2.5 py-1 rounded-md bg-white/95 text-slate-800 font-bold shadow-xs">
                      {service.categoryLabel}
                    </span>
                    <span
                      className={`font-label-sm text-[11px] px-2.5 py-1 rounded-md font-semibold shadow-xs ${
                        service.badgeClass || 'bg-primary text-on-primary'
                      }`}
                    >
                      {service.badge}
                    </span>
                  </div>
                  <div className="absolute bottom-3 right-3 w-10 h-10 rounded-xl bg-white/90 backdrop-blur-md flex items-center justify-center text-primary shadow-sm">
                    <span className="material-symbols-outlined text-[20px]">
                      {service.icon}
                    </span>
                  </div>
                </div>

                {/* Card Body */}
                <div className="p-6 lg:p-7 flex flex-col flex-1 justify-between">
                  <div>
                    <h3 className="font-display-title text-[20px] font-bold text-on-surface mb-2 group-hover:text-primary transition-colors">
                      <Link href={service.href} className="hover:underline">
                        {service.title}
                      </Link>
                    </h3>

                    <p className="font-body-sm text-body-sm text-on-surface-variant leading-relaxed mb-4">
                      {service.description}
                    </p>

                    {/* Features checklist */}
                    <ul className="space-y-1.5 mb-5 text-[13px] text-on-surface-variant">
                      {service.features.map((feat, idx) => (
                        <li key={idx} className="flex items-start gap-2">
                          <span className="material-symbols-outlined text-[16px] text-primary shrink-0 mt-0.5">
                            check_circle
                          </span>
                          <span>{feat}</span>
                        </li>
                      ))}
                    </ul>
                  </div>

                  {/* Pricing and Action Buttons */}
                  <div className="pt-4 border-t border-border-subtle/70">
                    <div className="flex items-center justify-between text-[12px] mb-4">
                      <div>
                        <span className="text-on-surface-variant text-[11px] block">NHS Banding</span>
                        <span className="font-semibold text-primary">{service.nhsPricing}</span>
                      </div>
                      <div className="text-right">
                        <span className="text-on-surface-variant text-[11px] block">Private Fee</span>
                        <span className="font-semibold text-slate-800">{service.privatePricing}</span>
                      </div>
                    </div>

                    <div className="grid grid-cols-2 gap-2">
                      <Link
                        href={service.href}
                        className="w-full text-center py-2.5 px-3 rounded-lg text-[13px] font-semibold border border-border-subtle bg-surface hover:bg-surface-container text-on-surface transition-colors flex items-center justify-center gap-1"
                      >
                        <span>Full Guide</span>
                        <span className="material-symbols-outlined text-[14px]">arrow_forward</span>
                      </Link>

                      {service.ctaPhone ? (
                        <a
                          href="tel:+441217652870"
                          className="w-full text-center py-2.5 px-3 rounded-lg text-[13px] font-semibold bg-status-error hover:bg-red-700 text-white transition-colors flex items-center justify-center gap-1 shadow-xs"
                        >
                          <span className="material-symbols-outlined text-[14px]">call</span>
                          <span>Call Triage</span>
                        </a>
                      ) : (
                        <button
                          type="button"
                          onClick={() => onOpenBooking && onOpenBooking(service.id)}
                          className="w-full text-center py-2.5 px-3 rounded-lg text-[13px] font-semibold bg-primary hover:bg-primary-dark text-on-primary transition-colors flex items-center justify-center gap-1 shadow-xs cursor-pointer"
                        >
                          <span>Book Slot</span>
                          <span className="material-symbols-outlined text-[14px]">calendar_month</span>
                        </button>
                      )}
                    </div>
                  </div>
                </div>
              </article>
            );
          })}
        </div>
      </div>
    </section>
  );
};
