'use client';

import React from 'react';
import Link from 'next/link';
import { usePathname } from 'next/navigation';
import { useTheme } from '@/context/ThemeContext';
import styles from './MobileAppNavBar.module.css';

interface MobileAppNavBarProps {
  onBookClick: () => void;
}

export const MobileAppNavBar: React.FC<MobileAppNavBarProps> = ({ onBookClick }) => {
  const pathname = usePathname();
  const { theme } = useTheme();

  const rawPhone = theme?.branding?.whatsapp || theme?.branding?.phone || '+441217652870';
  const cleanPhone = rawPhone.replace(/[^\d+]/g, '');
  const whatsappUrl = `https://wa.me/${cleanPhone.replace('+', '')}?text=${encodeURIComponent(
    'Hello Acocks Green Dental Practice, I would like to inquire about an appointment.'
  )}`;

  return (
    <nav className={styles.mobileNavBar} aria-label="Mobile Navigation">
      {/* 1. Home */}
      <Link
        href="/"
        className={`${styles.navItem} ${pathname === '/' ? styles.active : ''}`}
      >
        <span className={`material-symbols-outlined ${styles.icon}`}>home</span>
        <span>Home</span>
      </Link>

      {/* 2. Services */}
      <a
        href="#services"
        className={styles.navItem}
        onClick={(e) => {
          if (pathname === '/') {
            e.preventDefault();
            const el = document.getElementById('services');
            if (el) {
              el.scrollIntoView({ behavior: 'smooth' });
            }
          }
        }}
      >
        <span className={`material-symbols-outlined ${styles.icon}`}>dentistry</span>
        <span>Services</span>
      </a>

      {/* 3. Booking (Center Glowing CTA Button) */}
      <button
        type="button"
        className={styles.bookingCenterBtn}
        onClick={onBookClick}
        aria-label="Book an Appointment"
      >
        <div className={styles.bookingIconCircle}>
          <span className={`material-symbols-outlined ${styles.icon}`}>
            calendar_month
          </span>
        </div>
        <span className={styles.bookingLabel}>Book</span>
      </button>

      {/* 4. Blog */}
      <Link
        href="/blog"
        className={`${styles.navItem} ${pathname === '/blog' ? styles.active : ''}`}
      >
        <span className={`material-symbols-outlined ${styles.icon}`}>article</span>
        <span>Blog</span>
      </Link>

      {/* 5. WhatsApp Direct Chat */}
      <a
        href={whatsappUrl}
        target="_blank"
        rel="noopener noreferrer"
        className={`${styles.navItem} ${styles.whatsappItem}`}
        aria-label="Contact via WhatsApp"
      >
        <svg
          className={styles.whatsappSvg}
          viewBox="0 0 24 24"
          aria-hidden="true"
        >
          <path d="M12.031 2C6.496 2 2 6.5 2 12.043c0 1.942.548 3.774 1.528 5.344L2 22l4.808-1.503a9.986 9.986 0 005.223 1.488h.004c5.534 0 10.031-4.5 10.031-10.043 0-2.684-1.045-5.207-2.943-7.108C17.224 3.037 14.713 2 12.031 2zm0 18.358h-.003a8.318 8.318 0 01-4.24-1.161l-.304-.18-2.854.893.91-2.782-.198-.315a8.307 8.307 0 01-1.312-4.77c0-4.603 3.743-8.347 8.347-8.347 2.23 0 4.327.869 5.904 2.449a8.272 8.272 0 012.446 5.898c0 4.604-3.743 8.348-8.348 8.348zm4.573-6.242c-.251-.126-1.485-.733-1.715-.816-.23-.084-.397-.126-.565.126-.167.251-.649.816-.795.984-.147.168-.293.189-.544.063-.251-.126-1.06-.391-2.02-1.246-.747-.666-1.251-1.489-1.398-1.74-.146-.252-.016-.388.11-.513.113-.113.251-.293.377-.44.126-.147.168-.251.251-.419.084-.168.042-.314-.021-.44-.063-.126-.565-1.362-.774-1.865-.204-.49-.411-.424-.565-.432-.147-.008-.314-.01-.482-.01-.168 0-.44.063-.67.314-.23.251-.88 0.86-.88 2.097 0 1.238.899 2.433 1.025 2.601.126.168 1.769 2.702 4.286 3.789.599.259 1.067.414 1.431.53.601.191 1.149.164 1.582.099.482-.072 1.485-.607 1.694-1.193.21-.586.21-1.088.147-1.193-.063-.105-.23-.168-.482-.293z" />
        </svg>
        <span>WhatsApp</span>
      </a>
    </nav>
  );
};
