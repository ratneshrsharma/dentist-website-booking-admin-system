'use client';

import React from 'react';
import Image from 'next/image';
import { assetUrl } from '@/utils/asset';
import styles from './ClinicAddressAndContact.module.css';
import { HomePageData } from '@/types/cms';

export interface ClinicAddressAndContactProps {
  eyebrow?: string;
  title?: string;
  subtitle?: string;
  contactData?: HomePageData['contact_section'];
}

export const ClinicAddressAndContact: React.FC<ClinicAddressAndContactProps> = ({
  eyebrow,
  title,
  subtitle,
  contactData,
}) => {
  if (!contactData) return null;

  return (
    <section className={styles.section} id="contact">
      <div className={styles.container}>
        {/* Header */}
        <div className={styles.headerRow}>
          <span className={styles.eyebrow}>{eyebrow || contactData.eyebrow || 'Visit Our Surgery'}</span>
          <h2 className={styles.title}>{title || contactData.title}</h2>
          <p className={styles.subtitle}>{subtitle || contactData.subtitle}</p>
        </div>

        <div className={styles.grid}>
          {/* Clinical Hours & Info Card */}
          <div className={styles.hoursCard}>
            <div>
              <h3 className={styles.cardHeading}>
                <span className="material-symbols-outlined">schedule</span>
                <span>Surgery Clinical Hours</span>
              </h3>

              <div className={styles.hoursList}>
                {contactData.hours?.map((item, idx) => (
                  <div key={idx} className={styles.hoursRow}>
                    <span>{item.day_range}:</span>
                    <span
                      className={`${styles.timeText} ${
                        item.hours.includes('Emergency') ? styles.highlight : ''
                      }`}
                    >
                      {item.hours}
                    </span>
                  </div>
                ))}
              </div>

              <h3 className={styles.cardHeading}>
                <span className="material-symbols-outlined">pin_drop</span>
                <span>Practice Details</span>
              </h3>

              <div className={styles.contactDetails}>
                <p className={styles.contactItem}>
                  <span
                    className={`material-symbols-outlined ${styles.itemIcon}`}
                  >
                    location_on
                  </span>
                  <span>{contactData.address}</span>
                </p>

                <p className={styles.contactItem}>
                  <span
                    className={`material-symbols-outlined ${styles.itemIcon}`}
                  >
                    call
                  </span>
                  <a href={`tel:${contactData.phone}`}>{contactData.phone}</a>
                </p>

                <p className={styles.contactItem}>
                  <span
                    className={`material-symbols-outlined ${styles.itemIcon}`}
                  >
                    mail
                  </span>
                  <a href={`mailto:${contactData.email}`}>
                    {contactData.email}
                  </a>
                </p>
              </div>
            </div>

            <a
              href={`tel:${contactData.phone}`}
              className={styles.callReceptionBtn}
            >
              <span className="material-symbols-outlined text-[18px]">
                phone_in_talk
              </span>
              <span>Call Reception For Assistance</span>
            </a>
          </div>

          {/* Map Preview Card */}
          <div className={styles.mapCard}>
            <div className={styles.mapFrame}>
              <Image
                src={assetUrl(contactData.map_image || '/images/surgery-clinic.jpg')}
                alt="Clinic Location Map View"
                fill
              />
              <div className={styles.mapFloatingCard}>
                <div className={styles.pinHeader}>
                  <span className="material-symbols-outlined">
                    local_hospital
                  </span>
                  <p>Acocks Green Dental Practice</p>
                </div>
                <p className={styles.pinAddress}>{contactData.address}</p>
                <a
                  href={`https://maps.google.com/?q=${encodeURIComponent(
                    contactData.address
                  )}`}
                  target="_blank"
                  rel="noopener noreferrer"
                  className={styles.mapLink}
                >
                  <span>Open in Google Maps</span>
                  <span className="material-symbols-outlined text-[14px]">
                    open_in_new
                  </span>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  );
};
