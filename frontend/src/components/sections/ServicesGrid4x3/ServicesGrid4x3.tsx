'use client';

import React from 'react';
import Link from 'next/link';
import styles from './ServicesGrid4x3.module.css';
import { ServiceItem } from '@/types/cms';
import { CardSkeleton } from '@/components/common/Skeleton/CardSkeleton';

export interface ServicesGrid4x3Props {
  eyebrow?: string;
  title?: string;
  subtitle?: string;
  services?: ServiceItem[];
  isLoading?: boolean;
}

export const ServicesGrid4x3: React.FC<ServicesGrid4x3Props> = ({
  eyebrow = 'Our Practice Services',
  title = 'Discover Quality Dental Care in Acocks Green',
  subtitle = 'Personalized clinical dental solutions delivered in modern surgeries with low radiation digital radiography and compassionate pacing.',
  services = [],
  isLoading = false,
}) => {
  return (
    <section className={styles.section} id="services">
      <div className={styles.container}>
        {/* Section Header */}
        <div className={styles.headerRow}>
          <div className={styles.headerLeft}>
            <span className={styles.eyebrow} dangerouslySetInnerHTML={{ __html: eyebrow }} />
            <h2 className={styles.title} dangerouslySetInnerHTML={{ __html: title }} />
          </div>
          {subtitle && <p className={styles.subtitle} dangerouslySetInnerHTML={{ __html: subtitle }} />}
        </div>

        {/* Services Grid */}
        <div className={styles.grid}>
          {isLoading ? (
            <>
              <CardSkeleton type="service" />
              <CardSkeleton type="service" />
              <CardSkeleton type="service" />
              <CardSkeleton type="service" />
            </>
          ) : (
            services.map((service) => (
              <div key={service.id} className={styles.serviceCard}>
                <div>
                  <div className={styles.iconWrapper}>
                    <span className="material-symbols-outlined">
                      {service.icon || 'dentistry'}
                    </span>
                  </div>

                  {service.badge_tags && service.badge_tags.length > 0 && (
                    <div className={styles.tagGroup}>
                      {service.badge_tags.map((tag, tIdx) => (
                        <span key={tIdx} className={styles.tag}>
                          {tag}
                        </span>
                      ))}
                    </div>
                  )}

                  <h3 className={styles.cardTitle}>{service.title}</h3>
                  <p className={styles.cardDescription}>{service.description}</p>
                </div>

                <Link
                  href={`/treatments/${service.slug}`}
                  className={styles.cardLink}
                >
                  <span>Explore Care</span>
                  <span
                    className={`material-symbols-outlined ${styles.arrowIcon}`}
                  >
                    arrow_forward
                  </span>
                </Link>
              </div>
            ))
          )}
        </div>
      </div>
    </section>
  );
};
