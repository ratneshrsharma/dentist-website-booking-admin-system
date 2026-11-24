'use client';

import React from 'react';
import Link from 'next/link';
import Image from 'next/image';
import styles from './ContentBlockSection.module.css';
import { PageSection } from '@/types/cms';
import { assetUrl } from '@/utils/asset';

export interface ContentBlockSectionProps {
  section: PageSection;
}

export const ContentBlockSection: React.FC<ContentBlockSectionProps> = ({ section }) => {
  if (section.is_active === false) return null;

  const columnLayout = section.column_layout || 'two_col_split';
  const imagePosition = section.image_position || 'right';
  const hasImage = Boolean(section.feature_image);

  // Variant 1: Action Bar / Glowing Banner Callout (e.g. NHS Sexual Safety Charter)
  if (columnLayout === 'action_bar') {
    return (
      <section className={styles.section} id={section.id}>
        <div className={styles.container}>
          <div className={styles.actionBarWrapper}>
            <div className={styles.actionBarContent}>
              {section.eyebrow && (
                <div className={styles.actionBarEyebrow}>
                  <span className="material-symbols-outlined" style={{ fontSize: 16 }}>verified</span>
                  <span>{section.eyebrow}</span>
                </div>
              )}
              <h3 className={styles.actionBarTitle}>{section.title}</h3>
              {section.summary && (
                <p className={styles.actionBarSummary}>{section.summary}</p>
              )}
              {section.description && (
                <p className={styles.actionBarDesc}>{section.description}</p>
              )}
            </div>

            {section.cta_text && (
              <div className={styles.actionBarActions}>
                {section.cta_link?.startsWith('http') ? (
                  <a
                    href={section.cta_link}
                    target="_blank"
                    rel="noopener noreferrer"
                    className={styles.actionBarBtn}
                  >
                    <span>{section.cta_text}</span>
                    <span className="material-symbols-outlined" style={{ fontSize: 18 }}>open_in_new</span>
                  </a>
                ) : (
                  <Link href={section.cta_link || '#'} className={styles.actionBarBtn}>
                    <span>{section.cta_text}</span>
                    <span className="material-symbols-outlined" style={{ fontSize: 18 }}>arrow_forward</span>
                  </Link>
                )}
              </div>
            )}
          </div>
        </div>
      </section>
    );
  }

  // Variant 2: Full Width Centered
  if (columnLayout === 'full_width' || !hasImage) {
    return (
      <section className={`${styles.section} ${styles.sectionMuted}`} id={section.id}>
        <div className={styles.container}>
          <div className={styles.fullWidthWrapper}>
            {section.eyebrow && <span className={styles.eyebrow}>{section.eyebrow}</span>}
            <h2 className={styles.title}>{section.title}</h2>
            {section.summary && <p className={styles.summary}>{section.summary}</p>}
            {section.description && <p className={styles.description}>{section.description}</p>}
            {section.cta_text && (
              <Link href={section.cta_link || '#'} className={styles.btnPrimary}>
                <span>{section.cta_text}</span>
                <span className="material-symbols-outlined" style={{ fontSize: 18 }}>arrow_forward</span>
              </Link>
            )}
          </div>
        </div>
      </section>
    );
  }

  // Variant 3: Two Columns Split Layout (Left or Right Image)
  const isImageLeft = imagePosition === 'left';

  return (
    <section className={styles.section} id={section.id}>
      <div className={styles.container}>
        <div className={`${styles.twoColGrid} ${isImageLeft ? styles.imageLeft : styles.imageRight}`}>
          {/* Image Column */}
          <div className={styles.imageCol}>
            <div className={styles.imageWrapper}>
              <Image
                src={assetUrl(section.feature_image || '/images/surgery-clinic.jpg')}
                alt={section.title}
                fill
                sizes="(max-width: 1024px) 100vw, 50vw"
                style={{ objectFit: 'cover' }}
              />
            </div>
          </div>

          {/* Text Content Column */}
          <div className={styles.textCol}>
            {section.eyebrow && <span className={styles.eyebrow}>{section.eyebrow}</span>}
            <h2 className={styles.title}>{section.title}</h2>
            {section.summary && <p className={styles.summary}>{section.summary}</p>}
            {section.description && <p className={styles.description}>{section.description}</p>}
            {section.cta_text && (
              <Link href={section.cta_link || '#'} className={styles.btnPrimary}>
                <span>{section.cta_text}</span>
                <span className="material-symbols-outlined" style={{ fontSize: 18 }}>arrow_forward</span>
              </Link>
            )}
          </div>
        </div>
      </div>
    </section>
  );
};
