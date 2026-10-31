'use client';

import React, { useState, useEffect } from 'react';
import Link from 'next/link';
import styles from './Navbar.module.scss';
import { ThemeSwitcher } from '@/components/ui/ThemeSwitcher/ThemeSwitcher';
import { Button } from '@/components/ui/Button/Button';
import {
  Phone,
  Clock,
  MapPin,
  Calendar,
  Menu,
  X,
  ShieldCheck,
  Sparkles
} from 'lucide-react';

interface NavbarProps {
  onOpenBooking?: () => void;
}

export const Navbar: React.FC<NavbarProps> = ({ onOpenBooking }) => {
  const [isScrolled, setIsScrolled] = useState(false);
  const [mobileMenuOpen, setMobileMenuOpen] = useState(false);

  useEffect(() => {
    const handleScroll = () => {
      setIsScrolled(window.scrollY > 20);
    };
    window.addEventListener('scroll', handleScroll);
    return () => window.removeEventListener('scroll', handleScroll);
  }, []);

  return (
    <header className={`${styles.header} ${isScrolled ? styles.scrolled : ''}`}>
      {/* Top emergency & trust bar */}
      <div className={styles.topBar}>
        <div className={styles.topBarContainer}>
          <div className={styles.topBarLeft}>
            <span className={styles.infoPill}>
              <Clock size={12} />
              <span>Mon - Sat: 8:00 AM - 8:00 PM | Sun: Emergency Only</span>
            </span>
            <span className={`${styles.infoPill} ${styles.hideMobile}`}>
              <MapPin size={12} />
              <span>3 Branches Across Metro Region</span>
            </span>
          </div>

          <div className={styles.topBarRight}>
            <a href="tel:+15550192830" className={styles.emergencyLink}>
              <span className={styles.emergencyDot} />
              <Phone size={12} />
              <span>24/7 Dental Emergency: <strong>+1 (555) 019-2830</strong></span>
            </a>
            <div className={styles.topThemeWrapper}>
              <ThemeSwitcher />
            </div>
          </div>
        </div>
      </div>

      {/* Main navigation */}
      <nav className={styles.mainNav}>
        <div className={styles.navContainer}>
          {/* Logo */}
          <Link href="/" className={styles.brand}>
            <div className={styles.logoMark}>
              <Sparkles size={20} />
            </div>
            <div className={styles.brandText}>
              <span className={styles.brandTitle}>Advanced Dental Clinic</span>
              <span className={styles.brandSubtitle}>Practice & Multi-Clinic System</span>
            </div>
          </Link>

          {/* Desktop Navigation Links */}
          <ul className={styles.navLinks}>
            <li>
              <Link href="#services" className={styles.navLink}>
                Treatments
              </Link>
            </li>
            <li>
              <Link href="#doctors" className={styles.navLink}>
                Specialists
              </Link>
            </li>
            <li>
              <Link href="#makeover" className={styles.navLink}>
                Smile Gallery
              </Link>
            </li>
            <li>
              <Link href="#reviews" className={styles.navLink}>
                Patient Stories
              </Link>
            </li>
            <li>
              <Link href="#pricing" className={styles.navLink}>
                Plans & Coverage
              </Link>
            </li>
          </ul>

          {/* Action CTAs */}
          <div className={styles.navActions}>
            <div className={styles.trustBadge}>
              <ShieldCheck size={14} />
              <span>ADA Accredited</span>
            </div>
            <Button
              variant="primary"
              size="sm"
              icon={<Calendar size={14} />}
              onClick={onOpenBooking}
            >
              Book Appointment
            </Button>

            {/* Mobile Hamburger */}
            <button
              type="button"
              className={styles.mobileToggle}
              onClick={() => setMobileMenuOpen(!mobileMenuOpen)}
              aria-label="Toggle navigation menu"
            >
              {mobileMenuOpen ? <X size={24} /> : <Menu size={24} />}
            </button>
          </div>
        </div>

        {/* Mobile slide-down menu */}
        {mobileMenuOpen && (
          <div className={styles.mobileDropdown}>
            <ul className={styles.mobileList}>
              <li>
                <Link
                  href="#services"
                  onClick={() => setMobileMenuOpen(false)}
                >
                  Treatments & Procedures
                </Link>
              </li>
              <li>
                <Link
                  href="#doctors"
                  onClick={() => setMobileMenuOpen(false)}
                >
                  Doctor Profiles
                </Link>
              </li>
              <li>
                <Link
                  href="#makeover"
                  onClick={() => setMobileMenuOpen(false)}
                >
                  Smile Transformations
                </Link>
              </li>
              <li>
                <Link
                  href="#reviews"
                  onClick={() => setMobileMenuOpen(false)}
                >
                  Verified Reviews
                </Link>
              </li>
              <li>
                <Link
                  href="#pricing"
                  onClick={() => setMobileMenuOpen(false)}
                >
                  Plans & Pricing
                </Link>
              </li>
            </ul>
            <div className={styles.mobileCta}>
              <Button
                variant="primary"
                fullWidth
                icon={<Calendar size={16} />}
                onClick={() => {
                  setMobileMenuOpen(false);
                  if (onOpenBooking) onOpenBooking();
                }}
              >
                Schedule Consultation
              </Button>
            </div>
          </div>
        )}
      </nav>
    </header>
  );
};
