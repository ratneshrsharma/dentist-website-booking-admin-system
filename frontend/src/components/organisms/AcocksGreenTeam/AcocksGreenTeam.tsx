'use client';

import React, { useState } from 'react';
import { getAssetPath } from '@/lib/assetPath';

export interface TeamCmsData {
  badge?: string;
  headline?: string;
  title?: string;
  subtitle?: string;
}

interface AcocksGreenTeamProps {
  data?: TeamCmsData;
  onOpenBooking?: (serviceId?: number) => void;
}

interface Clinician {
  id: number;
  name: string;
  role: string;
  qualifications: string;
  bio: string;
  image: string;
  remoteFallback: string;
  alt: string;
}

const cliniciansData: Clinician[] = [
  {
    id: 1,
    name: 'Dr. Atandrilla Das',
    role: 'Associate Dentist',
    qualifications: 'BDS Associate Dental Surgeon',
    bio: 'Special interest in comprehensive restorative therapy, minimal-prep restorations, and pediatric patient care.',
    image: '/images/doctor-das.jpg',
    remoteFallback:
      'https://lh3.googleusercontent.com/aida-public/AB6AXuBEx_soy0FaoY2xMhIkb8RLR60ks0LshDyVsR5QWB3z3-DT_2N_to0Wcst3cfb_x_sKVRqyLXbCW69lY4NFd0FOGfYyX2RK8P7NHRVuzEGHdGkezJ1nT4oZfLAAW08CTOVADQNMM3t0be1sIdmhYPR_FGna86Tc5aYMw2O2GCQun02d6uY-vqCMaT59v786ncq85LxnE9P0LvNLNVn_aiVGZUERcYJ78U_OYPmoRQfh',
    alt: 'Portrait of Dr. Atandrilla Das, associate dental surgeon at Acocks Green Dental Practice in Birmingham',
  },
  {
    id: 2,
    name: 'Dr. Harjeevan Rai',
    role: 'Associate Dentist',
    qualifications: 'BDS Dental Surgeon',
    bio: 'Focused on preventive oral health, biomechanical restorations, and gentle pain relief treatments.',
    image: '/images/doctor-rai.jpg',
    remoteFallback:
      'https://lh3.googleusercontent.com/aida-public/AB6AXuAOw3d0Txl1o_y4o0HX10kqBQ52n1j3BiYwi1-Pg9fipmZf8P4Q9qbHJ0J0r1QTZl2UTM3qx97dPO829cPlppU0tWozjujKdE6z-DuyAf_wkGBIj8aymZ0waX-0QTQm24xeouNfzI8pb5--9oYtKeKjTiPbxp3agLe3WeckpbxJ_JmQ2Jm3_nC42llUvRSxgkXuXRnU8wclENQaVWEJN4Do1BdMwQnM_DVYlkfMcglL',
    alt: 'Portrait of Dr. Harjeevan Rai, experienced associate dentist at Acocks Green Dental Practice',
  },
  {
    id: 3,
    name: 'Dr. Nadeem Sohail',
    role: 'Associate Dentist',
    qualifications: 'BDS Dental Surgeon',
    bio: 'Experienced in complex endodontics, emergency extractions, and crown & bridge oral rehabilitation.',
    image: '/images/doctor-sohail.jpg',
    remoteFallback:
      'https://lh3.googleusercontent.com/aida-public/AB6AXuD6Qfa_-jjDJkBW3WdtJxAb5aNWoq-d2huj4qU2I0bjUJtqi9gfxXqqBceK6L0DszRwDiTonJ_SbDuxOh6zbdOAIJQGiZnLnxAC6lBL7fkbiZUH4BkXKDN_P9tDrF1pWHh5McAMGznEwkH7942Na-FIbZFfJFX8xmB2o7opvhIgU2TAC9VDUIS4g4y_8OHPnzgkPxN3wV2YiI77u87VUWQY2wk53gJihQNsi37X4iwb',
    alt: 'Professional portrait of Dr. Nadeem Sohail, associate dentist with expertise in endodontics at Acocks Green Dental Practice',
  },
  {
    id: 4,
    name: 'Claire',
    role: 'Dental Hygienist',
    qualifications: 'CEB Cert in Dental Hygiene',
    bio: 'Leading our hygiene suite with deep periodontal therapy, patient brushing coaching, and airflow stain polishing.',
    image: '/images/hygienist-claire.jpg',
    remoteFallback:
      'https://lh3.googleusercontent.com/aida-public/AB6AXuDFLAbce9lj4rvMM0hhMVAiS0AstCjmGm6oHdZyCQ7vkApMALTDSkIYrdNnBS2nVkY4i5YkVohtlyZp8UJE0mWD19kmBb3UTw5f_k_LvwXgROcVNZxCAGCen-SfDkmpBE-mD0oF33z3Ki_ks16CJzvW_LsLI0xxbE7cA6kFMOo6dMTslKJ8d-WIC5EGnPVdexGdPeSuhJhKcp6CLvJDqaO_DCL9KNsl5zR9CldkznDf',
    alt: 'Portrait of Claire, dedicated dental hygienist at Acocks Green Dental Practice in Birmingham',
  },
];

