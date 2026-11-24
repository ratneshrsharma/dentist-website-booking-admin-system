'use client';

import React from 'react';
import styles from './HeaderTopBar.module.css';
import { useTheme } from '@/context/ThemeContext';

export interface HeaderTopBarProps {
  phone?: string;
  hours?: string;
  address?: string;
}

export const HeaderTopBar: React.FC<HeaderTopBarProps> = ({
  phone,
  hours = 'Mon-Fri: 8:30am - 5:30pm',
  address,
}) => {
  const { theme } = useTheme();

  const displayPhone = phone || theme.branding.phone || '+44 121 765 2870';
  const displayAddress = address || theme.branding.address || '1078 Warwick Road, Birmingham B27 6BH';

  return (
    <aside className={styles.topBar} aria-label="Practice Quick Contact Info">
      <div className={styles.container}>
        <div className={styles.infoGroup}>
          <div className={styles.infoItem}>
            <span className={`material-symbols-outlined ${styles.icon}`}>call</span>
            <span className={styles.label}>Emergency Line:</span>
            <a href={`tel:${displayPhone.replace(/\s+/g, '')}`} className={styles.value}>
              {displayPhone}
            </a>
          </div>

          <div className={`${styles.infoItem} ${styles.hiddenMobile}`}>
            <span className={`material-symbols-outlined ${styles.icon}`}>schedule</span>
            <span>{hours}</span>
          </div>

          <div className={`${styles.infoItem} ${styles.hiddenTablet}`}>
            <span className={`material-symbols-outlined ${styles.icon}`}>location_on</span>
            <span>{displayAddress}</span>
          </div>
        </div>
      </div>
    </aside>
  );
};
