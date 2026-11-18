'use client';

import React from 'react';
import Link from 'next/link';

interface AcocksGreenServicesProps {
  onOpenBooking?: (serviceId?: number) => void;
}

const servicesData = [
  {
    id: 1,
    title: 'General Dentistry',
    badge1: 'Preventive',
    badge2: 'NHS / Private',
    icon: 'dentistry',
    href: '/treatments/general-dentistry',
    description:
      'Routine dental health examinations, digital diagnostics, high-durability composite white fillings, gentle root canals, and ongoing prevention.',
    cta: 'Explore General Care',
  },
  {
    id: 2,
    title: 'Hygiene & Periodontics',
    badge1: 'Gum Care',
    badge2: 'Airflow Polish',
    icon: 'clean_hands',
    href: '/treatments/general-dentistry#hygiene',
    description:
      'Deep ultrasonic plaque scaling, stubborn nicotine and coffee stain removal, and periodontal disease therapy led by our dedicated hygienist Claire.',
    cta: 'Explore Hygiene Care',
  },
  {
    id: 3,
    title: 'Restorative Dentistry',
    badge1: 'Restorative',
    badge2: 'Crowns & Bridges',
    icon: 'vital_signs',
    href: '/treatments/crowns-and-bridges',
    description:
      'Rebuild chewing function and oral harmony with customized ceramic crowns, bridges, durable inlays, and prosthetics designed for longevity.',
    cta: 'View Restorations',
  },
  {
    id: 4,
    title: 'Aesthetic & Aligners',
    badge1: 'Cosmetic',
    badge2: 'Invisalign®',
    icon: 'auto_awesome',
    href: '/treatments/clear-aligners',
    description:
      'Transform your smile with professional boutique teeth whitening, handcrafted porcelain veneers, and Invisalign® discreet clear aligner therapy.',
    cta: 'Explore Aligners',
  },
];

export const AcocksGreenServices: React.FC<AcocksGreenServicesProps> = ({
  onOpenBooking,
}) => {
  return (
    <section id="services" className="py-20 md:py-24 bg-surface relative">
      <div className="max-w-7xl mx-auto px-6 lg:px-12 pt-4">
        {/* Section Header */}
        <div className="flex flex-col md:flex-row md:items-end justify-between mb-12 md:mb-16 gap-6">
          <div className="max-w-2xl">
            <span className="font-subheading-eyebrow text-subheading-eyebrow uppercase text-primary tracking-wider block mb-2 font-bold">
              Our Practice Services
            </span>
            <h2 className="font-headline-lg text-[28px] sm:text-[34px] lg:text-headline-lg text-on-surface font-bold tracking-tight">
              Discover Quality Dental Care in Acocks Green
            </h2>
          </div>
          <p className="font-body-md text-body-md text-on-surface-variant max-w-md leading-relaxed">
            Personalized clinical dental solutions delivered in modern surgeries with low radiation digital radiography and compassionate pacing.
          </p>
        </div>

        {/* 4-Column Decare Treatment Grid */}
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
          {servicesData.map((service) => (
            <div
              key={service.id}
              className="bg-surface-card p-6 rounded-2xl shadow-xs hover:shadow-lg border border-border-subtle/70 transition-all duration-300 flex flex-col justify-between group"
            >
              <div>
                {/* Medical Icon in Glowing Tile */}
                <Link href={service.href} className="block w-14 h-14 rounded-xl bg-brand-accent-glow text-primary flex items-center justify-center mb-6 group-hover:scale-105 group-hover:bg-primary group-hover:text-on-primary transition-all duration-200">
                  <span className="material-symbols-outlined text-[30px]">
                    {service.icon}
                  </span>
                </Link>

                {/* Badges */}
                <div className="flex items-center gap-2 mb-3 flex-wrap">
                  <span className="font-label-sm text-[11px] px-2.5 py-0.5 rounded-full bg-surface-container-low text-primary font-semibold">
                    {service.badge1}
                  </span>
                  <span className="font-label-sm text-[11px] px-2.5 py-0.5 rounded-full bg-surface-container-low text-on-surface-variant">
                    {service.badge2}
                  </span>
                </div>

                {/* Service Title */}
                <h3 className="font-headline-sm text-headline-sm text-on-surface mb-3 group-hover:text-primary transition-colors font-bold">
                  <Link href={service.href} className="hover:underline">
                    {service.title}
                  </Link>
                </h3>

                {/* Description */}
                <p className="font-body-md text-body-md text-on-surface-variant leading-relaxed mb-6">
                  {service.description}
                </p>
              </div>

              {/* Action Triggers */}
              <div className="pt-3 border-t border-border-subtle/60 flex items-center justify-between gap-2">
                <Link
                  href={service.href}
                  className="inline-flex items-center gap-1 font-label-md text-[13px] text-primary hover:text-primary-container font-semibold transition-colors group-hover:underline"
                >
                  <span>{service.cta}</span>
                  <span className="material-symbols-outlined text-[16px] group-hover:translate-x-0.5 transition-transform">
                    arrow_forward
                  </span>
                </Link>

                <button
                  type="button"
                  onClick={() => onOpenBooking?.(service.id)}
                  className="p-1.5 rounded-lg text-on-surface-variant hover:text-primary hover:bg-surface-container-low transition-colors cursor-pointer"
                  title="Book this treatment"
                  aria-label={`Book ${service.title}`}
                >
                  <span className="material-symbols-outlined text-[18px]">calendar_month</span>
                </button>
              </div>
            </div>
          ))}
        </div>

        {/* Bottom Banner Linking Directly to Full Catalog */}
        <div className="mt-12 p-6 rounded-2xl bg-surface-container-low border border-border-subtle/80 flex flex-col sm:flex-row items-center justify-between gap-4">
          <div className="flex items-center gap-3">
            <div className="w-10 h-10 rounded-xl bg-primary-container text-on-primary flex items-center justify-center shrink-0 shadow-2xs">
              <span className="material-symbols-outlined text-[20px]">medical_services</span>
            </div>
            <div>
              <h4 className="font-headline-sm text-[16px] font-bold text-on-surface">
                Looking for all treatments and NHS fee bandings?
              </h4>
              <p className="text-[13px] text-on-surface-variant">
                Explore our full catalog of dental procedures, preventative treatments, and private cosmetic options.
              </p>
            </div>
          </div>
          <Link
            href="/treatments"
            className="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-primary text-on-primary font-label-md text-label-md font-bold hover:bg-primary-container transition-colors shadow-sm shrink-0"
          >
            <span>View All Treatments Catalog</span>
            <span className="material-symbols-outlined text-[18px]">arrow_forward</span>
          </Link>
        </div>
      </div>
    </section>
  );
};
