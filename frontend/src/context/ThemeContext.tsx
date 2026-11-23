'use client';

import React, { createContext, useContext, useEffect, useState } from 'react';
import { ThemeSettings, GlobalNavigation } from '@/types/cms';
import { CmsService } from '@/api/cms';

interface ThemeContextType {
  theme: ThemeSettings;
  navigation: GlobalNavigation;
  isReady: boolean;
  refreshTheme: () => Promise<void>;
}

const ThemeContext = createContext<ThemeContextType | undefined>(undefined);

export const ThemeProvider: React.FC<{ children: React.ReactNode }> = ({ children }) => {
  const [theme, setTheme] = useState<ThemeSettings | null>(null);
  const [navigation, setNavigation] = useState<GlobalNavigation | null>(null);
  const [isReady, setIsReady] = useState(false);

  const loadData = async () => {
    try {
      const [themeData, navData] = await Promise.all([
        CmsService.getTheme(),
        CmsService.getNavigation(),
      ]);
      setTheme(themeData);
      setNavigation(navData);

      // Dynamically apply primary color variable to root if customized
      if (typeof window !== 'undefined' && themeData.colors) {
        const root = document.documentElement;
        if (themeData.colors.primary) {
          root.style.setProperty('--primary-color', themeData.colors.primary);
        }
        if (themeData.colors.secondary) {
          root.style.setProperty('--secondary-color', themeData.colors.secondary);
        }
      }
    } catch (error) {
      console.warn('[ThemeProvider] Fallback data used due to error:', error);
    } finally {
      setIsReady(true);
    }
  };

  useEffect(() => {
    loadData();
  }, []);

  // Safe injection of custom head scripts from CMS (Yoast-style SEO / Tracking)
  useEffect(() => {
    if (theme?.custom_head_scripts && typeof window !== 'undefined') {
      const scriptContainer = document.getElementById('cms-custom-head-scripts');
      if (!scriptContainer) {
        const div = document.createElement('div');
        div.id = 'cms-custom-head-scripts';
        div.innerHTML = theme.custom_head_scripts;
        document.head.appendChild(div);
      }
    }
  }, [theme?.custom_head_scripts]);

  if (!theme || !navigation) {
    return null;
  }

  return (
    <ThemeContext.Provider
      value={{
        theme,
        navigation,
        isReady,
        refreshTheme: loadData,
      }}
    >
      {children}
    </ThemeContext.Provider>
  );
};

export const useTheme = (): ThemeContextType => {
  const context = useContext(ThemeContext);
  if (!context) {
    throw new Error('useTheme must be used within a ThemeProvider');
  }
  return context;
};
