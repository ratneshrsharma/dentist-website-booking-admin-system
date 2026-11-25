'use client';

import React, { useState } from 'react';
import Link from 'next/link';
import Image from 'next/image';
import { usePathname } from 'next/navigation';
import styles from './HeaderNavBar.module.css';
import { useTheme } from '@/context/ThemeContext';
import { assetUrl } from '@/utils/asset';

export interface HeaderNavBarProps {
  onBookClick?: (treatmentName?: string) => void;
}

export interface TreatmentMenuItem {
  title: string;
  path: string;
  icon: string;
  badge: string;
  price: string;
  desc: string;
}

export const CLINICAL_TREATMENTS: TreatmentMenuItem[] = [
  {
    title: 'Routine Dental Examinations',
    path: '/treatments/routine-examinations',
    icon: 'dentistry',
    badge: 'Preventive',
    price: 'NHS Band 1 (£26.80) / £45.00',
    desc: 'Comprehensive oral assessment, digital low-dose x-rays & oral cancer screening.',
  },
  {
    title: 'Dental Hygiene & Airflow Polish',
    path: '/treatments/dental-hygiene-airflow',
    icon: 'clean_hands',
    badge: 'Airflow Polish',
    price: 'From £65.00',
    desc: 'Ultrasonic plaque removal & high-velocity jet spray for deep stain brightening.',
  },
  {
    title: 'White Tooth Fillings (Composite)',
    path: '/treatments/composite-white-fillings',
    icon: 'healing',
    badge: 'Composite',
    price: 'From £95.00',
    desc: 'Seamless shade-matched biocompatible composite restorations for natural smiles.',
  },
  {
    title: 'Root Canal Therapy (Endodontics)',
    path: '/treatments/root-canal-therapy',
    icon: 'vital_signs',
    badge: 'Pain Relief',
    price: 'From £295.00',
    desc: 'Microscopic pulp therapy preserving infected natural teeth under local anaesthetic.',
  },
  {
    title: 'Dental Crowns & Fixed Bridges',
    path: '/treatments/crowns-and-bridges',
    icon: 'crown',
    badge: 'Ceramic',
    price: 'From £450.00',
    desc: 'Precision porcelain & zirconia restorative crowns restoring function and bite.',
  },
  {
    title: 'Invisalign® Clear Aligners',
    path: '/treatments/invisalign-clear-aligners',
    icon: 'auto_fix_high',
    badge: 'Discreet',
    price: 'From £1,800.00',
    desc: 'Custom transparent aligners straightening teeth comfortably without metal wires.',
  },
  {
    title: 'Emergency Tooth Extraction',
    path: '/treatments/tooth-extractions',
    icon: 'medical_services',
    badge: 'Same-Day',
    price: 'From £120.00',
    desc: 'Gentle, rapid surgical extractions for severely compromised or painful teeth.',
  },
  {
    title: 'Same-Day Emergency Relief',
    path: '/treatments/emergency-relief',
    icon: 'e911_emergency',
    badge: 'Urgent Care',
    price: 'From £50.00',
    desc: 'Rapid triage & cessation of acute toothache, broken teeth and dental abscesses.',
  },
];

export interface AboutMenuItem {
  title: string;
  path: string;
  icon: string;
  desc: string;
}

export const ABOUT_SUBMENU: AboutMenuItem[] = [
  {
    title: 'Why Us',
    path: '/about-us#why-us',
    icon: 'verified',
    desc: 'Our patient-first clinical philosophy, gentle care & CQC standards',
  },
  {
    title: 'Our Team',
    path: '/about-us#our-team',
    icon: 'groups',
    desc: 'Meet our experienced dentists, dental hygienists & support staff',
  },
  {
    title: 'Our Clinics',
    path: '/about-us#our-clinics',
    icon: 'location_on',
    desc: 'Acocks Green surgery location, opening hours & accessibility',
  },
  {
    title: 'NHS Safety Charter',
    path: '/about-us#nhs-charter',
    icon: 'shield_with_heart',
    desc: 'NHS Sexual Safety Charter signatory with zero-tolerance protocols',
  },
  {
    title: 'Patient Reviews',
    path: '/about-us#patient-reviews',
    icon: 'star',
    desc: 'Over 5,000 satisfied patients & verified Google 5-star reviews',
  },
];

