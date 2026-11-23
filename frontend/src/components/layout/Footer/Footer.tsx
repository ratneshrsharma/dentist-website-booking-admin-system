'use client';

import React from 'react';
import Image from 'next/image';
import Link from 'next/link';
import styles from './Footer.module.css';
import { useTheme } from '@/context/ThemeContext';

export const Footer: React.FC = () => {
  const { theme, navigation } = useTheme();
  const { clinic_name, tagline, logo_url, phone, address } = theme.branding;

  const currentYear = new Date().getFullYear();

  return (
    <footer className={styles.footer} role="contentinfo">
      <div className={styles.container}>
        <div className={styles.mainGrid}>
          {/* Column 1: Clinic Identity & Address */}
          <div className={styles.brandCol}>
            <div className={styles.brandHeader}>
              <div className={styles.logoWrapper}>
                <Image
                  src={logo_url || '/images/acocks-green-logo.png'}
                  alt={clinic_name}
                  width={40}
                  height={40}
                />
              </div>
              <div className={styles.brandTitles}>
                <span className={styles.clinicTitle}>{clinic_name}</span>
                <span className={styles.tagline}>{tagline}</span>
              </div>
            </div>

            <p className={styles.brandBio}>
              Providing dedicated family dental care, NHS treatment pathways,
              and advanced cosmetic dentistry to the Birmingham community with
              patient comfort at our core.
            </p>

            <div className={styles.addressBlock}>
              <span className={styles.addressLead}>Practice Location:</span>
              <span>{address}</span>
            </div>
          </div>

          {/* Column 2: Quick Links */}
          <div>
            <h4 className={styles.colHeading}>Quick Navigation</h4>
            <ul className={styles.linksList}>
              {navigation.quick_links?.map((link, idx) => (
                <li key={idx}>
                  <Link href={link.path}>{link.title}</Link>
                </li>
              ))}
            </ul>
          </div>

          {/* Column 3: Clinical Hours & Emergency Triage */}
          <div>
            <h4 className={styles.colHeading}>Clinical Hours</h4>
            <div className={styles.hoursBlock}>
              <div className={styles.hourRow}>
                <span>Mon – Thu:</span>
                <span className={styles.hourTime}>8:30 AM – 5:30 PM</span>
              </div>
              <div className={styles.hourRow}>
                <span>Friday:</span>
                <span className={styles.hourTime}>8:30 AM – 5:00 PM</span>
              </div>
              <div className={styles.hourRow}>
                <span>Saturday – Sunday:</span>
                <span className={`${styles.hourTime} ${styles.highlight}`}>
                  Emergency On-Call
                </span>
              </div>
            </div>

            <div className={styles.emergencyPillBox}>
              <p className={styles.triageLabel}>
                <span className="material-symbols-outlined">support_agent</span>
                <span>24/7 Dental Emergency Triage</span>
              </p>
              <a href={`tel:${phone}`} className={styles.triagePhone}>
                {phone}
              </a>
            </div>
          </div>

          {/* Column 4: NHS Charter Notice */}
          <div>
            <h4 className={styles.colHeading}>NHS Charter Notice</h4>
            <div className={styles.charterNoticeBox}>
              <div className={styles.cqcHeader}>
                <span className="material-symbols-outlined">verified</span>
                <span>Quality Care Standards</span>
              </div>
              <p>
                We are fully regulated by the Care Quality Commission (CQC) and
                operate strictly under NHS clinical safety protocols for your
                family's peace of mind.
              </p>
            </div>

            <div className={styles.badgeRow}>
              <span className={styles.cqcBadge}>CQC Compliant</span>
              <span className={styles.cqcBadge}>NHS Registered</span>
            </div>
          </div>
        </div>

        {/* Bottom Legal / Copyright Bar */}
        <div className={styles.bottomBar}>
          <p>© {currentYear} {clinic_name} {tagline}. All rights reserved.</p>
          <div className={styles.legalLinks}>
            {navigation.legal_links?.map((link, idx) => (
              <Link key={idx} href={link.path}>
                {link.title}
              </Link>
            ))}
          </div>
        </div>
      </div>
    </footer>
  );
};
