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
  const [shouldRender, setShouldRender] = useState(true);
  const [isFadingOut, setIsFadingOut] = useState(false);

  useEffect(() => {
    if (!isLoading) {
      setIsFadingOut(true);
      const timer = setTimeout(() => {
        setShouldRender(false);
        if (onFinish) onFinish();
      }, 500);
      return () => clearTimeout(timer);
    }

    setShouldRender(true);
    setIsFadingOut(false);
    return undefined;
  }, [isLoading, onFinish]);

  if (!shouldRender) {
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
        {/* Animated Brand Circular Badge with Pulse Glow */}
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