const ClinicianCard: React.FC<{
  clinician: Clinician;
  onOpenBooking?: () => void;
}> = ({ clinician, onOpenBooking }) => {
  const [imgSrc, setImgSrc] = useState(() => getAssetPath(clinician.image));
  const [imgError, setImgError] = useState(false);

  const handleError = () => {
    if (imgSrc !== clinician.remoteFallback) {
      setImgSrc(clinician.remoteFallback);
    } else {
      setImgError(true);
    }
  };

  return (
    <div className="bg-surface-card rounded-2xl overflow-hidden shadow-xs hover:shadow-lg border border-border-subtle/70 transition-all duration-300 flex flex-col justify-between group">
      <div>
        {/* Clinician Photo Frame */}
        <div className="h-64 bg-surface-variant overflow-hidden relative">
          {!imgError ? (
            /* eslint-disable-next-line @next/next/no-img-element */
            <img
              className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
              alt={clinician.alt}
              src={imgSrc}
              onError={handleError}
              loading="lazy"
              width={320}
              height={256}
            />
          ) : (
            <div className="w-full h-full flex flex-col items-center justify-center p-4 text-center bg-primary-container/10">
              <span className="material-symbols-outlined text-primary text-[48px] mb-2">person</span>
              <span className="font-headline-sm text-primary font-bold">{clinician.name}</span>
            </div>
          )}
          <span className="absolute bottom-3 left-3 bg-surface-card/95 backdrop-blur-md text-primary font-label-sm text-label-sm px-2.5 py-1 rounded-md shadow-xs border border-border-subtle/50 font-semibold">
            {clinician.role}
          </span>
        </div>

        {/* Clinician Details */}
        <div className="p-5">
          <h3 className="font-headline-sm text-headline-sm text-on-surface font-bold group-hover:text-primary transition-colors">
            {clinician.name}
          </h3>
          <p className="font-body-sm text-body-sm text-primary mb-2 font-semibold">
            {clinician.qualifications}
          </p>
          <p className="font-body-sm text-body-sm text-on-surface-variant leading-relaxed">
            {clinician.bio}
          </p>
        </div>
      </div>

      {/* Book with Clinician Action */}
      <div className="px-5 pb-5 pt-1">
        <button
          type="button"
          onClick={onOpenBooking}
          className="w-full text-center py-2 px-3 rounded-lg bg-surface-container-low hover:bg-primary-container hover:text-on-primary text-primary font-label-sm text-label-sm font-semibold transition-colors cursor-pointer"
        >
          Book Consultation
        </button>
      </div>
    </div>
  );
};

