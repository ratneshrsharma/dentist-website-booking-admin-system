'use client';

import React, { useEffect, useState } from 'react';
import Image from 'next/image';
import Link from 'next/link';
import styles from './page.module.css';
import { HomePageData } from '@/types/cms';
import { CmsService } from '@/api/cms';
import { CardSkeleton } from '@/components/common/Skeleton/CardSkeleton';

export default function HomePage() {
  const [pageData, setPageData] = useState<HomePageData | null>(null);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    async function loadData() {
      try {
        const data = await CmsService.getHomePage();
        setPageData(data);
      } catch (err) {
        console.error('Failed to load homepage CMS data:', err);
      } finally {
        setLoading(false);
      }
    }
    loadData();
  }, []);

  return (
    <main className={styles.main}>
      {/* SECTION 1: HERO & CLINICAL STATS */}
      <section className={styles.heroPlaceholder}>
        <div className={styles.container}>
          <div className={styles.heroGrid}>
            <div>
              <span className={styles.eyebrow}>
                {pageData?.hero?.eyebrow || 'NHS & Private Patients Welcomed'}
              </span>
              <h1 className={styles.headline}>
                {pageData?.hero?.headline || 'Make your Dental Experience a'}{' '}
                <span className={styles.highlight}>
                  {pageData?.hero?.headline_highlight || 'Lot Brighter'}
                </span>
              </h1>
              <p className={styles.subtitle}>
                {pageData?.hero?.subtitle}
              </p>

              {/* Stats Strip */}
              <div className={styles.statsGrid}>
                {pageData?.hero?.stats?.map((stat, idx) => (
                  <div key={idx} className={styles.statCard}>
                    <span className={styles.statValue}>{stat.value}</span>
                    <span className={styles.statLabel}>{stat.label}</span>
                  </div>
                ))}
              </div>

              {/* CTAs */}
              <div className={styles.ctaGroup}>
                <Link href="#book" className={styles.btnPrimary}>
                  <span>{pageData?.hero?.cta_primary || 'Book An Appointment'}</span>
                  <span className="material-symbols-outlined">calendar_month</span>
                </Link>
                <div className={styles.emergencyCard}>
                  <div className={styles.phoneIcon}>
                    <span className="material-symbols-outlined">call</span>
                  </div>
                  <div>
                    <span className={styles.label}>
                      {pageData?.hero?.emergency_label || 'Emergency Triage Line'}
                    </span>
                    <a
                      href={`tel:${pageData?.hero?.phone}`}
                      className={styles.phoneNumber}
                    >
                      {pageData?.hero?.phone}
                    </a>
                  </div>
                </div>
              </div>
            </div>

            {/* Right Hero Image */}
            <div className={styles.heroImageContainer}>
              <Image
                src={pageData?.hero?.hero_image || '/images/hero-patient.jpg'}
                alt="Dental Patient Care"
                fill
                priority
              />
              <div className={styles.floatingBadge}>
                <span className={`material-symbols-outlined ${styles.badgeIcon}`}>
                  verified
                </span>
                <span>CQC Regulated Standards</span>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* SECTION 2: DYNAMIC SERVICES GRID */}
      <section className={styles.section}>
        <div className={styles.container}>
          <div className={styles.sectionHeader}>
            <span className={styles.eyebrow}>
              {pageData?.services_intro?.eyebrow || 'Our Practice Services'}
            </span>
            <h2 className={styles.sectionTitle}>
              {pageData?.services_intro?.title || 'Discover Quality Dental Care'}
            </h2>
            <p className={styles.sectionSubtitle}>
              {pageData?.services_intro?.subtitle}
            </p>
          </div>

          <div className={styles.cardsGrid}>
            {loading ? (
              <>
                <CardSkeleton />
                <CardSkeleton />
                <CardSkeleton />
                <CardSkeleton />
              </>
            ) : (
              pageData?.featured_services?.map((svc) => (
                <div key={svc.id} className={styles.serviceCard}>
                  <div>
                    <div className={styles.iconWrapper}>
                      <span className="material-symbols-outlined">{svc.icon}</span>
                    </div>
                    {svc.badge_tags && (
                      <div className={styles.tagGroup}>
                        {svc.badge_tags.map((tag, tIdx) => (
                          <span key={tIdx} className={styles.tag}>
                            {tag}
                          </span>
                        ))}
                      </div>
                    )}
                    <h3 className={styles.cardTitle}>{svc.title}</h3>
                    <p className={styles.cardDescription}>{svc.description}</p>
                  </div>
                  <Link
                    href={`/treatments/${svc.slug}`}
                    className={styles.cardLink}
                  >
                    <span>Explore Treatment</span>
                    <span className="material-symbols-outlined">arrow_forward</span>
                  </Link>
                </div>
              ))
            )}
          </div>
        </div>
      </section>
    </main>
  );
}
