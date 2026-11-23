'use client';

import React, { useEffect, useState } from 'react';
import Image from 'next/image';
import styles from './BrandPreloader.module.css';

interface BrandPreloaderProps {
  logoUrl?: string;
  clinicName?: string;
  tagline?: string;
  isReady?: boolean;
}

export const BrandPreloader: React.FC<BrandPreloaderProps> = ({
  logoUrl = '/images/acocks-green-logo.png',
  clinicName = 'Acocks Green',
  tagline = 'Dental Practice',
  isReady = false,
}) => {
  const [mounted, setMounted] = useState(false);
  const [hidden, setHidden] = useState(false);

  useEffect(() => {
    setMounted(true);
  }, []);

  useEffect(() => {
    if (isReady && mounted) {
      const timer = setTimeout(() => {
        setHidden(true);
      }, 400); // graceful 400ms display so transitions are silky smooth
      return () => clearTimeout(timer);
    }
  }, [isReady, mounted]);

  if (!mounted) return null;

  return (
    <div
      className={`${styles.preloaderWrapper} ${hidden ? styles.hidden : ''}`}
      aria-hidden={hidden}
      role="progressbar"
      aria-label="Loading dental practice workspace"
    >
      <div className={styles.brandContent}>
        <div className={styles.logoContainer}>
          <Image
            src={logoUrl}
            alt={clinicName}
            width={70}
            height={70}
            priority
          />
        </div>
        <div className={styles.clinicTitle}>
          {clinicName}
          <span>{tagline}</span>
        </div>
        <div className={styles.progressBarTrack}>
          <div className={styles.progressBarFill} />
        </div>
      </div>
    </div>
  );
};
