'use client';

import React from 'react';

interface ConsultationActionBarProps {
  headline?: string;
  description?: string;
  phone?: string;
  address?: string;
  onOpenBooking?: () => void;
}

export const ConsultationActionBar: React.FC<ConsultationActionBarProps> = ({
  headline = 'Ready to Plan Your Treatment?',
  description = 'Book your consultation at 1078 Warwick Road, Acocks Green, Birmingham. Our clinical team provides gentle, unhurried guidance with zero obligation.',
  phone = '+44 121 765 2870',
  address = '1078 Warwick Road, Acocks Green, Birmingham B27 6BH',
  onOpenBooking,
}) => {
  return (
    <section className="w-full py-12 lg:py-16 bg-primary text-on-primary relative overflow-hidden">
      <div className="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(255,255,255,0.1),transparent_50%)] pointer-events-none" />
      <div className="max-w-7xl mx-auto px-6 lg:px-12 relative z-10">
        <div className="grid lg:grid-cols-12 gap-8 items-center justify-between">
          <div className="lg:col-span-8">
            <span className="font-subheading-eyebrow text-subheading-eyebrow text-on-primary/80 uppercase tracking-widest block mb-2 font-bold">
              START YOUR SMILE JOURNEY
            </span>
            <h2 className="font-display-section text-[28px] sm:text-[36px] lg:text-[42px] text-on-primary tracking-tight mb-3 leading-tight">
              {headline}
            </h2>
            <p className="font-body-md text-body-md text-on-primary/90 max-w-2xl leading-relaxed">
              {description}
            </p>
          </div>

          <div className="lg:col-span-4 flex flex-col sm:flex-row lg:flex-col gap-3 justify-end">
            <button
              type="button"
              onClick={onOpenBooking}
              className="py-3.5 px-6 rounded-xl font-bold bg-white text-primary hover:bg-slate-100 transition-all duration-200 shadow-md flex items-center justify-center gap-2 cursor-pointer"
            >
              <span className="material-symbols-outlined text-[20px]">calendar_month</span>
              <span>Book Appointment Online</span>
            </button>

            <a
              href={`tel:${phone}`}
              className="py-3.5 px-6 rounded-xl font-bold bg-primary-dark/80 border border-white/20 text-white hover:bg-primary-dark transition-all duration-200 shadow-sm flex items-center justify-center gap-2"
            >
              <span className="material-symbols-outlined text-[20px]">call</span>
              <span>Call Reception: {phone}</span>
            </a>
          </div>
        </div>

        <div className="mt-8 pt-6 border-t border-white/20 flex flex-wrap items-center justify-between gap-4 text-sm text-on-primary/90">
          <div className="flex items-center gap-2">
            <span className="material-symbols-outlined text-[18px]">location_on</span>
            <span>{address}</span>
          </div>
          <div className="flex items-center gap-2">
            <span className="material-symbols-outlined text-[18px]">verified_user</span>
            <span>CQC Fully Inspected &amp; Regulated Dental Surgery</span>
          </div>
        </div>
      </div>
    </section>
  );
};
