'use client';

import React from 'react';
import Link from 'next/link';
import Image from 'next/image';
import styles from './ContentBlockSection.module.css';
import { PageSection } from '@/types/cms';
import { assetUrl } from '@/utils/asset';

export interface ContentBlockSectionProps {
  section: PageSection;
  index?: number;
}

export const ContentBlockSection: React.FC<ContentBlockSectionProps> = ({ section, index = 0 }) => {
  if (section.is_active === false) return null;

  const columnLayout = section.column_layout || 'two_col_split';
  const imagePosition = section.image_position || 'right';
  const hasImage = Boolean(section.feature_image);
  const isEven = index % 2 === 1;

  // Background styling computation
  const bgType = section.bg_type || 'default';
  const customSectionStyle: React.CSSProperties = { position: 'relative' };
  let overlayStyle: React.CSSProperties | null = null;
  let isLightText = section.text_contrast === 'light';

  if (section.padding_y === 'compact') {
    customSectionStyle.paddingTop = '3.5rem';
    customSectionStyle.paddingBottom = '3.5rem';
  } else if (section.padding_y === 'generous') {
    customSectionStyle.paddingTop = '7.5rem';
    customSectionStyle.paddingBottom = '7.5rem';
  }

  switch (bgType) {
    case 'solid':
      customSectionStyle.backgroundColor = section.bg_color || (isEven ? '#f0fdf4' : '#ffffff');
      break;

    case 'gradient': {
      const start = section.bg_gradient_start || '#094713';
      const end = section.bg_gradient_end || '#15803d';
      const angle = section.bg_gradient_angle || '135deg';
      customSectionStyle.background = `linear-gradient(${angle}, ${start} 0%, ${end} 100%)`;
      if (section.text_contrast !== 'dark') isLightText = true;
      break;
    }

    case 'image':
      if (section.bg_image) {
        customSectionStyle.backgroundImage = `url(${assetUrl(section.bg_image)})`;
        customSectionStyle.backgroundSize = 'cover';
        customSectionStyle.backgroundPosition = 'center';
      }
      break;

    case 'image_overlay':
      if (section.bg_image) {
        customSectionStyle.backgroundImage = `url(${assetUrl(section.bg_image)})`;
        customSectionStyle.backgroundSize = 'cover';
        customSectionStyle.backgroundPosition = 'center';
        overlayStyle = {
          position: 'absolute',
          inset: 0,
          backgroundColor: section.bg_overlay_color || '#000000',
          opacity: section.bg_overlay_opacity ?? 0.6,
          zIndex: 1,
        };
        if (section.text_contrast !== 'dark') isLightText = true;
      }
      break;

    case 'default':
    default:
      customSectionStyle.backgroundColor = isEven ? '#f2fcf5' : '#ffffff';
      break;
  }

  const textColorStyle: React.CSSProperties = isLightText ? { color: '#ffffff' } : {};
  const subtitleColorStyle: React.CSSProperties = isLightText ? { color: 'rgba(255, 255, 255, 0.9)' } : {};
  const descColorStyle: React.CSSProperties = isLightText ? { color: 'rgba(255, 255, 255, 0.8)' } : {};

  // Variant 1: Action Bar / Glowing Banner Callout (e.g. NHS Sexual Safety Charter)
  if (columnLayout === 'action_bar') {
    return (
      <section className={styles.section} id={section.id} style={customSectionStyle}>
        {overlayStyle && <div style={overlayStyle} />}
        <div className={styles.container} style={{ position: 'relative', zIndex: 2 }}>
          <div className={styles.actionBarWrapper}>
            <div className={styles.actionBarContent}>
              {section.eyebrow && (
                <div className={styles.actionBarEyebrow}>
                  <span className="material-symbols-outlined" style={{ fontSize: 16 }}>verified</span>
                  <span dangerouslySetInnerHTML={{ __html: section.eyebrow }} />
                </div>
              )}
              <h3 className={styles.actionBarTitle} dangerouslySetInnerHTML={{ __html: section.title || '' }} />
              {section.summary && (
                <p className={styles.actionBarSummary} dangerouslySetInnerHTML={{ __html: section.summary }} />
              )}
              {section.description && (
                <p className={styles.actionBarDesc} dangerouslySetInnerHTML={{ __html: section.description }} />
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
      <section className={styles.section} id={section.id} style={customSectionStyle}>
        {overlayStyle && <div style={overlayStyle} />}
        <div className={styles.container} style={{ position: 'relative', zIndex: 2 }}>
          <div className={styles.fullWidthWrapper}>
            {section.eyebrow && (
              <span
                className={styles.eyebrow}
                style={isLightText ? { color: '#a7f3d0' } : {}}
                dangerouslySetInnerHTML={{ __html: section.eyebrow }}
              />
            )}
            <h2
              className={styles.title}
              style={textColorStyle}
              dangerouslySetInnerHTML={{ __html: section.title || '' }}
            />
            {section.summary && (
              <p
                className={styles.summary}
                style={subtitleColorStyle}
                dangerouslySetInnerHTML={{ __html: section.summary }}
              />
            )}
            {section.description && (
              <p
                className={styles.description}
                style={descColorStyle}
                dangerouslySetInnerHTML={{ __html: section.description }}
              />
            )}
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
    <section className={styles.section} id={section.id} style={customSectionStyle}>
      {overlayStyle && <div style={overlayStyle} />}
      <div className={styles.container} style={{ position: 'relative', zIndex: 2 }}>
        <div className={`${styles.twoColGrid} ${isImageLeft ? styles.imageLeft : styles.imageRight}`}>
          {/* Image Column */}
          <div className={styles.imageCol}>
            <div className={styles.imageWrapper}>
              <Image
                src={assetUrl(section.feature_image || '/uploads/home/surgery-clinic.jpg')}
                alt={section.title}
                fill
                sizes="(max-width: 1024px) 100vw, 50vw"
                style={{ objectFit: 'cover' }}
              />
            </div>
          </div>

          {/* Text Content Column */}
          <div className={styles.textCol}>
            {section.eyebrow && (
              <span
                className={styles.eyebrow}
                style={isLightText ? { color: '#a7f3d0' } : {}}
                dangerouslySetInnerHTML={{ __html: section.eyebrow }}
              />
            )}
            <h2
              className={styles.title}
              style={textColorStyle}
              dangerouslySetInnerHTML={{ __html: section.title || '' }}
            />
            {section.summary && (
              <p
                className={styles.summary}
                style={subtitleColorStyle}
                dangerouslySetInnerHTML={{ __html: section.summary }}
              />
            )}
            {section.description && (
              <p
                className={styles.description}
                style={descColorStyle}
                dangerouslySetInnerHTML={{ __html: section.description }}
              />
            )}
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
