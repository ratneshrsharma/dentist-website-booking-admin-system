'use client';

import React from 'react';
import Image from 'next/image';
import { assetUrl } from '@/utils/asset';
import styles from './DoctorsGrid.module.css';
import { ClinicianItem } from '@/types/cms';

export interface DoctorsGridProps {
  clinicians?: ClinicianItem[];
  supportTeam?: Array<{ name: string; role: string }>;
  practiceManager?: { name: string; title: string };
}

export const DoctorsGrid: React.FC<DoctorsGridProps> = ({
  clinicians = [],
  supportTeam = [],
  practiceManager,
}) => {
  return (
    <section className={styles.section} id="team">
      <div className={styles.container}>
        {/* Header */}
        <div className={styles.headerRow}>
          <span className={styles.eyebrow}>Our Clinicians</span>
          <h2 className={styles.title}>Dedicated Dental Surgeons & Specialists</h2>
          <p className={styles.subtitle}>
            Our clinicians combine university medical rigour with gentle chairside
            communication, backed by continuing professional development.
          </p>
        </div>

        {/* 4 Clinician Cards */}
        <div className={styles.doctorsGrid}>
          {clinicians.map((doctor) => (
            <div key={doctor.id} className={styles.doctorCard}>
              <div className={styles.avatarFrame}>
                <Image
                  src={assetUrl(doctor.avatar || '/images/doctor-das.jpg')}
                  alt={doctor.name}
                  fill
                />
                {doctor.badge && (
                  <span className={styles.roleBadge}>{doctor.badge}</span>
                )}
              </div>
              <div className={styles.cardBody}>
                <h3 className={styles.doctorName}>{doctor.name}</h3>
                <p className={styles.credentials}>
                  {doctor.credentials || doctor.title}
                </p>
                <p className={styles.bio}>{doctor.bio}</p>
              </div>
            </div>
          ))}
        </div>

        {/* Support Staff Strip */}
        {supportTeam.length > 0 && (
          <div className={styles.supportTeamStrip}>
            <div className={styles.supportHeader}>
              <div>
                <h4 className={styles.supportTitle}>
                  Foundation Clinicians & Dental Nursing Team
                </h4>
                <p className={styles.supportSubtitle}>
                  Ensuring clinical sterilisation, surgery assistance, and welcoming
                  front desk support.
                </p>
              </div>
              {practiceManager && (
                <div className={styles.managerBadge}>
                  Practice Manager: <strong>{practiceManager.name}</strong>
                </div>
              )}
            </div>

            <div className={styles.nursePillsWrap}>
              {supportTeam.map((member, idx) => (
                <span key={idx} className={styles.nursePill}>
                  {member.name}{' '}
                  <span className={styles.nurseRole}>({member.role})</span>
                </span>
              ))}
            </div>
          </div>
        )}
      </div>
    </section>
  );
};
