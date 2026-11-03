'use client';

import React, { useState, useEffect, useRef } from 'react';
import Link from 'next/link';
import styles from './Navbar.module.scss';
import { Button } from '@/components/ui/Button/Button';
import { MAIN_NAVIGATION, NavDropdown } from '@/data/navigation';
import {
  Phone,
  Clock,
  MapPin,
  Calendar,
  Menu,
  X,
  ShieldCheck,
  Sparkles,
  ChevronDown,
  Lock,
  Smile,
  Shield,
  Activity,
  ArrowRight,
} from 'lucide-react';

interface NavbarProps {
  onOpenBooking?: () => void;
}

export const Navbar: React.FC<NavbarProps> = ({ onOpenBooking }) => {
  const [isScrolled, setIsScrolled] = useState<boolean>(false);
  const [mobileMenuOpen, setMobileMenuOpen] = useState<boolean>(false);
  const [activeDropdown, setActiveDropdown] = useState<string | null>(null);
  const [mobileExpanded, setMobileExpanded] = useState<Record<string, boolean>>({});
  const timeoutRef = useRef<NodeJS.Timeout | null>(null);

  useEffect(() => {
    const handleScroll = () => {
      setIsScrolled(window.scrollY > 20);
    };
    window.addEventListener('scroll', handleScroll);
    return () => window.removeEventListener('scroll', handleScroll);
  }, []);

  const handleMouseEnter = (label: string) => {
    if (timeoutRef.current) clearTimeout(timeoutRef.current);
    setActiveDropdown(label);
  };

  const handleMouseLeave = () => {
    timeoutRef.current = setTimeout(() => {
      setActiveDropdown(null);
    }, 150);
  };

  const toggleMobileSubmenu = (label: string) => {
    setMobileExpanded((prev) => ({
      ...prev,
      [label]: !prev[label],
    }));
  };

  const renderIcon = (name?: string) => {
    switch (name) {
      case 'Sparkles':
        return <Sparkles size={16} className={styles.categoryIcon} />;
      case 'Smile':
        return <Smile size={16} className={styles.categoryIcon} />;
      case 'Shield':
        return <Shield size={16} className={styles.categoryIcon} />;
      case 'Activity':
        return <Activity size={16} className={styles.categoryIcon} />;
      default:
        return <Sparkles size={16} className={styles.categoryIcon} />;
    }
  };

  return (
    <header className={`${styles.header} ${isScrolled ? styles.scrolled : ''}`}>
      {/* Top Clinical & Trust Ribbon */}
      <div className={styles.topBar}>
        <div className={styles.topBarContainer}>
          <div className={styles.topBarLeft}>
            <span className={styles.infoPill}>
              <Clock size={12} />
              <span>Mon - Sat: 8:00 AM - 8:00 PM | Sun: Emergency Only</span>
            </span>
            <span className={`${styles.infoPill} ${styles.hideMobile}`}>
              <MapPin size={12} />
              <span>3 State-of-the-Art Metro Clinic Centers</span>
            </span>
          </div>

          <div className={styles.topBarRight}>
            <a href="tel:+15550192830" className={styles.emergencyLink}>
              <span className={styles.emergencyDot} />
              <Phone size={12} />
              <span>
                24/7 Dental Emergency: <strong>+1 (555) 019-2830</strong>
              </span>
            </a>
            <Link
              href="/admin"
              target="_blank"
              rel="noopener noreferrer"
              className={styles.staffPortalLink}
              title="Clinic Staff EMR Portal (Opens in New Tab)"
            >
              <Lock size={12} />
              <span>Admin EMR</span>
            </Link>
          </div>
        </div>
      </div>

      {/* Main Navigation Bar */}
      <nav className={styles.mainNav}>
        <div className={styles.navContainer}>
          {/* Logo & Clinical Brand */}
          <Link href="/" className={styles.brand} onClick={() => setActiveDropdown(null)}>
            <div className={styles.logoMark}>
              <Sparkles size={20} />
            </div>
            <div className={styles.brandText}>
              <span className={styles.brandTitle}>Advanced Dental Clinic</span>
              <span className={styles.brandSubtitle}>Comprehensive Practice & Multi-Clinic System</span>
            </div>
          </Link>

          {/* Desktop Navigation Links with Mega-Menus */}
          <ul className={styles.navLinks}>
            {MAIN_NAVIGATION.map((navItem: NavDropdown) => {
              const hasCategories = navItem.categories && navItem.categories.length > 0;
              const hasSimpleItems = navItem.items && navItem.items.length > 0;
              const isDropdown = hasCategories || hasSimpleItems;

              if (!isDropdown && navItem.href) {
                return (
                  <li key={navItem.label}>
                    <Link href={navItem.href} className={styles.navLink}>
                      {navItem.label}
                    </Link>
                  </li>
                );
              }

              return (
                <li
                  key={navItem.label}
                  className={`${styles.navItemDropdown} ${
                    hasCategories ? styles.hasMegaMenu : ''
                  } ${activeDropdown === navItem.label ? styles.isOpen : ''}`}
                  onMouseEnter={() => handleMouseEnter(navItem.label)}
                  onMouseLeave={handleMouseLeave}
                >
                  <button
                    type="button"
                    className={styles.dropdownTrigger}
                    aria-expanded={activeDropdown === navItem.label}
                    onClick={() =>
                      setActiveDropdown(activeDropdown === navItem.label ? null : navItem.label)
                    }
                  >
                    <span>{navItem.label}</span>
                    <ChevronDown size={14} className={styles.chevron} />
                  </button>

                  {/* Mega-Menu Panel for Categorized Treatments */}
                  {hasCategories && activeDropdown === navItem.label && (
                    <div className={styles.megaMenuWrapper}>
                      <div className={styles.megaMenuContainer}>
                        <div className={styles.megaMenuHeader}>
                          <h4>Clinical Specialties & Treatment Procedures</h4>
                          <p>
                            US standard dental care, computer-guided implantology & aesthetic smile makeovers.
                          </p>
                        </div>
                        <div className={styles.megaGrid}>
                          {navItem.categories!.map((cat) => (
                            <div key={cat.category} className={styles.categoryCol}>
                              <div className={styles.categoryTitle}>
                                {renderIcon(cat.iconName)}
                                <span>{cat.category}</span>
                              </div>
                              {cat.description && (
                                <p className={styles.categoryDesc}>{cat.description}</p>
                              )}
                              <ul className={styles.itemList}>
                                {cat.items.map((item) => (
                                  <li key={item.href}>
                                    <Link
                                      href={item.href}
                                      className={styles.itemLink}
                                      onClick={() => setActiveDropdown(null)}
                                    >
                                      <div className={styles.itemHeadingRow}>
                                        <span className={styles.itemTitle}>{item.label}</span>
                                        {item.badge && (
                                          <span className={styles.itemBadge}>{item.badge}</span>
                                        )}
                                      </div>
                                      {item.description && (
                                        <span className={styles.itemDesc}>{item.description}</span>
                                      )}
                                    </Link>
                                  </li>
                                ))}
                              </ul>
                            </div>
                          ))}
                        </div>
                        <div className={styles.megaMenuFooter}>
                          <div className={styles.footerNote}>
                            <ShieldCheck size={16} />
                            <span>All procedures covered under in-house warranty and digital 3D planning</span>
                          </div>
                          <Link
                            href="/treatments"
                            className={styles.viewAllLink}
                            onClick={() => setActiveDropdown(null)}
                          >
                            <span>Browse All 24+ Dental Procedures</span>
                            <ArrowRight size={14} />
                          </Link>
                        </div>
                      </div>
                    </div>
                  )}

                  {/* Standard Dropdown for About & Patient Resources */}
                  {hasSimpleItems && activeDropdown === navItem.label && (
                    <div className={styles.simpleDropdownWrapper}>
                      <ul className={styles.simpleList}>
                        {navItem.items!.map((item) => (
                          <li key={item.href}>
                            <Link
                              href={item.href}
                              className={styles.simpleLink}
                              onClick={() => setActiveDropdown(null)}
                            >
                              <strong className={styles.simpleTitle}>{item.label}</strong>
                              {item.description && (
                                <span className={styles.simpleDesc}>{item.description}</span>
                              )}
                            </Link>
                          </li>
                        ))}
                      </ul>
                    </div>
                  )}
                </li>
              );
            })}
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

            {/* Mobile Hamburger Toggle */}
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

        {/* Mobile Slide-down Navigation Accordion */}
        {mobileMenuOpen && (
          <div className={styles.mobileDropdown}>
            <div className={styles.mobileList}>
              <Link href="/" className={styles.mobileRootLink} onClick={() => setMobileMenuOpen(false)}>
                Home
              </Link>

              {MAIN_NAVIGATION.filter((n) => n.label !== 'Home').map((navItem) => {
                const isExpanded = !!mobileExpanded[navItem.label];
                const hasCategories = navItem.categories && navItem.categories.length > 0;
                const hasSimpleItems = navItem.items && navItem.items.length > 0;

                if (!hasCategories && !hasSimpleItems && navItem.href) {
                  return (
                    <Link
                      key={navItem.label}
                      href={navItem.href}
                      className={styles.mobileRootLink}
                      onClick={() => setMobileMenuOpen(false)}
                    >
                      {navItem.label}
                    </Link>
                  );
                }

                return (
                  <div key={navItem.label} className={styles.mobileGroup}>
                    <button
                      type="button"
                      className={styles.mobileGroupTrigger}
                      onClick={() => toggleMobileSubmenu(navItem.label)}
                    >
                      <span>{navItem.label}</span>
                      <ChevronDown
                        size={16}
                        className={`${styles.mobileChevron} ${isExpanded ? styles.rotated : ''}`}
                      />
                    </button>

                    {isExpanded && (
                      <div className={styles.mobileGroupBody}>
                        {hasCategories &&
                          navItem.categories!.map((cat) => (
                            <div key={cat.category} className={styles.mobileCategory}>
                              <h5 className={styles.mobileCatTitle}>{cat.category}</h5>
                              {cat.items.map((item) => (
                                <Link
                                  key={item.href}
                                  href={item.href}
                                  className={styles.mobileSubLink}
                                  onClick={() => setMobileMenuOpen(false)}
                                >
                                  <span>{item.label}</span>
                                  {item.badge && <span className={styles.mobileBadge}>{item.badge}</span>}
                                </Link>
                              ))}
                            </div>
                          ))}

                        {hasSimpleItems &&
                          navItem.items!.map((item) => (
                            <Link
                              key={item.href}
                              href={item.href}
                              className={styles.mobileSubLink}
                              onClick={() => setMobileMenuOpen(false)}
                            >
                              <span>{item.label}</span>
                            </Link>
                          ))}
                      </div>
                    )}
                  </div>
                );
              })}

              <div className={styles.mobileFooterActions}>
                <Link
                  href="/admin"
                  target="_blank"
                  rel="noopener noreferrer"
                  className={styles.mobileAdminLink}
                  onClick={() => setMobileMenuOpen(false)}
                >
                  <Lock size={14} />
                  <span>Clinic Staff & EMR Admin Portal</span>
                </Link>
                <Button
                  variant="primary"
                  size="md"
                  icon={<Calendar size={16} />}
                  onClick={() => {
                    setMobileMenuOpen(false);
                    onOpenBooking?.();
                  }}
                >
                  Book Instant Consultation
                </Button>
              </div>
            </div>
          </div>
        )}
      </nav>
    </header>
  );
};
