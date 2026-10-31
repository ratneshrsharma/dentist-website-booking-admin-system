'use client';

import React, { useEffect, useState } from 'react';
import styles from './ThemeSwitcher.module.scss';
import { Palette } from 'lucide-react';

export type ThemeMode = 'modern' | 'classic' | 'luxury';

export const ThemeSwitcher: React.FC = () => {
  const [activeTheme, setActiveTheme] = useState<ThemeMode>('modern');

  useEffect(() => {
    const savedTheme = (localStorage.getItem('adc-theme') as ThemeMode) || 'modern';
    setActiveTheme(savedTheme);
    document.documentElement.setAttribute('data-theme', savedTheme);
  }, []);

  const handleThemeChange = (theme: ThemeMode) => {
    setActiveTheme(theme);
    localStorage.setItem('adc-theme', theme);
    document.documentElement.setAttribute('data-theme', theme);
  };

  return (
    <div className={styles.container}>
      <span className={styles.label}>
        <Palette size={14} />
        <span>Template:</span>
      </span>
      <div className={styles.toggleGroup}>
        <button
          type="button"
          className={`${styles.toggleButton} ${activeTheme === 'modern' ? styles.active : ''}`}
          onClick={() => handleThemeChange('modern')}
          title="Template 1: Modern Minimalist (Confident Doctor)"
        >
          Modern
        </button>
        <button
          type="button"
          className={`${styles.toggleButton} ${activeTheme === 'classic' ? styles.active : ''}`}
          onClick={() => handleThemeChange('classic')}
          title="Template 2: Classic Heritage"
        >
          Classic
        </button>
        <button
          type="button"
          className={`${styles.toggleButton} ${activeTheme === 'luxury' ? styles.active : ''}`}
          onClick={() => handleThemeChange('luxury')}
          title="Template 3: Clinical Luxury"
        >
          Luxury
        </button>
      </div>
    </div>
  );
};
