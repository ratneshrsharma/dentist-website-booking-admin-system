'use client';

import React from 'react';

export interface CharterCmsData {
  badge?: string;
  headline?: string;
  title?: string;
  description?: string;
  practice_manager_contact?: string;
  charter_pdf_url?: string;
}

interface AcocksGreenSafetyCharterProps {
  data?: CharterCmsData;
}

export const AcocksGreenSafetyCharter: React.FC<AcocksGreenSafetyCharterProps> = ({ data }) => {
  const badgeText = data?.badge || 'NHS Safety Standard';
  const headlineText = data?.headline || data?.title || 'NHS Sexual Safety Charter & Patient Protection';
  const descText =
    data?.description ||
    'Acocks Green Dental Practice is strictly committed to providing a safe, respectful environment where every patient, visitor, and staff member feels completely protected and valued. We maintain a zero-tolerance policy towards harassment or inappropriate conduct across all practice touchpoints.';
  const managerContact = data?.practice_manager_contact || 'Rebecca Solly';
  const pdfUrl =
    data?.charter_pdf_url ||
    'https://www.acocksgreendentalpractice.co.uk/wp-content/uploads/2026/04/SEXUAL-SAFETY-CHARTER.pdf';

  return (
    <section id="charter" className="py-16 md:py-20 bg-surface relative">
      <div className="max-w-7xl mx-auto px-6 lg:px-12">
        <div className="bg-surface-card p-8 lg:p-10 rounded-2xl shadow-xs border border-border-subtle/80">
          <div className="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
            {/* Left Content Column (8 cols) */}
            <div className="lg:col-span-8 space-y-4">
              <div className="inline-flex items-center gap-2 bg-secondary-fixed/50 px-3 py-1 rounded-full text-on-secondary-fixed border border-secondary-fixed/30">
                <span className="material-symbols-outlined text-[18px] text-primary">verified</span>
                <span className="font-subheading-eyebrow text-[11px] uppercase tracking-wider font-bold text-primary">
                  {badgeText}
                </span>
              </div>

              <h2 className="font-headline-md text-[24px] sm:text-[28px] lg:text-headline-md text-on-surface font-bold tracking-tight">
                {headlineText}
              </h2>

              <p className="font-body-md text-body-md text-on-surface-variant leading-relaxed">
                {descText}
              </p>

              <div className="bg-surface-container-low p-4 rounded-xl flex items-center gap-3 border border-border-subtle/60">
                <div className="w-10 h-10 rounded-lg bg-brand-accent-glow text-primary flex items-center justify-center shrink-0">
                  <span className="material-symbols-outlined text-[24px]">support_agent</span>
                </div>
                <p className="font-body-sm text-body-sm text-on-surface leading-snug">
                  <strong>How to raise a concern:</strong> You may speak directly to our Practice Manager,{' '}
                  <strong className="text-primary font-bold">{managerContact}</strong>, in private confidence at any time.
                </p>
              </div>
            </div>

            {/* Right Action Column (4 cols) */}
            <div className="lg:col-span-4 flex flex-col items-start lg:items-end justify-center space-y-3">
              <a
                className="inline-flex items-center gap-2 bg-primary-container text-on-primary font-label-md text-label-md px-6 py-3.5 rounded-lg hover:bg-primary transition-all duration-200 shadow-sm hover:shadow-md cursor-pointer font-semibold"
                href={pdfUrl}
                target="_blank"
                rel="noopener noreferrer"
              >
                <span className="material-symbols-outlined text-[18px]">download</span>
                <span>Download Charter (PDF)</span>
              </a>
              <span className="font-label-sm text-[12px] text-on-surface-variant flex items-center gap-1">
                <span className="material-symbols-outlined text-[14px] text-primary">shield</span>
                <span>Official NHS England Framework</span>
              </span>
            </div>
          </div>
        </div>
      </div>
    </section>
  );
};
