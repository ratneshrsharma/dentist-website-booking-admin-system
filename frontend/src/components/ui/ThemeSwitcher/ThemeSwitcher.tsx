'use client';

import React, { useEffect, useState } from 'react';
import styles from './ThemeSwitcher.module.scss';
import { Palette, Check } from 'lucide-react';

export type ThemeMode = 'acocks-green' | 'modern' | 'classic' | 'luxury';

export interface ThemeSwitcherProps {
  onThemeChange?: (theme: ThemeMode) => void;
  className?: string;
}

export const ThemeSwitcher: React.FC<ThemeSwitcherProps> = ({
  onThemeChange,
  className,
}) => {
  // Acocks Green is the primary default theme
  const [activeTheme, setActiveTheme] = useState<ThemeMode>('acocks-green');

  useEffect(() => {
    const savedTheme = (localStorage.getItem('adc-theme') as ThemeMode) || 'acocks-green';
    setActiveTheme(savedTheme);
    document.documentElement.setAttribute('data-theme', savedTheme);
  }, []);

  const handleThemeChange = (theme: ThemeMode) => {
    setActiveTheme(theme);
    localStorage.setItem('adc-theme', theme);
    document.documentElement.setAttribute('data-theme', theme);
    if (onThemeChange) {
      onThemeChange(theme);
    }
  };

  return (
    <div className={`${styles.container} ${className || ''}`} role="region" aria-label="Theme & Template Switcher">
      <span className={styles.label}>
        <Palette size={14} className={styles.paletteIcon} />
        <span>Theme:</span>
      </span>
      <div className={styles.toggleGroup}>
        <button
          type="button"
          className={`${styles.toggleButton} ${styles.primaryTheme} ${activeTheme === 'acocks-green' ? styles.active : ''}`}
          onClick={() => handleThemeChange('acocks-green')}
          title="Primary Default Theme: Acocks Green Practice (Birmingham B27 NHS & Private)"
        >
          <span className={styles.themeDot} style={{ backgroundColor: '#0D631B' }} />
          <span>Acocks Green (Primary)</span>
          {activeTheme === 'acocks-green' && <Check size={12} className={styles.activeCheck} />}
        </button>

        <button
          type="button"
          className={`${styles.toggleButton} ${styles.secondaryTheme} ${activeTheme === 'modern' ? styles.active : ''}`}
          onClick={() => handleThemeChange('modern')}
          title="Secondary Theme: Confident Doctor (Modern Medical Teal)"
        >
          <span className={styles.themeDot} style={{ backgroundColor: '#0D9488' }} />
          <span>Confident Doctor (Secondary)</span>
          {activeTheme === 'modern' && <Check size={12} className={styles.activeCheck} />}
        </button>

        <button
          type="button"
          className={`${styles.toggleButton} ${activeTheme === 'classic' ? styles.active : ''}`}
          onClick={() => handleThemeChange('classic')}
          title="Theme 3: Classic Heritage (Royal Oxford Navy)"
        >
          <span className={styles.themeDot} style={{ backgroundColor: '#1E3A8A' }} />
          <span>Classic</span>
          {activeTheme === 'classic' && <Check size={12} className={styles.activeCheck} />}
        </button>

        <button
          type="button"
          className={`${styles.toggleButton} ${activeTheme === 'luxury' ? styles.active : ''}`}
          onClick={() => handleThemeChange('luxury')}
          title="Theme 4: Clinical Luxury (Obsidian & Gold)"
        >
          <span className={styles.themeDot} style={{ backgroundColor: '#D4AF37' }} />
          <span>Luxury</span>
          {activeTheme === 'luxury' && <Check size={12} className={styles.activeCheck} />}
        </button>
      </div>
    </div>
  );
};

