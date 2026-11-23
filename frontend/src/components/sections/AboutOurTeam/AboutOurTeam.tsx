'use client';

import React from 'react';
import Image from 'next/image';
import { assetUrl } from '@/utils/asset';
import styles from './AboutOurTeam.module.css';
import { HomePageData } from '@/types/cms';

export interface AboutOurTeamProps {
  about?: HomePageData['about_summary'];
}

export const AboutOurTeam: React.FC<AboutOurTeamProps> = ({ about }) => {
  if (!about) return null;

  return (
    <section className={styles.section} id="about">
      <div className={styles.container}>
        <div className={styles.grid}>
          {/* Left Dual Photo Frames */}
          <div className={styles.photoFrameContainer}>
            <div className={styles.photoGrid}>
              <div className={`${styles.photoCard} ${styles.offsetDown}`}>
                <Image
                  src={assetUrl('/images/treatment-room.jpg')}
                  alt="Modern clean dental operatory"
                  fill
                />
              </div>
              <div className={`${styles.photoCard} ${styles.offsetUp}`}>
                <Image
                  src={assetUrl('/images/surgery-clinic.jpg')}
                  alt="Acocks Green Dental Clinic reception"
                  fill
                />
              </div>
            </div>

            <div className={styles.trustSealBadge}>
              <div className={styles.sealIconWrapper}>
                <span className="material-symbols-outlined">favorite</span>
              </div>
              <div>
                <p className={styles.sealTitle}>Patient Comfort First</p>
                <p className={styles.sealSubtitle}>
                  Painless anaesthesia & gentle care
                </p>
              </div>
            </div>
          </div>

          {/* Right Text Column */}
          <div className={styles.contentCol}>
            <span className={styles.eyebrow}>{about.eyebrow}</span>
            <h2 className={styles.headline}>{about.title}</h2>
            <p className={styles.paragraph}>{about.paragraph}</p>

            {/* Pillars */}
            <div className={styles.pillarsList}>
              {about.pillars?.map((pillar) => (
                <div key={pillar.id} className={styles.pillarCard}>
                  <div className={styles.pillarIcon}>
                    <span className="material-symbols-outlined">{pillar.icon}</span>
                  </div>
                  <div>
                    <h4 className={styles.pillarTitle}>{pillar.title}</h4>
                    <p className={styles.pillarDesc}>{pillar.description}</p>
                  </div>
                </div>
              ))}
            </div>

            {/* Director Note */}
            {about.director_note && (
              <div className={styles.directorCard}>
                <div className={styles.directorLeft}>
                  <div className={styles.avatarInitials}>
                    {about.director_note.initials}
                  </div>
                  <div>
                    <p className={styles.directorName}>{about.director_note.name}</p>
                    <p className={styles.directorTitle}>{about.director_note.title}</p>
                  </div>
                </div>
                <div className={styles.trustPill}>
                  <span className="material-symbols-outlined">verified_user</span>
                  <span>100% Patient Focus</span>
                </div>
              </div>
            )}
          </div>
        </div>
      </div>
    </section>
  );
};
