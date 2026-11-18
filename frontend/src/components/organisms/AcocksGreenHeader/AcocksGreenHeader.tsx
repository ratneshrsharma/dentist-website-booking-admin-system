'use client';

import React, { useState, useEffect, useRef } from 'react';
import Link from 'next/link';
import { usePathname } from 'next/navigation';
import { getAssetPath } from '@/lib/assetPath';

interface AcocksGreenHeaderProps {
  onOpenBooking?: () => void;
  onOpenEmergency?: () => void;
}

export const AcocksGreenHeader: React.FC<AcocksGreenHeaderProps> = ({
  onOpenBooking,
  onOpenEmergency,
}) => {
  const pathname = usePathname();
  const isTreatments = pathname?.startsWith('/treatments');
  const isHome = pathname === '/' || pathname === '';
  const [isScrolled, setIsScrolled] = useState(false);
  const [aboutDropdownOpen, setAboutDropdownOpen] = useState(false);
  const [treatmentsDropdownOpen, setTreatmentsDropdownOpen] = useState(false);
  const [mobileTreatmentsOpen, setMobileTreatmentsOpen] = useState(false);
  const [mobileMenuOpen, setMobileMenuOpen] = useState(false);
  const [logoSrc, setLogoSrc] = useState(() => getAssetPath('/images/acocks-green-logo.png'));
  const [logoFallbackTried, setLogoFallbackTried] = useState(false);
  const [logoError, setLogoError] = useState(false);
  const aboutDropdownRef = useRef<HTMLDivElement>(null);
  const treatmentsDropdownRef = useRef<HTMLDivElement>(null);

  useEffect(() => {
    const handleScroll = () => {
      setIsScrolled(window.scrollY > 20);
    };
    window.addEventListener('scroll', handleScroll);
    return () => window.removeEventListener('scroll', handleScroll);
  }, []);

  // Click outside listener for dropdowns on touch devices
  useEffect(() => {
    const handleClickOutside = (event: MouseEvent) => {
      const target = event.target as Node;
      if (
        aboutDropdownRef.current &&
        !aboutDropdownRef.current.contains(target)
      ) {
        setAboutDropdownOpen(false);
      }
      if (
        treatmentsDropdownRef.current &&
        !treatmentsDropdownRef.current.contains(target)
      ) {
        setTreatmentsDropdownOpen(false);
      }
    };

    if (aboutDropdownOpen || treatmentsDropdownOpen) {
      document.addEventListener('mousedown', handleClickOutside);
    }
    return () => {
      document.removeEventListener('mousedown', handleClickOutside);
    };
  }, [aboutDropdownOpen, treatmentsDropdownOpen]);

  const handleLogoError = () => {
    if (!logoFallbackTried) {
      setLogoFallbackTried(true);
      setLogoSrc('https://www.acocksgreendentalpractice.co.uk/wp-content/uploads/2023/06/Acocks-Green-Dental-Practice-logo-w.png');
    } else {
      setLogoError(true);
    }
  };

  return (
    <header className="fixed top-0 w-full z-50 shadow-[0_1px_8px_rgba(0,0,0,0.04)]">
      {/* ========================================================
          TOP EMERGENCY & HOURS CLINICAL RIBBON
          ======================================================== */}
      <div className="bg-appointment-card-bg text-on-primary py-space-xs">
        <div className="max-w-7xl mx-auto px-6 lg:px-12 flex items-center justify-between font-body-sm text-body-sm">
          {/* Left: Contact, Hours, Address */}
          <div className="flex items-center gap-space-lg flex-wrap">
            <div className="flex items-center gap-space-xs">
              <span className="material-symbols-outlined text-primary-fixed text-[16px]">call</span>
              <span className="font-label-sm text-label-sm text-surface-container-low">Emergency:</span>
              <a
                className="hover:text-primary-fixed transition-colors font-label-sm text-label-sm text-on-primary font-semibold"
                href="tel:+441217652870"
              >
                +44 121 765 2870
              </a>
            </div>

            <div className="hidden md:flex items-center gap-space-xs">
              <span className="material-symbols-outlined text-primary-fixed text-[16px]">schedule</span>
              <span className="text-surface-container-low">Mon-Fri: 8:30am - 5:30pm</span>
            </div>

            <div className="hidden lg:flex items-center gap-space-xs">
              <span className="material-symbols-outlined text-primary-fixed text-[16px]">location_on</span>
              <span className="text-surface-container-low">1078 Warwick Road, Birmingham B27 6BH</span>
            </div>
          </div>

          {/* Right: Emergency Consultation CTA + Admin EMR Link */}
          <div className="flex items-center gap-space-md">
            <button
              type="button"
              onClick={onOpenEmergency || onOpenBooking}
              className="inline-flex items-center gap-space-xs bg-status-error text-on-error font-label-sm text-label-sm px-space-md py-0.5 rounded-lg hover:bg-error transition-colors cursor-pointer"
            >
              <span className="material-symbols-outlined text-[14px]">e911_emergency</span>
              <span>Emergency Consultation</span>
            </button>
            <Link
              href="/admin"
              target="_blank"
              rel="noopener noreferrer"
              className="hidden sm:inline-flex items-center gap-1 text-[11px] text-surface-container-low/80 hover:text-primary-fixed transition-colors"
              title="Clinic Staff Portal"
            >
              <span className="material-symbols-outlined text-[12px]">lock</span>
              <span>Admin EMR</span>
            </Link>
          </div>
        </div>
      </div>

      {/* ========================================================
          MAIN NAVIGATION BAR (Sticky Glassmorphic)
          ======================================================== */}
      <div
        className={`h-20 bg-surface/95 backdrop-blur-xl border-b border-border-subtle/50 transition-all duration-200 ${
          isScrolled ? 'shadow-md' : ''
        }`}
      >
        <div className="h-full max-w-7xl mx-auto px-6 lg:px-12 flex items-center justify-between">
          {/* Practice Logo & Clinical Branding */}
          <Link href="/" className="flex items-center gap-3 shrink-0 group">
            {!logoError ? (
              /* eslint-disable-next-line @next/next/no-img-element */
              <img
                alt="Acocks Green Dental Practice Logo"
                className="h-12 w-12 object-contain rounded-full shadow-xs border border-border-subtle bg-white"
                src={logoSrc}
                onError={handleLogoError}
              />
            ) : (
              <div className="h-12 w-12 rounded-full bg-primary-container text-on-primary flex items-center justify-center font-bold text-lg shadow-xs">
                AG
              </div>
            )}
            <div className="flex flex-col justify-center leading-tight">
              <span className="font-headline-sm text-headline-sm text-primary leading-none font-bold group-hover:text-primary-container transition-colors">
                Acocks Green
              </span>
              <span className="font-subheading-eyebrow text-[11px] text-on-surface-variant tracking-wider uppercase font-semibold mt-0.5">
                Dental Practice
              </span>
            </div>
          </Link>

          {/* Desktop Nav Links & CTAs */}
          <div className="flex items-center gap-6">
            <nav className="hidden xl:flex items-center gap-space-lg" data-active-classes="text-primary font-bold">
              <Link
                href="/"
                aria-current={isHome ? 'page' : undefined}
                className={`transition-colors font-label-md text-label-md ${
                  isHome
                    ? 'text-primary font-bold hover:text-primary-container'
                    : 'text-on-surface-variant hover:text-on-surface'
                }`}
              >
                Home
              </Link>

              {/* Treatments & Services Mega Dropdown */}
              <div
                ref={treatmentsDropdownRef}
                className="relative py-2"
                onMouseEnter={() => setTreatmentsDropdownOpen(true)}
                onMouseLeave={() => setTreatmentsDropdownOpen(false)}
              >
                <div className="flex items-center gap-1">
                  <Link
                    href="/treatments"
                    aria-current={isTreatments ? 'page' : undefined}
                    className={`transition-colors font-label-md text-label-md ${
                      isTreatments
                        ? 'text-primary font-bold hover:text-primary-container'
                        : 'text-on-surface-variant hover:text-on-surface'
                    }`}
                  >
                    Treatments &amp; Services
                  </Link>
                  <button
                    type="button"
                    className="text-on-surface-variant hover:text-primary transition-colors cursor-pointer p-0.5 rounded-sm"
                    aria-haspopup="true"
                    aria-expanded={treatmentsDropdownOpen}
                    onClick={() => setTreatmentsDropdownOpen(!treatmentsDropdownOpen)}
                    aria-label="Toggle treatments menu"
                  >
                    <span
                      className={`material-symbols-outlined text-[18px] transition-transform duration-200 block ${
                        treatmentsDropdownOpen ? 'rotate-180 text-primary' : ''
                      }`}
                    >
                      expand_more
                    </span>
                  </button>
                </div>

                {treatmentsDropdownOpen && (
                  <div className="absolute top-full left-1/2 -translate-x-1/2 w-[760px] pt-2 z-50 animate-in fade-in slide-in-from-top-1 duration-150">
                    <div className="bg-surface-card rounded-2xl shadow-2xl border border-border-subtle p-6 grid grid-cols-3 gap-6">
                      {/* Column 1: General & NHS */}
                      <div>
                        <span className="font-subheading-eyebrow text-[11px] text-primary uppercase font-bold tracking-wider block mb-3 pb-1.5 border-b border-border-subtle">
                          General &amp; NHS
                        </span>
                        <div className="flex flex-col gap-1">
                          <Link
                            href="/treatments/general-dentistry"
                            onClick={() => setTreatmentsDropdownOpen(false)}
                            className="p-2 rounded-xl hover:bg-surface-container-low transition-colors group flex items-start gap-2.5"
                          >
                            <span className="material-symbols-outlined text-primary text-[20px] mt-0.5 shrink-0">dentistry</span>
                            <div>
                              <strong className="text-[13px] text-on-surface block group-hover:text-primary font-semibold leading-snug">
                                General Dentistry
                              </strong>
                              <span className="text-[11px] text-on-surface-variant block leading-tight">14-point exam, check-ups &amp; fillings</span>
                            </div>
                          </Link>
                          <Link
                            href="/treatments/general-dentistry#hygiene"
                            onClick={() => setTreatmentsDropdownOpen(false)}
                            className="p-2 rounded-xl hover:bg-surface-container-low transition-colors group flex items-start gap-2.5"
                          >
                            <span className="material-symbols-outlined text-primary text-[20px] mt-0.5 shrink-0">clean_hands</span>
                            <div>
                              <strong className="text-[13px] text-on-surface block group-hover:text-primary font-semibold leading-snug">
                                Hygiene &amp; Airflow
                              </strong>
                              <span className="text-[11px] text-on-surface-variant block leading-tight">Ultrasonic calculus &amp; stain removal</span>
                            </div>
                          </Link>
                          <Link
                            href="/treatments/root-canal-treatment"
                            onClick={() => setTreatmentsDropdownOpen(false)}
                            className="p-2 rounded-xl hover:bg-surface-container-low transition-colors group flex items-start gap-2.5"
                          >
                            <span className="material-symbols-outlined text-status-error text-[20px] mt-0.5 shrink-0">e911_emergency</span>
                            <div>
                              <strong className="text-[13px] text-on-surface block group-hover:text-primary font-semibold leading-snug">
                                Emergency Root Canal
                              </strong>
                              <span className="text-[11px] text-on-surface-variant block leading-tight">Single-visit acute pain relief</span>
                            </div>
                          </Link>
                        </div>
                      </div>

                      {/* Column 2: Restorative & Surgical */}
                      <div>
                        <span className="font-subheading-eyebrow text-[11px] text-primary uppercase font-bold tracking-wider block mb-3 pb-1.5 border-b border-border-subtle">
                          Restorative &amp; Implants
                        </span>
                        <div className="flex flex-col gap-1">
                          <Link
                            href="/treatments/dental-implants"
                            onClick={() => setTreatmentsDropdownOpen(false)}
                            className="p-2 rounded-xl hover:bg-surface-container-low transition-colors group flex items-start gap-2.5"
                          >
                            <span className="material-symbols-outlined text-primary text-[20px] mt-0.5 shrink-0">vital_signs</span>
                            <div>
                              <strong className="text-[13px] text-on-surface block group-hover:text-primary font-semibold leading-snug">
                                Dental Implants
                              </strong>
                              <span className="text-[11px] text-on-surface-variant block leading-tight">Permanent titanium root replacement</span>
                            </div>
                          </Link>
                          <Link
                            href="/treatments/crowns-and-bridges"
                            onClick={() => setTreatmentsDropdownOpen(false)}
                            className="p-2 rounded-xl hover:bg-surface-container-low transition-colors group flex items-start gap-2.5"
                          >
                            <span className="material-symbols-outlined text-primary text-[20px] mt-0.5 shrink-0">architecture</span>
                            <div>
                              <strong className="text-[13px] text-on-surface block group-hover:text-primary font-semibold leading-snug">
                                Crowns &amp; Bridgework
                              </strong>
                              <span className="text-[11px] text-on-surface-variant block leading-tight">Precision monolithic ceramic repair</span>
                            </div>
                          </Link>
                          <Link
                            href="/treatments/all-on-4-dental-implants"
                            onClick={() => setTreatmentsDropdownOpen(false)}
                            className="p-2 rounded-xl hover:bg-surface-container-low transition-colors group flex items-start gap-2.5"
                          >
                            <span className="material-symbols-outlined text-primary text-[20px] mt-0.5 shrink-0">view_column</span>
                            <div>
                              <strong className="text-[13px] text-on-surface block group-hover:text-primary font-semibold leading-snug">
                                All-on-4 / Full Arch
                              </strong>
                              <span className="text-[11px] text-on-surface-variant block leading-tight">Same-day fixed bridge reconstruction</span>
                            </div>
                          </Link>
                        </div>
                      </div>

                      {/* Column 3: Cosmetics & Orthodontics */}
                      <div>
                        <span className="font-subheading-eyebrow text-[11px] text-primary uppercase font-bold tracking-wider block mb-3 pb-1.5 border-b border-border-subtle">
                          Cosmetic &amp; Aligners
                        </span>
                        <div className="flex flex-col gap-1">
                          <Link
                            href="/treatments/clear-aligners"
                            onClick={() => setTreatmentsDropdownOpen(false)}
                            className="p-2 rounded-xl hover:bg-surface-container-low transition-colors group flex items-start gap-2.5"
                          >
                            <span className="material-symbols-outlined text-primary text-[20px] mt-0.5 shrink-0">auto_awesome</span>
                            <div>
                              <strong className="text-[13px] text-on-surface block group-hover:text-primary font-semibold leading-snug">
                                Clear Aligners
                              </strong>
                              <span className="text-[11px] text-on-surface-variant block leading-tight">Discreet orthodontics &amp; Invisalign®</span>
                            </div>
                          </Link>
                          <Link
                            href="/treatments/teeth-whitening"
                            onClick={() => setTreatmentsDropdownOpen(false)}
                            className="p-2 rounded-xl hover:bg-surface-container-low transition-colors group flex items-start gap-2.5"
                          >
                            <span className="material-symbols-outlined text-primary text-[20px] mt-0.5 shrink-0">flare</span>
                            <div>
                              <strong className="text-[13px] text-on-surface block group-hover:text-primary font-semibold leading-snug">
                                Teeth Whitening
                              </strong>
                              <span className="text-[11px] text-on-surface-variant block leading-tight">Boutique home &amp; in-clinic brightening</span>
                            </div>
                          </Link>
                          <Link
                            href="/treatments/porcelain-veneers"
                            onClick={() => setTreatmentsDropdownOpen(false)}
                            className="p-2 rounded-xl hover:bg-surface-container-low transition-colors group flex items-start gap-2.5"
                          >
                            <span className="material-symbols-outlined text-primary text-[20px] mt-0.5 shrink-0">palette</span>
                            <div>
                              <strong className="text-[13px] text-on-surface block group-hover:text-primary font-semibold leading-snug">
                                Porcelain Veneers
                              </strong>
                              <span className="text-[11px] text-on-surface-variant block leading-tight">Bespoke handcrafted aesthetic smiles</span>
                            </div>
                          </Link>
                        </div>
                      </div>

                      {/* Mega Menu Footer Banner */}
                      <div className="col-span-3 pt-3 border-t border-border-subtle flex items-center justify-between bg-surface-container-low/70 -mx-6 -mb-6 p-4 rounded-b-2xl">
                        <div className="flex items-center gap-2">
                          <span className="material-symbols-outlined text-primary text-[18px]">verified</span>
                          <span className="text-[12px] text-on-surface-variant">
                            Transparent NHS dental bandings &amp; 0% APR private payment options.
                          </span>
                        </div>
                        <Link
                          href="/treatments"
                          onClick={() => setTreatmentsDropdownOpen(false)}
                          className="text-[12px] font-bold text-primary hover:text-primary-container inline-flex items-center gap-1 group"
                        >
                          <span>Explore All Treatments &amp; Fee Bands</span>
                          <span className="material-symbols-outlined text-[16px] group-hover:translate-x-0.5 transition-transform">arrow_forward</span>
                        </Link>
                      </div>
                    </div>
                  </div>
                )}
              </div>

              {/* About Us Dropdown */}
              <div
                ref={aboutDropdownRef}
                className="relative py-2"
                onMouseEnter={() => setAboutDropdownOpen(true)}
                onMouseLeave={() => setAboutDropdownOpen(false)}
              >
                <button
                  className="font-label-md text-label-md text-on-surface-variant hover:text-on-surface transition-colors inline-flex items-center gap-1 cursor-pointer"
                  type="button"
                  aria-haspopup="true"
                  aria-expanded={aboutDropdownOpen}
                  onClick={() => setAboutDropdownOpen(!aboutDropdownOpen)}
                >
                  <span>About Us</span>
                  <span
                    className={`material-symbols-outlined text-[18px] transition-transform duration-200 ${
                      aboutDropdownOpen ? 'rotate-180' : ''
                    }`}
                  >
                    expand_more
                  </span>
                </button>

                {aboutDropdownOpen && (
                  <div className="absolute top-full left-0 w-64 pt-2 z-50 animate-in fade-in slide-in-from-top-1 duration-150">
                    <div className="bg-surface-card rounded-xl shadow-xl border border-border-subtle p-2 flex flex-col gap-1">
                      <a
                        className="font-label-md text-label-md text-on-surface-variant hover:text-primary hover:bg-surface-container-low px-3 py-2 rounded-lg transition-colors flex items-center gap-2"
                        href="#team"
                        onClick={() => setAboutDropdownOpen(false)}
                      >
                        <span className="material-symbols-outlined text-[18px] text-primary">group</span>
                        <span>Our Clinicians &amp; Team</span>
                      </a>
                      <a
                        className="font-label-md text-label-md text-on-surface-variant hover:text-primary hover:bg-surface-container-low px-3 py-2 rounded-lg transition-colors flex items-center gap-2"
                        href="#about"
                        onClick={() => setAboutDropdownOpen(false)}
                      >
                        <span className="material-symbols-outlined text-[18px] text-primary">domain</span>
                        <span>Our Surgery / Clinics</span>
                      </a>
                      <a
                        className="font-label-md text-label-md text-on-surface-variant hover:text-primary hover:bg-surface-container-low px-3 py-2 rounded-lg transition-colors flex items-center gap-2"
                        href="#charter"
                        onClick={() => setAboutDropdownOpen(false)}
                      >
                        <span className="material-symbols-outlined text-[18px] text-primary">verified_user</span>
                        <span>NHS Safety Charter</span>
                      </a>
                      <a
                        className="font-label-md text-label-md text-on-surface-variant hover:text-primary hover:bg-surface-container-low px-3 py-2 rounded-lg transition-colors flex items-center gap-2"
                        href="#reviews"
                        onClick={() => setAboutDropdownOpen(false)}
                      >
                        <span className="material-symbols-outlined text-[18px] text-primary">rate_review</span>
                        <span>Patient Reviews</span>
                      </a>
                    </div>
                  </div>
                )}
              </div>

              <a
                href="#reviews"
                className="font-label-md text-label-md text-on-surface-variant hover:text-on-surface transition-colors"
              >
                Patient Stories
              </a>
              <a
                href="#contact"
                className="font-label-md text-label-md text-on-surface-variant hover:text-on-surface transition-colors"
              >
                Contact
              </a>
            </nav>

            {/* Desktop Booking CTA Button */}
            <div className="hidden md:flex items-center gap-3">
              <button
                type="button"
                onClick={onOpenBooking}
                className="inline-flex items-center gap-2 bg-primary-container text-on-primary font-label-md text-label-md px-4 py-2.5 rounded-lg shadow-sm hover:bg-primary transition-all duration-200 cursor-pointer"
              >
                <span>Book An Appointment</span>
                <span className="material-symbols-outlined text-[16px]">calendar_month</span>
              </button>
            </div>

            {/* Mobile Hamburger Button */}
            <button
              type="button"
              className="xl:hidden p-2 text-on-surface hover:text-primary transition-colors cursor-pointer"
              onClick={() => setMobileMenuOpen(!mobileMenuOpen)}
              aria-label="Toggle navigation menu"
            >
              <span className="material-symbols-outlined text-[28px]">
                {mobileMenuOpen ? 'close' : 'menu'}
              </span>
            </button>
          </div>
        </div>

        {/* ========================================================
            MOBILE COLLAPSIBLE MENU
            ======================================================== */}
        {mobileMenuOpen && (
          <div className="xl:hidden bg-surface-card border-b border-border-subtle shadow-xl px-6 py-6 animate-in slide-in-from-top-2 duration-200">
            <div className="flex flex-col space-y-4">
              <Link
                href="/"
                className={`font-label-md text-label-md py-1 border-b border-border-subtle ${
                  isHome ? 'text-primary font-bold' : 'text-on-surface-variant hover:text-primary'
                }`}
                onClick={() => setMobileMenuOpen(false)}
              >
                Home
              </Link>
              {/* Mobile Treatments & Services Accordion */}
              <div className="border-b border-border-subtle pb-1">
                <div className="flex items-center justify-between py-1">
                  <Link
                    href="/treatments"
                    className={`font-label-md text-label-md ${
                      isTreatments ? 'text-primary font-bold' : 'text-on-surface-variant hover:text-primary'
                    }`}
                    onClick={() => setMobileMenuOpen(false)}
                  >
                    Treatments &amp; Services
                  </Link>
                  <button
                    type="button"
                    onClick={() => setMobileTreatmentsOpen(!mobileTreatmentsOpen)}
                    className="p-1 text-on-surface-variant hover:text-primary transition-colors"
                    aria-label="Toggle mobile treatments submenu"
                  >
                    <span
                      className={`material-symbols-outlined text-[20px] transition-transform duration-200 block ${
                        mobileTreatmentsOpen ? 'rotate-180 text-primary' : ''
                      }`}
                    >
                      expand_more
                    </span>
                  </button>
                </div>
                {mobileTreatmentsOpen && (
                  <div className="bg-surface-container-low/60 rounded-xl p-3 my-2 flex flex-col gap-2 border border-border-subtle/50 animate-in fade-in slide-in-from-top-1 duration-150">
                    <Link
                      href="/treatments"
                      className="text-[12px] font-bold text-primary py-1 flex items-center justify-between border-b border-border-subtle/50 pb-1.5"
                      onClick={() => setMobileMenuOpen(false)}
                    >
                      <span>View All Treatments Catalog</span>
                      <span className="material-symbols-outlined text-[14px]">arrow_forward</span>
                    </Link>
                    <Link
                      href="/treatments/general-dentistry"
                      className="text-[12px] text-on-surface-variant hover:text-primary py-1 flex items-center gap-2"
                      onClick={() => setMobileMenuOpen(false)}
                    >
                      <span className="material-symbols-outlined text-primary text-[16px]">dentistry</span>
                      <span>General Dentistry &amp; Check-ups</span>
                    </Link>
                    <Link
                      href="/treatments/dental-implants"
                      className="text-[12px] text-on-surface-variant hover:text-primary py-1 flex items-center gap-2"
                      onClick={() => setMobileMenuOpen(false)}
                    >
                      <span className="material-symbols-outlined text-primary text-[16px]">vital_signs</span>
                      <span>Dental Implants Overview</span>
                    </Link>
                    <Link
                      href="/treatments/clear-aligners"
                      className="text-[12px] text-on-surface-variant hover:text-primary py-1 flex items-center gap-2"
                      onClick={() => setMobileMenuOpen(false)}
                    >
                      <span className="material-symbols-outlined text-primary text-[16px]">auto_awesome</span>
                      <span>Clear Aligners (Invisalign®)</span>
                    </Link>
                    <Link
                      href="/treatments/crowns-and-bridges"
                      className="text-[12px] text-on-surface-variant hover:text-primary py-1 flex items-center gap-2"
                      onClick={() => setMobileMenuOpen(false)}
                    >
                      <span className="material-symbols-outlined text-primary text-[16px]">architecture</span>
                      <span>Crowns &amp; Precision Bridgework</span>
                    </Link>
                    <Link
                      href="/treatments/root-canal-treatment"
                      className="text-[12px] text-on-surface-variant hover:text-primary py-1 flex items-center gap-2"
                      onClick={() => setMobileMenuOpen(false)}
                    >
                      <span className="material-symbols-outlined text-status-error text-[16px]">medical_services</span>
                      <span>Root Canal Emergency Therapy</span>
                    </Link>
                    <Link
                      href="/treatments/teeth-whitening"
                      className="text-[12px] text-on-surface-variant hover:text-primary py-1 flex items-center gap-2"
                      onClick={() => setMobileMenuOpen(false)}
                    >
                      <span className="material-symbols-outlined text-primary text-[16px]">flare</span>
                      <span>Professional Teeth Whitening</span>
                    </Link>
                  </div>
                )}
              </div>
              <a
                href="#team"
                className="font-label-md text-label-md text-on-surface-variant hover:text-primary py-1 border-b border-border-subtle flex items-center justify-between"
                onClick={() => setMobileMenuOpen(false)}
              >
                <span>Our Clinicians &amp; Staff</span>
                <span className="material-symbols-outlined text-[18px] text-primary">group</span>
              </a>
              <a
                href="#about"
                className="font-label-md text-label-md text-on-surface-variant hover:text-primary py-1 border-b border-border-subtle flex items-center justify-between"
                onClick={() => setMobileMenuOpen(false)}
              >
                <span>Our Surgery / Clinics</span>
                <span className="material-symbols-outlined text-[18px] text-primary">domain</span>
              </a>
              <a
                href="#charter"
                className="font-label-md text-label-md text-on-surface-variant hover:text-primary py-1 border-b border-border-subtle flex items-center justify-between"
                onClick={() => setMobileMenuOpen(false)}
              >
                <span>NHS Safety Charter</span>
                <span className="material-symbols-outlined text-[18px] text-primary">verified_user</span>
              </a>
              <a
                href="#reviews"
                className="font-label-md text-label-md text-on-surface-variant hover:text-primary py-1 border-b border-border-subtle flex items-center justify-between"
                onClick={() => setMobileMenuOpen(false)}
              >
                <span>Patient Reviews</span>
                <span className="material-symbols-outlined text-[18px] text-primary">rate_review</span>
              </a>
              <a
                href="#contact"
                className="font-label-md text-label-md text-on-surface-variant hover:text-primary py-1"
                onClick={() => setMobileMenuOpen(false)}
              >
                Contact Us
              </a>

              {/* Mobile CTAs */}
              <div className="pt-4 flex flex-col gap-3">
                <button
                  type="button"
                  onClick={() => {
                    setMobileMenuOpen(false);
                    onOpenBooking?.();
                  }}
                  className="w-full inline-flex items-center justify-center gap-2 bg-primary-container text-on-primary font-label-md text-label-md py-3 rounded-lg shadow-sm hover:bg-primary transition-all cursor-pointer"
                >
                  <span>Book An Appointment</span>
                  <span className="material-symbols-outlined text-[18px]">calendar_month</span>
                </button>
                <a
                  href="tel:+441217652870"
                  className="w-full inline-flex items-center justify-center gap-2 bg-surface-container-low text-primary font-label-md text-label-md py-3 rounded-lg border border-border-subtle"
                >
                  <span className="material-symbols-outlined text-[18px]">call</span>
                  <span>Call Emergency: +44 121 765 2870</span>
                </a>
              </div>
            </div>
          </div>
        )}
      </div>
    </header>
  );
};
