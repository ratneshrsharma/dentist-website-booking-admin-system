'use client';

import React from 'react';
import Link from 'next/link';
import { TreatmentItem } from './treatmentsData';

interface TreatmentCardProps {
  treatment: TreatmentItem;
  onOpenBooking?: (serviceId?: number) => void;
}

export const TreatmentCard: React.FC<TreatmentCardProps> = ({
  treatment,
  onOpenBooking,
}) => {
  return (
    <article className="group bg-surface-card rounded-2xl border border-border-subtle/80 overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col h-full hover:border-primary/40">
      {/* Thumbnail Image Header */}
      <div className="relative h-52 sm:h-56 w-full overflow-hidden bg-surface-container">
        {/* eslint-disable-next-line @next/next/no-img-element */}
        <img
          src={treatment.image}
          alt={treatment.title}
          className="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
          loading="lazy"
        />
        <div className="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent" />

        {/* Category Pill Tag */}
        <div className="absolute top-3 left-3 flex flex-wrap gap-1.5">
          <span className="font-label-sm text-[11px] px-2.5 py-1 rounded-md bg-white/95 text-slate-800 font-bold backdrop-blur-sm shadow-xs">
            {treatment.categoryLabel}
          </span>
          <span
            className={`font-label-sm text-[11px] px-2.5 py-1 rounded-md font-semibold backdrop-blur-sm shadow-xs ${
              treatment.badgeClass || 'bg-primary text-on-primary'
            }`}
          >
            {treatment.badge}
          </span>
        </div>

        {/* Category Icon */}
        <div className="absolute bottom-3 right-3 w-10 h-10 rounded-xl bg-white/90 backdrop-blur-md flex items-center justify-center text-primary shadow-sm">
          <span className="material-symbols-outlined text-[20px]">
            {treatment.icon || 'dentistry'}
          </span>
        </div>
      </div>

      {/* Card Content Body */}
      <div className="p-5 sm:p-6 flex-1 flex flex-col justify-between">
        <div>
          <h3 className="font-display-title text-[18px] sm:text-[20px] font-bold text-on-surface mb-2 group-hover:text-primary transition-colors leading-snug">
            <Link href={treatment.href} className="hover:underline">
              {treatment.title}
            </Link>
          </h3>

          <p className="font-body-sm text-body-sm text-on-surface-variant leading-relaxed mb-4">
            {treatment.description}
          </p>

          {/* Key Clinical Features Checklist */}
          <ul className="space-y-1.5 mb-5 text-[13px] text-on-surface-variant">
            {treatment.features.map((feature, idx) => (
              <li key={idx} className="flex items-start gap-2">
                <span className="material-symbols-outlined text-[16px] text-primary shrink-0 mt-0.5">
                  check_circle
                </span>
                <span>{feature}</span>
              </li>
            ))}
          </ul>
        </div>

        {/* Pricing Footnote & Action Buttons */}
        <div className="pt-4 border-t border-border-subtle/60">
          <div className="flex items-center justify-between text-[12px] mb-3">
            <div>
              <span className="text-on-surface-variant text-[11px] block">NHS Banding</span>
              <span className="font-semibold text-primary">{treatment.nhsPricing}</span>
            </div>
            <div className="text-right">
              <span className="text-on-surface-variant text-[11px] block">Private Fee</span>
              <span className="font-semibold text-slate-800">{treatment.privatePricing}</span>
            </div>
          </div>

          <div className="grid grid-cols-2 gap-2">
            <Link
              href={treatment.href}
              className="w-full text-center py-2 px-3 rounded-lg text-[13px] font-semibold border border-border-subtle bg-surface hover:bg-surface-container text-on-surface transition-colors flex items-center justify-center gap-1"
            >
              <span>Full Guide</span>
              <span className="material-symbols-outlined text-[14px]">arrow_forward</span>
            </Link>

            {treatment.ctaPhone ? (
              <a
                href="tel:+441217652870"
                className="w-full text-center py-2 px-3 rounded-lg text-[13px] font-semibold bg-status-error hover:bg-red-700 text-white transition-colors flex items-center justify-center gap-1 shadow-xs"
              >
                <span className="material-symbols-outlined text-[14px]">call</span>
                <span>Call Triage</span>
              </a>
            ) : (
              <button
                type="button"
                onClick={() => onOpenBooking && onOpenBooking(treatment.id)}
                className="w-full text-center py-2 px-3 rounded-lg text-[13px] font-semibold bg-primary hover:bg-primary-dark text-on-primary transition-colors flex items-center justify-center gap-1 shadow-xs cursor-pointer"
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
};
