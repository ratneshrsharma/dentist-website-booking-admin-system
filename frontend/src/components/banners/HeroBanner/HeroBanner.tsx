'use client';

import React from 'react';
import Image from 'next/image';
import { assetUrl } from '@/utils/asset';
import styles from './HeroBanner.module.css';
import { HomePageData } from '@/types/cms';
import { useTheme } from '@/context/ThemeContext';

export interface HeroBannerProps {
  hero: HomePageData['hero'];
  onBookClick?: () => void;
}

export const HeroBanner: React.FC<HeroBannerProps> = ({ hero, onBookClick }) => {
  const { theme } = useTheme();

  if (!hero) return null;

  const emergencyPhone =
    theme?.branding?.emergency_phone ||
    theme?.branding?.phone ||
    hero.phone ||
    '+44 121 765 2870';
  const emergencyLabel =
    hero.emergency_label ||
    theme?.branding?.emergency_label ||
    'Emergency Triage Line';

  return (
    <section className={styles.heroSection}>
      <div className={styles.ambientGlowTop} />
      <div className={styles.ambientGlowBottom} />

      <div className={styles.container}>
        <div className={styles.heroGrid}>
          {/* Left Text Column */}
          <div className={styles.contentCol}>
            <span
              className={styles.eyebrow}
              dangerouslySetInnerHTML={{
                __html: hero.eyebrow || 'NHS & Private Patients Welcomed',
              }}
            />
            <h1 className={styles.headline}>
              <span
                dangerouslySetInnerHTML={{
                  __html: hero.headline || hero.title || 'Make your Dental Experience a',
                }}
              />{' '}
              <span
                className={styles.highlight}
                dangerouslySetInnerHTML={{
                  __html: hero.headline_highlight || hero.highlight_word || 'Lot Brighter',
                }}
              />
            </h1>
            <p
              className={styles.subtitle}
              dangerouslySetInnerHTML={{ __html: hero.subtitle || '' }}
            />

            {/* Statistics Row */}
            {hero.stats && hero.stats.length > 0 && (
              <div className={styles.statsGrid}>
                {hero.stats
                  .filter((s) => s.is_active !== false)
                  .map((stat, idx) => (
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
                <span>{hero.cta_primary || 'Book An Appointment'}</span>
                <span className="material-symbols-outlined text-[18px]">
                  calendar_month
                </span>
              </button>

              {emergencyPhone && (
                <a
                  href={`tel:${emergencyPhone.replace(/\s+/g, '')}`}
                  className={styles.emergencyCard}
                >
                  <div className={styles.phoneIcon}>
                    <span className="material-symbols-outlined">call</span>
                  </div>
                  <div className={styles.phoneInfo}>
                    <span className={styles.emergencyLabel}>
                      {emergencyLabel}
                    </span>
                    <span className={styles.phoneLink}>
                      {emergencyPhone}
                    </span>
                  </div>
                </a>
              )}
            </div>
          </div>

          {/* Right Visual Column */}
          <div className={styles.visualCol}>
            <div className={styles.imageFrame}>
              <Image
                src={assetUrl(hero.hero_image || '/uploads/home/hero-patient.jpg')}
                alt="Friendly patient consultation"
                fill
                priority
              />
              <div className={styles.imageGradientOverlay} />

              <div className={styles.cqcBadge}>
                <span className={`material-symbols-outlined ${styles.badgeIcon}`}>
                  {hero.hero_badges?.[0]?.icon || 'verified'}
                </span>
                <span>{hero.hero_badges?.[0]?.title || 'CQC Regulated Standards'}</span>
              </div>

              <div className={styles.emergencySlotBanner}>
                <div className={styles.bannerLeft}>
                  <div className={styles.emergencySlotIcon}>
                    <span className="material-symbols-outlined">
                      {hero.hero_badges?.[1]?.icon || 'e911_emergency'}
                    </span>
                  </div>
                  <div>
                    <p className={styles.bannerTitle}>
                      {hero.hero_badges?.[1]?.title || 'Same-Day Emergency Slots'}
                    </p>
                    <p className={styles.bannerSubtitle}>
                      {hero.hero_badges?.[1]?.subtitle || 'Fast relief for severe toothache & trauma'}
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
