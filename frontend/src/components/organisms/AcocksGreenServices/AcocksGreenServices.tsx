'use client';

import React, { useState } from 'react';
import Link from 'next/link';

interface AcocksGreenServicesProps {
  onOpenBooking?: (serviceId?: number) => void;
}

interface HomepageServiceCard {
  id: number;
  slug: string;
  category: string;
  categoryLabel: string;
  title: string;
  badge: string;
  badgeClass?: string;
  icon: string;
  image: string;
  description: string;
  features: string[];
  nhsPricing: string;
  privatePricing: string;
  ctaText: string;
}

const HOMEPAGE_SERVICES: HomepageServiceCard[] = [
  {
    id: 1,
    slug: 'general-dentistry',
    category: 'general',
    categoryLabel: 'General Dentistry',
    title: 'Routine Examinations & Check-ups',
    badge: 'NHS & Private Available',
    badgeClass: 'bg-primary text-on-primary',
    icon: 'dentistry',
    image: 'https://images.unsplash.com/photo-1588776814546-1ffcf47267a5?auto=format&fit=crop&q=80&w=800',
    description:
      'Comprehensive oral health assessments, low-dose digital radiographs, periodontal screening, and early cancer detection for patients of all ages.',
    features: [
      'Low-Dose Digital Bitewing Radiographs',
      'BPE Periodontal Screening & Gum Score',
      'Soft Tissue & Oral Cancer Screening Protocol',
    ],
    nhsPricing: 'Band 1 (£26.80)',
    privatePricing: 'From £45.00',
    ctaText: 'View General Dentistry',
  },
  {
    id: 2,
    slug: 'general-dentistry#hygiene',
    category: 'hygiene',
    categoryLabel: 'Hygiene & Prevention',
    title: 'Dental Hygiene & AirFlow Therapy',
    badge: 'Direct Access Available',
    badgeClass: 'bg-teal-700 text-white',
    icon: 'clean_hands',
    image: 'https://images.unsplash.com/photo-1606811841689-23dfddce3e95?auto=format&fit=crop&q=80&w=800',
    description:
      'Professional ultrasonic scaling, targeted stain removal with AirFlow technology, and personalized periodontal maintenance to preserve bone support.',
    features: [
      'AirFlow High-Precision Polish & Stain Removal',
      'Ultrasonic Plaque & Subgingival Debridement',
      'Personalized Gum Health & Interdental Protocol',
    ],
    nhsPricing: 'Band 2 (if clinical)',
    privatePricing: 'From £65.00',
    ctaText: 'Explore Hygiene Services',
  },
  {
    id: 3,
    slug: 'crowns-and-bridges',
    category: 'restorative',
    categoryLabel: 'Restorative Care',
    title: 'Crowns, Bridges & Restorative Care',
    badge: 'High-Durability Ceramics',
    badgeClass: 'bg-secondary text-on-secondary',
    icon: 'architecture',
    image: 'https://images.unsplash.com/photo-1598256989800-fe5f95da9787?auto=format&fit=crop&q=80&w=800',
    description:
      'Rebuilding broken or decayed teeth with biocompatible, natural-looking porcelain, lithium disilicate (E-Max), and monolithic zirconia prosthetics.',
    features: [
      'Monolithic Zirconia & E-Max Ceramic Formulations',
      'Precision 3D Digital Scans (No Messy Trays)',
      'Multi-Unit Fixed Bridges for Gap Replacement',
    ],
    nhsPricing: 'Band 3 (£319.10)',
    privatePricing: 'From £495.00',
    ctaText: 'Explore Restorations',
  },
  {
    id: 4,
    slug: 'dental-implants',
    category: 'implants',
    categoryLabel: 'Implantology & Surgery',
    title: 'Dental Implants & Bone Grafting',
    badge: 'Lifelong Titanium Tooth Roots',
    badgeClass: 'bg-indigo-700 text-white',
    icon: 'vital_signs',
    image: 'https://images.unsplash.com/photo-1629909613654-28e377c37b09?auto=format&fit=crop&q=80&w=800',
    description:
      'Permanent Swiss-grade titanium tooth root replacement, 3D CBCT guided keyhole surgery, and same-day full arch All-on-4 restorations.',
    features: [
      '3D CBCT Volumetric Radiology & Nerve Mapping',
      'Sub-Millimeter Computer Guided Keyhole Placement',
      'Single Tooth, Multi-Unit & All-on-4 Solutions',
    ],
    nhsPricing: 'Private Only',
    privatePricing: 'From £1,995.00 (0% APR)',
    ctaText: 'View Implant Options',
  },
  {
    id: 5,
    slug: 'clear-aligners',
    category: 'aesthetic',
    categoryLabel: 'Aesthetic Orthodontics',
    title: 'Clear Aligners & Invisalign®',
    badge: 'Invisalign® Smile Simulation',
    badgeClass: 'bg-primary-container text-on-primary',
    icon: 'auto_awesome',
    image: 'https://images.unsplash.com/photo-1579684385127-1ef15d508118?auto=format&fit=crop&q=80&w=800',
    description:
      'Discreet, removable clear aligners engineered to straighten crooked, crowded, or spaced teeth predictably without metal brackets or wires.',
    features: [
      'Custom 3D ClinCheck Virtual Outcome Simulation',
      'Transparent, Removable & Lifestyle-Friendly',
      'Complimentary Teeth Whitening with Full Treatment',
    ],
    nhsPricing: 'Private Only',
    privatePricing: 'From £1,495.00 (0% APR)',
    ctaText: 'Explore Clear Aligners',
  },
  {
    id: 6,
    slug: 'root-canal-treatment',
    category: 'emergency',
    categoryLabel: 'Emergency & Endodontics',
    title: 'Root Canal Therapy & Urgent Relief',
    badge: 'Same-Day Slots Guaranteed',
    badgeClass: 'bg-status-error text-on-error',
    icon: 'medical_services',
    image: 'https://images.unsplash.com/photo-1606811841689-23dfddce3e95?auto=format&fit=crop&q=80&w=800',
    description:
      'Rapid-response triage and diagnosis for severe toothaches, dental abscesses, trauma, and gentle single-visit rotary endodontics.',
    features: [
      'Priority Same-Day Triage Mon–Fri on 0121 765 2870',
      'Rotary Endodontics & Electronic Apex Locators',
      'Definitive Pain Relief & Infection Management',
    ],
    nhsPricing: 'Band 2 (£73.50)',
    privatePricing: 'From £395.00',
    ctaText: 'Emergency & Root Canal',
  },
];

