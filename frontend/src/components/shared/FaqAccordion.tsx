'use client';

import React, { useState } from 'react';

interface FaqItem {
  question: string;
  answer: string;
}

interface FaqAccordionProps {
  items: FaqItem[];
  headline?: string;
  eyebrow?: string;
}

export const FaqAccordion: React.FC<FaqAccordionProps> = ({
  items,
  headline = 'Frequently Asked Questions',
  eyebrow = 'PATIENT GUIDANCE & CLARITY',
}) => {
  const [openIndex, setOpenIndex] = useState<number | null>(0);

  const toggle = (idx: number) => {
    setOpenIndex(openIndex === idx ? null : idx);
  };

  return (
    <section className="w-full py-12 lg:py-16 bg-surface border-t border-border-subtle/60" id="faq-section">
      <div className="max-w-4xl mx-auto px-6 lg:px-8">
        <div className="text-center mb-10">
          <span className="font-subheading-eyebrow text-subheading-eyebrow text-primary uppercase tracking-widest block mb-2 font-bold">
            {eyebrow}
          </span>
          <h2 className="font-display-section text-[28px] sm:text-[34px] text-on-surface tracking-tight">
            {headline}
          </h2>
        </div>

        <div className="space-y-3">
          {items.map((item, idx) => {
            const isOpen = openIndex === idx;
            return (
              <div
                key={idx}
                className="bg-surface-card rounded-xl border border-border-subtle overflow-hidden transition-colors"
              >
                <button
                  type="button"
                  onClick={() => toggle(idx)}
                  className="w-full p-4 sm:p-5 text-left flex items-center justify-between gap-4 font-bold text-on-surface text-[16px] hover:text-primary transition-colors cursor-pointer"
                >
                  <span>{item.question}</span>
                  <span
                    className={`material-symbols-outlined text-[20px] transition-transform duration-200 text-primary ${
                      isOpen ? 'rotate-180' : ''
                    }`}
                  >
                    expand_more
                  </span>
                </button>
                {isOpen && (
                  <div className="px-4 sm:px-5 pb-5 pt-1 text-sm text-on-surface-variant leading-relaxed border-t border-border-subtle/40">
                    <p>{item.answer}</p>
                  </div>
                )}
              </div>
            );
          })}
        </div>
      </div>
    </section>
  );
};