export const HeaderNavBar: React.FC<HeaderNavBarProps> = ({ onBookClick }) => {
  const { theme } = useTheme();
  const pathname = usePathname();
  const [mobileOpen, setMobileOpen] = useState(false);
  const [mobileMegaOpen, setMobileMegaOpen] = useState(false);
  const [mobileAboutOpen, setMobileAboutOpen] = useState(false);

  const { clinic_name, tagline, logo_url } = theme.branding;
  const [megaHovered, setMegaHovered] = useState(false);
  const [aboutHovered, setAboutHovered] = useState(false);

  const handleSmoothAnchor = (
    e: React.MouseEvent<HTMLAnchorElement>,
    anchorPath: string
  ) => {
    if (pathname === '/' && anchorPath.startsWith('/#')) {
      e.preventDefault();
      const targetId = anchorPath.replace('/#', '');
      const targetEl = document.getElementById(targetId);
      if (targetEl) {
        targetEl.scrollIntoView({ behavior: 'smooth' });
      }
      setMobileOpen(false);
    }
  };

  return (
    <>
    <header className={styles.header}>
      <div className={styles.container}>
        {/* Brand Logo & Title */}
        <Link href="/" className={styles.brandLink}>
          <div className={styles.logoWrapper}>
            <Image
              src={assetUrl(logo_url || '/images/acocks-green-logo.png')}
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
          {/* 1. Home */}
          <div className={styles.navItem}>
            <Link
              href="/"
              className={`${styles.navLink} ${pathname === '/' ? styles.active : ''}`}
            >
              <span>Home</span>
            </Link>
          </div>

          {/* 2. Treatments & Services (Mega Dropdown) */}
          <div
            className={`${styles.navItem} ${styles.hasMega}`}
            onMouseEnter={() => setMegaHovered(true)}
            onMouseLeave={() => setMegaHovered(false)}
          >
            <a
              href="/#services"
              onClick={(e) => handleSmoothAnchor(e, '/#services')}
              className={`${styles.navLink} ${pathname.startsWith('/treatments') ? styles.active : ''}`}
            >
              <span>Treatments & Services</span>
              <span className="material-symbols-outlined text-[18px]">
                expand_more
              </span>
            </a>

            {/* Mega Dropdown Panel */}
            <div
              className={styles.megaMenu}
              style={{ display: megaHovered ? 'block' : undefined }}
              role="menu"
            >
              <div className={styles.megaGrid}>
                {CLINICAL_TREATMENTS.map((treatment, idx) => (
                  <Link
                    key={idx}
                    href={treatment.path}
                    className={styles.megaCard}
                  >
                    <div className={styles.cardIconBox}>
                      <span className="material-symbols-outlined">
                        {treatment.icon}
                      </span>
                    </div>
                    <span className={styles.cardTitle}>
                      {treatment.title}
                    </span>
                  </Link>
                ))}
              </div>

              <div className={styles.megaFooter}>
                <div className={styles.emergencyNote}>
                  <span className={`material-symbols-outlined ${styles.emergencyIcon}`}>
                    support_agent
                  </span>
                  <span>
                    Emergency dental triage: <a href="tel:+441217652870" className={styles.phoneLink}>+44 121 765 2870</a>
                  </span>
                </div>
                <button
                  type="button"
                  className={styles.megaBookCta}
                  onClick={() => onBookClick && onBookClick()}
                >
                  <span>Book Practice Visit</span>
                  <span className="material-symbols-outlined text-[16px]">
                    calendar_month
                  </span>
                </button>
              </div>
            </div>
          </div>

          {/* 3. Blog */}
          <div className={styles.navItem}>
            <Link
              href="/blog"
              className={`${styles.navLink} ${pathname === '/blog' ? styles.active : ''}`}
            >
              <span>Blog</span>
            </Link>
          </div>

          {/* 4. About (Dropdown) */}
          <div
            className={`${styles.navItem} ${styles.hasDropdown}`}
            onMouseEnter={() => setAboutHovered(true)}
            onMouseLeave={() => setAboutHovered(false)}
          >
            <Link
              href="/about-us"
              className={`${styles.navLink} ${pathname.startsWith('/about') ? styles.active : ''}`}
            >
              <span>About</span>
              <span className="material-symbols-outlined text-[18px]">
                expand_more
              </span>
            </Link>

            <div
              className={styles.dropdownMenu}
              style={{ display: aboutHovered ? 'block' : undefined }}
              role="menu"
            >
              {ABOUT_SUBMENU.map((item, idx) => (
                <Link
                  key={idx}
                  href={item.path}
                  className={styles.aboutDropdownItem}
                  role="menuitem"
                >
                  <div className={styles.aboutIconBox}>
                    <span className="material-symbols-outlined">
                      {item.icon}
                    </span>
                  </div>
                  <div className={styles.aboutTextCol}>
                    <span className={styles.aboutItemTitle}>{item.title}</span>
                    <span className={styles.aboutItemDesc}>{item.desc}</span>
                  </div>
                </Link>
              ))}
            </div>
          </div>

          {/* 5. Contact */}
          <div className={styles.navItem}>
            <a
              href="/#contact"
              onClick={(e) => handleSmoothAnchor(e, '/#contact')}
              className={`${styles.navLink} ${pathname === '/contact' ? styles.active : ''}`}
            >
              <span>Contact</span>
            </a>
          </div>
        </nav>

        {/* Right Action & Mobile Toggle */}
        <div className={styles.headerActions}>
          <button
            type="button"
            className={styles.bookButton}
            onClick={() => onBookClick && onBookClick()}
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
    </header>

    {/* Mobile & Tablet Full-Height Right Slide-In Drawer (<= 1200px) */}
    <div
      className={`${styles.mobileBackdrop} ${mobileOpen ? styles.open : ''}`}
      onClick={() => setMobileOpen(false)}
      aria-hidden={!mobileOpen}
    />

    <aside
      className={`${styles.mobileDrawer} ${mobileOpen ? styles.open : ''}`}
      aria-label="Mobile Navigation Drawer"
      aria-hidden={!mobileOpen}
    >
      <div className={styles.mobileDrawerHeader}>
        <span className={styles.drawerBrandTitle}>{clinic_name}</span>
        <button
          type="button"
          className={styles.drawerCloseBtn}
          onClick={() => setMobileOpen(false)}
          aria-label="Close mobile menu"
        >
          <span className="material-symbols-outlined">close</span>
        </button>
      </div>

      <div className={styles.mobileDrawerBody}>
        <Link
          href="/"
          className={styles.mobileLink}
          onClick={() => setMobileOpen(false)}
        >
          <span className="material-symbols-outlined">home</span>
          <span>Home</span>
        </Link>

        {/* Mobile Treatments Accordion */}
        <div className={styles.mobileAccordion}>
          <button
            type="button"
            className={styles.mobileAccordionHeader}
            onClick={() => setMobileMegaOpen(!mobileMegaOpen)}
          >
            <div className="flex items-center gap-2">
              <span className="material-symbols-outlined">dentistry</span>
              <span>Treatments & Services</span>
            </div>
            <span className="material-symbols-outlined">
              {mobileMegaOpen ? 'expand_less' : 'expand_more'}
            </span>
          </button>
          {mobileMegaOpen && (
            <div className={styles.mobileSubList}>
              {CLINICAL_TREATMENTS.map((treatment, idx) => (
                <Link
                  key={idx}
                  href={treatment.path}
                  className={styles.mobileSubItem}
                  onClick={() => setMobileOpen(false)}
                >
                  <span className="material-symbols-outlined text-[18px] text-[#094713]">
                    {treatment.icon}
                  </span>
                  <div>
                    <div className="font-semibold text-[13px] text-gray-900">
                      {treatment.title}
                    </div>
                    <div className="text-[11px] text-gray-500">
                      {treatment.price}
                    </div>
                  </div>
                </Link>
              ))}
            </div>
          )}
        </div>

        <Link
          href="/blog"
          className={styles.mobileLink}
          onClick={() => setMobileOpen(false)}
        >
          <span className="material-symbols-outlined">article</span>
          <span>Blog</span>
        </Link>

        {/* Mobile About Accordion */}
        <div className={styles.mobileAccordion}>
          <button
            type="button"
            className={styles.mobileAccordionHeader}
            onClick={() => setMobileAboutOpen(!mobileAboutOpen)}
          >
            <div className="flex items-center gap-2">
              <span className="material-symbols-outlined">info</span>
              <span>About</span>
            </div>
            <span className="material-symbols-outlined">
              {mobileAboutOpen ? 'expand_less' : 'expand_more'}
            </span>
          </button>
          {mobileAboutOpen && (
            <div className={styles.mobileSubList}>
              {ABOUT_SUBMENU.map((sub, sIdx) => (
                <a
                  key={sIdx}
                  href={sub.path}
                  className={styles.mobileSubItem}
                  onClick={(e) => {
                    setMobileOpen(false);
                    handleSmoothAnchor(e, sub.path);
                  }}
                >
                  <span className="material-symbols-outlined text-[18px] text-[#094713]">
                    {sub.icon}
                  </span>
                  <div>
                    <div className="font-semibold text-[13px] text-gray-900">
                      {sub.title}
                    </div>
                    <div className="text-[11px] text-gray-500">
                      {sub.desc}
                    </div>
                  </div>
                </a>
              ))}
            </div>
          )}
        </div>

        <a
          href="/#contact"
          className={styles.mobileLink}
          onClick={(e) => {
            setMobileOpen(false);
            handleSmoothAnchor(e, '/#contact');
          }}
        >
          <span className="material-symbols-outlined">location_on</span>
          <span>Contact</span>
        </a>
      </div>

      <div className={styles.mobileDrawerFooter}>
        <button
          type="button"
          className={styles.bookButton}
          style={{ display: 'inline-flex', width: '100%', justifyContent: 'center' }}
          onClick={() => {
            setMobileOpen(false);
            if (onBookClick) onBookClick();
          }}
        >
          <span>Book An Appointment</span>
          <span className="material-symbols-outlined text-[18px]">
            calendar_month
          </span>
        </button>
      </div>
    </aside>
    </>
  );
};