export const AcocksGreenTeam: React.FC<AcocksGreenTeamProps> = ({
  data,
  onOpenBooking,
}) => {
  const badgeText = data?.badge || 'Our Clinicians';
  const headlineText = data?.headline || data?.title || 'Dedicated Dental Surgeons & Specialists';
  const subtitleText =
    data?.subtitle ||
    'Our clinicians combine university medical rigour with gentle chairside communication, backed by continuing professional development across Birmingham.';

  return (
    <section id="team" className="py-20 md:py-24 bg-surface relative">
      <div className="max-w-7xl mx-auto px-6 lg:px-12">
        {/* Section Header */}
        <div className="text-center max-w-2xl mx-auto mb-14 md:mb-16">
          <span className="font-subheading-eyebrow text-subheading-eyebrow uppercase text-primary tracking-wider font-bold block mb-2">
            {badgeText}
          </span>
          <h2 className="font-headline-lg text-[28px] sm:text-[34px] lg:text-headline-lg text-on-surface font-bold tracking-tight">
            {headlineText}
          </h2>
          <p className="font-body-md text-body-md text-on-surface-variant mt-3 leading-relaxed">
            {subtitleText}
          </p>
        </div>

        {/* 4 Primary Clinicians Grid */}
        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
          {cliniciansData.map((clinician) => (
            <ClinicianCard
              key={clinician.id}
              clinician={clinician}
              onOpenBooking={() => onOpenBooking?.(clinician.id)}
            />
          ))}
        </div>

        {/* Extended Clinical & Nursing Team Strip */}
        <div className="bg-surface-container-low p-6 md:p-8 rounded-2xl border border-border-subtle/60 shadow-xs">
          <div className="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 mb-4">
            <div>
              <h3 className="font-headline-sm text-headline-sm text-on-surface font-bold">
                Foundation Clinicians &amp; Dental Nursing Team
              </h3>
              <p className="font-body-sm text-body-sm text-on-surface-variant mt-1">
                The dedicated professionals ensuring clinical sterilisation, seamless surgery assistance, and welcoming front desk support.
              </p>
            </div>
            <div className="shrink-0">
              <span className="font-label-sm text-label-sm px-3.5 py-1.5 rounded-full bg-surface-card text-on-surface border border-border-subtle/80 shadow-xs inline-flex items-center gap-1.5">
                <span className="material-symbols-outlined text-primary text-[16px]">badge</span>
                <span>Practice Manager: <strong>Rebecca Solly</strong></span>
              </span>
            </div>
          </div>

          {/* Nursing & Reception Badges */}
          <div className="flex flex-wrap gap-2.5 pt-2">
            <span className="bg-surface-card px-3 py-1.5 rounded-lg font-body-sm text-body-sm text-on-surface shadow-xs border border-border-subtle/50">
              Hannah <span className="text-primary font-semibold">(Foundation Dentist)</span>
            </span>
            <span className="bg-surface-card px-3 py-1.5 rounded-lg font-body-sm text-body-sm text-on-surface shadow-xs border border-border-subtle/50">
              Niamh <span className="text-primary font-semibold">(Foundation Dentist)</span>
            </span>
            <span className="bg-surface-card px-3 py-1.5 rounded-lg font-body-sm text-body-sm text-on-surface shadow-xs border border-border-subtle/50">
              Mulaykah Abdurrahman <span className="text-on-surface-variant font-medium">(Nurse Apprentice)</span>
            </span>
            <span className="bg-surface-card px-3 py-1.5 rounded-lg font-body-sm text-body-sm text-on-surface shadow-xs border border-border-subtle/50">
              Gabriela Popescu <span className="text-on-surface-variant font-medium">(Nurse)</span>
            </span>
            <span className="bg-surface-card px-3 py-1.5 rounded-lg font-body-sm text-body-sm text-on-surface shadow-xs border border-border-subtle/50">
              Hamza Ahmad <span className="text-on-surface-variant font-medium">(Nurse)</span>
            </span>
            <span className="bg-surface-card px-3 py-1.5 rounded-lg font-body-sm text-body-sm text-on-surface shadow-xs border border-border-subtle/50">
              Rukhsana Choudhary <span className="text-on-surface-variant font-medium">(Nurse)</span>
            </span>
            <span className="bg-surface-card px-3 py-1.5 rounded-lg font-body-sm text-body-sm text-on-surface shadow-xs border border-border-subtle/50">
              Richard Gill <span className="text-on-surface-variant font-medium">(Nurse)</span>
            </span>
            <span className="bg-surface-card px-3 py-1.5 rounded-lg font-body-sm text-body-sm text-on-surface shadow-xs border border-border-subtle/50">
              Jessica William <span className="text-on-surface-variant font-medium">(Nurse)</span>
            </span>
            <span className="bg-surface-card px-3 py-1.5 rounded-lg font-body-sm text-body-sm text-on-surface shadow-xs border border-border-subtle/50">
              Jade Walker <span className="text-on-surface-variant font-medium">(Receptionist)</span>
            </span>
          </div>
        </div>
      </div>
    </section>
  );
};
