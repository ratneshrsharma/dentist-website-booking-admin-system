'use client';

import React, { useState } from 'react';
import Link from 'next/link';
import Image from 'next/image';
import { usePathname } from 'next/navigation';
import styles from './HeaderNavBar.module.css';
import { useTheme } from '@/context/ThemeContext';

export interface HeaderNavBarProps {
  onBookClick?: () => void;
}

export const HeaderNavBar: React.FC<HeaderNavBarProps> = ({ onBookClick }) => {
  const { theme, navigation } = useTheme();
  const pathname = usePathname();
  const [mobileOpen, setMobileOpen] = useState(false);

  const { clinic_name, tagline, logo_url } = theme.branding;
  const menuItems = navigation.header_menu || [];

  return (
    <header className={styles.header}>
      <div className={styles.container}>
        {/* Brand Logo & Title */}
        <Link href="/" className={styles.brandLink}>
          <div className={styles.logoWrapper}>
            <Image
              src={logo_url || '/images/acocks-green-logo.png'}
              alt={`${clinic_name} Logo`}
              width={48}
              height={48}
              priority
            />
          </div>
          <div className={styles.brandText}>
            <span className={styles.clinicName}>{clinic_name}</span>
            <span className={styles.tagline}>{tagline}</span>
          </div>
        </Link>

        {/* Desktop Navigation */}
        <nav className={styles.navMenu} aria-label="Main Navigation">
          {menuItems.map((item, idx) => {
            const hasChildren = item.children && item.children.length > 0;
            const isActive = pathname === item.path;

            return (
              <div key={idx} className={styles.navItem}>
                <Link
                  href={item.path}
                  className={`${styles.navLink} ${isActive ? styles.active : ''}`}
                >
                  <span>{item.title}</span>
                  {hasChildren && (
                    <span className="material-symbols-outlined text-[18px]">
                      expand_more
                    </span>
                  )}
                </Link>

                {hasChildren && (
                  <div className={styles.dropdownMenu} role="menu">
                    {item.children?.map((sub, sIdx) => (
                      <Link
                        key={sIdx}
                        href={sub.path}
                        className={styles.dropdownItem}
                        role="menuitem"
                      >
                        {sub.icon && (
                          <span
                            className={`material-symbols-outlined ${styles.dropdownIcon}`}
                          >
                            {sub.icon}
                          </span>
                        )}
                        <span>{sub.title}</span>
                      </Link>
                    ))}
                  </div>
                )}
              </div>
            );
          })}
        </nav>

        {/* Right Action & Mobile Toggle */}
        <div className={styles.headerActions}>
          <button
            type="button"
            className={styles.bookButton}
            onClick={onBookClick}
          >
            <span>Book An Appointment</span>
            <span className="material-symbols-outlined text-[16px]">
              calendar_month
            </span>
          </button>

          <button
            type="button"
            className={styles.mobileMenuToggle}
            onClick={() => setMobileOpen(!mobileOpen)}
            aria-label="Toggle mobile navigation"
          >
            <span className="material-symbols-outlined text-[28px]">
              {mobileOpen ? 'close' : 'menu'}
            </span>
          </button>
        </div>
      </div>

      {/* Mobile Drawer */}
      {mobileOpen && (
        <div className={styles.mobileDrawer}>
          {menuItems.map((item, idx) => (
            <div key={idx}>
              <Link
                href={item.path}
                className={styles.navLink}
                onClick={() => setMobileOpen(false)}
              >
                <span>{item.title}</span>
              </Link>
              {item.children?.map((sub, sIdx) => (
                <Link
                  key={sIdx}
                  href={sub.path}
                  className={styles.dropdownItem}
                  onClick={() => setMobileOpen(false)}
                  style={{ paddingLeft: '1.5rem' }}
                >
                  <span>{sub.title}</span>
                </Link>
              ))}
            </div>
          ))}
          <button
            type="button"
            className={styles.bookButton}
            style={{ display: 'inline-flex', marginTop: '1rem' }}
            onClick={() => {
              setMobileOpen(false);
              if (onBookClick) onBookClick();
            }}
          >
            <span>Book An Appointment</span>
          </button>
        </div>
      )}
    </header>
  );
};