const CATEGORIES = [
  { id: 'all', label: 'All Treatments' },
  { id: 'general', label: 'General & Check-ups' },
  { id: 'hygiene', label: 'Hygiene & Prevention' },
  { id: 'restorative', label: 'Restorative & Crowns' },
  { id: 'implants', label: 'Implants & Surgery' },
  { id: 'aesthetic', label: 'Aesthetic & Aligners' },
  { id: 'emergency', label: 'Emergency Relief' },
];

export const AcocksGreenServices: React.FC<AcocksGreenServicesProps> = ({
  onOpenBooking,
}) => {
  const [activeCategory, setActiveCategory] = useState<string>('all');

  const filteredServices =
    activeCategory === 'all'
      ? HOMEPAGE_SERVICES
      : HOMEPAGE_SERVICES.filter((s) => s.category === activeCategory);

  return (
    <section id="services" className="py-20 md:py-24 bg-surface relative">
      <div className="max-w-7xl mx-auto px-6 lg:px-12 pt-4">
        {/* Section Header */}
        <div className="flex flex-col md:flex-row md:items-end justify-between mb-8 md:mb-12 gap-6">
          <div className="max-w-2xl">
            <span className="font-subheading-eyebrow text-subheading-eyebrow uppercase text-primary tracking-wider block mb-2 font-bold">
              Our Practice Treatments &amp; Services
            </span>
            <h2 className="font-headline-lg text-[28px] sm:text-[34px] lg:text-headline-lg text-on-surface font-bold tracking-tight">
              Evidence-Based Clinical Dentistry in Acocks Green
            </h2>
          </div>
          <p className="font-body-md text-body-md text-on-surface-variant max-w-md leading-relaxed">
            Delivering both statutory NHS dental bandings and advanced private cosmetic &amp; restorative solutions on Warwick Road, Birmingham B27 6BH.
          </p>
        </div>

        {/* Category Filter Pills (matching /treatments/) */}
        <div className="flex flex-wrap items-center gap-2 mb-8" role="tablist" aria-label="Treatment categories">
          {CATEGORIES.map((cat) => {
            const isActive = activeCategory === cat.id;
            return (
              <button
                key={cat.id}
                type="button"
                role="tab"
                aria-selected={isActive}
                onClick={() => setActiveCategory(cat.id)}
                className={`font-label-md text-label-md px-3.5 py-1.5 rounded-lg transition-all duration-150 cursor-pointer ${
                  isActive
                    ? 'bg-primary text-on-primary shadow-sm font-semibold'
                    : 'bg-surface-card border border-border-subtle text-on-surface-variant hover:text-on-surface hover:bg-surface-container'
                }`}
              >
                {cat.label}
              </button>
            );
          })}
        </div>

        {/* Quick Procedure Jump Pill Strip (10 Core Treatments) */}
        <div className="mb-10 pb-4 border-b border-border-subtle/60">
          <span className="text-[11px] font-bold text-on-surface-variant uppercase tracking-wider block mb-2">
            Direct Procedure Guides:
          </span>
          <div className="flex flex-wrap items-center gap-1.5">
            {[
              { label: 'General Dentistry', href: '/treatments/general-dentistry' },
              { label: 'Dental Implants', href: '/treatments/dental-implants' },
              { label: 'Clear Aligners', href: '/treatments/clear-aligners' },
              { label: 'Crowns & Bridges', href: '/treatments/crowns-and-bridges' },
              { label: 'Root Canal Treatment', href: '/treatments/root-canal-treatment' },
              { label: 'Teeth Whitening', href: '/treatments/teeth-whitening' },
              { label: 'Porcelain Veneers', href: '/treatments/porcelain-veneers' },
              { label: 'All-on-4 Implants', href: '/treatments/all-on-4-dental-implants' },
              { label: 'Computer Guided Surgery', href: '/treatments/computer-guided-implant-surgery' },
              { label: 'Cosmetic Dentistry', href: '/treatments/cosmetic-dentistry' },
            ].map((proc) => (
              <Link
                key={proc.href}
                href={proc.href}
                className="text-[11px] sm:text-[12px] px-2.5 py-1 rounded-md bg-surface-card hover:bg-primary hover:text-on-primary text-on-surface-variant border border-border-subtle/80 transition-all duration-150 inline-flex items-center gap-1 shadow-2xs group"
              >
                <span>{proc.label}</span>
                <span className="material-symbols-outlined text-[13px] group-hover:translate-x-0.5 transition-transform">
                  arrow_forward
                </span>
              </Link>
            ))}
          </div>
        </div>

        {/* Treatment Cards Grid (3 Columns, matching /treatments/ style) */}
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          {filteredServices.map((service) => {
            const href = `/treatments/${service.slug}`;
            return (
              <article
                key={service.id}
                className="service-card group bg-surface-card rounded-2xl border border-border-subtle shadow-sm overflow-hidden flex flex-col transition-all duration-300 hover:-translate-y-1.5 hover:shadow-lg"
              >
                {/* Visual Image with Badge */}
                <div className="relative h-52 w-full overflow-hidden bg-surface-container-high">
                  <Link href={href} className="block w-full h-full">
                    {/* eslint-disable-next-line @next/next/no-img-element */}
                    <img
                      alt={service.title}
                      className="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                      src={service.image}
                    />
                  </Link>
                  <div
                    className={`absolute top-4 left-4 font-label-sm text-label-sm px-3 py-1 rounded-md shadow-sm flex items-center gap-1.5 ${
                      service.badgeClass || 'bg-primary text-on-primary'
                    }`}
                  >
                    <span className="material-symbols-outlined text-[14px]">verified</span>
                    <span className="font-semibold">{service.badge}</span>
                  </div>
                </div>

                {/* Card Body */}
                <div className="p-6 lg:p-7 flex flex-col flex-1 justify-between">
                  <div>
                    {/* Category Eyebrow with Icon */}
                    <div className="flex items-center gap-2 mb-2">
                      <span className="material-symbols-outlined text-[20px] text-primary">
                        {service.icon}
                      </span>
                      <span className="font-subheading-eyebrow text-subheading-eyebrow uppercase text-primary font-bold">
                        {service.categoryLabel}
                      </span>
                    </div>

                    {/* Procedure Title */}
                    <h3 className="font-headline-sm text-headline-sm text-on-surface mb-3 group-hover:text-primary transition-colors font-bold">
                      <Link href={href} className="hover:underline">
                        {service.title}
                      </Link>
                    </h3>

                    {/* Excerpt */}
                    <p className="font-body-md text-body-md text-on-surface-variant mb-5 leading-relaxed">
                      {service.description}
                    </p>

                    {/* Clinical Feature Checklist */}
                    <ul className="flex flex-col gap-2 mb-6 text-on-surface-variant font-body-sm text-body-sm">
                      {service.features.map((feat, i) => (
                        <li key={i} className="flex items-center gap-2">
                          <span className="material-symbols-outlined text-primary text-[17px] shrink-0">
                            check_circle
                          </span>
                          <span>{feat}</span>
                        </li>
                      ))}
                    </ul>

                    {/* Pricing Summary Chips */}
                    <div className="mb-6 p-3 rounded-xl bg-surface-container-low border border-border-subtle/80 flex items-center justify-between text-[12px]">
                      <div>
                        <span className="text-on-surface-variant block font-medium">NHS Banding:</span>
                        <span className="font-bold text-on-surface">{service.nhsPricing}</span>
                      </div>
                      <div className="h-6 w-px bg-border-subtle" />
                      <div className="text-right">
                        <span className="text-on-surface-variant block font-medium">Private Option:</span>
                        <span className="font-bold text-primary">{service.privatePricing}</span>
                      </div>
                    </div>
                  </div>

                  {/* Action Buttons */}
                  <div className="pt-4 border-t border-border-subtle flex items-center justify-between gap-3">
                    <button
                      type="button"
                      onClick={() => onOpenBooking?.(service.id)}
                      className="inline-flex items-center gap-1.5 font-label-md text-label-md bg-primary-container text-on-primary px-3.5 py-2 rounded-lg shadow-xs hover:bg-primary transition-colors cursor-pointer"
                    >
                      <span className="material-symbols-outlined text-[16px]">calendar_month</span>
                      <span>Book Treatment</span>
                    </button>

                    <Link
                      href={href}
                      className="inline-flex items-center gap-1 font-label-md text-label-md text-primary hover:text-primary-container font-semibold transition-colors group-hover:underline"
                    >
                      <span>Full Guide</span>
                      <span className="material-symbols-outlined text-[16px] group-hover:translate-x-0.5 transition-transform">
                        arrow_forward
                      </span>
                    </Link>
                  </div>
                </div>
              </article>
            );
          })}
        </div>

        {/* Bottom Banner Linking to Full Treatments Catalog */}
        <div className="mt-14 p-6 rounded-2xl bg-surface-container-low border border-border-subtle/80 flex flex-col sm:flex-row items-center justify-between gap-4">
          <div className="flex items-center gap-3">
            <div className="w-10 h-10 rounded-xl bg-primary-container text-on-primary flex items-center justify-center shrink-0 shadow-2xs">
              <span className="material-symbols-outlined text-[20px]">medical_services</span>
            </div>
            <div>
              <h4 className="font-headline-sm text-[16px] font-bold text-on-surface">
                Looking for all treatments, specialist options &amp; NHS fee bandings?
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
