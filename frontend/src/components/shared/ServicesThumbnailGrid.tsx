'use client';

import React, { useState } from 'react';
import { TreatmentCard } from './TreatmentCard';
import { TreatmentCardSkeleton } from './TreatmentCardSkeleton';
import { CLINICAL_9_TREATMENTS, TreatmentItem } from './treatmentsData';

interface ServicesThumbnailGridProps {
  onOpenBooking?: (serviceId?: number) => void;
  isLoading?: boolean;
  activeFilter?: string;
  showCategoryFilters?: boolean;
  headline?: string;
  eyebrow?: string;
  subtitle?: string;
}

export const ServicesThumbnailGrid: React.FC<ServicesThumbnailGridProps> = ({
  onOpenBooking,
  isLoading = false,
  activeFilter: initialFilter = 'all',
  showCategoryFilters = true,
  headline = 'Our 9 Specialized Dental Treatments & Clinical Services',
  eyebrow = 'EVIDENCE-BASED CLINICAL EXCELLENCE',
  subtitle = 'Comprehensive NHS fee bands and bespoke private dental options at 1078 Warwick Road, Birmingham.',
}) => {
  const [activeCategory, setActiveCategory] = useState<string>(initialFilter);

  const categories = [
    { id: 'all', label: 'All 9 Treatments' },
    { id: 'general', label: 'NHS & General Dentistry' },
    { id: 'restorative', label: 'Restorative & Implants' },
    { id: 'cosmetic', label: 'Cosmetic & Aligners' },
    { id: 'emergency', label: 'Emergency Pain Relief' },
  ];

  const filteredTreatments: TreatmentItem[] = CLINICAL_9_TREATMENTS.filter((t) => {
    if (activeCategory === 'all') return true;
    if (activeCategory === 'general') return t.category === 'general' || t.category === 'hygiene';
    if (activeCategory === 'restorative') return t.category === 'restorative' || t.category === 'implants';
    if (activeCategory === 'cosmetic') return t.category === 'cosmetic' || t.category === 'orthodontics';
    if (activeCategory === 'emergency') return t.category === 'emergency';
    return true;
  });

  return (
    <section className="w-full py-10 lg:py-16 bg-surface" id="clinical-services-grid">
      <div className="max-w-7xl mx-auto px-6 lg:px-12">
        {/* Section Header */}
        <div className="flex flex-col md:flex-row md:items-end justify-between mb-8 gap-4">
          <div>
            <span className="font-subheading-eyebrow text-subheading-eyebrow text-primary uppercase tracking-widest block mb-2 font-bold">
              {eyebrow}
            </span>
            <h2 className="font-display-section text-[28px] sm:text-[34px] lg:text-[40px] text-on-surface tracking-tight leading-tight max-w-2xl">
              {headline}
            </h2>
            {subtitle && (
              <p className="font-body-md text-body-md text-on-surface-variant max-w-2xl mt-2 leading-relaxed">
                {subtitle}
              </p>
            )}
          </div>

          {/* Quick Counter */}
          <div className="hidden md:flex items-center gap-2 bg-primary/10 text-primary px-3.5 py-1.5 rounded-full text-[13px] font-semibold shrink-0">
            <span className="material-symbols-outlined text-[18px]">verified</span>
            <span>9 Clinical Procedures Active</span>
          </div>
        </div>

        {/* Category Filter Pills (High-contrast, accessibility-tested) */}
        {showCategoryFilters && (
          <div
            className="flex flex-wrap items-center gap-2 mb-8 pb-3 border-b border-border-subtle/60"
            role="tablist"
            aria-label="Filter clinical treatments by category"
          >
            {categories.map((cat) => {
              const isActive = activeCategory === cat.id;
              return (
                <button
                  key={cat.id}
                  type="button"
                  role="tab"
                  aria-selected={isActive}
                  onClick={() => setActiveCategory(cat.id)}
                  className={`font-label-md text-label-md px-4 py-2 rounded-xl transition-all duration-200 cursor-pointer font-medium ${
                    isActive
                      ? 'bg-primary text-white shadow-sm font-semibold scale-102'
                      : 'bg-white hover:bg-slate-100 text-slate-700 border border-slate-200 hover:border-slate-300'
                  }`}
                >
                  {cat.label}
                </button>
              );
            })}
          </div>
        )}

        {/* 9 Treatments 3x3 Responsive Grid */}
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
          {isLoading
            ? Array.from({ length: 6 }).map((_, idx) => (
                <TreatmentCardSkeleton key={`skeleton-${idx}`} />
              ))
            : filteredTreatments.map((treatment) => (
                <TreatmentCard
                  key={treatment.id}
                  treatment={treatment}
                  onOpenBooking={onOpenBooking}
                />
              ))}
        </div>
      </div>
    </section>
  );
};
