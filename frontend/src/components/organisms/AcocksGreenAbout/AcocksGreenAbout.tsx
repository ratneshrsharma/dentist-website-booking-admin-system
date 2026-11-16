'use client';

import React, { useState } from 'react';
import { getAssetPath } from '@/lib/assetPath';

const REMOTE_FALLBACK_1 =
  'https://lh3.googleusercontent.com/aida-public/AB6AXuBcqm72jYfdOV_hJJXJ0-zuO_KZtyrbc-5BvP9Sf60v1dFXQP1GvzlFL2ClUz413vl_bGHE9jaAAslNl17soPzD4pNmODKaMaDtJhSGuHf0HjG0k6TtI9qh_GSpsgVe9ILOzSPZyid2qPrmc1daq5-iJe6PXfKceZvxrBggcsdhLixCHjeDwbThSydVOcESTXcrJ-mtC8mKb6XCkaIv0CsJ8d8D9szYOh_wEZipag_I';

const REMOTE_FALLBACK_2 =
  'https://lh3.googleusercontent.com/aida-public/AB6AXuBvQmLjgKxwCeJTDpXlRGFSe4hdL420kvlp07oRPMmIBbguZ6Y69xr_LD7iJ-JviRg0SM8HdkoiRThknfRVgPDSZVcWZ1mxP4wvhQJFUBlv5zeJ4c0-bWwc2KhMcF9Smeu5EELsOvXjoNvIEM1DBja6XOCG9ctbIisGxs4BJ8ytRc_B8hqIAClvVzrsd7Cbp8aube4jnvQwAWJXGjRiQ3D45xDeRNtxh9fcpzZ2xvXX';

interface AcocksGreenAboutProps {
  onOpenBooking?: () => void;
}

