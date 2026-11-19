'use client';

import React from 'react';
import Link from 'next/link';

interface BreadcrumbItem {
  label: string;
  href?: string;
}

interface InnerBannerProps {
  title: string;
  subtitle: string;
  eyebrow?: string;
  breadcrumbs: BreadcrumbItem[];
  leadClinicianName?: string;
  leadClinicianRole?: string;
  imageUrl?: string;
  badgeText?: string;
}

export const InnerBanner: React.FC<InnerBannerProps> = ({
  title,
  subtitle,
  eyebrow = 'ACOCKS GREEN DENTAL PRACTICE',
  breadcrumbs,
  leadClinicianName = 'Dr. Richard C. Williams',
  leadClinicianRole = 'Clinical Director & Lead Surgeon | GDC No: 178924',
  imageUrl = 'https://images.unsplash.com/photo-1622253692010-333f2da6031d?auto=format&fit=crop&q=80&w=800',
  badgeText = 'NHS & Private Care',
}) => {
  return (
    <section className="w-full bg-surface py-8 lg:py-10 border-b border-border-subtle/60">
      <div className="max-w-7xl mx-auto px-6 lg:px-12">
        <div className="grid lg:grid-cols-12 gap-8 items-center">
          {/* Left Text & Breadcrumbs */}
          <div className="lg:col-span-7">
            {/* Breadcrumb Navigation */}
            <nav
              aria-label="Breadcrumb"
              className="flex items-center gap-1.5 font-label-sm text-label-sm text-on-surface-variant mb-3 flex-wrap"
            >
              <Link href="/" className="hover:text-primary transition-colors flex items-center gap-1">
                <span className="material-symbols-outlined text-[15px]">home</span>
                <span>Home</span>
              </Link>
              {breadcrumbs.map((crumb, idx) => (
                <React.Fragment key={idx}>
                  <span className="material-symbols-outlined text-[13px] text-outline">
                    chevron_right
                  </span>
                  {crumb.href ? (
                    <Link href={crumb.href} className="hover:text-primary transition-colors">
                      {crumb.label}
                    </Link>
                  ) : (
                    <span className="text-primary font-semibold">{crumb.label}</span>
                  )}
                </React.Fragment>
              ))}
            </nav>

            <span className="font-subheading-eyebrow text-subheading-eyebrow text-primary uppercase tracking-widest block mb-1.5 font-bold">
              {eyebrow}
            </span>

            <h1 className="font-display-hero text-[30px] sm:text-[38px] lg:text-[44px] text-on-surface mb-3 tracking-tight leading-tight">
              {title}
            </h1>

            <p className="font-body-md text-body-md text-on-surface-variant leading-relaxed max-w-2xl">
              {subtitle}
            </p>
          </div>

          {/* Right Lead Clinician Visual Card */}
          <div className="lg:col-span-5 relative">
            {/* eslint-disable-next-line @next/next/no-img-element */}
            <img
              alt={leadClinicianName}
              className="rounded-2xl shadow-md border border-border-subtle/80 object-cover h-64 lg:h-72 w-full"
              src={imageUrl}
            />
            <div className="absolute bottom-3 left-3 right-3 bg-surface-card/95 backdrop-blur-md px-4 py-2.5 rounded-xl border border-border-subtle shadow-sm flex items-center justify-between">
              <div>
                <span className="font-label-sm text-label-sm text-primary font-bold block">
                  {leadClinicianName}
                </span>
                <span className="text-[11px] text-on-surface-variant font-medium">
                  {leadClinicianRole}
                </span>
              </div>
              <span className="bg-primary/10 text-primary font-label-sm text-[11px] px-2.5 py-1 rounded-md font-semibold shrink-0">
                {badgeText}
              </span>
            </div>
          </div>
        </div>
      </div>
    </section>
  );
};
