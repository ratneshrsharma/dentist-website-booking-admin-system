'use client';

import React from 'react';

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
    description:
      'Deep ultrasonic plaque scaling, stubborn nicotine and coffee stain removal, and periodontal disease therapy led by our dedicated hygienist Claire.',
    cta: 'Meet Our Hygienist',
  },
  {
    id: 3,
    title: 'Restorative Dentistry',
    badge1: 'Restorative',
    badge2: 'Crowns & Bridges',
    icon: 'vital_signs',
    description:
      'Rebuild chewing function and oral harmony with customized ceramic crowns, bridges, durable inlays, and prosthetics designed for longevity.',
    cta: 'View Treatments',
  },
  {
    id: 4,
    title: 'Aesthetic & Aligners',
    badge1: 'Cosmetic',
    badge2: 'Invisalign®',
    icon: 'auto_awesome',
    description:
      'Transform your smile with professional boutique teeth whitening, handcrafted porcelain veneers, and Invisalign® discreet clear aligner therapy.',
    cta: 'Consult Aesthetic Team',
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
                <div className="w-14 h-14 rounded-xl bg-brand-accent-glow text-primary flex items-center justify-center mb-6 group-hover:scale-105 group-hover:bg-primary group-hover:text-on-primary transition-all duration-200">
                  <span className="material-symbols-outlined text-[30px]">
                    {service.icon}
                  </span>
                </div>

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
                  {service.title}
                </h3>

                {/* Description */}
                <p className="font-body-md text-body-md text-on-surface-variant leading-relaxed mb-6">
                  {service.description}
                </p>
              </div>

              {/* Action Trigger */}
              <button
                type="button"
                onClick={() => onOpenBooking?.(service.id)}
                className="inline-flex items-center gap-2 font-label-md text-label-md text-primary hover:text-primary-container font-semibold transition-colors cursor-pointer pt-2 group-hover:underline"
              >
                <span>{service.cta}</span>
                <span className="material-symbols-outlined text-[16px] group-hover:translate-x-1 transition-transform">
                  arrow_forward
                </span>
              </button>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
};