export const AcocksGreenAbout: React.FC<AcocksGreenAboutProps> = ({
  onOpenBooking,
}) => {
  const [photo1Src, setPhoto1Src] = useState(() => getAssetPath('/images/surgery-clinic.jpg'));
  const [photo1Error, setPhoto1Error] = useState(false);

  const [photo2Src, setPhoto2Src] = useState(() => getAssetPath('/images/treatment-room.jpg'));
  const [photo2Error, setPhoto2Error] = useState(false);

  const handlePhoto1Error = () => {
    if (photo1Src !== REMOTE_FALLBACK_1) {
      setPhoto1Src(REMOTE_FALLBACK_1);
    } else {
      setPhoto1Error(true);
    }
  };

  const handlePhoto2Error = () => {
    if (photo2Src !== REMOTE_FALLBACK_2) {
      setPhoto2Src(REMOTE_FALLBACK_2);
    } else {
      setPhoto2Error(true);
    }
  };

  return (
    <section id="about" className="py-20 md:py-24 bg-surface-container-low relative overflow-hidden">
      <div className="max-w-7xl mx-auto px-6 lg:px-12">
        <div className="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
          {/* ========================================================
              LEFT SIDE: DUAL PHOTO FRAMING ARRANGEMENT
              ======================================================== */}
          <div className="lg:col-span-6 relative">
            <div className="grid grid-cols-2 gap-4 sm:gap-6">
              {/* Photo 1: Consultation & Surgery */}
              <div className="rounded-2xl overflow-hidden shadow-lg aspect-[3/4] translate-y-4 border border-border-subtle/50 bg-surface-variant">
                {!photo1Error ? (
                  /* eslint-disable-next-line @next/next/no-img-element */
                  <img
                    className="w-full h-full object-cover"
                    alt="A friendly consultation at Acocks Green Dental Practice where a dentist converses with a patient in a bright modern surgery room."
                    src={photo1Src}
                    onError={handlePhoto1Error}
                    loading="lazy"
                    width={400}
                    height={533}
                  />
                ) : (
                  <div className="w-full h-full flex flex-col items-center justify-center p-4 text-center bg-primary-container/10">
                    <span className="material-symbols-outlined text-primary text-[40px] mb-2">meeting_room</span>
                    <span className="font-label-md text-primary font-bold">Consultation Suite</span>
                  </div>
                )}
              </div>

              {/* Photo 2: Hygienic Clinical Treatment Suite */}
              <div className="rounded-2xl overflow-hidden shadow-lg aspect-[3/4] -translate-y-4 border border-border-subtle/50 bg-surface-variant">
                {!photo2Error ? (
                  /* eslint-disable-next-line @next/next/no-img-element */
                  <img
                    className="w-full h-full object-cover"
                    alt="Clinical hygiene procedure performed under modern illumination at Acocks Green Dental Practice."
                    src={photo2Src}
                    onError={handlePhoto2Error}
                    loading="lazy"
                    width={400}
                    height={533}
                  />
                ) : (
                  <div className="w-full h-full flex flex-col items-center justify-center p-4 text-center bg-primary-container/10">
                    <span className="material-symbols-outlined text-primary text-[40px] mb-2">dentistry</span>
                    <span className="font-label-md text-primary font-bold">Modern Operatory</span>
                  </div>
                )}
              </div>
            </div>

            {/* Trust Seal Floating Overlay Badge */}
            <div className="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-surface-card/95 backdrop-blur-md p-4 rounded-2xl shadow-xl flex items-center gap-3 border border-border-subtle/80 max-w-[90%] sm:max-w-none pointer-events-none select-none">
              <div className="w-12 h-12 rounded-xl bg-primary text-on-primary flex items-center justify-center shrink-0">
                <span className="material-symbols-outlined text-[26px]">favorite</span>
              </div>
              <div>
                <p className="font-label-md text-label-md text-on-surface font-bold">
                  Patient Comfort First
                </p>
                <p className="font-body-sm text-body-sm text-on-surface-variant">
                  Painless anaesthesia &amp; gentle care
                </p>
              </div>
            </div>
          </div>

          {/* ========================================================
              RIGHT SIDE: CONTENT & CLINICAL PILLARS
              ======================================================== */}
          <div className="lg:col-span-6 flex flex-col space-y-6">
            <div>
              <span className="font-subheading-eyebrow text-subheading-eyebrow uppercase text-primary tracking-wider font-bold block mb-2">
                About Our Surgery
              </span>
              <h2 className="font-headline-lg text-[28px] sm:text-[34px] lg:text-headline-lg text-on-surface font-bold tracking-tight">
                We Care For Your Dental Health &amp; Well-being
              </h2>
            </div>

            <p className="font-body-md text-body-md text-on-surface-variant leading-relaxed">
              Acocks Green Dental Practice is a family-oriented practice dedicated to providing exceptional dental treatments for patients of all ages across Birmingham B27. Our mission is to promote and maintain optimal dental health, ensuring beautiful and confident smiles that endure for a lifetime.
            </p>

            <div className="space-y-4 pt-1">
              {/* Feature 1: Welcoming Nervous Patients */}
              <div className="flex items-start gap-4 p-4 rounded-xl bg-surface-card shadow-xs border border-border-subtle/60 hover:shadow-sm transition-shadow">
                <div className="w-10 h-10 rounded-lg bg-brand-accent-glow text-primary flex items-center justify-center shrink-0">
                  <span className="material-symbols-outlined text-[22px]">sentiment_satisfied</span>
                </div>
                <div>
                  <h3 className="font-headline-sm text-headline-sm text-on-surface font-bold">
                    Welcoming Nervous &amp; Phobic Patients
                  </h3>
                  <p className="font-body-sm text-body-sm text-on-surface-variant mt-1 leading-relaxed">
                    We take extra time to explain every step, provide calm unhurried appointments, and employ gentle numbing techniques for absolute peace of mind.
                  </p>
                </div>
              </div>

              {/* Feature 2: NHS & Private Flexibility */}
              <div className="flex items-start gap-4 p-4 rounded-xl bg-surface-card shadow-xs border border-border-subtle/60 hover:shadow-sm transition-shadow">
                <div className="w-10 h-10 rounded-lg bg-brand-accent-glow text-primary flex items-center justify-center shrink-0">
                  <span className="material-symbols-outlined text-[22px]">health_and_safety</span>
                </div>
                <div>
                  <h3 className="font-headline-sm text-headline-sm text-on-surface font-bold">
                    NHS &amp; Private Flexibility
                  </h3>
                  <p className="font-body-sm text-body-sm text-on-surface-variant mt-1 leading-relaxed">
                    Transparent treatment costings with no hidden fees. From essential NHS safety-net dentistry to premium private aesthetic aligners.
                  </p>
                </div>
              </div>
            </div>

            {/* Practice Owner Note & Lead Director */}
            <div className="p-4 rounded-xl bg-surface-container flex items-center justify-between border border-border-subtle/50 flex-wrap gap-3">
              <div className="flex items-center gap-3">
                <div className="w-10 h-10 rounded-full bg-primary-container text-on-primary flex items-center justify-center font-bold text-sm shrink-0">
                  TM
                </div>
                <div>
                  <p className="font-label-md text-label-md text-on-surface font-bold">Tarlok Marok</p>
                  <p className="font-body-sm text-body-sm text-on-surface-variant">
                    Practice Owner &amp; Lead Director
                  </p>
                </div>
              </div>
              <div className="flex items-center gap-3">
                <span className="font-label-sm text-label-sm text-primary flex items-center gap-1 font-semibold">
                  <span className="material-symbols-outlined text-[16px]">verified_user</span>
                  <span>100% Patient Focus</span>
                </span>
                {onOpenBooking && (
                  <button
                    type="button"
                    onClick={onOpenBooking}
                    className="text-xs bg-primary text-on-primary px-3 py-1.5 rounded-lg hover:bg-primary-container transition-colors cursor-pointer font-semibold"
                  >
                    Book Consultation
                  </button>
                )}
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  );
};
