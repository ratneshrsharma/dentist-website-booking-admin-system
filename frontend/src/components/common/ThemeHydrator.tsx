'use client';

import React, { useEffect } from 'react';
import { GlobalThemeConfig, cmsService } from '@/services/cms.service';

export interface ThemeHydratorProps {
  initialTheme?: GlobalThemeConfig | null;
}

/**
 * Injects dynamic color tokens and typography settings from the backend REST API
 * into document.documentElement (:root) CSS custom variables.
 */
export const ThemeHydrator: React.FC<ThemeHydratorProps> = ({ initialTheme }) => {
  useEffect(() => {
    let isMounted = true;

    const applyThemeTokens = (theme: GlobalThemeConfig) => {
      if (!theme || !theme.colors) return;
      const root = document.documentElement;

      const colorMap: Record<string, string | undefined> = {
        '--color-primary': theme.colors.primary,
        '--color-primary-hover': theme.colors.primary_hover,
        '--color-secondary': theme.colors.secondary,
        '--color-secondary-hover': theme.colors.secondary_hover || theme.colors.secondary,
        '--color-accent': theme.colors.accent,
        '--color-surface': theme.colors.surface,
        '--color-surface-muted': theme.colors.surface_muted,
        '--color-border': theme.colors.border,
        '--color-text-main': theme.colors.text_primary,
        '--color-text-muted': theme.colors.text_muted,
        '--color-nhs-blue': theme.colors.nhs_blue || '#005eb8',
      };

      Object.entries(colorMap).forEach(([prop, val]) => {
        if (val) {
          root.style.setProperty(prop, val);
        }
      });

      if (theme.typography) {
        if (theme.typography.font_family_heading) {
          root.style.setProperty('--font-family-display', theme.typography.font_family_heading);
        }
        if (theme.typography.font_family_body) {
          root.style.setProperty('--font-family-sans', theme.typography.font_family_body);
        }
      }

      // If custom Google Fonts URL is provided, append link tag if missing
      if (theme.typography?.google_fonts_url) {
        const fontHref = theme.typography.google_fonts_url;
        const existingLink = document.querySelector(`link[href="${fontHref}"]`);
        if (!existingLink) {
          const link = document.createElement('link');
          link.rel = 'stylesheet';
          link.href = fontHref;
          document.head.appendChild(link);
        }
      }
    };

    if (initialTheme) {
      applyThemeTokens(initialTheme);
    } else {
      cmsService
        .getGlobalTheme()
        .then((theme) => {
          if (isMounted && theme) {
            applyThemeTokens(theme);
          }
        })
        .catch((err) => {
          console.warn('[ThemeHydrator] Failed to load global theme:', err);
        });
    }

    return () => {
      isMounted = false;
    };
  }, [initialTheme]);

  return null;
};

export default ThemeHydrator;
