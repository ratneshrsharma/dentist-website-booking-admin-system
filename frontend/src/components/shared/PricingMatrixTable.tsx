'use client';

import React from 'react';

interface NhsBand {
  band: string;
  desc: string;
  price: string;
  isUrgent?: boolean;
}

interface PrivateOption {
  service: string;
  desc: string;
  price: string;
  prefix?: string;
}

interface PricingMatrixTableProps {
  nhsBands: NhsBand[];
  privateOptions: PrivateOption[];
  onOpenBooking?: () => void;
}

export const PricingMatrixTable: React.FC<PricingMatrixTableProps> = ({
  nhsBands,
  privateOptions,
  onOpenBooking,
}) => {
  return (
    <section className="w-full py-12 lg:py-16 bg-surface-container/50 border-t border-border-subtle/60" id="pricing-matrix">
      <div className="max-w-7xl mx-auto px-6 lg:px-12">
        <div className="text-center max-w-2xl mx-auto mb-12">
          <span className="font-subheading-eyebrow text-subheading-eyebrow text-primary uppercase tracking-widest block mb-2 font-bold">
            TRANSPARENT FEE SCHEDULE
          </span>
          <h2 className="font-display-section text-[28px] sm:text-[34px] lg:text-[40px] text-on-surface tracking-tight mb-3">
            NHS Fee Bands &amp; Private Pricing Matrix
          </h2>
          <p className="font-body-md text-body-md text-on-surface-variant">
            We believe in complete pricing transparency with zero hidden costs. Review our standard NHS treatment bands and bespoke private care fees.
          </p>
        </div>

        <div className="grid lg:grid-cols-2 gap-8 items-start">
          {/* NHS Banding Column */}
          <div className="bg-surface-card rounded-2xl border border-border-subtle p-6 sm:p-8 shadow-sm">
            <div className="flex items-center justify-between mb-6 pb-4 border-b border-border-subtle">
              <div>
                <h3 className="font-display-title text-[20px] font-bold text-on-surface">
                  NHS Banded Treatment Fees
                </h3>
                <span className="text-xs text-on-surface-variant">Standard NHS England Dental Charges</span>
              </div>
              <span className="bg-primary/10 text-primary font-semibold text-xs px-3 py-1 rounded-full">
                NHS Scotland &amp; England
              </span>
            </div>

            <div className="space-y-4">
              {nhsBands.map((band, idx) => (
                <div
                  key={idx}
                  className={`p-4 rounded-xl border transition-colors ${
                    band.isUrgent
                      ? 'bg-red-50/50 border-red-200'
                      : 'bg-surface border-border-subtle hover:border-primary/40'
                  }`}
                >
                  <div className="flex items-center justify-between mb-1">
                    <span className="font-bold text-on-surface text-[16px]">{band.band}</span>
                    <span className="font-display-title font-bold text-primary text-[17px]">
                      {band.price}
                    </span>
                  </div>
                  <p className="text-sm text-on-surface-variant">{band.desc}</p>
                </div>
              ))}
            </div>
          </div>

          {/* Private Care Column */}
          <div className="bg-surface-card rounded-2xl border border-border-subtle p-6 sm:p-8 shadow-sm">
            <div className="flex items-center justify-between mb-6 pb-4 border-b border-border-subtle">
              <div>
                <h3 className="font-display-title text-[20px] font-bold text-on-surface">
                  Private &amp; Cosmetic Fees
                </h3>
                <span className="text-xs text-on-surface-variant">Advanced Materials &amp; Extended Appointments</span>
              </div>
              <span className="bg-secondary/10 text-secondary font-semibold text-xs px-3 py-1 rounded-full">
                0% APR Finance Available
              </span>
            </div>

            <div className="space-y-4">
              {privateOptions.map((opt, idx) => (
                <div
                  key={idx}
                  className="p-4 rounded-xl border border-border-subtle bg-surface hover:border-secondary/40 transition-colors"
                >
                  <div className="flex items-center justify-between mb-1">
                    <span className="font-bold text-on-surface text-[16px]">{opt.service}</span>
                    <div className="text-right">
                      {opt.prefix && <span className="text-xs text-on-surface-variant mr-1">{opt.prefix}</span>}
                      <span className="font-display-title font-bold text-secondary text-[17px]">
                        {opt.price}
                      </span>
                    </div>
                  </div>
                  <p className="text-sm text-on-surface-variant">{opt.desc}</p>
                </div>
              ))}
            </div>

            <div className="mt-6 pt-6 border-t border-border-subtle text-center">
              <button
                type="button"
                onClick={onOpenBooking}
                className="w-full py-3 px-6 rounded-xl font-semibold bg-primary hover:bg-primary-dark text-on-primary transition-colors shadow-sm flex items-center justify-center gap-2 cursor-pointer"
              >
                <span>Book Consultation &amp; Treatment Assessment</span>
                <span className="material-symbols-outlined text-[18px]">arrow_forward</span>
              </button>
            </div>
          </div>
        </div>
      </div>
    </section>
  );
};
