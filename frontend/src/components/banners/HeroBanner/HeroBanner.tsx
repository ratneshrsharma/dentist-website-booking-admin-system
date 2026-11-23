'use client';

import React from 'react';
import Image from 'next/image';
import { assetUrl } from '@/utils/asset';
import styles from './HeroBanner.module.css';
import { HomePageData } from '@/types/cms';

export interface HeroBannerProps {
  hero: HomePageData['hero'];
  onBookClick?: () => void;
}

export const HeroBanner: React.FC<HeroBannerProps> = ({ hero, onBookClick }) => {
  if (!hero) return null;

  return (
    <section className={styles.heroSection}>
      <div className={styles.ambientGlowTop} />
      <div className={styles.ambientGlowBottom} />

      <div className={styles.container}>
        <div className={styles.heroGrid}>
          {/* Left Text Column */}
          <div className={styles.contentCol}>
            <span className={styles.eyebrow}>{hero.eyebrow}</span>
            <h1 className={styles.headline}>
              {hero.headline}{' '}
              {hero.headline_highlight && (
                <span className={styles.highlight}>{hero.headline_highlight}</span>
              )}
            </h1>
            <p className={styles.subtitle}>{hero.subtitle}</p>

            {/* Statistics Row */}
            {hero.stats && hero.stats.length > 0 && (
              <div className={styles.statsGrid}>
                {hero.stats.map((stat, idx) => (
                  <div key={idx} className={styles.statCard}>
                    <span className={styles.statValue}>{stat.value}</span>
                    <span className={styles.statLabel}>{stat.label}</span>
                  </div>
                ))}
              </div>
            )}

            {/* CTAs */}
            <div className={styles.ctaRow}>
              <button
                type="button"
                className={styles.primaryCta}
                onClick={onBookClick}
              >
                <span>{hero.cta_primary}</span>
                <span className="material-symbols-outlined text-[18px]">
                  calendar_month
                </span>
              </button>

              {hero.phone && (
                <div className={styles.emergencyCard}>
                  <div className={styles.phoneIcon}>
                    <span className="material-symbols-outlined">call</span>
                  </div>
                  <div>
                    <span className={styles.emergencyLabel}>
                      {hero.emergency_label || 'Emergency Triage Line'}
                    </span>
                    <a href={`tel:${hero.phone}`} className={styles.phoneLink}>
                      {hero.phone}
                    </a>
                  </div>
                </div>
              )}
            </div>
          </div>

          {/* Right Visual Column */}
          <div className={styles.visualCol}>
            <div className={styles.imageFrame}>
              <Image
                src={assetUrl(hero.hero_image || '/images/hero-patient.jpg')}
                alt="Friendly patient consultation"
                fill
                priority
              />
              <div className={styles.imageGradientOverlay} />

              <div className={styles.cqcBadge}>
                <span className={`material-symbols-outlined ${styles.badgeIcon}`}>
                  verified
                </span>
                <span>CQC Regulated Standards</span>
              </div>

              <div className={styles.emergencySlotBanner}>
                <div className={styles.bannerLeft}>
                  <div className={styles.emergencySlotIcon}>
                    <span className="material-symbols-outlined">
                      e911_emergency
                    </span>
                  </div>
                  <div>
                    <p className={styles.bannerTitle}>Same-Day Emergency Slots</p>
                    <p className={styles.bannerSubtitle}>
                      Fast relief for severe toothache & trauma
                    </p>
                  </div>
                </div>
                <span className={styles.slotTag}>Available</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  );
};
