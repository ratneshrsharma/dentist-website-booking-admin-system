'use client';

import React from 'react';
import styles from './SafetyCharterBanner.module.css';
import { HomePageData } from '@/types/cms';

export interface SafetyCharterBannerProps {
  charter?: HomePageData['safety_charter'];
}

export const SafetyCharterBanner: React.FC<SafetyCharterBannerProps> = ({
  charter,
}) => {
  if (!charter) return null;

  return (
    <section className={styles.section} id="charter">
      <div className={styles.container}>
        <div className={styles.charterCard}>
          <div className={styles.grid}>
            <div className={styles.contentCol}>
              <div className={styles.badgePill}>
                <span className="material-symbols-outlined">verified</span>
                <span>NHS Safety Standard</span>
              </div>

              <h3 className={styles.title}>{charter.title}</h3>
              <p className={styles.description}>{charter.description}</p>

              <div className={styles.concernCallout}>
                <span
                  className={`material-symbols-outlined ${styles.calloutIcon}`}
                >
                  support_agent
                </span>
                <p>
                  <strong>How to raise a concern:</strong> You may speak
                  directly to our Practice Manager,{' '}
                  <strong>{charter.contact_person}</strong>, in private confidence
                  at any time.
                </p>
              </div>
            </div>

            <div className={styles.actionCol}>
              <a
                href={charter.download_url}
                target="_blank"
                rel="noopener noreferrer"
                className={styles.downloadBtn}
              >
                <span className="material-symbols-outlined text-[18px]">
                  download
                </span>
                <span>Download Charter (PDF)</span>
              </a>
              <span className={styles.frameworkLabel}>
                Official NHS England Framework
              </span>
            </div>
          </div>
        </div>
      </div>
    </section>
  );
};
