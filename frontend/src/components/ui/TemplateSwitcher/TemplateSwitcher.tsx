'use client';

import React, { useState } from 'react';
import styles from './TemplateSwitcher.module.scss';
import { Palette, Check, Building2, ChevronUp, ChevronDown } from 'lucide-react';

export type TemplateType = 'acocks-green';

export interface TemplateSwitcherProps {
  activeTemplate?: TemplateType;
  onSelectTemplate?: (template: TemplateType) => void;
  activeTheme?: string;
  onSelectTheme?: (theme: string) => void;
}

export const TemplateSwitcher: React.FC<TemplateSwitcherProps> = ({
  activeTemplate: _activeTemplate = 'acocks-green',
  onSelectTemplate,
  activeTheme = 'acocks-green',
  onSelectTheme,
}) => {
  const [paletteExpanded, setPaletteExpanded] = useState(false);

  return (
    <aside
      className={styles.floatingBar}
      role="region"
      aria-label="Clinical Website Template & Theme Selector"
    >
      <div className={styles.barInner}>
        {/* Left Badge: Switcher Label */}
        <div className={styles.labelSection}>
          <div className={styles.liveIndicator}>
            <span className={styles.livePulse} />
            <span className={styles.liveDot} />
          </div>
          <span className={styles.labelText}>Practice:</span>
        </div>

        {/* Template Selectors */}
        <div className={styles.templateGroup}>
          {/* Primary Default: Acocks Green Practice */}
          <button
            type="button"
            className={`${styles.templateBtn} ${styles.primaryBtn} ${styles.active}`}
            onClick={() => onSelectTemplate?.('acocks-green')}
            title="Primary Default: Acocks Green Dental Practice (Birmingham NHS & Private Surgery)"
          >
            <span className={styles.pillIcon}>
              <Building2 size={14} />
            </span>
            <span className={styles.templateName}>Acocks Green</span>
            <span className={styles.roleBadgePrimary}>Primary Practice</span>
            <Check size={13} className={styles.checkIcon} />
          </button>
        </div>

        {/* Theme Palette Dropdown Toggle */}
        {onSelectTheme && (
          <div className={styles.paletteWrapper}>
            <button
              type="button"
              className={`${styles.paletteToggleBtn} ${paletteExpanded ? styles.expanded : ''}`}
              onClick={() => setPaletteExpanded(!paletteExpanded)}
              title="Change Color Theme"
              aria-expanded={paletteExpanded}
            >
              <Palette size={14} />
              <span className={styles.paletteLabel}>Color Themes</span>
              {paletteExpanded ? <ChevronDown size={12} /> : <ChevronUp size={12} />}
            </button>

            {paletteExpanded && (
              <div className={styles.paletteDropdown}>
                <button
                  type="button"
                  className={`${styles.colorOption} ${activeTheme === 'acocks-green' ? styles.colorActive : ''}`}
                  onClick={() => {
                    onSelectTheme('acocks-green');
                    setPaletteExpanded(false);
                  }}
                >
                  <span className={styles.colorSwatch} style={{ backgroundColor: '#0D631B' }} />
                  <span>Acocks Green (Botanical)</span>
                  {activeTheme === 'acocks-green' && <Check size={12} />}
                </button>

                <button
                  type="button"
                  className={`${styles.colorOption} ${activeTheme === 'modern' ? styles.colorActive : ''}`}
                  onClick={() => {
                    onSelectTheme('modern');
                    setPaletteExpanded(false);
                  }}
                >
                  <span className={styles.colorSwatch} style={{ backgroundColor: '#0D9488' }} />
                  <span>Medical Teal</span>
                  {activeTheme === 'modern' && <Check size={12} />}
                </button>

                <button
                  type="button"
                  className={`${styles.colorOption} ${activeTheme === 'classic' ? styles.colorActive : ''}`}
                  onClick={() => {
                    onSelectTheme('classic');
                    setPaletteExpanded(false);
                  }}
                >
                  <span className={styles.colorSwatch} style={{ backgroundColor: '#1E3A8A' }} />
                  <span>Royal Navy</span>
                  {activeTheme === 'classic' && <Check size={12} />}
                </button>

                <button
                  type="button"
                  className={`${styles.colorOption} ${activeTheme === 'luxury' ? styles.colorActive : ''}`}
                  onClick={() => {
                    onSelectTheme('luxury');
                    setPaletteExpanded(false);
                  }}
                >
                  <span className={styles.colorSwatch} style={{ backgroundColor: '#D4AF37' }} />
                  <span>Luxury Gold</span>
                  {activeTheme === 'luxury' && <Check size={12} />}
                </button>
              </div>
            )}
          </div>
        )}
      </div>
    </aside>
  );
};
