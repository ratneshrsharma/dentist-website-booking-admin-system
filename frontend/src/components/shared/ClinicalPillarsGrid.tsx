'use client';

import React from 'react';

interface PillarItem {
  icon: string;
  title: string;
  description: string;
  tag: string;
}

interface ClinicalPillarsGridProps {
  pillars?: PillarItem[];
  headline?: string;
  eyebrow?: string;
}

const DEFAULT_PILLARS: PillarItem[] = [
  {
    icon: 'radiology',
    title: 'Modern Digital Technology',
    description:
      'Ultra-low radiation digital radiography, 3D CBCT bone mapping, and high-definition intraoral scanners for precise diagnoses.',
    tag: 'Digital Precision',
  },
  {
    icon: 'favorite',
    title: 'Welcoming Phobic Patients',
    description:
      'A gentle, unhurried bedside manner designed specifically to dissolve dental anxiety, sensory discomfort, and panic.',
    tag: 'Gentle Pacing',
  },
  {
    icon: 'calendar_clock',
    title: 'Prompt Emergency Triage',
    description:
      'Guaranteed daily emergency booking slots and rapid pain-relief protocols for toothaches, trauma, and lost restorations.',
    tag: 'Prompt Access',
  },
  {
    icon: 'verified',
    title: 'Strict NHS & CQC Safety',
    description:
      'Strict adherence to Care Quality Commission standards, HTM 01-05 decontamination, and gold-standard autoclaving.',
    tag: '100% CQC Compliant',
  },
];

export const ClinicalPillarsGrid: React.FC<ClinicalPillarsGridProps> = ({
  pillars = DEFAULT_PILLARS,
  headline = 'Clinical Reassurance & Patient Safety Standards',
  eyebrow = 'WHY PATIENTS TRUST OUR SURGERY',
}) => {
  return (
    <section className="w-full py-12 lg:py-16 bg-surface border-t border-border-subtle/60" id="clinical-pillars">
      <div className="max-w-7xl mx-auto px-6 lg:px-12">
        <div className="text-center max-w-2xl mx-auto mb-12">
          <span className="font-subheading-eyebrow text-subheading-eyebrow text-primary uppercase tracking-widest block mb-2 font-bold">
            {eyebrow}
          </span>
          <h2 className="font-display-section text-[28px] sm:text-[34px] lg:text-[40px] text-on-surface tracking-tight">
            {headline}
          </h2>
        </div>

        <div className="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
          {pillars.map((pillar, idx) => (
            <div
              key={idx}
              className="bg-surface-card rounded-2xl border border-border-subtle/80 p-6 flex flex-col justify-between hover:border-primary/40 transition-colors shadow-2xs"
            >
              <div>
                <div className="w-12 h-12 rounded-xl bg-primary/10 text-primary flex items-center justify-center mb-4">
                  <span className="material-symbols-outlined text-[24px]">{pillar.icon}</span>
                </div>
                <h3 className="font-display-title text-[18px] font-bold text-on-surface mb-2">
                  {pillar.title}
                </h3>
                <p className="font-body-sm text-body-sm text-on-surface-variant leading-relaxed mb-4">
                  {pillar.description}
                </p>
              </div>
              <span className="inline-block text-[11px] font-bold text-primary bg-primary/10 px-2.5 py-1 rounded-md w-fit">
                {pillar.tag}
              </span>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
};
