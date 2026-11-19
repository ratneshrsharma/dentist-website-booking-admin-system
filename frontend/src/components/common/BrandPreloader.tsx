'use client';

import React, { useEffect, useState } from 'react';
import { getAssetPath } from '@/lib/assetPath';
import styles from './BrandPreloader.module.scss';

export interface BrandPreloaderProps {
  isLoading: boolean;
  clinicName?: string;
  badge?: string;
  message?: string;
  onFinish?: () => void;
}

export const BrandPreloader: React.FC<BrandPreloaderProps> = ({
  isLoading,
  clinicName = 'Acocks Green Dental Practice',
  badge = 'B27 6BH NHS & Private Surgery',
  message = 'Connecting Clinical Systems & Theme Tokens...',
  onFinish,
}) => {
  // Check if session has already seen initial preloader once
  const [shouldRender, setShouldRender] = useState(false);
  const [isFadingOut, setIsFadingOut] = useState(false);

  useEffect(() => {
    // Zero-loading rule: Never block client-side route transitions
    if (typeof window !== 'undefined') {
      const alreadySeen = sessionStorage.getItem('brand_preloader_seen');
      if (alreadySeen || !isLoading) {
        setShouldRender(false);
        if (onFinish) onFinish();
        return;
      }

      // First hard load only
      setShouldRender(true);
      sessionStorage.setItem('brand_preloader_seen', 'true');
    }
  }, [isLoading, onFinish]);

  useEffect(() => {
    if (!isLoading && shouldRender) {
      setIsFadingOut(true);
      // Fast 100ms fade-out for zero perceived loading delay
      const timer = setTimeout(() => {
        setShouldRender(false);
        if (onFinish) onFinish();
      }, 100);
      return () => clearTimeout(timer);
    }
    return undefined;
  }, [isLoading, shouldRender, onFinish]);

  if (!shouldRender || !isLoading) {
    return null;
  }

  const logoSrc = getAssetPath('/images/acocks-green-logo.png');

  return (
    <div
      className={`${styles.preloaderOverlay} ${isFadingOut ? styles.hidden : ''}`}
      role="status"
      aria-live="polite"
      aria-label="Loading clinical page content"
    >
      <div className={styles.preloaderCard}>
        {/* Animated Brand Circular Badge */}
        <div className={styles.logoWrapper}>
          <div className={styles.logoGlow} />
          <div className={styles.logoRing} />
          {/* eslint-disable-next-line @next/next/no-img-element */}
          <img
            src={logoSrc}
            alt={clinicName}
            className={styles.logoImage}
            width={84}
            height={84}
          />
        </div>

        {/* Practice Title & Location Badge */}
        <h2 className={styles.clinicTitle}>{clinicName}</h2>
        <div className={styles.badgeRow}>
          <span className={styles.badgeDot} />
          <span>{badge}</span>
        </div>

        {/* Dynamic Progress Bar */}
        <div className={styles.progressBarTrack}>
          <div className={styles.progressBarFill} />
        </div>

        {/* Reassurance Status Subtitle */}
        <p className={styles.statusMessage}>{message}</p>
      </div>
    </div>
  );
};

export default BrandPreloader;
