'use client';

import React, { useState } from 'react';
import Link from 'next/link';
import styles from './ServicesSidebarList.module.css';
import { ServiceItem } from '@/types/cms';

export interface ServicesSidebarListProps {
  eyebrow?: string;
  title?: string;
  subtitle?: string;
  services?: ServiceItem[];
  isLoading?: boolean;
  onBookClick?: (serviceName?: string) => void;
}

export const ServicesSidebarList: React.FC<ServicesSidebarListProps> = ({
  eyebrow = 'Our Practice Services',
  title = 'Discover Quality Dental Care in Acocks Green',
  subtitle = 'Browse our comprehensive range of general, cosmetic, and emergency dental treatments.',
  services = [],
  isLoading = false,
  onBookClick,
}) => {
  const activeServices = services.filter((s) => s.is_active !== false);
  const [selectedIndex, setSelectedIndex] = useState(0);

  if (activeServices.length === 0 && !isLoading) {
    return null;
  }

  const selectedService = activeServices[selectedIndex] || activeServices[0];

  return (
    <section className={styles.section} id="services-sidebar">
      <div className={styles.container}>
        {/* Section Header */}
        <div className={styles.headerRow}>
          <div className={styles.headerLeft}>
            <span className={styles.eyebrow} dangerouslySetInnerHTML={{ __html: eyebrow }} />
            <h2 className={styles.title} dangerouslySetInnerHTML={{ __html: title }} />
          </div>
          {subtitle && <p className={styles.subtitle} dangerouslySetInnerHTML={{ __html: subtitle }} />}
        </div>

        {/* Sidebar + Detail Split Layout */}
        <div className={styles.sidebarLayout}>
          {/* Left: Interactive Vertical Service Menu */}
          <div className={styles.sidebarCol}>
            <h3 className={styles.sidebarTitle}>
              <span className="material-symbols-outlined text-primary">clinical_notes</span>
              <span>Available Treatments</span>
            </h3>

            <ul className={styles.sidebarList}>
              {activeServices.map((service, idx) => {
                const isSelected = idx === selectedIndex;
                return (
                  <li key={service.id || idx}>
                    <button
                      type="button"
                      className={`${styles.sidebarItem} ${isSelected ? styles.active : ''}`}
                      onClick={() => setSelectedIndex(idx)}
                    >
                      <div className={styles.itemLeft}>
                        <div className={styles.itemIcon}>
                          <span className="material-symbols-outlined">
                            {service.icon || 'dentistry'}
                          </span>
                        </div>
                        <div className={styles.itemInfo}>
                          <span className={styles.itemName}>{service.title}</span>
                          <span className={styles.itemCategory}>{service.category}</span>
                        </div>
                      </div>
                      <span className={`material-symbols-outlined ${styles.itemArrow}`}>
                        chevron_right
                      </span>
                    </button>
                  </li>
                );
              })}
            </ul>
          </div>

          {/* Right: Selected Service Detailed Card */}
          {selectedService && (
            <div className={styles.mainCol}>
              <div className={styles.detailBadgeRow}>
                {selectedService.badge && (
                  <span className={styles.badge}>
                    <span className="material-symbols-outlined" style={{ fontSize: 16 }}>verified</span>
                    <span>{selectedService.badge}</span>
                  </span>
                )}
                {selectedService.cdt_code && (
                  <span className={styles.cdtBadge}>
                    Code: {selectedService.cdt_code}
                  </span>
                )}
              </div>

              <h3 className={styles.detailTitle}>{selectedService.title}</h3>

              <div className={styles.detailMeta}>
                {selectedService.starting_price && (
                  <div className={styles.metaItem}>
                    <span className={`material-symbols-outlined ${styles.metaIcon}`}>payments</span>
                    <span className={styles.metaLabel}>Pricing:</span>
                    <span className={styles.metaValue}>{selectedService.starting_price}</span>
                  </div>
                )}
                {selectedService.duration && (
                  <div className={styles.metaItem}>
                    <span className={`material-symbols-outlined ${styles.metaIcon}`}>schedule</span>
                    <span className={styles.metaLabel}>Duration:</span>
                    <span className={styles.metaValue}>{selectedService.duration}</span>
                  </div>
                )}
              </div>

              {selectedService.summary && (
                <p className={styles.detailSummary}>{selectedService.summary}</p>
              )}

              {selectedService.content ? (
                <p className={styles.detailContent}>{selectedService.content}</p>
              ) : (
                <p className={styles.detailContent}>{selectedService.description}</p>
              )}

              <div className={styles.actionRow}>
                <button
                  type="button"
                  className={styles.bookBtn}
                  onClick={() => onBookClick && onBookClick(selectedService.title)}
                >
                  <span>Book This Treatment</span>
                  <span className="material-symbols-outlined" style={{ fontSize: 18 }}>calendar_month</span>
                </button>

                <Link
                  href={`/treatments/${selectedService.slug}`}
                  className={styles.learnMoreBtn}
                >
                  <span>Full Clinical Guide</span>
                  <span className="material-symbols-outlined" style={{ fontSize: 18 }}>arrow_forward</span>
                </Link>
              </div>
            </div>
          )}
        </div>
      </div>
    </section>
  );
};
